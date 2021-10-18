// Built-in WP.media popup for Featured Images Settings
export default function mediaFileChooser(obj) {
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