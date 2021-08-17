const isPluginPage = document.querySelector('#wdss-settings-page');

const titleClippingSection = {
  toggler: '#wdss-title-clipping input',
  target: '#wdss-title-clipping-group'
};

const titleClippingByDateSection = {
  toggler: '#wdss-title-clipping-condition input',
  target: '#wdss-title-clipping-by-date'
};


function sectionToggler(section) {

  const toggler = document.querySelector(section.toggler);
  const isEnabled = toggler.hasAttribute('checked');
  const target = document.querySelector(section.target);
  
  if (isEnabled) {
    target.classList.toggle('visible');
  }
  
  toggler.addEventListener('click', () => {
    target.classList.toggle('visible');
  });
}


function toggleCheckbox() {
  const inputs = Array.from(document.querySelectorAll('input[type="checkbox"'));
  inputs.forEach((input) => {
    input.addEventListener('click', () => {
      
      if(input.hasAttribute('checked')) {
        input.removeAttribute('checked');
        input.checked = false;
      }
      else {
        input.setAttribute('checked', 'checked');
        input.checked = true;
      }
    })
  });
}


function toggleAllOptions() {
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


function init() {
  if(isPluginPage) {
    sectionToggler(titleClippingSection);
    sectionToggler(titleClippingByDateSection);
    toggleCheckbox();
    toggleAllOptions();
  }
}

document.addEventListener('DOMContentLoaded', init);