import {getSiteTitle, accordionToggler, checkboxToggler, sectionToggler, groupToggler, resetValue, toggleAllOptions} from "./js/helpers";
import schemaSectionSettings from "./js/schema-settings";
import mediaFileChooser from "./js/media-file-chooser";
import getPostsModal from "./js/posts-modal";
import sectionPinner from "./js/section-pinner";
import './css/styles.css';

// Condition for calling our functions
const pluginPage = document.querySelector('#wdss-settings-page');

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


function Init() {
  if(pluginPage) {
    sectionToggler();
    sectionPinner();

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

    checkboxToggler();
    toggleAllOptions();
    accordionToggler();
  }
}

document.addEventListener('DOMContentLoaded', Init);