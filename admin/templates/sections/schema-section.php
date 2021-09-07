<section id="wdss-jsonld-schema-settings" class="wdss-section">
  <div class="wdss-section-header">
    <h2>JSON-LD Schema Settings</h2>
  </div>
  <div class="wdss-row">

    <div class="wdss-jsonld-schema-predifined-settings">
      <div id="wdss-jsonld-schema-logo" class="wdss-setting-item image-chooser ">
          <label>
              <span>Organization Logo</span>
              <?php 
                text_handler_html(['field_name' => 'wdss_jsonld_schema_logo']);            
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
      </div>

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

      <div id="wdss-jsonld-schema-enail" class="wdss-setting-item">
          <label>
              <span>Email</span>
              <?php 
                text_handler_html(['field_name' => 'wdss_jsonld_schema_email']); 
                if( get_option('wdss_jsonld_schema_email') == '' ) update_option( 'wdss_jsonld_schema_email', '' );               
              ?>    
          </label>
      </div>      
    
    <div id="wdss-jsonld-schema-enail" class="wdss-setting-item">
          <label>
              <span>Author</span>
              <?php 
                text_handler_html(['field_name' => 'wdss_jsonld_schema_author']); 
                if( get_option('wdss_jsonld_schema_author') == '' ) update_option( 'wdss_jsonld_schema_author', '' );               
              ?>    
          </label>
      </div>      
    </div>

    <!-- Custom schema editor field -->
    <div id="wdss-advanced-jsonld-schema-condition" class="wdss-setting-item">
      <label>
      <span>Use custom schema</span>
      <?php 
        checkbox_handler_html(['field_name' => 'wdss_advanced_jsonld_schema']); 
        if( get_option('wdss_advanced_jsonld_schema') == '' ) update_option( 'wdss_advanced_jsonld_schema', '0' );               
        ?>    
      </label>
    </div>
    <div id="wdss-advanced-jsonld-schema-group" class="wdss-setting-group">
      <div id="wdss-advanced-jsonld-schema-content" class="wdss-setting-item">
        <span>Content</span>
        <?php 
          text_handler_html(['field_name' => 'wdss_advanced_jsonld_schema_content']);               
          ?>    
      </div>
    </div>
  </div>
</section>