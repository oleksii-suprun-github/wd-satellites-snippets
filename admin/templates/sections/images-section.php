<section id="images-settings" class="wdss-section">
  <div class="wdss-section-header">
    <h2 class="section-toggler">Post Images</h2>
    <div class="wdss-section-header-togglers">
      <i title="Pin this section as open" class="fas fa-lock section-pin"></i>
      <i class="fas fa-chevron-down section-toggler"></i>
    </div>
  </div>
  <div class="wdss-row hidden">
    <div class="wdss-section-content">
      <div class="wdss-section-content-description">
        <strong>Provide URLs with images which will be EXCLUDED from post content</strong>
      </div>

      <div class="wdp-add-item-panel">
                  <div class="wdss-list-item">
                    <span>Host (e.g. google.com)</span>
                    <?php text_handler_html(
                      ['field_name' => 'wdss_excluded_hosts_dictionary_url', 
                       'id' => 'wdss-excluded-host-url',
                       ]
                      ); ?>
                  </div>

                  <div class="wdss-list-item-handlers">
                    <span title="Add a new rule" class="wdss-list-item-handler add">Add</span>
                  </div>        
                </div>
      <div class="wdss-list-table-wrapper">
                  <table class="wdss-list-table">
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
                                <td class="wdss-list-table__remove-item"><i class="fas fa-trash"></i></td>
                              </tr>
                            <?php endforeach; 
                          } ?>
                    </tbody>
                  </table>
                  <div class="wdss-list-table-actions">
                    <button type="button" class="wdp-button save-dictionary">Save</button>
                  </div>
                </div>
              </div>      
    </div>
</section>