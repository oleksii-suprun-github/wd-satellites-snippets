// Custom popup
export default function getPostsModal() {
  const html = document.querySelector('html'); 
  const open_modal_btn = document.querySelector('#wdss-remove-broken-featured__choose');
  const close_modal_btn = document.querySelector('.wdss-modal-header i.fa-times');
  const modal = document.querySelector('.wdss-modal');
  const execute_btn = modal.querySelector('.wdss-button.submit');
  const toggle_all_btn = modal.querySelector('.wdss-button.toggle-all');
  const get_posts_btn = modal.querySelector('.wdss-button.get-posts');
  const context = document.querySelector('#wdss-exclude-posts-table tbody');

  open_modal_btn.addEventListener('click', openModal);
  function openModal() {
    modal.classList.add('active');
    html.classList.add('fixed');
  }

  close_modal_btn.addEventListener('click', closeModal);
  function closeModal() {
    modal.classList.remove('active');
    html.classList.remove('fixed');
  }
  document.onkeydown = ((e) => e.key === 'Esc' || e.key === 'Escape' ? closeModal() : null);


  get_posts_btn.addEventListener('click', getPostsList);
  function getPostsList() {
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

    get_posts_btn.classList.add('inactive');
    execute_btn.classList.remove('inactive');
    toggle_all_btn.classList.remove('inactive');

    toggle_all_btn.addEventListener('click', toggleAll);
    toggle_all_btn.params = posts_list;

    function check(input) {
      input.setAttribute('checked', 'checked');
      input.checked = true; 
    }

    function uncheck(input) {
      input.removeAttribute('checked');
      input.checked = false;
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

    function clearAll() {
      let table_rows = Array.from(modal.querySelectorAll('.wdss-table-row.post'));
      console.log(table_rows);

      table_rows.forEach(row => {
        row.parentNode.removeChild(row);
      });
    }

    
    execute_btn.addEventListener('click', () => {
      const proceded_posts = modal.querySelectorAll('.wdss-table-post__select input[type="checkbox"]:checked');
      let idsArr = [];
      let ids;
  
      proceded_posts.forEach(post => {
        idsArr.push(post.value);
      });
  
      ids = idsArr.join(',');
      console.log(ids);

      clearAll();
      
      get_posts_btn.classList.remove('inactive');
      execute_btn.classList.add('inactive');
      toggle_all_btn.classList.add('inactive');

    });
  }

}
