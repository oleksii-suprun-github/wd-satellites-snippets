<section id="post-content-settings" class="wdss-section">

  <?php 
    include_once(dirname(__DIR__). '/includes/modal.php');
    get_modal_template('fix-validation-posts-modal');
  ?>

  <div class="wdss-section-header">
    <h2 class="section-toggler">Post Content</h2>
    <div class="wdss-section-header-togglers">
      <i title="Pin this section as open" class="fas fa-lock section-pin"></i>
      <i class="fas fa-chevron-down section-toggler"></i>
    </div>
  </div>
  <div class="wdss-row hidden">
    <div class="wdss-section-content">

    <div id="wdss-fix-validation-errors" class="wdss-setting-item">
          <span>Fix Validation Errors<br><small>Be sure to create DB backup first</small></span>
          <button id="wdss-fix-validation-errors__choose" type="button" class="wdss-button">Open settings</button>
		  </div>

      <div class="wdss-setting-item wdss-table-handler">
          <div class="wdss-table-description">
            <strong>Provide URLs with images which will be EXCLUDED from post content</strong>
          </div>
          <div class="wdss-table-content">
                <div class="wdss-table-add-item-handler">
                  <div class="wdss-table-input">
                    <span>Host (e.g. google.com)</span>
                    <?php text_handler_html(
                      ['field_name' => 'wdss_excluded_hosts_dictionary_url', 
                       'id' => 'wdss-excluded-host-url',
                       ]
                      ); ?>
                  </div>
                  <button type="button" title="Add a new rule" class="wdss-button wdss-table-add">Add</button>     
                </div>

                <div class="wdss-table-wrapper">
                  <table class="wdss-table">
                    <thead>
                      <th>URL</th>
                      <th>Action</th>
                    </thead>
                    <tbody>
                        <?php 
                          if( get_option('wdss_excluded_hosts_dictionary', '') ) {
                            $dictionary = get_option('wdss_excluded_hosts_dictionary');
                            foreach ($dictionary as $url) : ?>
                              <tr id="<?= wp_rand();?>">
                                <td><?= $url; ?></td>
                                <td class="wdss-table__remove-item"><i class="fas fa-trash"></i></td>
                              </tr>
                            <?php endforeach; 
                          } 
                        ?>
                    </tbody>
                  </table>
                  <div class="wdss-table-actions">
                    <button type="button" class="wdss-button save-dictionary">Save</button>
                  </div>
                </div>
          </div>
      </div>
      </div>      
    </div>
</section>
