window.addEventListener("load", () => {
    let eventListeners = ["scroll", "mousemove", "click"],
        scriptsLoaded = false;
    eventListeners.forEach((eventListener) => {
        window.addEventListener(eventListener, () => {
            if (scriptsLoaded === false) {
                let script = document.createElement('script'),
                    body = document.querySelector('body');
                script.src = `https://www.google.com/recaptcha/api.js`;
                body.append(script);
                scriptsLoaded = true;
            }
        }, {
            once: true
        })
    })
});