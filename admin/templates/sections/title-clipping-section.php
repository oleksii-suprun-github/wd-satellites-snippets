<?php 
            $total_post_count = wp_count_posts('post')->publish;
            if( $total_post_count !== 0 ) { 
          ?>
          <section id="wdss-title-clipping-settings">
            <h2>Long Title Clipping Settings <small>(posts only)</small></h2>
            <div class="wdss-row">
                <div id="wdss-title-clipping" class="wdss-setting-item">
                    <label>
                      <span>Enable</span>
                      <?php 
                        checkbox_handler_html(['field_name' => 'wdss_enable_title_clipping']); 
                        if( get_option('wdss_enable_title_clipping') == '' ) update_option( 'wdss_enable_title_clipping', '0' );               
                      ?>    
                  </label>
                </div>    

                <div id="wdss-title-clipping-group" class="wdss-setting-group">

                  <div id="wdss-title-clipping-condition-group">
                    <div id="wdss-title-clipping-condition" class="wdss-setting-item">
                    <label>
                          <span>Date Condition </span>
                          <?php 
                          checkbox_handler_html(['field_name' => 'wdss_title_clipping_condition']); 
                          if( get_option('wdss_title_clipping_condition') == '' ) update_option( 'wdss_title_clipping_condition', '0' );               
                          ?>     
                      </label>
                    </div> 
                    
                    
                    <div id="wdss-title-clipping-by-date" class="wdss-setting-item wdss-setting-group">
                    <label>
                          <span>-- Cut titles since</span>
                          <?php 
                          date_handler_html(['field_name' => 'wdss_title_clipping_by_date']); 
                          if( get_option('wdss_title_clipping_by_date') == '' ) update_option( 'wdss_title_clipping_by_date', '0' );               
                          ?>  

                      </label>
                    </div> 

                  </div>


                  <div id="wdss-words-limit" class="wdss-setting-item">
                  <label>
                        <span title="By default: 6">Words Limit</span>
                        <?php 
                          $default_words_limit = '6';
                          number_handler_html(['field_name' => 'wdss_title_words_limit', 'min' => '2', 'max' => '7']); 
                          if( get_option('wdss_title_words_limit') == '' ) update_option( 'wdss_title_words_limit', $default_words_limit );               
                        ?>    
                    </label>
                  </div>   

                  <div id="wdss-chars-limit" class="wdss-setting-item">
                      <label>
                        <span title="By default: 35">Chars Per Word</span>
                        <?php 
                          $default_chars_limit = '35';
                          number_handler_html(['field_name' => 'wdss_word_chars_limit', 'min' => '32', 'max' => '50']); 
                          if( get_option('wdss_word_chars_limit') == '' ) update_option( 'wdss_word_chars_limit', $default_chars_limit );               
                        ?>    
                    </label>
                  </div>   

                  <div id="wdss-title-clipping-excluded" class="wdss-setting-item">
                      <label>
                        <span title="Exclude some special posts from global clipping (comma separated)">Exclude by ID</span>
                        <?php 
                          text_handler_html(['field_name' => 'wdss_title_clipping_excluded']); 
                          if( get_option('wdss_title_clipping_excluded') == '' ) update_option( 'wdss_title_clipping_excluded', '' );               
                        ?>    
                    </label>
                  </div>  


                  


                  
                  <div id="wdss-title-ending" class="wdss-setting-item">
                      <label>
                        <span>Title Ending (with divider)</span>
                        <?php 
                          text_handler_html(['field_name' => 'wdss_title_ending']); 
                          if( get_option('wdss_title_ending') == '' ) update_option( 'wdss_title_ending', '' );               
                        ?>    
                    </label>
                  </div> 
                </div> 
            </div>
          </section>
          <?php } 
          else { update_option('wdss_enable_title_clipping', '0'); }
          ?>