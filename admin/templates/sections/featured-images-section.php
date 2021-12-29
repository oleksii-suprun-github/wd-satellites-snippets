<?php 
  $total_post_count = wp_count_posts('post')->publish;

  $categories = get_categories();
  $categories_count = count($categories); 

  $polylang_default_lang = null;
  $polylang_current_lang = null;

  
  if( function_exists('pll_the_languages') ) {
    $polylang_default_lang = pll_default_language();
    $polylang_current_lang = $polylang_default_lang === pll_current_language();
  }

  if( $total_post_count > 0 )  : 
?>
<section id="featured-images-settings" class="wdss-section">

  <?php   
    include_once(dirname(__DIR__). '/includes/modal.php');
    get_modal_template('exclude-posts-modal');
  ?>

  <div class="wdss-section-header">
    <h2 class="section-toggler">Featured Images </h2>
    <div class="wdss-section-header-togglers">
      <i title="Pin this section as open" class="fas fa-lock section-pin"></i>
      <i class="fas fa-chevron-down section-toggler"></i>
    </div>
  </div>
  <div class="wdss-row hidden">
    <div class="wdss-section-content">

    <?php if( get_option('wdss_auto_featured_image') ) : ?>
     <div id="wdss-remove-broken-featured" class="wdss-setting-item">
          <span>Delete Broken Featured Images<br><small>Be sure to setup the option below first</small></span>
          <button id="wdss-remove-broken-featured__choose" type="button" class="wdss-button">Open settings</button>
		  </div>
    <?php endif; ?>


      <div id="wdss-auto-featured-image-condition" class="wdss-setting-item">
          <label>
              <span>Featured Image From Predefined Lists</span>
              <?php 
                checkbox_handler_html(['field_name' => 'wdss_auto_featured_image']); 
                if( get_option('wdss_auto_featured_image') == '' ) update_option( 'wdss_auto_featured_image', '0' );               
              ?>    
          </label>
      </div>

      <?php 
        if( $categories_count > 0 ) { ?>
          <div id="wdss-featured-images-group" class="wdss-setting-group hidden">    
            
          <?php if( $polylang_current_lang || !$polylang_default_lang ) : ?>
             <span>In case if there`s no images in post, you also can choose which images should be randomly picked for posts in each category </span>
          <?php elseif(!$polylang_current_lang) : ?>
              <span>Please change your lang to <?= strtoupper($polylang_default_lang); ?> in order to implement custom featured images</span>
          <?php endif; ?>
          
          <div id="default-category-featured" class="wdss-setting-item image-chooser featured">
            <span>-- *Default*</span>
             <?php 
                text_handler_html(['field_name' => 'wdss_featured_images_list_default']);            
              ?>  
              <button type="button" class="wdss-button choose">Choose</button>
              <button type="button" class="wdss-button reset"><i class="fas fa-trash"></i></button>
          </div>

          <?php 
          foreach( $categories as $category ) {

            $category_id = $category->term_id;

            if( $polylang_default_lang ) { 
              if( $polylang_current_lang )  {
                $category_tr =  get_category(pll_get_term($category_id)); 
                $category_tr_name = $category_tr->name;
                $category_tr_slug = $category_tr->slug;
                $category_tr_html_id = preg_replace('/\s+/', '-', strtolower($category_tr_name));
                $category_tr_option = preg_replace('/\-+/', '_', strtolower($category_tr_slug));
              ?>
                <div id="<?= $category_tr_html_id;?>-category-featured" class="wdss-setting-item image-chooser featured">
                <span>-- *<?= $category_tr_name?>*</span>
                <?php 
                  text_handler_html(['field_name' => 'wdss_featured_images_list_'. $category_tr_option . '']);            
                ?>  
                <button type="button" class="wdss-button choose">Choose</button>
                <button type="button" class="wdss-button reset"><i class="fas fa-trash"></i></button>
              </div>
  
              <?php 
              }
            }
            else { 
              $category_name = $category->name;
              $category_slug = $category->slug;
              $category_html_id = preg_replace('/\s+/', '-', strtolower($category_name));
              $category_option = preg_replace('/\-+/', '_', strtolower($category_slug));         
            ?>
              <div id="<?= $category_html_id;?>-category-featured" class="wdss-setting-item image-chooser featured">
              <span>-- *<?= $category_name?>*</span>
              <?php 
                text_handler_html(['field_name' => 'wdss_featured_images_list_'. $category_option . '']);            
              ?>  
              <button type="button" class="wdss-button choose">Choose</button>
              <button type="button" class="wdss-button reset"><i class="fas fa-trash"></i></button>
            </div>

          <?php }
          } ?>
        </div>
        <?php } ?>

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

    foreach( $categories as $category ) {
      $category_slug = $category->slug;
      $category_option = preg_replace('/\-+/', '_', strtolower($category_slug));

      update_option( 'wdss_featured_images_list_' . $category_option . '', '' );
    }
  endif; 
?>