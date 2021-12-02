  // Notification modal
  export function notification(msg, type = 'info', target_func) {

  	let notification_template;
  	let html = document.querySelector('html');
  	let notification_class;

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

  	function closeNotification() {
  		this.closest('.notification').remove();
  		if (type === 'prompt') html.classList.remove('fixed');
  	}

  	if (type === 'prompt') html.classList.add('fixed');

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
  	notification_template += `</div>`;
  	document.body.insertAdjacentHTML('beforeend', notification_template);


  	if (document.querySelector('.modal.notification')) {
  		let notification = document.querySelector('.modal.notification');
  		let close_notification = notification.querySelector('i');
  		close_notification.addEventListener('click', closeNotification);

  		if (type === 'prompt' && document.querySelector('.notification-content-inputs')) {
  			let inputs_panel = document.querySelector('.notification-content-inputs');
  			let input = inputs_panel.querySelector('input');
  			let button = inputs_panel.querySelector('button');
  			if (input.value) {
  				button.addEventListener('click', function() {
  					target_func(input.value);
  					notification.remove();
  				});
  			}
  		}

  	}
  }