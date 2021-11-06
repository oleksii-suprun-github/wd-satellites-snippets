<?php 
  $total_post_count = wp_count_posts('post')->publish;

  $categories = get_categories();
  $categories_count = count($categories); 

  if( $total_post_count > 0 )  : 
?>
<section id="featured-images-settings" class="wdss-section">
  <div class="wdss-section-header">
    <h2 class="section-toggler">Featured Images </h2>
    <div class="wdss-section-header-togglers">
      <i title="Pin this section as open" class="fas fa-lock section-pin"></i>
      <i class="fas fa-chevron-down section-toggler"></i>
    </div>
  </div>
  <div class="wdss-row hidden">
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

      <?php 
        if( $categories_count > 0 ) : ?>
          <div id="wdss-featured-images-group" class="wdss-setting-group hidden">    
          <span>You also can choose which images should be randomly picked for posts in each category </span>
          <?php foreach($categories as $category) : ?>

            <?php 
              $category_name = $category->name;
              $category_option = preg_replace('/\s+/', '_', strtolower($category_name));
              $category_id = preg_replace('/\s+/', '-', strtolower($category_name));
           ?>

            <div id="<?= $category_id;?>-category-featured" class="wdss-setting-item image-chooser featured">
              <span>-- For *<?= $category_name?>*</span>
              <?php 
                text_handler_html(['field_name' => 'wdss_featured_images_list_'. $category_option . '']);            
              ?>  
              <button type="button" class="wdss-button choose">Choose</button>
              <button type="button" class="wdss-button reset"><i class="fas fa-trash"></i></button>
            </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

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

    foreach($categories as $category) {
      $category_name = $category->name;
      $category_option = preg_replace('/\s+/', '_', strtolower($category_name));

      update_option('wdss_featured_images_list_' . $category_option . '', '');
    }
  endif; 
?>