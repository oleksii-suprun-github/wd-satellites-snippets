let dmcaCounter = 0;
let scriptID = 'dmca-js';

function dmcaHandler() {
  if(!document.getElementById(scriptID)) {
    let script = document.createElement('script');
    script.src = 'https://images.dmca.com/Badges/DMCABadgeHelper.min.js';
    script.id = scriptID; script.defer = 'defer';
    document.body.append(script);
  }
}

if (!dmcaCounter) {
  dmcaCounter++;
  window.addEventListener('scroll', dmcaHandler);
  window.addEventListener('mousemove', dmcaHandler);
  window.addEventListener('click', dmcaHandler);
}