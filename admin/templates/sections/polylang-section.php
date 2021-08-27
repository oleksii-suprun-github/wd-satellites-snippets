<?php 
  if( function_exists('pll_languages_list') )  : 
?>
<section id="polylang-settings" class="wdss-section">
  <div class="wdss-section-header">
    <h2>Multilang Settings</h2>
  </div>
  <div class="wdss-row">

    <div id="wdss-polylang-meta-data-condition" class="wdss-setting-item">
        <label>
            <span>Custom meta descriptions</span>
            <?php 
              checkbox_handler_html(['field_name' => 'wdss_polylang_meta_data']); 
              if( get_option('wdss_polylang_meta_data') == '' ) update_option( 'wdss_polylang_meta_data', '0' );               
            ?>    
        </label>
    </div>

    <div id="wdss-polylang-meta-data-group" class="wdss-setting-group">    
      <div id="wdss-polylang-homepage-description" class="wdss-setting-item">
        <div class="wdss-setting-item-accordion">
          <h3>Homepage description</h3>
          <i class="fas fa-chevron-down"></i>
        </div>

        <?php $polylang_lang_list = pll_languages_list(['fields' => []]);  ?>

          <div class="wdss-setting-item-accordion-content">
                <?php foreach($polylang_lang_list as $lang) : ?>
                  <div class="wdss-polylang-textarea-block">
                    <strong><?= $lang->name; ?></strong>
                      <?php 
                        textarea_handler_html(['field_name' => 'wdss_polylang_home_desc_' . $lang->slug . '']);        
                      ?>
                  </div>
                <?php endforeach;  ?>
          </div>
      </div>   

      <?php 
        $total_posts = wp_count_posts('post')->publish;
        if($total_posts > 0) : 
      ?>
        <div id="wdss-polylang-author-description" class="wdss-setting-item">
          <div class="wdss-setting-item-accordion">
            <h3>Author`s page description</h3>
            <i class="fas fa-chevron-down"></i>
          </div>

          <div class="wdss-setting-item-accordion-content">
            <?php
              $authors = get_users( array( 'fields' => array( 'ID', 'display_name', 'user_nicename' ), 'has_published_posts' => 'post' ) );
              foreach($authors as $author) : 
            ?>    
            <div class="wdss-polylang-author-block">
              <h4><i class="fas fa-user"></i> <?= $author->display_name; ?></h4>
              <div class="wdss-polylang-textarea-blocks">
                <?php foreach($polylang_lang_list as $lang) : ?>
                <div class="wdss-polylang-textarea-block">
                  <strong><?= $lang->name; ?></strong>
                    <?php 
                      textarea_handler_html(['field_name' => 'wdss_polylang_author_desc_' . $author->user_nicename . '_'. $lang->slug . '']);       
                    ?>
                </div>
                <?php endforeach;  ?>
              </div>
            <?php endforeach; ?>   
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div id="wdss-multilang-sitemap-condition" class="wdss-setting-item">
      <label>
          <span>Use Multilang Sitemap<br> instead of Yoast</span>
          <?php 
            checkbox_handler_html(['field_name' => 'wdss_multilang_sitemap']); 
            if( get_option('wdss_multilang_sitemap') == '' ) update_option( 'wdss_multilang_sitemap', '0' );               
          ?>    
      </label>
  </div>

</section>
<?php 
  else : 
    update_option('wdss_polylang_meta_data', '0');
    update_option('wdss_multilang_sitemap', '0');
  endif; 
?>