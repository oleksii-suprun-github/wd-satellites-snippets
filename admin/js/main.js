// Condition for calling our functions
const isPluginPage = document.querySelector('#wdss-settings-page');

// Selectors for our functions
const titleClippingSection = {
  toggler: '#wdss-title-clipping-condition input',
  target: '#wdss-title-clipping-group'
};

const featuredImageSection = {
  toggler: '#wdss-auto-featured-image-condition input',
  target: '#wdss-featured-images-group'
};

const customSchemaSection = {
  toggler: '#wdss-advanced-jsonld-schema-condition input',
  target: '#wdss-advanced-jsonld-schema-group' 
}

const polylangSection = {
  toggler: '#wdss-polylang-meta-data-condition input',
  target: '#wdss-polylang-meta-data-group'  
};

const cutTitleClippingReset = {
  button: '#wdss-title-clipping-excluded button.reset',
  target: '#wdss-title-clipping-excluded input'
};

const cutTitleSinceReset = {
  button: '#wdss-title-clipping-by-date button.reset',
  target: '#wdss-title-clipping-by-date input'
};

const featuredImagesListReset = {
  button: '#wdss-featured-images-group button.reset',
  target: '#wdss-featured-images-group input'
};

const organizationLogoReset = {
  button: '#wdss-jsonld-schema-logo button.reset',
  target: '#wdss-jsonld-schema-logo input'
};

const featuredImagesChooser = {
  select: '#wdss-featured-images__choose',
  target: '#wdss-featured-images-list input',
  is_multiple: true
};

const organizationLogoChooser = {
  select: '#wdss_jsonld_schema_logo__choose',
  target: '#wdss-jsonld-schema-logo input',
  is_multiple: false
}




// Resets value attr in target input
function resetValue(item) {
  const button = document.querySelector(item.button);
  const target = document.querySelector(item.target);

  button.addEventListener('click', () => {
    if( target.value !== "" && confirm('Are you sure?') ) {
      target.value = "";
    }
  });
}

// Show/hide section on click helper
function sectionToggler() {
  const sectionsList = document.querySelectorAll('.wdss-section:not(#wdss-snippets-settings) > .wdss-row');
  sectionsList.forEach((section) => {
    section.classList.add('hidden');

    let header = section.previousElementSibling;

    if(header) {
      header.addEventListener('click', () => {
        header.classList.toggle('active');
        section.classList.toggle('hidden');  
      });  
    }

  });
}


// Show/hide group on-condition helper
function groupToggler(section) {  
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


// Show/hide accordion content helper
function toggleAccordion() {
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
function toggleCheckbox() {
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

// Checks/unchecks all checkbox inputs within section
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

// Gets site title on click for Long Title Clipping Settings 
function getSiteTitle() {
  if(document.querySelector('#wdss-get-title')) {
    const btn = document.querySelector('#wdss-get-title');
    const input = document.querySelector('#wdss-title-ending input');
    const siteTitle = wdss_localize.site_title;
  
    btn.addEventListener('click', () => input.value = siteTitle);
  }
}

// Custom popup with list of published posts for Long Title Clipping Settings
function getPostsModal() {
  const btn = document.querySelector('#wdss-title-clipping-excluded__choose');
  const context = document.querySelector('#wdss-title-clipping-excluded');

  btn.addEventListener('click', init);

  function init() {

    jQuery.ajax({
        url : wdss_localize.url,
        type : 'post',
        data : {
          action : 'fetch_modal_content',
          security : wdss_localize.nonce,
        },
        success : function(response) {
          modalHandler.call(context, response);
        
        }
    });
  }

  function modalHandler($content) {

    const html = document.querySelector('html'); 
    html.classList.add('fixed');

    this.insertAdjacentHTML('beforeend', $content);
    
    const posts = Array.from(document.querySelectorAll('.wdss-table-row.post'));
    posts.forEach(post => {
        post.addEventListener('click', () => {
          let checkbox = post.querySelector('.wdss-table-post__select input[type="checkbox"]');
          if(checkbox.hasAttribute('checked')) {
            uncheck(checkbox);
          }
          else {
            check(checkbox);
          }
        });
    });

    function check(input) {
      input.setAttribute('checked', 'checked');
      input.checked = true; 
    }

    function uncheck(input) {
      input.removeAttribute('checked');
      input.checked = false;
    }


    const modal = this.querySelector('.wdss-modal');
    const close_btn = modal.querySelector('.wdss-modal-header i');
    const save_btn = modal.querySelector('.wdss-button.submit');
    const input = this.querySelector('#wdss-title-clipping-excluded input[type="text"]');
  
    if(input.value !== '') {
      let inputIdsArr = input.value.split(',');
      let checkboxes = Array.from(modal.querySelectorAll('.wdss-table-post__select input[type="checkbox"]'));
      checkboxes.forEach(checkbox => {
        if(inputIdsArr.includes(checkbox.value)) {
          checkbox.setAttribute('checked', 'checked');
          checkbox.checked = true;
        }
      });
    }

    function closeModal() {
      modal.remove();
      html.classList.remove('fixed');
    }

    close_btn.addEventListener('click', closeModal);
    document.onkeydown = ((e) => {
      if(e.key === 'Esc' || e.key === 'Escape') {
        closeModal();
      }
    });
    
    save_btn.addEventListener('click', () => {
      
      const posts = modal.querySelectorAll('.wdss-table-post__select input[type="checkbox"]:checked');

      console.log(posts);

      let idsArr = [];
      let ids;
  
      posts.forEach(post => {
        idsArr.push(post.value);
      });
  
      ids = idsArr.join(',');
      input.value = ids;
      modal.remove();
      html.classList.remove('fixed');
    });
  }
}


// Built-in WP.media popup for Featured Images Settings
function mediaFileChooser(obj) {
  const btn = document.querySelector(obj.select);

  btn.addEventListener('click', function(e) {
      e.preventDefault();
      
      let image_frame;
      if (image_frame) {
        image_frame.open();
      }

      image_frame = wp.media({
        title: 'Select Featured Images',
        multiple: obj.is_multiple,
        library: {
          type: 'image',
        },
        button: {
          text: 'Select'
        }
      });

      image_frame.on('close', function() {
        let is_featured_image_section = btn.closest('#wdss-featured-images-list');
        let selection = image_frame.state().get('selection');

        let gallery_ids = new Array();
        let gallery_urls = new Array();
        let index = 0;

        if(is_featured_image_section) {
          selection.forEach(function(attachment) {
            gallery_ids[index] = attachment['id'];
            index++;
          });
          let ids = gallery_ids.join(",");
          document.querySelector(obj.target).value = ids;
        }
        else {
          selection.forEach(function(attachment) {
            gallery_urls[index] = attachment.attributes['url'];
            index++;
          });
          let urls = gallery_urls.join(",");
          document.querySelector(obj.target).value = urls;         
        }
      });

      image_frame.on('open', function() {
        let selection = image_frame.state().get('selection');
        let ids = document.querySelector(obj.target).value.split(',');
        ids.forEach(function(id) {
          let attachment = wp.media.attachment(id);
          attachment.fetch();
          selection.add(attachment ? [attachment] : []);
        });

      });

      image_frame.open();
  });
}


function schemaSectionSettings() {
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


function Init() {
  if(isPluginPage) {
    
    sectionToggler();

    if(wdss_localize.total_post_count > 0) {
      groupToggler(titleClippingSection);
      groupToggler(featuredImageSection);
      getSiteTitle();

      mediaFileChooser(featuredImagesChooser);

      resetValue(cutTitleClippingReset);
      resetValue(cutTitleSinceReset);
      resetValue(featuredImagesListReset);


      getPostsModal();
    }

    if(wdss_localize.is_polylang_exists) {
      groupToggler(polylangSection);  
    }

    mediaFileChooser(organizationLogoChooser);
    resetValue(organizationLogoReset);

    schemaSectionSettings();
    groupToggler(customSchemaSection);

    toggleCheckbox();
    toggleAllOptions();
    toggleAccordion();
  }
}

document.addEventListener('DOMContentLoaded', Init);