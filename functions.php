<?php
/**
 * Theme includes
 *
 * @link https://github.com/roots/sage
 */
$sage_includes = [
  'lib/assets.php',
  'lib/extras.php',
  'lib/setup.php',
  'lib/titles.php',
  'lib/wrapper.php',
  'lib/customizer.php',
  'lib/home.php',
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'dayjobsnightlife'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);
