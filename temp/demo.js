var $body       = $('body');

var backgrounds = [
    { src: 'img/1.jpg', delay: 3000, cover: true },
    { src: 'img/2.jpg', delay: 6000, cover: true },
    { src: 'img/3.jpg', delay: 3000, cover: true },
    { src: 'img/2.jpg', delay: 6000, cover: true, video: [
        'img/intro.mp4',
        'img/intro.ogv',
        'img/intro.webm',
        ],
        loop: false,
        mute: false
    },
    { src: 'img/3.jpg', delay: 20000, cover: true, video: [
        'slider/arduino.mp4',
        'slider/arduino.ogv',
        'slider/arduino.webm'
    ],
        loop: false,
        mute: false
    },
];

$('html').addClass('animated');

$body.vegas({
    preload: true,
    overlay: 'img/01.png',
    transitionDuration: 1000,
    //delay: 5000,
    slides: backgrounds,
    shuffle: false,
    walk: function (nb, settings) {
        if (settings.video) {
            $('.logo').addClass('collapsed');
        } else {
            $('.logo').removeClass('collapsed');
        }
    }
});