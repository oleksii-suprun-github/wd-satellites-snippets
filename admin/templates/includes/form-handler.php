<?php 

function isset_option($option) {
  if( isset($_POST[$option])) {
    return update_option($option, sanitize_text_field($_POST[$option]));   
  }
  else {
    return update_option($option, '');    
  }
}

function isset_editor_content($option) {
  if( isset($_POST[$option])) {
    return update_option($option, stripslashes($_POST[$option]));   
  }
  else {
    return update_option($option, '');    
  }  
}

function wdss_form_handler() {
    if(wp_verify_nonce($_POST['wfp_nonce'], 'wdss_save_settings') && current_user_can('manage_options')) { 

      isset_option('wdss_last_modified_n_304'); 

      isset_option('wdss_forced_trail_slash');   
      isset_option('wdss_disable_jquery'); 
      
      isset_option('wdss_redundant_links');   
      isset_option('wdss_disable_emojis');   
      isset_option('wdss_disable_pingbacks');   
      

      isset_option('wdss_disable_autoupdates');
      isset_option('wdss_disable_admin_notices');
      isset_option('wdss_disable_rss');      
      
      isset_option('wdss_auto_widght_height_attr');    

      isset_option('wdss_auto_featured_image');   
      
      isset_option('wdss_auto_alt_attribute');

      isset_option('wdss_comments_passive_listener_fix');
    
      isset_option('lazy_load_for_iframes');

      isset_option('wdss_remove_hentry');
      isset_option('wdss_yoast_schema');   
      isset_option('wdss_yoast_canonical_fix');   
      isset_option('wdss_autoptimize_lazy_fix');   
      isset_option('wdss_gutenberg_styles');   
      isset_option('wdss_amp_rules');  
      isset_option('wdss_amp_fix');   
      isset_option('wdss_force_lowercase');  
      
      isset_option('wdss_enable_title_clipping');   
      isset_option('wdss_remove_homepage_pagination');

      isset_option('wdss_title_clipping_excluded');   
      isset_option('wdss_title_clipping_by_date');         
      
      isset_option('wdss_title_words_limit');  
      isset_option('wdss_word_chars_limit');  
      isset_option('wdss_title_ending');  
      
      isset_option('wdss_410_rules');

      isset_option('wdss_featured_images_add_column');
      isset_option('wdss_featured_images_list');
    
      isset_option('wdss_polylang_meta_data');   

      isset_option('wdss_multilang_sitemap');
      
      isset_option('wdss_jsonld_schema_logo');
      isset_option('wdss_jsonld_schema_orgname');
      isset_option('wdss_jsonld_schema_locality');
      isset_option('wdss_jsonld_schema_region');
      isset_option('wdss_jsonld_schema_postal_code');
      isset_option('wdss_jsonld_schema_street');
      isset_option('wdss_jsonld_schema_country');
      isset_option('wdss_jsonld_schema_telephone');
      isset_option('wdss_jsonld_schema_email');
      isset_option('wdss_jsonld_schema_author');

      isset_option('wdss_advanced_jsonld_schema');

      isset_option('wdss_gtm_id');
      isset_option('wdss_yoast_posts_exclude');

      isset_editor_content('wdss_advanced_jsonld_schema_homepage');
      isset_editor_content('wdss_advanced_jsonld_schema_category');
      isset_editor_content('wdss_advanced_jsonld_schema_author');
      isset_editor_content('wdss_advanced_jsonld_schema_page');
      isset_editor_content('wdss_advanced_jsonld_schema_single');
      
      if( function_exists('pll_languages_list') ) {
        $polylang_lang_list = pll_languages_list(['fields' => []]); 
        $authors = get_users( array( 'fields' => array( 'ID', 'display_name', 'user_nicename' ), 'has_published_posts' => 'post' ) );

        foreach($polylang_lang_list as $lang) {
          isset_option('wdss_polylang_home_desc_' . $lang->slug . '');  
          foreach($authors as $author) {
            isset_option('wdss_polylang_author_desc_' . $author->user_nicename . '_' . $lang->slug . '');   
          }     
        }
      }

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