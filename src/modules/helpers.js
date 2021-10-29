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

  // Gets site title on click for Long Title Clipping Settings 
  export function getSiteTitle() {
    if(document.querySelector('#wdss-get-title')) {
      const btn = document.querySelector('#wdss-get-title');
      const input = document.querySelector('#wdss-title-ending input');
      const siteTitle = wdss_localize.site_title;
    
      btn.addEventListener('click', () => input.value = siteTitle);
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
  export function resetValue(item) {
    const button = document.querySelector(item.button);
    const target = document.querySelector(item.target);

    button.addEventListener('click', () => {
      if( target.value !== "" && confirm('Are you sure?') ) {
        target.value = "";
      }
    });
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