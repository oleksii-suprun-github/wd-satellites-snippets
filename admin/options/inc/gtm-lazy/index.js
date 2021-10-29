let gtmCounter = 0;
function gtmHandler() {

  if (window.dataLayer !== undefined) return false;

  let id = `${wdss_gtm.id}`;

  let script = document.createElement('script');
  script.src = 'https://www.googletagmanager.com/gtm.js?id=' + id;
  script.id = "gtm-js"; script.defer = 'defer';
  document.body.append(script);

  let script1 = document.createElement('script');
  let secondPart = document.createTextNode('window.dataLayer=window.dataLayer||[],window.dataLayer.push({"gtm.start":(new Date).getTime(),event:"gtm.js"})');
  script1.appendChild(secondPart);
  document.body.append(script1);

  let script2 = document.createElement('script');
  let thirdPart = document.createTextNode('/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera' +
  ' Mini/i.test(navigator.userAgent)?setTimeout(function(){window.dataLayer.push({event:"wd_init_other_metrics"})},1200):window.dataLayer.push({event:"wd_init_other_metrics"})');
  script2.appendChild(thirdPart);
  document.body.append(script2);
}
if (!gtmCounter){
  gtmCounter++;
  window.addEventListener('scroll', gtmHandler);
  window.addEventListener('mousemove', gtmHandler);
  window.addEventListener('click', gtmHandler);
}