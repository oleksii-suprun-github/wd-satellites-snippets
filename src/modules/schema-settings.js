export default function schemaSectionSettings() {
  const toggler = document.querySelector('#wdss-advanced-jsonld-schema-condition input');
  const target = document.querySelector('.wdss-jsonld-schema-predifined-settings');

  if(toggler.hasAttribute('checked')) {
    target.classList.add('disabled');
  }

  function sectionToggler() {
    if(target.classList.contains('disabled')) {
      target.classList.remove('disabled');
    }
    else {
      target.classList.add('disabled');
    }
  }

  toggler.addEventListener('click', sectionToggler);
}