<section id="other-settings" class="wdss-section">
  <div class="wdss-section-header">
    <h2 class="section-toggler">Other</h2>
    <div class="wdss-section-header-togglers">
      <i title="Pin this section as open" class=" lock section-pin"></i>
      <i class=" chevron-down section-toggler"></i>
    </div>
  </div>
  <div class="wdss-row hidden">
    <div class="wdss-section-content">
      <div id="gtm-identifier" class="wdss-setting-item">
          <label>
            <span title="e.g. GTM-WT1234">GTM Identifier for lazyload <sup>?</sup></span>
            <?php 
              text_handler_html(['field_name' => 'wdss_gtm_id']); 
              if( get_option('wdss_gtm_id') == '' ) update_option( 'wdss_gtm_id', '' );               
            ?>    
          </label>
      </div> 
      
      <div id="recaptcha-code" class="wdss-setting-item">
          <label>
            <span>Google ReCaptcha Site Code</span>
            <?php 
              text_handler_html(['field_name' => 'wdss_recaptcha_id']); 
              if( get_option('wdss_recaptcha_id') == '' ) update_option( 'wdss_recaptcha_id', '' );               
            ?>    
          </label>
      </div> 

      <div id="wdss-yoast-posts-exclude" class="wdss-setting-item">
          <label>
            <span title="By category`s id, coma-separated">Exclude posts of categories from Yoast Sitemap <sup>?</sup></span>
            <?php 
              text_handler_html(['field_name' => 'wdss_yoast_posts_exclude']); 
              if( get_option('wdss_yoast_posts_exclude') == '' ) update_option( 'wdss_yoast_posts_exclude', '' );               
            ?>    
          </label>
      </div> 

    </div>
</section>
