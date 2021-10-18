// Custom popup with list of published posts for Long Title Clipping Settings
export default function getPostsModal() {
  const btn = document.querySelector('#wdss-title-clipping-excluded__choose');
  const context = document.querySelector('#wdss-title-clipping-excluded');

  btn.addEventListener('click', init);

  function init() {

    jQuery.ajax({
        url : wdss_localize.url,
        type : 'post',
        data : {
          action : 'fetch_modal_content',
          security : wdss_localize.nonce,
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
    
    const posts = Array.from(document.querySelectorAll('.wdss-table-row.post'));
    posts.forEach(post => {
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


    const modal = this.querySelector('.wdss-modal');
    const close_btn = modal.querySelector('.wdss-modal-header i');
    const save_btn = modal.querySelector('.wdss-button.submit');
    const input = this.querySelector('#wdss-title-clipping-excluded input[type="text"]');
  
    if(input.value !== '') {
      let inputIdsArr = input.value.split(',');
      let checkboxes = Array.from(modal.querySelectorAll('.wdss-table-post__select input[type="checkbox"]'));
      checkboxes.forEach(checkbox => {
        if(inputIdsArr.includes(checkbox.value)) {
          checkbox.setAttribute('checked', 'checked');
          checkbox.checked = true;
        }
      });
    }

    function closeModal() {
      modal.remove();
      html.classList.remove('fixed');
    }

    close_btn.addEventListener('click', closeModal);
    document.onkeydown = ((e) => {
      if(e.key === 'Esc' || e.key === 'Escape') {
        closeModal();
      }
    });
    
    save_btn.addEventListener('click', () => {
      
      const posts = modal.querySelectorAll('.wdss-table-post__select input[type="checkbox"]:checked');

      console.log(posts);

      let idsArr = [];
      let ids;
  
      posts.forEach(post => {
        idsArr.push(post.value);
      });
  
      ids = idsArr.join(',');
      input.value = ids;
      modal.remove();
      html.classList.remove('fixed');
    });
  }
}
