// Pin section as open even after page reload (localStorage based)
export default function sectionPinner() {
  const triggers = document.querySelectorAll('.wdss-section .section-pin');
  const sections_list = document.querySelectorAll('.wdss-section:not(#wdss-snippets-settings)');
  function setPinnedSection() {
    let pinned_section_list;
  
    if(localStorage.getItem('PINNED_WDS_SECTIONS')) {
      pinned_section_list = localStorage.getItem('PINNED_WDS_SECTIONS');
    }
    else {
      pinned_section_list = [];
      localStorage.setItem('PINNED_WDS_SECTIONS', JSON.stringify(pinned_section_list));
    }

    const sections_ids = pinned_section_list;
    sections_list.forEach(section => {
      let id = section.getAttribute('id');
      let header = section.querySelector('.wdss-section-header');
      let content = header.nextElementSibling;
      
      if(sections_ids.includes(id)) {
        section.classList.add('pinned');
        header.querySelector('i.section-pin').classList.add('active');
        header.querySelector('i.section-toggler').classList.add('disabled');

        header.classList.add('active');
        header.querySelector('h2').classList.add('pinned');
        content.classList.remove('hidden');
        
      }
    });

  }
  setPinnedSection();

  function addPinnedSection(data) { 
    let temp_arr = JSON.parse(localStorage.getItem('PINNED_WDS_SECTIONS')) || [];
    temp_arr.push(data);
    localStorage.setItem('PINNED_WDS_SECTIONS', JSON.stringify(temp_arr));
  }

  function removePinnedSection(data) {
    let temp_arr = JSON.parse(localStorage.getItem('PINNED_WDS_SECTIONS')) || [];

    let index = temp_arr.indexOf(data);
    if (index !== -1) {
      temp_arr.splice(index, 1);
    }
    localStorage.setItem('PINNED_WDS_SECTIONS', JSON.stringify(temp_arr));
  }

  function init() {
    let header = this.closest('.wdss-section-header');
    let current_section = header.closest('.wdss-section').getAttribute('id');

    let pinned_section_list = JSON.parse(localStorage.getItem('PINNED_WDS_SECTIONS')) || [];

    if(pinned_section_list.includes(current_section)) {
      this.classList.remove('active');
      header.querySelector('h2').classList.remove('pinned');
      header.querySelector('i.section-toggler').classList.remove('disabled');

      removePinnedSection(current_section);
    }
    else {
      this.classList.add('active');
      header.classList.add('active');
      addPinnedSection(current_section);
  
      header.querySelector('h2').classList.add('pinned');
      header.querySelector('i.section-toggler').classList.add('disabled');
    }
  }
  triggers.forEach(trigger => {
    trigger.addEventListener('click', init); 

  });
}