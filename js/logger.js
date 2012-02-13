/**
 * Created by JetBrains PhpStorm.
 * User: seanmcgary
 * Date: 10/24/11
 * Time: 5:09 PM
 * To change this template use File | Settings | File Templates.
 */
if(typeof console == 'undefined'){
    console = {};
    console.log = function(){

    }

    window.console = console;
}

$(document).ready(function(){

    var log_socket = io.connect('https://drink.csh.rit.edu:8081');

    log_socket.emit('auth_drink_admin', {ibutton: ibutton});
    
    log_socket.on('log_message', function(data){
        $('#log-console').append('<div class="line">' + data.msg + '</div>');
        scroll_logs();

    });

    log_socket.on('auth_drink_admin_res', function(data){
        if(data.status == true){
            for(var i in data.logs){
                if(typeof data.logs[i].message != 'undefined'){
                    $('#log-console').append('<div class="line">' + data.logs[i].message + '</div>');
                    scroll_logs();
                }
            }
        } else {
            console.log("Sorry, youre not a drink admin");
        }
    });

    function scroll_logs(){
        var scroll_height = $('#log-console').get(0).scrollHeight;

        $('#log-console').get(0).scrollTop = scroll_height;
    }


});

    