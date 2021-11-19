import {getSiteInfo, accordionToggler, checkboxToggler, sectionToggler, groupToggler, resetValues, toggleAllOptions} from "./modules/helpers";
import schemaSectionSettings from "./modules/schema-settings";
import mediaFileChooser from "./modules/media-file-chooser";
import sectionPinner from "./modules/section-pinner";
import E410_DictionaryHandler from "./modules/e410-handler";
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
  select: '.image-chooser.featured button.choose',
  target: '.image-chooser.featured input',
  is_multiple: true,
  title: 'Select Featured Images'
};

const organizationLogoChooser = {
  select: '.image-chooser.logo button.choose',
  target: '.image-chooser.logo input',
  is_multiple: false,
  title: 'Select Organization Logo'
}

const getOgranizationName = {
  selector: '#wdss-generate-orgname',
  input: '#wdss-jsonld-schema-orgname input',
}

const getSiteYoastEnding = {
  selector: '#wdss-get-title',
  input: '#wdss-title-ending input',
}

const getSiteEmail = {
  selector: '#wdss-generate-email',
  input: '#wdss-jsonld-schema-email input',
}


function Init() {
  if(pluginPage) {

    sectionToggler();
    sectionPinner();

    if(wdss_localize.total_post_count > 0) {
      groupToggler(titleClippingSection);
      groupToggler(featuredImageSection);

      getSiteInfo(getOgranizationName);

      mediaFileChooser(featuredImagesChooser);

      resetValues(cutTitleClippingReset, cutTitleSinceReset, featuredImagesListReset);

    }

    if(wdss_localize.is_polylang_exists && wdss_localize.is_polylang_setup) {
      groupToggler(polylangSection);  
    }

    E410_DictionaryHandler();

    mediaFileChooser(organizationLogoChooser);
    resetValues(organizationLogoReset);

    schemaSectionSettings();

    getSiteInfo(getSiteYoastEnding);
    getSiteInfo(getSiteEmail);

    groupToggler(customSchemaSection);

    checkboxToggler();
    toggleAllOptions();
    accordionToggler();
  }
}

document.addEventListener('DOMContentLoaded', Init);