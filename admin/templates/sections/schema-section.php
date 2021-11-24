
    
<section id="wdss-jsonld-schema-settings" class="wdss-section">

  <?php
    $count_posts = wp_count_posts();
    $published_posts = $count_posts->publish;
  ?>

  <div class="wdss-section-header">
    <h2 class="section-toggler">JSON-LD Schema</h2>
    <div class="wdss-section-header-togglers">
      <i title="Pin this section as open" class="fas fa-lock section-pin"></i>
      <i class="fas fa-chevron-down section-toggler"></i>
    </div>
  </div>
  <div class="wdss-row hidden">
    <div class="wdss-section-content">
      <div class="wdss-jsonld-schema-predifined-settings">
        <div id="wdss-jsonld-schema-logo" class="wdss-setting-item image-chooser logo">
            <label>
                <span>Organization Logo</span>
                <?php 
                  image_to_url_handler_html(['field_name' => 'wdss_jsonld_schema_logo']);            
                  if( get_option('wdss_jsonld_schema_logo') == '' ) update_option( 'wdss_jsonld_schema_logo', '' );   
                ?>  
                <button type="button" id="wdss_jsonld_schema_logo__choose" class="wdss-button choose">Choose</button>
                <button type="button" class="wdss-button reset"><i class="fas fa-trash"></i></button>   
            </label>
        </div>

        <div id="wdss-jsonld-schema-orgname" class="wdss-setting-item">
            <label>
                <span>Organization Name</span>
                <?php 
                  text_handler_html(['field_name' => 'wdss_jsonld_schema_orgname']); 
                  if( get_option('wdss_jsonld_schema_orgname') == '' ) update_option( 'wdss_jsonld_schema_orgname', '' );               
                ?>    
            </label>
            <button type="button" id="wdss-generate-orgname" class="wdss-button">Generate</button>
        </div>

        <?php if ($published_posts > 1) : ?>

        <div id="wdss-jsonld-schema-locality" class="wdss-setting-item">
            <label>
                <span title="addressLocality field">Locality <sup>?<sup></span>
                <?php 
                  text_handler_html(['field_name' => 'wdss_jsonld_schema_locality']); 
                  if( get_option('wdss_jsonld_schema_locality') == '' ) update_option( 'wdss_jsonld_schema_locality', '' );               
                ?>    
            </label>
        </div>


        <div id="wdss-jsonld-schema-region" class="wdss-setting-item">
            <label>
                <span title="addressRegion field" >Region <sup>?<sup></span>
                <?php 
                  text_handler_html(['field_name' => 'wdss_jsonld_schema_region']); 
                  if( get_option('wdss_jsonld_schema_region') == '' ) update_option( 'wdss_jsonld_schema_region', '' );               
                ?>    
            </label>
        </div>
        
        <div id="wdss-jsonld-schema-region" class="wdss-setting-item">
            <label>
                <span title="postalCode field" >Postal Code <sup>?<sup></span>
                <?php 
                  text_handler_html(['field_name' => 'wdss_jsonld_schema_postal_code']); 
                  if( get_option('wdss_jsonld_schema_postal_code') == '' ) update_option( 'wdss_jsonld_schema_postal_code', '' );               
                ?>    
            </label>
        </div>

        <div id="wdss-jsonld-schema-region" class="wdss-setting-item">
            <label>
                <span title="streetAddress field" >Street <sup>?<sup></span>
                <?php 
                  text_handler_html(['field_name' => 'wdss_jsonld_schema_street']); 
                  if( get_option('wdss_jsonld_schema_street') == '' ) update_option( 'wdss_jsonld_schema_street', '' );               
                ?>    
            </label>
        </div>      

        <div id="wdss-jsonld-schema-country" class="wdss-setting-item">
            <label>
                <span title="addressCountry field">Country <sup>?<sup></span>
                <?php 
                  text_handler_html(['field_name' => 'wdss_jsonld_schema_country']); 
                  if( get_option('wdss_jsonld_schema_country') == '' ) update_option( 'wdss_jsonld_schema_country', '' );               
                ?>    
            </label>
        </div>
        
        <div id="wdss-jsonld-schema-telephone" class="wdss-setting-item">
            <label>
                <span>Telephone</span>
                <?php 
                  text_handler_html(['field_name' => 'wdss_jsonld_schema_telephone']); 
                  if( get_option('wdss_jsonld_schema_telephone') == '' ) update_option( 'wdss_jsonld_schema_telephone', '' );               
                ?>    
            </label>
        </div>

        <div id="wdss-jsonld-schema-email" class="wdss-setting-item">
            <label>
                <span>Email</span>
                <?php 
                  text_handler_html(['field_name' => 'wdss_jsonld_schema_email']); 
                  if( get_option('wdss_jsonld_schema_email') == '' ) update_option( 'wdss_jsonld_schema_email', '' );               
                ?>    
            </label>
            <button type="button" id="wdss-generate-email" class="wdss-button">Generate</button>
        </div>
        <?php elseif($published_posts <= 1): ?>
          
        <div id="wdss-jsonld-schema-author" class="wdss-setting-item">
            <label>
                <span>Author Name</span>
                <?php 
                  text_handler_html(['field_name' => 'wdss_jsonld_schema_author_name']); 
                  if( get_option('wdss_jsonld_schema_author_name') == '' ) update_option( 'wdss_jsonld_schema_author_name', '' );               
                ?>    
            </label>
        </div>


        <?php endif; ?>            
      </div>

      <!-- Custom schema editor field -->
      <div id="wdss-advanced-jsonld-schema-condition" class="wdss-setting-item">
        <label>
        <span>Use hard-coded schema</span>
        <?php 
          checkbox_handler_html(['field_name' => 'wdss_advanced_jsonld_schema']); 
          if( get_option('wdss_advanced_jsonld_schema') == '' ) update_option( 'wdss_advanced_jsonld_schema', '0' );               
          ?>    
        </label>
      </div>
    </div>
  </div>
</section>