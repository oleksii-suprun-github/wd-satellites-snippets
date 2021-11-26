// Custom modal handler
export default function getPostsModal() {

  const html = document.querySelector('html'); 
  const modal = document.querySelector('.wdss-modal');
  const open_modal_btn = document.querySelector('#wdss-remove-broken-featured__choose');
  const close_modal_btn = document.querySelector('.wdss-modal-header i.fa-times');

  let total_posts = wdss_localize.total_post_count;

  function Init() {
    const modal_title_template = '<span class="wdss-modal-title">Delete Broken Featured Images</span>';
    const modal_body = modal.querySelector('.wdss-modal-body');
    const info_panel = modal.querySelector('.wdss-modal-informaion-panel');
    const context = document.querySelector('#wdss-exclude-posts-table tbody');
  
    const execute_btn = modal.querySelector('.wdss-button.submit');
    const toggle_all_btn = modal.querySelector('.wdss-button.toggle-all');
    const get_posts_btn = modal.querySelector('.wdss-button.get-posts');
  
    const total_posts_text = modal.querySelector('.wdss-modal-posts-count');
    let total_posts_text_number = total_posts_text.querySelector('strong');
  
    const welcome_msg = modal.querySelector('.wdss-modal-welcome-msg');
    const not_found_msg_template = '<span class="wdss-modal-not-found-msg">No results...</span>';
    const load_more_btn_template = '<button type="button" class="wdss-button load-more">Fetch next page</button>';
  
    let load_more_btn;
    let fetched_posts = [];
    let is_lite_mode = false; 
    let cusotm_max_posts_per_fetch = parseInt(prompt('Enter max posts per fetch count: '));
    let max_posts_per_fetch =  cusotm_max_posts_per_fetch ? cusotm_max_posts_per_fetch : 800;
    let total_pages_info = Math.ceil(wdss_localize.total_post_count / 100);
    console.log(`Total fetchable pages: ${total_pages_info}`);
  
  
    modal.querySelector('.wdss-modal-header').insertAdjacentHTML('afterbegin', modal_title_template);
    const modal_title = modal.querySelector('.wdss-modal-title');
    const lite_mode_msg_template = `<small>Lite-mode: max ${max_posts_per_fetch} posts per fetch</small>`;
  
    if(total_posts > max_posts_per_fetch) {
      is_lite_mode = true;
        modal_title.insertAdjacentHTML('afterend', lite_mode_msg_template);
    }
  
    if(is_lite_mode) total_posts = max_posts_per_fetch;
    let next_fetched_page = Math.ceil(total_posts / 100);
  
    
    openModal()

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
  
  
    function updateFetchedPostsNumber() {
      let total_posts_amount = Array.from(document.querySelectorAll('.wdss-table-row.post')).length;
  
      total_posts_text.classList.add('active');
      if(total_posts_text_number) {
        return total_posts_text_number.innerHTML = total_posts_amount;
      }
      return;
    }
  
    function fetchMorePostsHandler() {
      load_more_btn.classList.add('inactive');
      modal_body.classList.add('loading');
      toggle_all_btn.classList.add('inactive');
      execute_btn.classList.add('inactive');
  
      if(total_pages_info === next_fetched_page) {
        alert('You achived the last page');
        return;
      }
  
      try {
        fetch(document.location.origin + `/wp-json/wp/v2/posts?per_page=100&page=${next_fetched_page}`)
        .then(response => {
          return response.json();
        })
        .then(data => {
          jQuery.ajax({
            url : wdss_localize.url,
            type : 'post',
            data : {
              fetched_list: JSON.stringify(data),
              action: 'fetch_broken_featured',
              broken_featured_nonce1: wdss_localize.broken_featured_list_nonce,
            },
            success : function(response) {
              context.insertAdjacentHTML('beforeend', response);
              next_fetched_page++;
  
              load_more_btn.classList.remove('inactive');
              toggle_all_btn.classList.remove('inactive');
              modal_body.classList.remove('loading');
              execute_btn.classList.remove('inactive');
  
              updateFetchedPostsNumber();
            }
          }); 
        })
      } catch(e) {
        console.log(e);
      }
    }
  
    async function fetchPostsMainHandler() {    
      modal_body.classList.add('loading');
  
      function fetchPosts() { 
        let promises = []
  
        for (let i = 1; i <= next_fetched_page; i++) {
          try {
            promises.push(new Promise((resolve, reject) => {
              fetch(document.location.origin + `/wp-json/wp/v2/posts?per_page=100&page=${i}`)
              .then(response => {
                return response.json();
              })
              .then(data => {
                fetched_posts = fetched_posts.concat(data);
                resolve();
              })
              .catch(error => { 
                console.log(error);
                reject();
              });
            }));
          }
          catch(e) {
            break;
          }
        }
        next_fetched_page++;
        if(next_fetched_page < total_pages_info) {
          console.log(`Next page to fetch ${next_fetched_page}`);
        }
        else {
          console.log(`This is the last page to fetch`);
        }
  
        return Promise.allSettled(promises);
      }
  
      await fetchPosts(next_fetched_page);
      console.log(`Fetched posts: ${fetched_posts.length}`);
      jQuery.ajax({
        url : wdss_localize.url,
        type : 'post',
        data : {
          fetched_list: JSON.stringify(fetched_posts),
          action: 'fetch_broken_featured',
          broken_featured_nonce1: wdss_localize.broken_featured_list_nonce,
        },
        success : function(response) {
          modalHandler.call(context, response);
          modal_body.classList.remove('loading');
        }
      }); 
    }
  
    get_posts_btn.addEventListener('click', getPostsHandler);
    function getPostsHandler() {
  
      let notification_message = modal.querySelector('.msg'); 
      if(notification_message) notification_message.remove();
  
      get_posts_btn.classList.add('inactive');
      welcome_msg.classList.remove('active');
  
      let not_found_msg = modal.querySelector('.wdss-modal-not-found-msg');
  
      if(not_found_msg) not_found_msg.remove();
  
      console.log(`Current fetched pages: ${next_fetched_page}`);
      next_fetched_page = Math.ceil(total_posts / 100);
      fetchPostsMainHandler();
    }
  
    function modalHandler($content) {
      this.insertAdjacentHTML('beforeend', $content);
      updateFetchedPostsNumber();
  
      let posts_list = Array.from(document.querySelectorAll('.wdss-table-row.post'));
  
      if(is_lite_mode && !modal.querySelector('.wdss-button.load-more')) {
        get_posts_btn.insertAdjacentHTML('beforebegin', load_more_btn_template);
        load_more_btn = modal.querySelector('.wdss-button.load-more');
      }
  
      if(load_more_btn) {
        load_more_btn.addEventListener('click', function() {
          fetchMorePostsHandler();
        });
      }
  
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
        execute_btn.classList.add('inactive');
        toggle_all_btn.classList.add('inactive');  
        total_posts_text.classList.remove('active');
        total_posts_text_number.innerHTML = '';
  
        let table_rows = Array.from(modal.querySelectorAll('.wdss-table-row.post'));
  
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
        info_panel.insertAdjacentHTML('afterbegin', not_found_msg_template);
        get_posts_btn.classList.remove('inactive');
      }
  
      execute_btn.addEventListener('click', () => {
        const proceded_posts = Array.from(modal.querySelectorAll('.wdss-table-post__select input[type="checkbox"]:checked'));
        let proceded_posts_ids_arr = [];
        let proceded_posts_ids;
  
        if(!proceded_posts.length) {
          alert('Please, select the posts which will be proceded');
          return;
        }
        if(!confirm('Are you ready to start?')) return;
          
        get_posts_btn.classList.remove('inactive');
        proceded_posts.forEach(post => {
          proceded_posts_ids_arr.push(post.value);
        });
      
        proceded_posts_ids = proceded_posts_ids_arr.join(',');
    
        clearAll();
          
        jQuery.ajax({
            url : wdss_localize.url,
            type : 'post',
            data : {
              selected_list: JSON.stringify(proceded_posts_ids),
              action: 'remove_broken_featured',
              broken_featured_nonce2: wdss_localize.remove_broken_featured_nonce,
            },
            success : function() {
              get_posts_btn.classList.add('inactive');
              info_panel.insertAdjacentHTML('afterbegin', '<span class="msg successful">Completed!<br><small>Please wait several minutes while changes are implementing</small></span>');
            },
            error: function(error) {
              info_panel.insertAdjacentHTML('afterbegin', '<span class="msg error">An Error occured!<br><smallLook in console for more details</small></span>');
              console.log(error);
            }
        });
      });
    }
  }

  if(open_modal_btn) {
    open_modal_btn.addEventListener('click', Init);
  }
}
