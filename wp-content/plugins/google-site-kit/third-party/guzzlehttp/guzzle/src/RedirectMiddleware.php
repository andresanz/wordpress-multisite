<?php

namespace Google\Site_Kit_Dependencies\GuzzleHttp;

use Google\Site_Kit_Dependencies\GuzzleHttp\Exception\BadResponseException;
use Google\Site_Kit_Dependencies\GuzzleHttp\Exception\TooManyRedirectsException;
use Google\Site_Kit_Dependencies\GuzzleHttp\Promise\PromiseInterface;
use Google\Site_Kit_Dependencies\Psr\Http\Message\RequestInterface;
use Google\Site_Kit_Dependencies\Psr\Http\Message\ResponseInterface;
use Google\Site_Kit_Dependencies\Psr\Http\Message\UriInterface;
/**
 * Request redirect middleware.
 *
 * Apply this middleware like other middleware using
 * {@see \GuzzleHttp\Middleware::redirect()}.
 *
 * @final
 */
class RedirectMiddleware
{
    public const HISTORY_HEADER = 'X-Guzzle-Redirect-History';
    public const STATUS_HISTORY_HEADER = 'X-Guzzle-Redirect-Status-History';
    /**
     * @var array
     */
    public static $defaultSettings = ['max' => 5, 'protocols' => ['http', 'https'], 'strict' => \false, 'referer' => \false, 'track_redirects' => \false];
    /**
     * @var callable(RequestInterface, array): PromiseInterface
     */
    private $nextHandler;
    /**
     * @param callable(RequestInterface, array): PromiseInterface $nextHandler Next handler to invoke.
     */
    public function __construct(callable $nextHandler)
    {
        $this->nextHandler = $nextHandler;
    }
    public function __invoke(\Google\Site_Kit_Dependencies\Psr\Http\Message\RequestInterface $request, array $options) : \Google\Site_Kit_Dependencies\GuzzleHttp\Promise\PromiseInterface
    {
        $fn = $this->nextHandler;
        if (empty($options['allow_redirects'])) {
            return $fn($request, $options);
        }
        if ($options['allow_redirects'] === \true) {
            $options['allow_redirects'] = self::$defaultSettings;
        } elseif (!\is_array($options['allow_redirects'])) {
            throw new \InvalidArgumentException('allow_redirects must be true, false, or array');
        } else {
            // Merge the default settings with the provided settings
            $options['allow_redirects'] += self::$defaultSettings;
        }
        if (empty($options['allow_redirects']['max'])) {
            return $fn($request, $options);
        }
        return $fn($request, $options)->then(function (\Google\Site_Kit_Dependencies\Psr\Http\Message\ResponseInterface $response) use($request, $options) {
            return $this->checkRedirect($request, $options, $response);
        });
    }
    /**
     * @return ResponseInterface|PromiseInterface
     */
    public function checkRedirect(\Google\Site_Kit_Dependencies\Psr\Http\Message\RequestInterface $request, array $options, \Google\Site_Kit_Dependencies\Psr\Http\Message\ResponseInterface $response)
    {
        if (\strpos((string) $response->getStatusCode(), '3') !== 0 || !$response->hasHeader('Location')) {
            return $response;
        }
        $this->guardMax($request, $response, $options);
        $nextRequest = $this->modifyRequest($request, $options, $response);
        // If authorization is handled by curl, unset it if URI is cross-origin.
        if (\Google\Site_Kit_Dependencies\GuzzleHttp\Psr7\UriComparator::isCrossOrigin($request->getUri(), $nextRequest->getUri()) && \defined('\\CURLOPT_HTTPAUTH')) {
            unset($options['curl'][\CURLOPT_HTTPAUTH], $options['curl'][\CURLOPT_USERPWD]);
        }
        if (isset($options['allow_redirects']['on_redirect'])) {
            $options['allow_redirects']['on_redirect']($request, $response, $nextRequest->getUri());
        }
        $promise = $this($nextRequest, $options);
        // Add headers to be able to track history of redirects.
        if (!empty($options['allow_redirects']['track_redirects'])) {
            return $this->withTracking($promise, (string) $nextRequest->getUri(), $response->getStatusCode());
        }
        return $promise;
    }
    /**
     * Enable tracking on promise.
     */
    private function withTracking(\Google\Site_Kit_Dependencies\GuzzleHttp\Promise\PromiseInterface $promise, string $uri, int $statusCode) : \Google\Site_Kit_Dependencies\GuzzleHttp\Promise\PromiseInterface
    {
        return $promise->then(static function (\Google\Site_Kit_Dependencies\Psr\Http\Message\ResponseInterface $response) use($uri, $statusCode) {
            // Note that we are pushing to the front of the list as this
            // would be an earlier response than what is currently present
            // in the history header.
            $historyHeader = $response->getHeader(self::HISTORY_HEADER);
            $statusHeader = $response->getHeader(self::STATUS_HISTORY_HEADER);
            \array_unshift($historyHeader, $uri);
            \array_unshift($statusHeader, (string) $statusCode);
            return $response->withHeader(self::HISTORY_HEADER, $historyHeader)->withHeader(self::STATUS_HISTORY_HEADER, $statusHeader);
        });
    }
    /**
     * Check for too many redirects.
     *
     * @throws TooManyRedirectsException Too many redirects.
     */
    private function guardMax(\Google\Site_Kit_Dependencies\Psr\Http\Message\RequestInterface $request, \Google\Site_Kit_Dependencies\Psr\Http\Message\ResponseInterface $response, array &$options) : void
    {
        $current = $options['__redirect_count'] ?? 0;
        $options['__redirect_count'] = $current + 1;
        $max = $options['allow_redirects']['max'];
        if ($options['__redirect_count'] > $max) {
            throw new \Google\Site_Kit_Dependencies\GuzzleHttp\Exception\TooManyRedirectsException("Will not follow more than {$max} redirects", $request, $response);
        }
    }
    public function modifyRequest(\Google\Site_Kit_Dependencies\Psr\Http\Message\RequestInterface $request, array $options, \Google\Site_Kit_Dependencies\Psr\Http\Message\ResponseInterface $response) : \Google\Site_Kit_Dependencies\Psr\Http\Message\RequestInterface
    {
        // Request modifications to apply.
        $modify = [];
        $protocols = $options['allow_redirects']['protocols'];
        // Use a GET request if this is an entity enclosing request and we are
        // not forcing RFC compliance, but rather emulating what all browsers
        // would do.
        $statusCode = $response->getStatusCode();
        if ($statusCode == 303 || $statusCode <= 302 && !$options['allow_redirects']['strict']) {
            $safeMethods = ['GET', 'HEAD', 'OPTIONS'];
            $requestMethod = $request->getMethod();
            $modify['method'] = \in_array($requestMethod, $safeMethods) ? $requestMethod : 'GET';
            $modify['body'] = '';
        }
        $uri = self::redirectUri($request, $response, $protocols);
        if (isset($options['idn_conversion']) && $options['idn_conversion'] !== \false) {
            $idnOptions = $options['idn_conversion'] === \true ? \IDNA_DEFAULT : $options['idn_conversion'];
            $uri = \Google\Site_Kit_Dependencies\GuzzleHttp\Utils::idnUriConvert($uri, $idnOptions);
        }
        $modify['uri'] = $uri;
        \Google\Site_Kit_Dependencies\GuzzleHttp\Psr7\Message::rewindBody($request);
        // Add the Referer header if it is told to do so and only
        // add the header if we are not redirecting from https to http.
        if ($options['allow_redirects']['referer'] && $modify['uri']->getScheme() === $request->getUri()->getScheme()) {
            $uri = $request->getUri()->withUserInfo('');
            $modify['set_headers']['Referer'] = (string) $uri;
        } else {
            $modify['remove_headers'][] = 'Referer';
        }
        // Remove Authorization and Cookie headers if URI is cross-origin.
        if (\Google\Site_Kit_Dependencies\GuzzleHttp\Psr7\UriComparator::isCrossOrigin($request->getUri(), $modify['uri'])) {
            $modify['remove_headers'][] = 'Authorization';
            $modify['remove_headers'][] = 'Cookie';
        }
        return \Google\Site_Kit_Dependencies\GuzzleHttp\Psr7\Utils::modifyRequest($request, $modify);
    }
    /**
     * Set the appropriate URL on the request based on the location header.
     */
    private static function redirectUri(\Google\Site_Kit_Dependencies\Psr\Http\Message\RequestInterface $request, \Google\Site_Kit_Dependencies\Psr\Http\Message\ResponseInterface $response, array $protocols) : \Google\Site_Kit_Dependencies\Psr\Http\Message\UriInterface
    {
        $location = \Google\Site_Kit_Dependencies\GuzzleHttp\Psr7\UriResolver::resolve($request->getUri(), new \Google\Site_Kit_Dependencies\GuzzleHttp\Psr7\Uri($response->getHeaderLine('Location')));
        // Ensure that the redirect URI is allowed based on the protocols.
        if (!\in_array($location->getScheme(), $protocols)) {
            throw new \Google\Site_Kit_Dependencies\GuzzleHttp\Exception\BadResponseException(\sprintf('Redirect URI, %s, does not use one of the allowed redirect protocols: %s', $location, \implode(', ', $protocols)), $request, $response);
        }
        return $location;
    }
}
