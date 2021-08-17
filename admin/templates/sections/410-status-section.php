<?php 
            $total_post_count = wp_count_posts('post')->publish;
            if( $total_post_count <= 1 ) { ?>
              <section id="wdss-410-settings">
                <h2>410 Status for Category Pages</h2>
                <div class="wdss-row">
                  <div id="wdss-category-410" class="wdss-setting-item">
                    <label>
                      <span>Enable</span>
                      <?php checkbox_handler_html(['field_name' => 'wdss_410_rules']); ?>
                    </label>
                  </div>
                </div>
              </section>
            <?php }
            else { update_option('wdss_410_rules', '0'); }        
          ?>