import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '06bf00730cc8c812a2f0',
    cluster: 'ap3',
    forceTLS: true
});

window.Echo.channel('notifications')
    .listen('BrowserNotification', (e) => {
        console.log(e);
        console.log(e); // Добавьте это для отладки
        toastr[e.type](e.message, e.title); // Или используйте SweetAlert
        console.log(window.Echo);

        // В зависимости от типа уведомления, отображаем его по-разному
        switch (e.type) {
            case 'info':
                // Отображение информационного уведомления
                toastr.info(e.message, e.title);
                break;
            case 'warning':
                // Отображение предупреждающего уведомления
                toastr.warning(e.message, e.title);
                break;
            case 'error':
                // Отображение уведомления об ошибке
                toastr.error(e.message, e.title);
                break;
            default:
                // Отображение стандартного уведомления
                toastr.info(e.message, e.title);
                break;
        }
    });


