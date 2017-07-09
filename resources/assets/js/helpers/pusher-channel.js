import Pusher from 'pusher-js';

const pusher = new Pusher(dashboard.pusherKey, {
    authEndpoint: '/pusher/authenticate',
});

const pusherChannel = pusher.subscribe('private-dashboard');

export default pusherChannel;

///////

var rsschannel = pusher.subscribe('rss-dashboard');

rsschannel.bind('App\\Components\\RefreshRSSEvent', function(data) {
    $('.cycle-slideshow').cycle('destroy');
    $('.cycle-slideshow').cycle({
        speed: 500,
        timeout: 8000,
        fx: "scrollVert",
        slides: "> li"
    })
});