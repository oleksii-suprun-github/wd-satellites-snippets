<?php 
  $post_counts = wp_count_posts( 'post' )->publish;
  if($post_counts > 1) : ?>
  <section id="post-content-settings" class="wdss-section">

    <?php 
      include_once(dirname(__DIR__). '/includes/modal.php');
      get_modal_template('fix-validation-posts-modal');
    ?>

    <div class="wdss-section-header">
      <h2 class="section-toggler">Post Content</h2>
      <div class="wdss-section-header-togglers">
        <i title="Pin this section as open" class=" lock section-pin"></i>
        <i class=" chevron-down section-toggler"></i>
      </div>
    </div>
    <div class="wdss-row hidden">
      <div class="wdss-section-content">

      <div id="wdss-fix-empty-content" class="wdss-setting-item">
            <span>Find & fix empty content<br><small>Be sure to create DB backup first</small></span>
            <button id="wdss-fix-empty-content__choose" type="button" class="wdss-button">Open settings</button>
        </div>
        </div>      
      </div>
  </section>
<?php endif; ?>