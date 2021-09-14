<?php 
  $total_post_count = wp_count_posts('post')->publish;
  if( $total_post_count > 0 )  : 
?>
<section id="featured-images-settings" class="wdss-section">
  <div class="wdss-section-header">
    <h2>Featured Images Settings</h2>
    <div class="wdss-section-header-togglers">
      <i title="Pin this section as open" class="fas fa-lock"></i>
      <i class="fas fa-chevron-down"></i>
    </div>
  </div>
  <div class="wdss-row">
    <div class="wdss-section-content">
      <div id="wdss-auto-featured-image-condition" class="wdss-setting-item">
          <label>
              <span title="Takes featured image from the first attached image">Auto Featured Image <sup>?</sup></span>
              <?php 
                checkbox_handler_html(['field_name' => 'wdss_auto_featured_image']); 
                if( get_option('wdss_auto_featured_image') == '' ) update_option( 'wdss_auto_featured_image', '0' );               
              ?>    
          </label>
      </div>

      <div id="wdss-featured-images-group" class="wdss-setting-group hidden">    
        <div id="wdss-featured-images-list" class="wdss-setting-item image-chooser">
          <span title="When chosen if post has no featured image then it will be chosen randomly from the list">-- Default images list <sup>?</sup></span>
          <?php 
            text_handler_html(['field_name' => 'wdss_featured_images_list']);            
          ?>  
          <button type="button" id="wdss-featured-images__choose" class="wdss-button choose">Choose</button>
          <button type="button" class="wdss-button reset"><i class="fas fa-trash"></i></button>
        </div>
      </div>

      <div id="wdss-featured-images-add-column" class="wdss-setting-item">
        <label>
          <span>Featured image column on posts screen</span>
          <?php 
              checkbox_handler_html(['field_name' => 'wdss_featured_images_add_column']); 
              if( get_option('wdss_featured_images_add_column') == '' ) update_option( 'wdss_featured_images_add_column', '0' );               
            ?>
        </label> 
      </div>
    </div>
</section>
<?php 
  else : 
    update_option('wdss_auto_featured_image', '0');
    update_option('wdss_featured_images_add_column', '0');
    update_option('wdss_featured_images_list', '');
  endif; 
?>