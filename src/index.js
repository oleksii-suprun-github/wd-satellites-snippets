import {getSiteInfo, accordionToggler, checkboxToggler, sectionToggler, groupToggler, resetValues, toggleAllOptions} from "./modules/helpers";
import {featuredImageSection, polylangSection, featuredImagesListReset, organizationLogoReset, featuredImagesChooser, organizationLogoChooser, getOgranizationName, getSiteEmail, e410_Dictionary, excludedHostsDictionary, removeBrokenFeatured} from './modules/variables';
import getPostsModal from "./modules/posts-modal";
import schemaSectionSettings from "./modules/schema-settings";
import mediaFileChooser from "./modules/media-file-chooser";
import sectionPinner from "./modules/section-pinner";
import dictionaryHandler from "./modules/dictionary-handler";
import './css/styles.css';

// Condition for calling our functions
const pluginPage = document.querySelector('#wdss-settings-page');

function Init() {
  if(pluginPage) {

    getPostsModal(removeBrokenFeatured);
    
    sectionToggler();
    sectionPinner();

    if(wdss_localize.total_post_count > 0) {
      groupToggler(featuredImageSection);
      mediaFileChooser(featuredImagesChooser);
      resetValues(featuredImagesListReset);
      getSiteInfo(getSiteEmail);
    }

    if(wdss_localize.is_polylang_exists && wdss_localize.is_polylang_setup) {
      groupToggler(polylangSection);  
    }

    dictionaryHandler(e410_Dictionary);

    if(wdss_localize.total_post_count > 0) {
      dictionaryHandler(excludedHostsDictionary);
    }
    
    mediaFileChooser(organizationLogoChooser);
    resetValues(organizationLogoReset);

    schemaSectionSettings();

    getSiteInfo(getOgranizationName);

    checkboxToggler();
    toggleAllOptions();
    accordionToggler();
  }
}

document.addEventListener('DOMContentLoaded', Init);