/**
 * Created by JetBrains PhpStorm.
 * User: seanmcgary
 * Date: 9/26/11
 * Time: 2:44 AM
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(function(){

    var requesting = false;
    var request_queue = [];
    var request_callback = null;
    var socket = io.connect('https://drink.csh.rit.edu:8080', {secure: true});
    
    
    var slot_to_drop = null;

    function command_prep(callback, command){
        
        if(requesting == false){
            request_callback = callback;
        
            command();
        } else {
            request_queue.push({command: command, callback: callback});
        }
    }

    function process_queue(){
        //console.log(request_queue);
        if(request_queue.length > 0){
            var request = request_queue.pop();

            request_callback = request.callback;

            request.command();
        }
    }


    socket.emit('ibutton', {ibutton: ibutton});

    socket.on('connect', function(){

    });

    socket.on('stat_recv', function(data){
        if(request_callback != null){
            request_callback(data);
        }

        process_queue();
    });

    socket.on('ibutton_recv', function(data){

        if(request_callback != null){
            request_callback(data);
        }

        process_queue();
    });

    socket.on('machine_recv', function(data){

        if(request_callback != null){
            request_callback(data);
        }

        process_queue();
    });

    socket.on('drop_recv', function(data){

        if(request_callback != null){
            request_callback(data);
        }

        process_queue();
    });

    socket.on('disconnect', function(){

    });

    socket.on('close', function(){

    });

    socket.on('reconnect', function(){

    });

    socket.on('reconnecting', function(){
        console.log('reconnected');
    });

    var countdown_time = 0;

    function countdown(){
        setTimeout(function(){
            if(countdown_time - 1 > 0){
                countdown_time -= 1;
                $('#drop-countdown').html(countdown_time);

                if(countdown_time != 0 ){
                    countdown();
                }
            }
        }, 1000);
    }

    $('#drop_delay').live('submit', function(event){
        event.preventDefault();

        if(slot_to_drop != null){

            var delay = $(this).find('#delay').val();
            console.log(delay);
            console.log(slot_to_drop);
            var command = function(){
                $('#modal').html('Dropping in <span id="drop-countdown">' + delay + '</span>');
                countdown_time = delay;

                countdown();

                socket.emit('machine', {machine_id: slot_to_drop.machine_alias});
            }

            var callback = function(recv_data){
                console.log(recv_data);
                console.log('drop command');

                if(recv_data.substr(0, 2) == 'OK'){

                    var inner_call = function(data){
                        console.log(data);

                        if(data.substr(0, 2) == 'OK'){
                            $('#modal').css('display', 'none');
                            $('#modal-overlay').css('display', 'none');
                        } else {
                            $('#modal').html(data);
                            setTimeout(function(){
                                $('#modal').css('display', 'none');
                                $('#modal').html('');
                                $('#modal-overlay').css('display', 'none');
                            }, 3000);
                        }
                    }

                    var inner_command = function(){
                        socket.emit('drop', {slot_num: slot_to_drop.slot_num, delay: delay});
                        // print error if there is one...
                    }

                    command_prep(inner_call, inner_command);
                } else {
                    $('#modal').html(recv_data);
                    setTimeout(function(){
                        $('#modal').css('display', 'none');
                        $('#modal').html('');
                        $('#modal-overlay').css('display', 'none');
                    }, 3000);
                }
            }

            command_prep(callback, command);
        } else {
            $('#modal').html("Please select a slot first");

            setTimeout(function(){
                $('#modal').css('display', 'none');
                $('#modal').html('');
                $('#modal-overlay').css('display', 'none');
            }, 2000);
        }

        return false;
    });

    $('.action-button[action="cancel-drop"]').live('click', function(){
        $('#modal').css('display', 'none');
        $('#modal-overlay').css('display', 'none');
        $('#modal').html('');

        slot_to_drop = null;

    });

    $('.action-button[action="drop"]').live('click', function(){
        console.log("foo");
        var machine_alias = $(this).attr('machine_alias');
        var slot_num = $(this).attr('slot_id');

        slot_to_drop = {
            slot_num: slot_num,
            machine_alias: machine_alias,
            delay: 0
        };

        $('#modal').html(
            '<div class="drop-delay">' +
                '<form id="drop_delay" name="drop_delay">' +
                    'Delay <input type="number" name="delay" id="delay" value="0" required="true" min="0"> <input type="submit" class="action-button green" value="Drop"> <input type="button" class="action-button orange" action="cancel-drop" value="Cancel">' +
                '</form>' +
            '</div>');


        $('#modal-overlay').css('display', 'block').css('height', document.body.clientHeight + 'px').css('width', window.innerWidth + 'px');
        $('#modal').css('left', ((window.innerWidth / 2) - 200) + "px");
        $('#modal').css('top', (window.pageYOffset + 200) + 'px');

        $('#modal').css('display', 'block');
    });
})
