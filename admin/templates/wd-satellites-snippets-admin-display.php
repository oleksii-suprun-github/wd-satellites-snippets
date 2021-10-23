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

        <?php 
          if(!empty($_POST['wdss_form_submitted'])) {
            $_POST['wdss_form_submitted'] === 'true' ? wdss_form_handler() : null; 
          } 
        ?>

        <form method="POST">

          <input type="hidden" name="wdss_form_submitted" value='true'>
          <?php wp_nonce_field('wdss_save_settings', 'wfp_nonce'); ?>


          <?php include_once('sections/snippets-section.php') ?>

          <?php include_once('sections/title-clipping-section.php') ?>

          <?php include_once('sections/410-status-section.php') ?>

          <?php include_once('sections/featured-images-section.php') ?>

          <?php include_once('sections/polylang-section.php') ?>

          <?php include_once('sections/schema-section.php') ?>

          <?php include_once('sections/custom-410s-section.php') ?>

          <?php include_once('sections/blocked-notices-section.php') ?>

          <?php include_once('sections/other-section.php') ?>

          <input type="submit" name="submit" id="submit" class="wdss-button submit" value="<?= __('Save changes', 'wdss_domain') ?>">
        </form>
      </div>
    </div>
  <?php }