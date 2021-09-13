<section id="wdss-snippets-settings" class="wdss-section">
              <div class="wdss-section-header">
                <h2>Snippets List</h2>
                <button type="button" id="wdss-toggle-options">Toggle Options</button>
              </div>
              <div class="wdss-row">
                <div class="wdss-section-content">
                    <div id="wdss-last-modified" class="wdss-setting-item">
                        <label>
                          <span>Last Modified and 304</span>
                          <?php 
                            checkbox_handler_html(['field_name' => 'wdss_last_modified_n_304']); 
                            if( get_option('wdss_last_modified_n_304') == '' ) update_option( 'wdss_last_modified_n_304', '0' );               
                          ?>    
                      </label>
                    </div>

                    <div id="wdss-disable-jquery" class="wdss-setting-item">
                        <label>
                          <span title="Disables jQuery and Migration script for Frontend">Disable jQuery <sup>?</sup></span>
                          <?php 
                            checkbox_handler_html(['field_name' => 'wdss_disable_jquery']); 
                            if( get_option('wdss_disable_jquery') == '' ) update_option( 'wdss_disable_jquery', '0' );               
                          ?>    
                      </label>
                    </div>           
                  
                    <div id="wdss-last-modified" class="wdss-setting-item">
                        <label>
                          <span title="To apply changes visit Permalinks page ">Force Trailling Slash <sup>?</sup></span>
                          <?php 
                            checkbox_handler_html(['field_name' => 'wdss_forced_trail_slash']); 
                            if( get_option('wdss_forced_trail_slash') == '' ) update_option( 'wdss_forced_trail_slash', '0' );               
                          ?>    
                      </label>
                    </div>

                    <div id="wdss-redundant-links" class="wdss-setting-item">
                        <label>
                          <span title="Removes different links from head section (e.g. rest-api, wp_generator etc)">Remove Redundant Links <sup>?</sup></span>
                          <?php 
                            checkbox_handler_html(['field_name' => 'wdss_redundant_links']); 
                            if( get_option('wdss_redundant_links') == '' ) update_option( 'wdss_redundant_links', '0' );               
                          ?>    
                      </label>
                    </div>

                    <div id="wdss-remove-hentry" class="wdss-setting-item">
                        <label>
                          <span>Remove Hentry</span>
                          <?php 
                            checkbox_handler_html(['field_name' => 'wdss_remove_hentry']); 
                            if( get_option('wdss_remove_hentry') == '' ) update_option( 'wdss_remove_hentry', '0' );               
                          ?>    
                      </label>
                    </div>

                    <div id="wdss-auto-alt-attr" class="wdss-setting-item">
                        <label>
                          <span>Auto Alt Attributes</span>
                          <?php 
                            checkbox_handler_html(['field_name' => 'wdss_auto_alt_attribute']); 
                            if( get_option('wdss_auto_alt_attribute') == '' ) update_option( 'wdss_auto_alt_attribute', '0' );               
                          ?>    
                      </label>
                    </div>

                    <div id="wdss-comments-passive-listener-fix" class="wdss-setting-item">
                        <label>
                          <span title="Fixes *Remove passive event listener* Pagespeed warning">WP Comments Fix <sup>?</sup></span>
                          <?php 
                            checkbox_handler_html(['field_name' => 'wdss_comments_passive_listener_fix']); 
                            if( get_option('wdss_comments_passive_listener_fix') == '' ) update_option( 'wdss_comments_passive_listener_fix', '0' );               
                          ?>    
                      </label>
                    </div>
                    
                    <div id="wdss-disable-rss" class="wdss-setting-item">
                        <label>
                          <span>Disable RSS Feeds</span>
                          <?php 
                            checkbox_handler_html(['field_name' => 'wdss_disable_rss']); 
                            if( get_option('wdss_disable_rss') == '' ) update_option( 'wdss_disable_rss', '0' );               
                          ?>    
                      </label>
                    </div>

                    <div id="wdss-disable-autoupdates" class="wdss-setting-item">
                        <label>
                          <span>Disable Auto Updates</span>
                          <?php 
                            checkbox_handler_html(['field_name' => 'wdss_disable_autoupdates']); 
                            if( get_option('wdss_disable_autoupdates') == '' ) update_option( 'wdss_disable_autoupdates', '0' );               
                          ?>    
                      </label>
                    </div>

                    <div id="wdss-disable-admin-notices" class="wdss-setting-item">
                        <label>
                          <span>Disable Admin Notices</span>
                          <?php 
                            checkbox_handler_html(['field_name' => 'wdss_disable_admin_notices']); 
                            if( get_option('wdss_disable_admin_notices') == '' ) update_option( 'wdss_disable_admin_notices', '0' );               
                          ?>    
                      </label>
                    </div>                  

                    <?php if( function_exists('wpseo_init') ) { ?>    
                    <div id="wdss-yoast-schema" class="wdss-setting-item">
                        <label>
                          <span>Remove Yoast Schema</span>
                          <?php 
                            checkbox_handler_html(['field_name' => 'wdss_yoast_schema']); 
                            if( get_option('wdss_yoast_schema') == '' ) update_option( 'wdss_yoast_schema', '0' );               
                          ?>    
                      </label>
                    </div>      
                    <?php } ?>         

                    <?php if( function_exists('wpseo_init') ) { ?>    
                    <div id="wdss-yoast-canonic-pager" class="wdss-setting-item">
                        <label>
                          <span>Yoast Canonical Pagination Fix</span>
                          <?php 
                            checkbox_handler_html(['field_name' => 'wdss_yoast_canonical_fix']); 
                            if( get_option('wdss_yoast_canonical_fix') == '' ) update_option( 'wdss_yoast_canonical_fix', '0' );               
                          ?>    
                      </label>
                    </div>
                    <?php } ?>   

                    <?php if( function_exists('autoptimize') ) { ?>           
                    <div id="wdss-autoptimize-lazyload" class="wdss-setting-item">
                        <label>
                          <span title="Fixes W3C Validation error with enabled lazyload">Autoptimize Lazyload Fix <sup>?</sup></span>
                          <?php 
                            checkbox_handler_html(['field_name' => 'wdss_autoptimize_lazy_fix']); 
                            if( get_option('wdss_autoptimize_lazy_fix') == '' ) update_option( 'wdss_autoptimize_lazy_fix', '0' );               
                          ?>    
                      </label>
                    </div>
                    <?php } ?>

                    <div id="wdss-gutenberg-styles" class="wdss-setting-item">
                        <label>
                          <span>Remove Gutenberg stylesheets</span>
                          <?php 
                            checkbox_handler_html(['field_name' => 'wdss_gutenberg_styles']); 
                            if( get_option('wdss_gutenberg_styles') == '' ) update_option( 'wdss_gutenberg_styles', '0' );               
                          ?>    
                      </label>
                    </div> 

                    <div id="wdss-redundant-links" class="wdss-setting-item">
                        <label>
                          <span>Basic Redirect Rules</span>
                          <?php 
                            checkbox_handler_html(['field_name' => 'wdss_amp_rules']); 
                            if( get_option('wdss_amp_rules') == '' ) update_option( 'wdss_amp_rules', '0' );               
                          ?>    
                      </label>
                    </div>

                    <?php if( function_exists('amp_bootstrap_plugin') ) { ?>
                    <div id="wdss-amp-template-fix" class="wdss-setting-item">
                        <label>
                          <span>AMP Template Fix</span>
                          <?php 
                            checkbox_handler_html(['field_name' => 'wdss_amp_fix']); 
                            if( get_option('wdss_amp_fix') == '' ) update_option( 'wdss_amp_fix', '0' );               
                          ?>    
                      </label>
                    </div>
                    <?php } ?>


                  <div class="wdss-col-4">
                    <div id="wdss-lowercase-urls" class="wdss-setting-item">
                        <label>
                          <span>Force Lowercase URLs</span>
                          <?php 
                            checkbox_handler_html(['field_name' => 'wdss_force_lowercase']); 
                            if( get_option('wdss_force_lowercase') == '' ) update_option( 'wdss_force_lowercase', '0' );               
                          ?>    
                      </label>
                    </div>
                  </div>
                </div>
            </div>
        </section>