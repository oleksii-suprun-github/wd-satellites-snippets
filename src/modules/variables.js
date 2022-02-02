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
    title: 'Select Featured Images',
    types: ['image']
  };
  
  export const organizationLogoChooser = {
    select: '.image-chooser.logo button.choose',
    target: '.image-chooser.logo input',
    is_multiple: false,
    title: 'Select Organization Logo',
    types: ['image']
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
    query_type: 'rest',
    modal_el: '#exclude-posts-modal',
    modal_title: 'Delete Broken Featured Images',
    open_modal_btn: '#wdss-remove-broken-featured__choose',
    fetch_action:  'fetch_broken_featured',
    fetch_nonce_name: 'fetch_broken_featured_nonce',
    fetch_nonce_value: wdss_localize.broken_featured_list_nonce,
    post_action: 'remove_broken_featured',
    post_nonce_name: 'remove_broken_featured_nonce',
    post_nonce_value: wdss_localize.remove_broken_featured_nonce
  }

  export const fixEmptyPostsContent = {
    query_type: 'sql',
    modal_el: '#fix-validation-posts-modal',
    modal_title: 'Fix Empty Posts Content',
    open_modal_btn: '#wdss-fix-empty-content__choose',
    fetch_action:  'fetch_all_posts',
    fetch_nonce_name: 'empty_posts_list_nonce',
    fetch_nonce_value: wdss_localize.empty_posts_list_nonce,
    post_action: 'fix_posts_validation_errors',
    post_nonce_name: 'fix-posts-validation-errors-nonce',
    post_nonce_value: wdss_localize.fix_posts_validation_errors_nonce    
  }


  export const removeAllPostAttachments = {
    target_btn: '#wdss-delete-posts-attachments__button',
    confirm_msg: 'You are going to remove all attached images to all post! Continue?',
    data: 'true',
    post_action: 'remove_posts_attachments',
    post_nonce_name: 'remove-posts-attachments-nonce',
    post_nonce_value: wdss_localize.remove_posts_attachments_nonce
  }