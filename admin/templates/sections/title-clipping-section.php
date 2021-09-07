<?php 
  $total_post_count = wp_count_posts('post')->publish;
  if( $total_post_count > 0 ) :
?>
<section id="wdss-title-clipping-settings" class="wdss-section">
  <div class="wdss-section-header">
    <h2>Long Title Clipping Settings <small>(posts only)</small></h2>
  </div>
  <div class="wdss-row">
    <div id="wdss-title-clipping-condition" class="wdss-setting-item">
      <label>
      <span>Enable</span>
      <?php 
        checkbox_handler_html(['field_name' => 'wdss_enable_title_clipping']); 
        if( get_option('wdss_enable_title_clipping') == '' ) update_option( 'wdss_enable_title_clipping', '0' );               
        ?>    
      </label>
    </div>
    <div id="wdss-title-clipping-group" class="wdss-setting-group">
      
      <div id="wdss-title-clipping-by-date" class="wdss-setting-item">
          <label>
            <span>Cut titles since</span>
            <?php 
              date_handler_html(['field_name' => 'wdss_title_clipping_by_date']);     
              ?>  
          </label>
          <button type="button" class="wdss-button reset"><i class="fas fa-trash"></i></button>
      </div>

      <div id="wdss-words-limit" class="wdss-setting-item">
        <label>
        <span title="By default: 6; counts words from 3 or more chars">Words Limit <sup>?</sup></span>
        <?php 
          $default_words_limit = '6';
          number_handler_html(['field_name' => 'wdss_title_words_limit', 'min' => '2', 'max' => '7']); 
          if( get_option('wdss_title_words_limit') == '' ) update_option( 'wdss_title_words_limit', $default_words_limit );               
          ?>    
        </label>
      </div>
      <div id="wdss-chars-limit" class="wdss-setting-item">
        <label>
        <span title="By default: 35">Max Symbols Per Word <sup>?</sup></span>
        <?php 
          $default_chars_limit = '35';
          number_handler_html(['field_name' => 'wdss_word_chars_limit', 'min' => '32', 'max' => '50']); 
          if( get_option('wdss_word_chars_limit') == '' ) update_option( 'wdss_word_chars_limit', $default_chars_limit );               
          ?>    
        </label>
      </div>
      <div id="wdss-title-clipping-excluded" class="wdss-setting-item">
        <span title="Exclude some special posts from global clipping (comma separated)">Exclude by ID <sup>?</sup></span>
        <?php 
          text_handler_html(['field_name' => 'wdss_title_clipping_excluded']);               
          ?>    
        <button id="wdss-title-clipping-excluded__choose" type="button" class="wdss-button">Choose</button>
        <button type="button" class="wdss-button reset"><i class="fas fa-trash"></i></button>
      </div>
      <div id="wdss-title-ending" class="wdss-setting-item">
        <label>
        <span>Title Ending (with divider)</span>
        <?php 
          text_handler_html(['field_name' => 'wdss_title_ending']);             
          ?>    
        </label>
        <?php if( class_exists( 'WPSEO_Options' ) ) : ?>
        <button type="button" id="wdss-get-title" class="wdss-button">Get Site Title from Yoast</button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php 
  else : 
    update_option('wdss_enable_title_clipping', '0'); 
  endif;
  ?>