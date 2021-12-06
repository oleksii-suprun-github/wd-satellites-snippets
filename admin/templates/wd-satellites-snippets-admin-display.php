<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/Mironezes
 *
 * @package    Wd_Satellites
 * @subpackage Wd_Satellites/admin/templates
 */

  require_once('includes/input-handler.php');

  require_once('includes/form-handler.php');

  function wdss_settings_template() { ?>
    <div id="wdss-settings-page">
      <div class="container">

        <h1>WD Satellite  <small>ver <?= WD_SATELLITES_SNIPPETS_VERSION ?></small></h1>
        <a href="https://maxiproject.atlassian.net/wiki/spaces/FSDV/pages/3594682804/WD+Satellite" target="_blank">Documentation</a>

        <?php 
          if(!empty($_POST['wdss_form_submitted'])) {
            $_POST['wdss_form_submitted'] === 'true' ? wdss_form_handler() : null; 
          } 
        ?>

        <form method="POST">

          <input type="hidden" name="wdss_form_submitted" value='true'>
          <?php wp_nonce_field('wdss_save_settings', 'wfp_nonce'); ?>

          <?php 
            include_once('sections/snippets-section.php');
            include_once('sections/featured-images-section.php'); 
            include_once('sections/post-content-section.php'); 
            include_once('sections/polylang-section.php'); 
            include_once('sections/schema-section.php');
            include_once('sections/custom-410s-section.php'); 
            include_once('sections/other-section.php');
            include_once('includes/modal.php');
          ?>

          <input type="submit" name="submit" id="wdss-submit" class="wdss-button submit" value="<?= __('Save changes', 'wdss_domain') ?>">
        </form>
      </div>
    </div>
  <?php }