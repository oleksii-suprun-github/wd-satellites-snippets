  // Selectors for our functions
  export const featuredImageSection = {
    toggler: '#wdss-auto-featured-image-condition input',
    target: '#wdss-featured-images-group'
  };
  
  export  const polylangSection = {
    toggler: '#wdss-polylang-meta-data-condition input',
    target: '#wdss-polylang-meta-data-group'  
  };
  
  export const featuredImagesListReset = {
    button: '#wdss-featured-images-group button.reset',
    target: '#wdss-featured-images-group input'
  };
  
  export const organizationLogoReset = {
    button: '#wdss-jsonld-schema-logo button.reset',
    target: '#wdss-jsonld-schema-logo input'
  };
  
  export const featuredImagesChooser = {
    select: '.image-chooser.featured button.choose',
    target: '.image-chooser.featured input',
    is_multiple: true,
    title: 'Select Featured Images'
  };
  
  export const organizationLogoChooser = {
    select: '.image-chooser.logo button.choose',
    target: '.image-chooser.logo input',
    is_multiple: false,
    title: 'Select Organization Logo'
  }
  
  export const getOgranizationName = {
    selector: '#wdss-generate-orgname',
    input: '#wdss-jsonld-schema-orgname input',
  }
  
  export const getSiteEmail = {
    selector: '#wdss-generate-email',
    input: '#wdss-jsonld-schema-email input',
  }
  
  export const e410_Dictionary = {
    root_el: '#custom-410s-list-settings',
    action: 'e410_dictionary_update',
    nonce: 'e410-dictionary-nonce',
    name: 'e410_dictionary'
  }
  
  export const excludedHostsDictionary = {
    root_el: '#post-content-settings',
    action: 'excluded_hosts_dictionary_update',
    nonce: 'excluded-hosts-dictionary-nonce',
    name: 'excluded_hosts_dictionary'
  }

  export const removeBrokenFeatured = {
    modal_el: '#exclude-posts-modal',
    open_modal_btn: '#wdss-remove-broken-featured__choose',
    fetch_action:  'fetch_broken_featured',
    fetch_nonce_name: 'fetch_broken_featured_nonce',
    fetch_nonce_value: wdss_localize.broken_featured_list_nonce,
    post_action: 'remove_broken_featured',
    post_nonce_name: 'remove_broken_featured_nonce',
    post_nonce_value: wdss_localize.remove_broken_featured_nonce
  }
