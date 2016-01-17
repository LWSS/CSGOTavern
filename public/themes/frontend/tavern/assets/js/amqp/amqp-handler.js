/**
 * Created by Administrator on 9/11/2015.
 */

var has_had_focus = false;
var pipe = function(el_name, send) {
    var div  = $(el_name + ' div');
    var inp  = $(el_name + ' input');
    var form = $(el_name + ' form');

    var print = function(m, p) {
        p = (p === undefined) ? '' : JSON.stringify(p);
        div.append($("<code>").text(m + ' ' + p));
        div.scrollTop(div.scrollTop() + 10000);
    };

    if (send) {
        form.submit(function() {
            send(inp.val());
            inp.val('');
            return false;
        });
    }
    return print;
};

// Stomp.js boilerplate
var ws = new SockJS('https://vionox.com:15671/stomp');
var client = Stomp.over(ws);

// SockJS does not support heart-beat: disable heart-beats
client.heartbeat.outgoing = 0;
client.heartbeat.incoming = 0;
client.debug = pipe('#second');

var print_first = pipe('#first', function(data) {
    client.send('/exchange/users.direct/test', {"content-type":"text/plain"}, data);
});
var on_connect = function(x) {
    id = client.subscribe("/exchange/users.direct/test", function(d) {
        console.log(d);
    });
    client.subscribe("/exchange/broadcast", function(d) {
        console.log(d);
    });
};
var on_error =  function() {
    console.log('error');
};
client.connect('csgotavern-user', 'anNmr8E2YmENeA7nnr3fAm1sydcRCizh', on_connect, on_error, 'csgotavern.com');

$('#first input').focus(function() {
    if (!has_had_focus) {
        has_had_focus = true;
        $(this).val("");
    }
});