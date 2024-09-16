export  default function loadTelegramWidget(){
    if(document.getElementById('telegram-widget-container')) {
        const script = document.createElement('script');
        script.src = 'https://telegram.org/js/telegram-widget.js?22';
        console.log(import.meta.env.VITE_TELEGRAM_BOT_NAME);
        script.setAttribute('data-telegram-login', import.meta.env.VITE_TELEGRAM_BOT_NAME);
        script.setAttribute('data-size', 'medium');
        script.setAttribute('data-auth-url', route('v1.callbacks.telegram'));
        script.setAttribute('data-request-access', 'write');
        script.async = true;
        document.getElementById('telegram-widget-container').appendChild(script);
    }
}
