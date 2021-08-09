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


function init() {
  if(isPluginPage) {
    sectionToggler(titleClippingSection);
    sectionToggler(titleClippingByDateSection);
  }
}

document.addEventListener('DOMContentLoaded', init);