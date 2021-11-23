// Custom popup
export default function getPostsModal() {
  const btn = document.querySelector('#wdss-remove-broken-featured__choose');
  const context = document.querySelector('#wdss-remove-broken-featured');


  btn.addEventListener('click', Init);
  function Init() {

    jQuery.ajax({
        url : wdss_localize.url,
        type : 'post',
        data : {
          action : 'fetch_broken_featured_images',
          security : wdss_localize.broken_featured_images_nonce,
        },
        success : function(response) {
          modalHandler.call(context, response);
        }
    });
  }

  function modalHandler($content) {

    const html = document.querySelector('html'); 
    html.classList.add('fixed');

    this.insertAdjacentHTML('beforeend', $content);
    
    let posts_list = Array.from(document.querySelectorAll('.wdss-table-row.post'));
    posts_list.forEach(post => {
        post.addEventListener('click', () => {
          let checkbox = post.querySelector('.wdss-table-post__select input[type="checkbox"]');
          if(checkbox.hasAttribute('checked')) {
            uncheck(checkbox);
          }
          else {
            check(checkbox);
          }
        });
    });

    function check(input) {
      input.setAttribute('checked', 'checked');
      input.checked = true; 
    }

    function uncheck(input) {
      input.removeAttribute('checked');
      input.checked = false;
    }

    function closeModal() {
      modal.remove();
      html.classList.remove('fixed');
    }

    function toggleAll(e) {
      let posts = e.currentTarget.params;
      posts.forEach(post => {
          let checkbox = post.querySelector('.wdss-table-post__select input[type="checkbox"]');
          if(checkbox.hasAttribute('checked')) {
            uncheck(checkbox);
          }
          else {
            check(checkbox);
          }
      });
    }

    const modal = this.querySelector('.wdss-modal');
    const close_btn = modal.querySelector('.wdss-modal-header i');
    const toggle_btn = modal.querySelector('.wdss-button.toggle-all');
    const execute_btn = modal.querySelector('.wdss-button.submit');

    toggle_btn.addEventListener('click', toggleAll);
    toggle_btn.params = posts_list;

    close_btn.addEventListener('click', closeModal);
    document.onkeydown = ((e) => {
      if(e.key === 'Esc' || e.key === 'Escape') {
        closeModal();
      }
    });
    
    execute_btn.addEventListener('click', () => {
      
      const posts = modal.querySelectorAll('.wdss-table-post__select input[type="checkbox"]:checked');
      let idsArr = [];
      let ids;
  
      posts.forEach(post => {
        idsArr.push(post.value);
      });
  
      ids = idsArr.join(',');

      console.log(ids);

      modal.remove();
      html.classList.remove('fixed');
    });
  }
}
