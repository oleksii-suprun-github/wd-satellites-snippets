function titleClippingSection() {
  const toggler = document.querySelector('#wdss-title-clipping input');
  const isEnabled = toggler.hasAttribute('checked');
  const group = document.querySelector('#wdss-title-clipping-group');
  
  if (isEnabled) {
    group.classList.toggle('visible');
  }
  
  toggler.addEventListener('click', () => {
    group.classList.toggle('visible');
  });
}


function init() {
  titleClippingSection();
}

document.addEventListener('DOMContentLoaded', init);