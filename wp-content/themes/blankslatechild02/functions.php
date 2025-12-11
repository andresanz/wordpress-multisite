<?php

add_filter('auto_update_plugin', '__return_true');
add_filter('auto_update_theme', '__return_true');

function enqueue_fontawesome()
{
  wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_fontawesome');

function auto_link_content_images($content)
{
  // Load the DOM
  if (false === strpos($content, '<img')) return $content;

  libxml_use_internal_errors(true); // suppress warnings
  $dom = new DOMDocument();
  $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));

  $imgs = $dom->getElementsByTagName('img');

  foreach ($imgs as $img) {
    $src = $img->getAttribute('src');
    $parent = $img->parentNode;

    // only wrap if not already inside an <a>
    if ($parent->nodeName !== 'a') {
      $link = $dom->createElement('a');
      $link->setAttribute('href', $src);
      $link->setAttribute('target', '_blank');

      $parent->replaceChild($link, $img);
      $link->appendChild($img);
    }
  }

  return preg_replace('~<(?:!DOCTYPE|/?(?:html|body))[^>]*>\s*~i', '', $dom->saveHTML());
}
add_filter('the_content', 'auto_link_content_images', 20);

function clean_excerpt_more($more)
{
  // Remove WordPress' default " [...]" / "..." more text
  return '';
}
add_filter('excerpt_more', 'clean_excerpt_more', 999);

function custom_trim_excerpt($text, $raw_excerpt)
{
  // If there is no manual excerpt, build from full content
  if ($raw_excerpt === '') {
    $text = get_the_content('');
    $text = strip_shortcodes($text);
    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]&gt;', $text);
  }

  // Always trim to 40 words, with NO trailing ellipsis
  $text = wp_trim_words(wp_strip_all_tags($text), 40, '...');

  return $text;
}
add_filter('wp_trim_excerpt', 'custom_trim_excerpt', 10, 2);

add_theme_support('post-thumbnails');

add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
});

function blankslatechild01_enqueue_styles()
{
  // Google Fonts
  wp_enqueue_style('open-sans', 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap');

  // Theme root style.css (optional if you're not using it directly)
  wp_enqueue_style('main-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'blankslatechild01_enqueue_styles');

function blankslatechild01_setup()
{
  register_nav_menus(array('main-menu' => 'Main Menu'));
}
add_action('after_setup_theme', 'blankslatechild01_setup');

function blankslatechild01_widgets_init()
{
  register_sidebar(array(
    'name' => 'Primary Widget Area',
    'id' => 'primary-widget-area',

    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));
}
add_action('widgets_init', 'blankslatechild01_widgets_init');
