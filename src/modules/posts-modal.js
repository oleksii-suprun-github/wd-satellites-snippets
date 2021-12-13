// Custom modal handler
import {
	check,
	uncheck,
} from './helpers';

import {
	Notification
} from './notifications';
let notification = new Notification;

String.prototype.stripSlashes = function(){
	return this.replace(/\\(.)/mg, "$1");
}


export default function getPostsModal(obj) {

	const html = document.querySelector('html');
	const modal = document.querySelector(obj.modal_el);
	const open_modal_btn = document.querySelector(obj.open_modal_btn);
	const close_modal_btn = modal.querySelector('.wdss-modal-header i.fa-times');

	let total_posts = wdss_localize.total_post_count;

	function Init() {
		const modal_body = modal.querySelector('.wdss-modal-body');
		const info_panel = modal.querySelector('.wdss-modal-informaion-panel');
		const context = modal.querySelector('tbody');

		const execute_btn = modal.querySelector('.wdss-button.submit');
		const toggle_all_btn = modal.querySelector('.wdss-button.toggle-all');
		const get_posts_btn = modal.querySelector('.wdss-button.get-posts');

		const total_posts_text = modal.querySelector('.wdss-modal-posts-count');
		let total_posts_text_number = total_posts_text.querySelector('strong');

		const welcome_msg = modal.querySelector('.wdss-modal-welcome-msg');
		const not_found_msg_template = '<span class="wdss-modal-not-found-msg">No results...</span>';

		const completed_msg_template = '<span class="msg successful">Completed!<br><small>It can take several minutes while changes are implementing</small></span>';
		const error_msg_template = '<span class="msg error">An Error occured!<br><smallLook in console for more details</small></span>';

		const modal_title = modal.querySelector('.wdss-modal-title');
		const modal_title_value = obj.modal_title;

		if (modal_title.childNodes.length < 1) {
			modal_title.insertAdjacentHTML('afterbegin', modal_title_value);
		}

		openModal();

		function openModal() {
			window.next_fetched_page = Math.ceil(total_posts / 30);
			modal.classList.add('active');
			html.classList.add('fixed');
		}

		close_modal_btn.addEventListener('click', closeModal);

		function closeModal() {
			modal.classList.remove('active');
			html.classList.remove('fixed');
			let notifications = Array.from(document.querySelectorAll('.notification'));
			notifications.forEach(notification => {
				notification.remove();
			})
		}
		document.onkeydown = ((e) => e.key === 'Esc' || e.key === 'Escape' ? closeModal() : null);

		function getPostsFromTable() {
			return Array.from(document.querySelectorAll('.wdss-table-row.post'));
		}

		function updateFetchedPostsNumber() {
			let total_posts_amount = getPostsFromTable().length;

			total_posts_text.classList.add('active');
			if (total_posts_text_number) {
				return total_posts_text_number.innerHTML = total_posts_amount;
			}
			return;
		}


		function toggleAllCheckboxes() {
			let posts = getPostsFromTable();
			posts.forEach(post => {
				let checkbox = post.querySelector('.wdss-table-post__select input[type="checkbox"]');
					check(checkbox);
			});
		}

		async function fetchPostsMainHandler() {
			modal_body.classList.add('loading');

			function fetchPosts() {
				let promises = []
					for (let i = 1; i <= window.next_fetched_page; i++) {
						try {
							promises.push(new Promise((resolve, reject) => {
								fetch(document.location.origin + `/wp-json/wp/v2/posts/?per_page=30&page=${i}`)
									.then(response => {
										return response.json();
									})
									.then(data => {
	
										let data_obj = {
											fetched_list: JSON.stringify(data),
											action: `${obj.fetch_action}`,
										};
										data_obj[obj.fetch_nonce_name] = obj.fetch_nonce_value;
							
										jQuery.post( ajaxurl, data_obj, 'json').
										done(function(response) {
											resolve();
											context.insertAdjacentHTML('beforeend', response);
											info_panel.classList.remove('active');
										}).
										fail(function(error) {
											modal_body.classList.remove('loading');
											info_panel.insertAdjacentHTML('afterbegin', error_msg_template);
											console.log(error);
										});
									})
									.catch(error => {
										console.log(error);
										reject();
									});
							}));
						} catch (e) {
							break;
						}
				}
				return Promise.allSettled(promises);
			}

			if(obj.query_type === 'rest') {
				await fetchPosts(window.next_fetched_page);
				modal_body.classList.remove('loading');
				get_posts_btn.classList.add('inactive');
				modalHandler();
			}
			if(obj.query_type === 'sql') {
				let data_obj = {
					action: `${obj.fetch_action}`,
				};
				data_obj[obj.fetch_nonce_name] = obj.fetch_nonce_value;
	
				jQuery.post( ajaxurl, data_obj, 'json').
				done(function(response) {
					context.insertAdjacentHTML('beforeend', response);
					info_panel.classList.remove('active');
					modalHandler();
				}).
				fail(function(error) {
					info_panel.insertAdjacentHTML('afterbegin', error_msg_template);
					console.log(error);
				}).
				always(function(){
					modal_body.classList.remove('loading');
					get_posts_btn.classList.add('inactive');
				});
			}
		}

		get_posts_btn.addEventListener('click', getPostsHandler);

		function getPostsHandler() {

			let notification_message = modal.querySelector('.msg');
			if (notification_message) notification_message.remove();

			get_posts_btn.classList.add('inactive');
			welcome_msg.classList.remove('active');

			window.next_fetched_page = Math.ceil(total_posts / 30);
			fetchPostsMainHandler();
		}

		function modalHandler() {
			updateFetchedPostsNumber();

			let posts_list = getPostsFromTable();

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

			if (posts_list.length > 0) {
				posts_list.forEach(post => {
					post.addEventListener('click', () => {
						let checkbox = post.querySelector('.wdss-table-post__select input[type="checkbox"]');
						if (checkbox.hasAttribute('checked')) {
							uncheck(checkbox);
						} else {
							check(checkbox);
						}
					});
				});

				get_posts_btn.classList.add('inactive');
				execute_btn.classList.remove('inactive');
				toggle_all_btn.classList.remove('inactive');

				toggle_all_btn.addEventListener('click', toggleAllCheckboxes);
			} else {
				info_panel.insertAdjacentHTML('afterbegin', not_found_msg_template);
				info_panel.classList.add('active');
				toggle_all_btn.classList.add('inactive');
				execute_btn.classList.add('inactive');
			}

			execute_btn.addEventListener('click', () => {
				console.log('e');

				notification.confirm('Are you ready to start?').then(result => {

					if (result !== true) {
						return;
					} else {
						const proceded_posts = Array.from(modal.querySelectorAll('.wdss-table-post__select input[type="checkbox"]:checked'));
						let proceded_posts_ids_arr = [];
						let proceded_posts_ids;

						if (!proceded_posts.length) {
							notification.info('Please, select the posts which will be proceded');
							return;
						}

						get_posts_btn.classList.remove('inactive');
						proceded_posts.forEach(post => {
							proceded_posts_ids_arr.push(post.value);
						});

						proceded_posts_ids = proceded_posts_ids_arr.join(',');
						console.log(`Selected IDs: ${proceded_posts_ids}`);
						clearAll();

						let data_obj = {
							selected_list: JSON.stringify(proceded_posts_ids),
							action: obj.post_action
						};
						data_obj[obj.post_nonce_name] = obj.post_nonce_value;

						get_posts_btn.classList.add('inactive');
						modal_body.classList.add('processing');

						jQuery.post( ajaxurl, data_obj, 'json').
						done(function(response) {
							info_panel.insertAdjacentHTML('afterbegin', completed_msg_template);
							info_panel.classList.add('active');
						}).
						fail(function(error) {
							modal_body.classList.remove('loading');
							info_panel.insertAdjacentHTML('afterbegin', error_msg_template);
							console.log(error);
						}).
						always(function() {
							modal_body.classList.remove('processing');
							get_posts_btn.classList.remove('inactive');
						});
					}
				});
			}, {once:true});
		}
	}
	if (open_modal_btn) {
		open_modal_btn.addEventListener('mousedown', Init);
	}
}