  // Deep array comparison helper
  export const areArrsEqual = (first, second) => {
    if(first.length !== second.length){
      return false;
    };
    for(let i = 0; i < first.length; i++){
      if(!second.includes(first[i])){
          return false;
      };
    };
    return true;
  };

  // Gets site specific info by request
  export function getSiteInfo(obj) {
      function init() {
        let target = document.querySelector(obj.input);
        let action = '';
    
        switch (obj.input) {
          case '#wdss-jsonld-schema-orgname input':
            action = wdss_localize.site_name;
            break;
          case '#wdss-jsonld-schema-email input':
            action = wdss_localize.site_email;
            break;          
          default:
            break;
        }
        target.value = action;
      }

      if(obj && document.querySelector(obj.selector)) {
        document.querySelector(obj.selector).addEventListener('click', init);
      }
  }

  // Hide notices with time helper
  export const hideMessage = (element, timeout) => {
    setTimeout(function() {
      element.remove();
    }, timeout);
  };

  // Show/hide accordion content helper
  export function accordionToggler() {
    const accordions = Array.from(document.querySelectorAll('.wdss-setting-item-accordion'));

    accordions.forEach(accordion => {

      let content = accordion.nextElementSibling;

      accordion.addEventListener('click', () => {
        if(content.classList.contains('active')) {
          accordion.classList.remove('opened');
          content.classList.remove('active');
        }
        else {
          accordion.classList.add('opened');
          content.classList.add('active');
        }
      });
    });
  }

  // Checkbox toggle helper
  export function checkboxToggler() {
    const inputs = Array.from(document.querySelectorAll('input[type="checkbox"'));
    inputs.forEach((input) => {
      input.addEventListener('click', () => {
        
        if(input.hasAttribute('checked')) {
          input.removeAttribute('checked');
          input.value = 0;
          input.checked = false;
        }
        else {
          input.setAttribute('checked', 'checked');
          input.checked = true;
          input.value = 1;
        }
      })
    });
  }

  // Show/hide section on click helper
  export function sectionToggler() {
    const sectionsList = document.querySelectorAll('.wdss-section:not(#wdss-snippets-settings) > .wdss-row');

    sectionsList.forEach((section) => {

      if(!section.classList.contains('pinned')) {
        section.classList.add('hidden');
      }

      let header = section.previousElementSibling;
      let togglers = header.querySelectorAll('.section-toggler');

      function init() {
        header.classList.toggle('active');
        section.classList.toggle('hidden');  
      }

      if(togglers) {
        togglers.forEach(toggler => {
          toggler.addEventListener('click', init);  
        });
      }
    });
  }

  // Show/hide group on-condition helper
  export function groupToggler(section) {  
    const toggler = document.querySelector(section.toggler);
    const is_enabled = toggler.hasAttribute('checked');
    const target = document.querySelector(section.target);
    
    if (is_enabled) {
      target.classList.toggle('hidden');
    }
    
    toggler.addEventListener('click', () => {
      target.classList.toggle('hidden');
    });
  }

  // Resets value attr in target input
  export function resetValues(...items) {
    items.forEach(item => {
      const buttons = Array.from(document.querySelectorAll(item.button));

      buttons.forEach(button => {
        button.addEventListener('click', () => {
          let parent = button.closest('div');
          let target = parent.querySelector(item.target);
  
          if( target.value !== "" && confirm('Are you sure?') ) target.value = "";
        });
      });
    });
  }


  // Notification modal
  export function notification(msg, type = 'info', target_func) {

    let notification_template;
    let html = document.querySelector('html');
    let notification_class;

    switch (type) {
      case 'info':
        notification_class = 'info';
        break;
        case 'prompt':
          notification_class = 'prompt';
          break;
      default:
        break;
    }

    function closeNotification() {
      this.closest('.notification').remove();
      if(type === 'prompt') html.classList.remove('fixed');
    }

    if(type === 'prompt') html.classList.add('fixed');

    notification_template = `
    <div class="modal notification ${notification_class}">
    <div class="notification-header">
      <i class="fas fa-times"></i>
    </div>
    <div class="notification-content">
    <span>${msg}</span>
    </div>`;

    if(type === 'prompt') {
      html.classList.add('fixed');
      notification_template += `<div class="notification-content-inputs"><input required type="number" min="100" value="100"><button type="button" class="wdss-button">Enter</button></div>`;
    }
    notification_template += `</div>`;
    document.body.insertAdjacentHTML('beforeend', notification_template);


    if(document.querySelector('.modal.notification')) {
      let notification = document.querySelector('.modal.notification');
      let close_notification = notification.querySelector('i');
      close_notification.addEventListener('click', closeNotification);

      if(type === 'prompt' && document.querySelector('.notification-content-inputs')) {
        let inputs_panel = document.querySelector('.notification-content-inputs');
        let input = inputs_panel.querySelector('input');
        let button = inputs_panel.querySelector('button');
        if(input.value) {
          button.addEventListener('click', function() {
            target_func(input.value);
            notification.remove();
        });
        }
      }
    
    }
  }


  // Check option in modal window
  export function check(input) {
    input.setAttribute('checked', 'checked');
    input.checked = true; 
  }

  // Un-check option in modal window
  export function uncheck(input) {
    input.removeAttribute('checked');
    input.checked = false;
  }



  // Checks/unchecks all checkbox inputs within section
  export function toggleAllOptions() {
    const inputs = Array.from(document.querySelectorAll('#wdss-snippets-settings input'));
    let toggler = document.querySelector('#wdss-toggle-options');

    function uncheckAll() {
      inputs.forEach((input) => {
          input.removeAttribute('checked');
          input.checked = false;
      });  
    }

    function checkAll() {
      inputs.forEach((input) => {
          input.setAttribute('checked', 'checked');
          input.checked = true;
      });  
    }

    toggler.addEventListener('click', () => {
      if(inputs[0].hasAttribute('checked')) {
        uncheckAll();
      }
      else {
        checkAll();
      }
    });
  }