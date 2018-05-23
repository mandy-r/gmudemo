<?php

/**
 * @file
 * Factory Hook: post-install.
 *
 * This hook enables you to execute PHP after a new website is created
 * in your subscription. Unlike most API-based hooks, this hook does not
 * take arguments, but instead executes the PHP code it is provided.
 *
 * This is used so that an ACSF site install will match a local BLT site
 * install. After a local site install, the update functions are run.
 *
 */

$site = $_ENV['AH_SITE_GROUP'];
$env = $_ENV['AH_SITE_ENVIRONMENT'];
$target_env = $site . $env;

// The public domain name of the website.
// Run updates against requested domain rather than acsf primary domain.
$domain = $_SERVER['HTTP_HOST'];

if ($is_acsf_env && function_exists('gardens_site_data_load_file')) {
    // Function gardens_site_data_load_file() lives in
    // /mnt/www/html/$ah_site/docroot/sites/g/sites.inc.
    if (($map = gardens_site_data_load_file()) && isset($map['sites'])) {
      foreach ($map['sites'] as $site => $site_details) {
        if ($acsf_db_name == $site_details['name']) {
          $acsf_site_name = $site;
          break;
        }
      }
    }
}
exec("/mnt/www/html/$site.$env/vendor/acquia/blt/bin/blt artifact:update:drupal --environment=$env --site=$domain --define drush.uri=$domain --verbose --yes");
