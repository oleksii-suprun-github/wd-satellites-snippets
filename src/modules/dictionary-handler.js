import {hideMessage, areArrsEqual} from "./helpers";
import {Notification} from './notifications';  
let notification = new Notification;

// Title Dictionary Handler
export default function dictionaryHandler(dictionary) {

  // Constants diclarations
  const root_el = document.querySelector(dictionary.root_el);

  if(root_el) {

    const add_item_button = root_el.querySelector('.wdss-button.wdss-table-add');
    const save_dictionary_button = root_el.querySelector('.save-dictionary');
    const form = document.querySelector('#wdss-settings-page form');
    const table = root_el.querySelector('.wdss-table-handler .wdss-table tbody');
  
    const url = root_el.querySelector('input[type="text"]');
    
    // Counts initial dictionary options
    let table_rows = jQuery(`${dictionary.root_el} .wdss-table tbody tr`);
    let table_rows_ids = [];
    jQuery.each(table_rows, function() {table_rows_ids.push(this.id)});
  
    // Sends added rules to DB with wp_update_option func via ajax
    function updateDictionary() {
      let dictionary_rows = jQuery(`${dictionary.root_el} .wdss-table-handler .wdss-table tbody tr`);
      let dictionary_data = [];
  
      dictionary_rows.each((index, row) => {
        let value = row.querySelector('td:nth-of-type(1)').textContent;
        dictionary_data.push(value);
      });
  
      let data_obj = {
          action : dictionary.action,
          security : dictionary.nonce,
      }
      data_obj[dictionary.name] = dictionary_data;
  
      jQuery.ajax({
        url : wdss_localize.url,
        type : 'post',
        dataType: 'json',
        data : data_obj,
        success : function() {
          let status_msg = root_el.querySelector('.wdss-table-actions span');
          if(status_msg) status_msg.remove();
          
          save_dictionary_button.insertAdjacentHTML('afterend', '<span class="msg successful">Table was updated</span>');
  
          hideMessage(root_el.querySelector('span.msg'), 1200);
  
          save_dictionary_button.classList.add('saved');
        },
        fail : function(error) {
          let status_msg = root_el.querySelector('.wdss-table-actions span');
          if(status_msg) status_msg.remove();
  
          save_dictionary_button.insertAdjacentHTML('afterend', '<span class="msg error">Error, look at information in console</span>');
          
          hideMessage(root_el.querySelector('span.msg'), 1200);
  
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
          <td class="wdss-table__remove-item"><i class="trash"></i></td>
        </tr>
        `);
      }
    }
    add_item_button.addEventListener('click', addItem);
  
    // Removes rule from dictionary
    function removeItem() {
      save_dictionary_button.classList.remove('saved');
      notification.confirm('Remove this rule from table?').then( result => {
        if(result === true) {
          this.closest('tr').remove();
        }
      });
    }
    jQuery(document).on('click',`${dictionary.root_el} .wdss-table__remove-item i`, removeItem);
  
    // Checks if no unsaved changes are left
    async function onSave(e) {
  
      // Counts actual (on save) dictionary options
      let current_table_rows = jQuery(`${dictionary.root_el} .wdss-table tbody tr`);
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

}