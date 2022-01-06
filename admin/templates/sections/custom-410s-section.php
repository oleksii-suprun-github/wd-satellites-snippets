<section id="custom-410s-list-settings" class="wdss-section">
  <div class="wdss-section-header">
    <h2 class="section-toggler">Custom 410s </h2>
    <div class="wdss-section-header-togglers">
      <i title="Pin this section as open" class=" lock section-pin"></i>
      <i class=" chevron-down section-toggler"></i>
    </div>
  </div>
  <div class="wdss-row hidden">
    <div class="wdss-section-content">
      <div class="wdss-setting-item wdss-table-handler">
          <div class="wdss-table-description">
            <strong>Add relative URL`s which should have 410 Status Code</strong>
          </div>
          <div class="wdss-table-content">
                <div class="wdss-table-add-item-handler">
                  <div class="wdss-table-input">
                    <span>Relative URL</span>
                    <?php text_handler_html(
                      ['field_name' => 'wdss_410s_dictionary_url', 
                       'id' => 'wdss-410s-dictionary-url',
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
                          if( get_option('wdss_410s_dictionary', '') ) {
                            $dictionary = get_option('wdss_410s_dictionary');
                            foreach ($dictionary as $url) : ?>
                              <tr id="<?= wp_rand();?>">
                                <td><?= $url; ?></td>
                                <td class="wdss-table__remove-item"><i class="trash"></i></td>
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
</section>