<?php

/**
 * "PKCS1" (RFC5915) Formatted EC Key Handler
 *
 * PHP version 5
 *
 * Used by File/X509.php
 *
 * Processes keys with the following headers:
 *
 * -----BEGIN EC PRIVATE KEY-----
 * -----BEGIN EC PARAMETERS-----
 *
 * Technically, PKCS1 is for RSA keys, only, but we're using PKCS1 to describe
 * DSA, whose format isn't really formally described anywhere, so might as well
 * use it to describe this, too. PKCS1 is easier to remember than RFC5915, after
 * all. I suppose this could also be named IETF but idk
 *
 * @author    Jim Wigginton <terrafrost@php.net>
 * @copyright 2015 Jim Wigginton
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link      http://phpseclib.sourceforge.net
 */
namespace Google\Site_Kit_Dependencies\phpseclib3\Crypt\EC\Formats\Keys;

use Google\Site_Kit_Dependencies\phpseclib3\Common\Functions\Strings;
use Google\Site_Kit_Dependencies\phpseclib3\Crypt\Common\Formats\Keys\PKCS1 as Progenitor;
use Google\Site_Kit_Dependencies\phpseclib3\Crypt\EC\BaseCurves\Base as BaseCurve;
use Google\Site_Kit_Dependencies\phpseclib3\Crypt\EC\BaseCurves\Montgomery as MontgomeryCurve;
use Google\Site_Kit_Dependencies\phpseclib3\Crypt\EC\BaseCurves\TwistedEdwards as TwistedEdwardsCurve;
use Google\Site_Kit_Dependencies\phpseclib3\Exception\UnsupportedCurveException;
use Google\Site_Kit_Dependencies\phpseclib3\File\ASN1;
use Google\Site_Kit_Dependencies\phpseclib3\File\ASN1\Maps;
use Google\Site_Kit_Dependencies\phpseclib3\Math\BigInteger;
/**
 * "PKCS1" (RFC5915) Formatted EC Key Handler
 *
 * @author  Jim Wigginton <terrafrost@php.net>
 */
abstract class PKCS1 extends \Google\Site_Kit_Dependencies\phpseclib3\Crypt\Common\Formats\Keys\PKCS1
{
    use Common;
    /**
     * Break a public or private key down into its constituent components
     *
     * @param string $key
     * @param string $password optional
     * @return array
     */
    public static function load($key, $password = '')
    {
        self::initialize_static_variables();
        if (!\Google\Site_Kit_Dependencies\phpseclib3\Common\Functions\Strings::is_stringable($key)) {
            throw new \UnexpectedValueException('Key should be a string - not a ' . \gettype($key));
        }
        if (\strpos($key, 'BEGIN EC PARAMETERS') && \strpos($key, 'BEGIN EC PRIVATE KEY')) {
            $components = [];
            \preg_match('#-*BEGIN EC PRIVATE KEY-*[^-]*-*END EC PRIVATE KEY-*#s', $key, $matches);
            $decoded = parent::load($matches[0], $password);
            $decoded = \Google\Site_Kit_Dependencies\phpseclib3\File\ASN1::decodeBER($decoded);
            if (!$decoded) {
                throw new \RuntimeException('Unable to decode BER');
            }
            $ecPrivate = \Google\Site_Kit_Dependencies\phpseclib3\File\ASN1::asn1map($decoded[0], \Google\Site_Kit_Dependencies\phpseclib3\File\ASN1\Maps\ECPrivateKey::MAP);
            if (!\is_array($ecPrivate)) {
                throw new \RuntimeException('Unable to perform ASN1 mapping');
            }
            if (isset($ecPrivate['parameters'])) {
                $components['curve'] = self::loadCurveByParam($ecPrivate['parameters']);
            }
            \preg_match('#-*BEGIN EC PARAMETERS-*[^-]*-*END EC PARAMETERS-*#s', $key, $matches);
            $decoded = parent::load($matches[0], '');
            $decoded = \Google\Site_Kit_Dependencies\phpseclib3\File\ASN1::decodeBER($decoded);
            if (!$decoded) {
                throw new \RuntimeException('Unable to decode BER');
            }
            $ecParams = \Google\Site_Kit_Dependencies\phpseclib3\File\ASN1::asn1map($decoded[0], \Google\Site_Kit_Dependencies\phpseclib3\File\ASN1\Maps\ECParameters::MAP);
            if (!\is_array($ecParams)) {
                throw new \RuntimeException('Unable to perform ASN1 mapping');
            }
            $ecParams = self::loadCurveByParam($ecParams);
            // comparing $ecParams and $components['curve'] directly won't work because they'll have different Math\Common\FiniteField classes
            // even if the modulo is the same
            if (isset($components['curve']) && self::encodeParameters($ecParams, \false, []) != self::encodeParameters($components['curve'], \false, [])) {
                throw new \RuntimeException('EC PARAMETERS does not correspond to EC PRIVATE KEY');
            }
            if (!isset($components['curve'])) {
                $components['curve'] = $ecParams;
            }
            $components['dA'] = new \Google\Site_Kit_Dependencies\phpseclib3\Math\BigInteger($ecPrivate['privateKey'], 256);
            $components['curve']->rangeCheck($components['dA']);
            $components['QA'] = isset($ecPrivate['publicKey']) ? self::extractPoint($ecPrivate['publicKey'], $components['curve']) : $components['curve']->multiplyPoint($components['curve']->getBasePoint(), $components['dA']);
            return $components;
        }
        $key = parent::load($key, $password);
        $decoded = \Google\Site_Kit_Dependencies\phpseclib3\File\ASN1::decodeBER($key);
        if (!$decoded) {
            throw new \RuntimeException('Unable to decode BER');
        }
        $key = \Google\Site_Kit_Dependencies\phpseclib3\File\ASN1::asn1map($decoded[0], \Google\Site_Kit_Dependencies\phpseclib3\File\ASN1\Maps\ECParameters::MAP);
        if (\is_array($key)) {
            return ['curve' => self::loadCurveByParam($key)];
        }
        $key = \Google\Site_Kit_Dependencies\phpseclib3\File\ASN1::asn1map($decoded[0], \Google\Site_Kit_Dependencies\phpseclib3\File\ASN1\Maps\ECPrivateKey::MAP);
        if (!\is_array($key)) {
            throw new \RuntimeException('Unable to perform ASN1 mapping');
        }
        if (!isset($key['parameters'])) {
            throw new \RuntimeException('Key cannot be loaded without parameters');
        }
        $components = [];
        $components['curve'] = self::loadCurveByParam($key['parameters']);
        $components['dA'] = new \Google\Site_Kit_Dependencies\phpseclib3\Math\BigInteger($key['privateKey'], 256);
        $components['QA'] = isset($ecPrivate['publicKey']) ? self::extractPoint($ecPrivate['publicKey'], $components['curve']) : $components['curve']->multiplyPoint($components['curve']->getBasePoint(), $components['dA']);
        return $components;
    }
    /**
     * Convert EC parameters to the appropriate format
     *
     * @return string
     */
    public static function saveParameters(\Google\Site_Kit_Dependencies\phpseclib3\Crypt\EC\BaseCurves\Base $curve, array $options = [])
    {
        self::initialize_static_variables();
        if ($curve instanceof \Google\Site_Kit_Dependencies\phpseclib3\Crypt\EC\BaseCurves\TwistedEdwards || $curve instanceof \Google\Site_Kit_Dependencies\phpseclib3\Crypt\EC\BaseCurves\Montgomery) {
            throw new \Google\Site_Kit_Dependencies\phpseclib3\Exception\UnsupportedCurveException('TwistedEdwards and Montgomery Curves are not supported');
        }
        $key = self::encodeParameters($curve, \false, $options);
        return "-----BEGIN EC PARAMETERS-----\r\n" . \chunk_split(\Google\Site_Kit_Dependencies\phpseclib3\Common\Functions\Strings::base64_encode($key), 64) . "-----END EC PARAMETERS-----\r\n";
    }
    /**
     * Convert a private key to the appropriate format.
     *
     * @param BigInteger $privateKey
     * @param BaseCurve $curve
     * @param \phpseclib3\Math\Common\FiniteField\Integer[] $publicKey
     * @param string $secret optional
     * @param string $password optional
     * @param array $options optional
     * @return string
     */
    public static function savePrivateKey(\Google\Site_Kit_Dependencies\phpseclib3\Math\BigInteger $privateKey, \Google\Site_Kit_Dependencies\phpseclib3\Crypt\EC\BaseCurves\Base $curve, array $publicKey, $secret = null, $password = '', array $options = [])
    {
        self::initialize_static_variables();
        if ($curve instanceof \Google\Site_Kit_Dependencies\phpseclib3\Crypt\EC\BaseCurves\TwistedEdwards || $curve instanceof \Google\Site_Kit_Dependencies\phpseclib3\Crypt\EC\BaseCurves\Montgomery) {
            throw new \Google\Site_Kit_Dependencies\phpseclib3\Exception\UnsupportedCurveException('TwistedEdwards Curves are not supported');
        }
        $publicKey = "\x04" . $publicKey[0]->toBytes() . $publicKey[1]->toBytes();
        $key = ['version' => 'ecPrivkeyVer1', 'privateKey' => $privateKey->toBytes(), 'parameters' => new \Google\Site_Kit_Dependencies\phpseclib3\File\ASN1\Element(self::encodeParameters($curve)), 'publicKey' => "\x00" . $publicKey];
        $key = \Google\Site_Kit_Dependencies\phpseclib3\File\ASN1::encodeDER($key, \Google\Site_Kit_Dependencies\phpseclib3\File\ASN1\Maps\ECPrivateKey::MAP);
        return self::wrapPrivateKey($key, 'EC', $password, $options);
    }
}
