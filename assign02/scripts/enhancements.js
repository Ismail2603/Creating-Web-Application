window.addEventListener('load',
    function () {
        if (this.location.href.includes('timer')) {
            var fiveMinutes = 120; // 2 minutes
            var display = document.querySelector('#time');
            this.startTimer(fiveMinutes, display);
        } else if (this.location.href.includes('navigation_highlight')) {
            this.highlightMenu();
        }
    }, false
);


function highlightMenu() {
    $(function () {
        $('a').each(function () {
            if ($(this).prop('href') == window.location.href) {
                $(this).addClass('active'); $(this).parents('li').addClass('active');
            }
        });
    });
}


function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            timer = duration;
            alert('Your time is up. You will be redirected to home page!');
            window.location.href = 'index.html';
        }
    }, 1000);
}

