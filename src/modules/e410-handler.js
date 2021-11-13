import {hideMessage, areArrsEqual} from "./helpers";

// Title Dictionary Handler
export default function E410_DictionaryHandler() {
  // Constants diclarations
  const add_item_button = document.querySelector('.wdss-list-item-handler.add');
  const save_dictionary_button = document.querySelector('.save-dictionary');
  const form = document.querySelector('#wdss-settings-page form');
  const table = document.querySelector('.wdss-list-table tbody');
  const url = document.querySelector('#wdss-410s-dictionary-url');
  
  // Counts initial dictionary options
  let table_rows = jQuery('.wdss-list-table tbody tr');
  let table_rows_ids = [];
  jQuery.each(table_rows, function() {table_rows_ids.push(this.id)});

  // Sends added rules to DB with wp_update_option func via ajax
  function updateDictionary() {
    let dictionary_rows = jQuery('.wdss-list-table tbody tr');
    let data_obj = [];

    dictionary_rows.each((index, row) => {
      let value = row.querySelector('td:nth-of-type(1)').textContent;
      data_obj.push(value);
    });

    jQuery.ajax({
      url : wdss_localize.url,
      type : 'post',
      dataType: 'json',
      data : {
        action : 'e410_dictionary_update',
        e410_dictionary: data_obj,
        security : wdss_localize.e410_dictionary_nonce,
      },
      success : function(response) {
        let status_msg = document.querySelector('.wdss-list-table-actions span');
        if(status_msg) status_msg.remove();
        
        save_dictionary_button.insertAdjacentHTML('afterend', '<span class="msg successful">Table was updated</span>');

        hideMessage(document.querySelector('span.msg'), 1200);

        save_dictionary_button.classList.add('saved');
      },
      fail : function(error) {
        let status_msg = document.querySelector('.wdss-list-table-actions span');
        if(status_msg) status_msg.remove();

        save_dictionary_button.insertAdjacentHTML('afterend', '<span class="msg error">Error, look at information in console</span>');
        
        hideMessage(document.querySelector('span.msg'), 1200);

        console.log(error);
      }
    });
  }
  save_dictionary_button.addEventListener('click', updateDictionary);

  // Adds rule to dictionary
  function addItem() {
    if(url.value) {
      save_dictionary_button.classList.remove('saved');
      let url_temp = url.value;
  
      url.value = '';
  
      table.insertAdjacentHTML('beforeend',`
      <tr id="${wdss_localize.wp_rand}">
        <td>${url_temp}</td>
        <td class="wdss-list-table__remove-item"><i class="fas fa-trash"></i></td>
      </tr>
      `);
    }
  }
  add_item_button.addEventListener('click', addItem);

  // Removes rule from dictionary
  function removeItem() {
    save_dictionary_button.classList.remove('saved');
    if(confirm('Remove this rule from table?')) {
      this.closest('tr').remove();
    }
  }
  jQuery(document).on('click','.wdss-list-table__remove-item i', removeItem);

  // Checks if no unsaved changes are left
  function onSave(e) {
    // Counts actual (on save) dictionary options
    let current_table_rows = jQuery('.wdss-list-table tbody tr');
    let current_table_rows_ids = [];
    jQuery.each(current_table_rows, function() {
      current_table_rows_ids.push(this.id);
    });

    // Checks if saved options are equal to currents
    let is_ids_equals;
    if(areArrsEqual(table_rows_ids, current_table_rows_ids)) is_ids_equals = true;

    // If options are not equal & changes unsaved then show notification
    if( !is_ids_equals && !save_dictionary_button.classList.contains('saved')) {
      let warning_msg = confirm('All unsaved changes will be lost. Do you want to continue?');
      if(!warning_msg) {
        e.preventDefault();
      }
    }
  }
  form.addEventListener('submit', onSave);
}