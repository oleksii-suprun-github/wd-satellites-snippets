// Built-in WP.media popup for Featured Images Settings
export default function mediaFileChooser(obj) {
  const btns = Array.from(document.querySelectorAll(obj.select));

  btns.forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();

      let image_frame;

      image_frame = wp.media({
        title: obj.title,
        multiple: obj.is_multiple,
        library: {
          type: 'image',
        },
        button: {
          text: 'Select'
        }
      });

      image_frame.on('close', function() {
        let featured_image_section = btn.closest('.image-chooser.featured');
        let json_logo_section = btn.closest('.image-chooser.logo');
        let selection = image_frame.state().get('selection');

        let gallery_ids = new Array();
        let gallery_urls = new Array();
        let index = 0;

        if(featured_image_section) {
          selection.forEach(function(attachment) {
            gallery_ids[index] = attachment['id'];
            index++;
          });

          let ids = gallery_ids.join(",");
          featured_image_section.querySelector(obj.target).value = ids;
        }
        else if(json_logo_section) {
          selection.forEach(function(attachment) {
            gallery_urls[index] = attachment.attributes['url'];
            index++;
          });
          let urls = gallery_urls.join(",");
          json_logo_section.querySelector(obj.target).value = urls;         
        }
      });

      image_frame.on('open', function() {
        let current_section = btn.closest('.wdss-setting-item.image-chooser');
        let selection = image_frame.state().get('selection');
        let ids = current_section.querySelector(obj.target).value.split(',');
        ids.forEach(function(id) {
          let attachment = wp.media.attachment(id);
          attachment.fetch();
          selection.add(attachment ? [attachment] : []);
        });

      });

      image_frame.open();
    });
  });


}