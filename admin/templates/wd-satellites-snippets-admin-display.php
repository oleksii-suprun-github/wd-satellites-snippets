<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/Mironezes
 *
 * @package    Wd_Satellites_Snippets
 * @subpackage Wd_Satellites_Snippets/admin/templates
 */

  function checkbox_handler_html($args) { ?>
    <input type="checkbox" name="<?= $args['field_name']; ?>" value="1" <?php checked(esc_attr(get_option($args['field_name']))) ?>>  
  <? }

  function text_handler_html($args) { ?>
    <input type="text" name="<?= $args['field_name']; ?>" value="<?= esc_attr(get_option($args['field_name']));?>" >  
  <? }


  function date_handler_html($args) { ?>
    <input type="date" name="<?= $args['field_name']; ?>" value="<?= esc_attr(get_option($args['field_name']));?>" >  
  <? }


  function number_handler_html($args) { ?>
    <input type="number" name="<?= $args['field_name']; ?>" min="<?= $args['min']; ?>" max="<?= $args['max']; ?>" value="<?= esc_attr(get_option($args['field_name']));?>" >  
  <? }


  function wdss_form_handler() {
    if(wp_verify_nonce($_POST['wfp_nonce'], 'wdss_save_settings') && current_user_can('manage_options')) { 

      update_option('wdss_last_modified_n_304', sanitize_text_field($_POST['wdss_last_modified_n_304'])); 

      update_option('wdss_forced_trail_slash', sanitize_text_field($_POST['wdss_forced_trail_slash']));   
      update_option('wdss_disable_jquery', sanitize_text_field($_POST['wdss_disable_jquery'])); 
      
      update_option('wdss_redundant_links', sanitize_text_field($_POST['wdss_redundant_links']));   

      update_option('wdss_disable_autoupdates', sanitize_text_field($_POST['wdss_disable_autoupdates']));
      update_option('wdss_disable_admin_notices', sanitize_text_field( $_POST['wdss_disable_admin_notices']));
      update_option('wdss_disable_rss', sanitize_text_field( $_POST['wdss_disable_rss']));      
      
      update_option('wdss_auto_featured_image', sanitize_text_field( $_POST['wdss_auto_featured_image']));
      update_option('wdss_auto_alt_attribute', sanitize_text_field( $_POST['wdss_auto_alt_attribute']));

      update_option('wdss_comments_passive_listener_fix', sanitize_text_field( $_POST['wdss_comments_passive_listener_fix']));
    
      update_option('wdss_yoast_schema', sanitize_text_field($_POST['wdss_yoast_schema']));   
      update_option('wdss_yoast_canonical_fix', sanitize_text_field($_POST['wdss_yoast_canonical_fix']));   
      update_option('wdss_autoptimize_lazy_fix', sanitize_text_field($_POST['wdss_autoptimize_lazy_fix']));   
      update_option('wdss_gutenberg_styles', sanitize_text_field($_POST['wdss_gutenberg_styles']));   
      update_option('wdss_amp_rules', sanitize_text_field($_POST['wdss_amp_rules']));  
      update_option('wdss_amp_fix', sanitize_text_field($_POST['wdss_amp_fix']));   
      update_option('wdss_force_lowercase', sanitize_text_field($_POST['wdss_force_lowercase']));  
      
      update_option('wdss_enable_title_clipping', sanitize_text_field($_POST['wdss_enable_title_clipping']));   
      update_option('wdss_title_clipping_excluded', sanitize_text_field($_POST['wdss_title_clipping_excluded']));
      update_option('wdss_title_clipping_condition', sanitize_text_field($_POST['wdss_title_clipping_condition']));   
      update_option('wdss_title_clipping_by_date', sanitize_text_field($_POST['wdss_title_clipping_by_date']));         
      

      update_option('wdss_title_words_limit', sanitize_text_field($_POST['wdss_title_words_limit']));  
      update_option('wdss_word_chars_limit', sanitize_text_field($_POST['wdss_word_chars_limit']));  
      update_option('wdss_title_ending', sanitize_text_field($_POST['wdss_title_ending']));  
      
      update_option('wdss_410_rules', sanitize_text_field($_POST['wdss_410_rules']));

    ?>

      <div class="notice updated">
        <p><?= __('Settings are updated', 'wdss_domain') ?></p>
      </div>
    <?php }
      else { ?>
      <div class="notice error">
        <p><?= __('You don`t have permissions to do this', 'wdss_domain') ?></p>
      </div>
    <?php  }
  }


  function wdss_settings_template() { ?>
    <div id="wdss-settings-page">
      <div class="container">

        <h1>Satellites Snippets <small>ver <?= WD_SATELLITES_SNIPPETS_VERSION ?></small></h1>

        <?php $_POST['wdss_form_submitted'] === 'true' ? wdss_form_handler() : null; ?>

        <form method="POST">

          <input type="hidden" name="wdss_form_submitted" value='true'>
          <?php wp_nonce_field('wdss_save_settings', 'wfp_nonce'); ?>


          <?php include_once('sections/snippet-section.php') ?>
          <?php include_once('sections/title-clipping-section.php') ?>
          <?php include_once('sections/410-status-section.php') ?>

          <input type="submit" name="submit" id="submit" class="button" value="<?= __('Save changes', 'wdss_domain') ?>">
        </form>
      </div>
    </div>
  <?php }