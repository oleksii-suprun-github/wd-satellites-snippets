// Custom modal handler
export default function getPostsModal() {
  const html = document.querySelector('html'); 

  const open_modal_btn = document.querySelector('#wdss-remove-broken-featured__choose');
  const close_modal_btn = document.querySelector('.wdss-modal-header i.fa-times');

  const modal_title_template = '<span class="wdss-modal-title">Delete Broken Featured Images</span>';

  const modal = document.querySelector('.wdss-modal');
  const table = modal.querySelector('table');
  const context = document.querySelector('#wdss-exclude-posts-table tbody');

  const execute_btn = modal.querySelector('.wdss-button.submit');
  const toggle_all_btn = modal.querySelector('.wdss-button.toggle-all');
  const get_posts_btn = modal.querySelector('.wdss-button.get-posts');

  const welcome_msg = modal.querySelector('.wdss-modal-welcome-msg');
  const loading_msg_template = '<span class="wdss-modal-loading-msg">Loading...</span>';
  const not_found_msg_template = '<span class="wdss-modal-not-found-msg">No results...</span>';

  modal.querySelector('.wdss-modal-header').insertAdjacentHTML('afterbegin', modal_title_template);
  
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

    let not_found_msg = modal.querySelector('.wdss-modal-not-found-msg');

    if(not_found_msg) {
      not_found_msg.remove();
    }

    welcome_msg.classList.remove('active');
    table.insertAdjacentHTML('afterend', loading_msg_template);

    let fetched_posts;
    let loading_msg = document.querySelector('.wdss-modal-loading-msg')
    
    jQuery.ajax({
      url : document.location.origin + '/wp-json/wp/v2/posts?per_page=50', 
      type: 'get',
      success: function(response) {
        fetched_posts = response;
      },
      complete: function() {
        jQuery.ajax({
          url : wdss_localize.url,
          type : 'post',
          data : {
            posts_list: JSON.stringify(fetched_posts),
            action : 'fetch_broken_featured_images',
            security : wdss_localize.broken_featured_images_nonce,
          },
          success : function(response) {
            modalHandler.call(context, response);
            loading_msg.remove();
          }
        });
      }
    });
  }

  function modalHandler($content) {
    this.insertAdjacentHTML('beforeend', $content);
    
    
    let posts_list = Array.from(document.querySelectorAll('.wdss-table-row.post'));

    // let load_more_btn;
    // if(posts_list.length >= 50) {
    //   let load_more_button = '<button type="button" class="wdss-button load-more">Load more</button>';
    //   get_posts_btn.insertAdjacentHTML('beforebegin', load_more_button);

    //   load_more_btn = modal.querySelector('.wdss-button.load-more');
    // }

    // if(load_more_btn) {
    //   load_more_btn.addEventListener('click', loadMorePosts);
    //   function loadMorePosts() {
    //   }
    // }

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

    if(posts_list.length > 0) {
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
    }
    else {
      table.insertAdjacentHTML('afterend', not_found_msg_template);
    }

    execute_btn.addEventListener('click', () => {
      const proceded_posts = modal.querySelectorAll('.wdss-table-post__select input[type="checkbox"]:checked');
      let idsArr = [];
      let ids;

      if(proceded_posts.length !== 0) {
        proceded_posts.forEach(post => {
          idsArr.push(post.value);
        });
    
        ids = idsArr.join(',');
        console.log(ids);
  
        clearAll();
        get_posts_btn.classList.remove('inactive');
        execute_btn.classList.add('inactive');
        toggle_all_btn.classList.add('inactive');        
      }
      else {
        alert('No post are selected!');
      }
    });
  }

}
