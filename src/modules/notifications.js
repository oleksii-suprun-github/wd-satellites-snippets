  // Notification modal

	export class Notification {

		static closeNotification(target, type, context) {
			let is_module_block = context ? context.includes('wdss-modal') : null; 
			let html = document.querySelector('html');
			
			if(target.closest('.notification')) {
				target.closest('.notification').remove();
			}
			if (type === 'prompt' || is_module_block) {
				html.classList.remove('fixed');
			}
		}


		
		static template(msg, type, context) {
			let notification_template;
			let html = document.querySelector('html');
			let notification_class;
			document.onkeydown = ((e) => e.key === 'Esc' || e.key === 'Escape' ? Notification.closeNotification(document.querySelector('.modal.notification')) : null);
	
			switch (type) {
				case 'info':
					notification_class = 'info';
					break;
				case 'prompt':
					notification_class = 'prompt';
					break;
				case 'confirm':
					notification_class = 'confirm';
					break;
				default:
					notification_class = 'info';
			}
			
				notification_template = `
				<div class="modal notification ${notification_class}">
				<div class="notification-header">
					<i class="fas fa-times"></i>
				</div>
				<div class="notification-content">
				<span>${msg}</span>
				</div>`;
		
				if (type === 'prompt') {
					html.classList.add('fixed');
					notification_template += `<div class="notification-content-inputs"><input required type="number" min="100" value="100"><button type="button" class="wdss-button">Enter</button></div>`;
				}
				else if(type === 'confirm') {
					notification_template += `<div class="notification-content-inputs"><button class="wdss-button confirm">Yes</button><button class="wdss-button cancel">No</button></div>`;
				}
				notification_template += `</div>`;
				document.body.insertAdjacentHTML('beforeend', notification_template);


				if(document.querySelector('.notification-header i')) {
					let close_btn =  document.querySelector('.notification-header i');

					close_btn.addEventListener('click', () => { 
						Notification.closeNotification(close_btn, type, context);
					});
				}
		}



		async confirm(msg) {
			Notification.template(msg, 'confirm');

			let inputs_panel = document.querySelector('.notification-content-inputs');
			let button_confirm = inputs_panel.querySelector('button.confirm');
			let button_cancel = inputs_panel.querySelector('button.cancel');

			let promise = new Promise((resolve) => {
				button_confirm.addEventListener('click', function() {
					resolve(true);
					Notification.closeNotification(inputs_panel);
				});
				button_cancel.addEventListener('click', function() {
					resolve(false);
					Notification.closeNotification(inputs_panel);
				});
			});

			return await promise;
		}



		info(msg, context = null) {
			Notification.template(msg, 'info', context);
		}



		prompt(msg, call_func) {
			Notification.template(msg, 'prompt');

			let inputs_panel = document.querySelector('.notification-content-inputs');
			let input = inputs_panel.querySelector('input');
			let button = inputs_panel.querySelector('button');
			if (input.value) {
					button.addEventListener('click', function() {
						call_func(input.value);
						Notification.closeNotification(inputs_panel);
					});
				}
		}
}
