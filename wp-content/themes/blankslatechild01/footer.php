<?php
$host = $_SERVER['HTTP_HOST'];

if (strpos($host, 'randomcategory.com') !== false) {
  get_template_part('template-parts/footer', 'randomcategory');
} elseif (strpos($host, 'andresanz.com') !== false) {
  get_template_part('template-parts/footer', 'andresanz');
} elseif (strpos($host, 'noahsanz.com') !== false) {
  get_template_part('template-parts/footer', 'noahsanz');
} else {
  get_template_part('template-parts/footer', 'default');
}
