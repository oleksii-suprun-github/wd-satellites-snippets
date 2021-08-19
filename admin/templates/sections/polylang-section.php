<?php 
  if( function_exists('pll_languages_list') )  : 
?>
<section id="polylang-settings" class="wdss-section">
  <div class="wdss-section-header">
    <h2>Polylang Settings</h2>
  </div>
  <div class="wdss-row">

    <div id="wdss-polylang-meta-data-conditions" class="wdss-setting-item">
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
        <h3>Homepage description</h3>
        
        <?php $polylang_lang_list = pll_languages_list(['fields' => []]);  ?>

          <div class="wdss-polylang-textarea-blocks">
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

      <div id="wdss-polylang-author-description" class="wdss-setting-item">
        <h3>Author`s page description</h3>

        <div class="wdss-polylang-textarea-blocks">

          <?php
            $authors = get_users( array( 'fields' => array( 'ID', 'display_name', 'user_nicename' ), 'has_published_posts' => 'post' ) );
            foreach($authors as $author) : 
          ?>    
            <div class="wdss-polylang-author-block">
              <h4><span class="dashicons dashicons-admin-users"></span> <?= $author->display_name; ?></h4>
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
      </div>
    </div>
</section>
<?php 
  else : 
    update_option('wdss_polylang_meta_data', '0');
  endif; 
?>