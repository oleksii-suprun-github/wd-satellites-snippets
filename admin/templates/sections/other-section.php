<section id="other-settings" class="wdss-section">
  <div class="wdss-section-header">
    <h2 class="section-toggler">Other</h2>
    <div class="wdss-section-header-togglers">
      <i title="Pin this section as open" class="fas fa-lock section-pin"></i>
      <i class="fas fa-chevron-down section-toggler"></i>
    </div>
  </div>
  <div class="wdss-row hidden">
    <div class="wdss-section-content">
      <div id="gtm-identifier" class="wdss-setting-item">
          <label>
            <span>GTM Identifier</span>
            <?php 
              text_handler_html(['field_name' => 'wdss_gtm_id']); 
              if( get_option('wdss_gtm_id') == '' ) update_option( 'wdss_gtm_id', '' );               
            ?>    
          </label>
      </div> 
      
      <div id="wdss-yoast-posts-exclude" class="wdss-setting-item">
          <label>
            <span>Exclude posts of specific categories from Yoast Sitemap</span>
            <?php 
              text_handler_html(['field_name' => 'wdss_yoast_posts_exclude']); 
              if( get_option('wdss_yoast_posts_exclude') == '' ) update_option( 'wdss_yoast_posts_exclude', '' );               
            ?>    
          </label>
      </div> 

    </div>
</section>