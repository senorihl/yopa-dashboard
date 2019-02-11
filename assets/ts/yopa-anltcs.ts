((y, o, p, a, e, v, n, t, s) => {
    if (y['yopa']) return;
    y['yopa'] = {hostname: a, events: [], listeners: [],
        page: function() { this.events.push({t:'page', a:arguments}) },
        click: function () { this.events.push({t:'click', a:arguments}) },
        misc: function (name) { this.events.push({t:'misc', a:arguments}) },
        onLoaded: function (callback) { this.listeners.push({event: 'loaded', callback}) },
    };
    v = o.createElement(p); v.async = true; v.src = '//' + a + e;
    n = o.getElementsByTagName(p)[0]; n.parentNode.insertBefore(v, n);
})(window, document, 'script', SERVICE_URL || window.location.host, '/script.js');
