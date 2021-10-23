<section id="custom-410s-list-settings" class="wdss-section">
  <div class="wdss-section-header">
    <h2 class="section-toggler">Other</h2>
    <div class="wdss-section-header-togglers">
      <i title="Pin this section as open" class="fas fa-lock section-pin"></i>
      <i class="fas fa-chevron-down section-toggler"></i>
    </div>
  </div>
  <div class="wdss-row">
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
    </div>
</section>