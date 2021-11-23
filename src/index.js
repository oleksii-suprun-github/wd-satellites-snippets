import {getSiteInfo, accordionToggler, checkboxToggler, sectionToggler, groupToggler, resetValues, toggleAllOptions} from "./modules/helpers";
import {featuredImageSection, polylangSection, featuredImagesListReset, organizationLogoReset, featuredImagesChooser, organizationLogoChooser, getOgranizationName, getSiteEmail, e410_Dictionary, excludedHostsDictionary} from './modules/variables';

import schemaSectionSettings from "./modules/schema-settings";
import mediaFileChooser from "./modules/media-file-chooser";
import getPostsModal from "./modules/posts-modal";
import sectionPinner from "./modules/section-pinner";
import dictionaryHandler from "./modules/dictionary-handler";
import './css/styles.css';

// Condition for calling our functions
const pluginPage = document.querySelector('#wdss-settings-page');

function Init() {
  if(pluginPage) {

    sectionToggler();
    sectionPinner();

    if(wdss_localize.total_post_count > 0) {
      groupToggler(featuredImageSection);

      getSiteInfo(getOgranizationName);

      mediaFileChooser(featuredImagesChooser);

      resetValues(featuredImagesListReset);

      getPostsModal();
    }

    if(wdss_localize.is_polylang_exists && wdss_localize.is_polylang_setup) {
      groupToggler(polylangSection);  
    }

    dictionaryHandler(e410_Dictionary);
    dictionaryHandler(excludedHostsDictionary);

    mediaFileChooser(organizationLogoChooser);
    resetValues(organizationLogoReset);

    schemaSectionSettings();

    getSiteInfo(getSiteEmail);

    checkboxToggler();
    toggleAllOptions();
    accordionToggler();
  }
}

document.addEventListener('DOMContentLoaded', Init);