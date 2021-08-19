const isPluginPage = document.querySelector('#wdss-settings-page');

const titleClippingSection = {
  toggler: '#wdss-title-clipping-condition input',
  target: '#wdss-title-clipping-group'
};

const titleClippingByDateSection = {
  toggler: '#wdss-title-clipping-condition input',
  target: '#wdss-title-clipping-by-date'
};

const featuredImageSection = {
  toggler: '#wdss-featured-images-condition input',
  target: '#wdss-featured-images-group'
};

const polylangSection = {
  toggler: '#wdss-polylang-meta-data-conditions input',
  target: '#wdss-polylang-meta-data-group'  
}


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

function getSiteTitle() {
  const btn = document.querySelector('#wdss-get-title');
  const input = document.querySelector('#wdss-title-ending input');
  const siteTitle = wdss_localize.site_title;

  btn.addEventListener('click', () => input.value = siteTitle);
}


function Init() {
  if(isPluginPage) {
    if(wdss_localize.total_post_count > 0) {
      sectionToggler(titleClippingSection);
      sectionToggler(titleClippingByDateSection);
      sectionToggler(featuredImageSection);
      getSiteTitle();
    }
    if(wdss_localize.is_polylang_exists) {
      sectionToggler(polylangSection);  
    }
    toggleCheckbox();
    toggleAllOptions();
  }
}

document.addEventListener('DOMContentLoaded', Init);