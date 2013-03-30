/**
 * Created by JetBrains PhpStorm.
 * User: seanmcgary
 * Date: 2/12/12
 * Time: 6:46 PM
 * To change this template use File | Settings | File Templates.
 */

function Request(command, callback, command_data){
    var self = this;

    if(typeof command_data == 'undefined'){
        command_data = {};
    }

    self.command = command;
    self.callback = callback;
    self.command_data = command_data;
}

Request.prototype.run_callback = function(callback_data){
    var self = this;

    self.callback(callback_data);
};

Request.prototype.run_command = function(){
    var self = this;

    self.command(self.command_data);
};

function WebsocketConn(ibutton){
    var self = this;

    self.ibutton = ibutton;
    self.authed = false;

    self.requesting = false;
    self.request_queue = [];
    self.current_request = null;
    self.slot_to_drop = null;

    self.socket = io.connect('https://drink.csh.rit.edu:8080', {secure: true});
    self.init_ws_events(function(){
        self.connect();
        self.init_click_events();
    });
};

WebsocketConn.prototype.init_click_events = function(){
    var self = this;

	// Clicking the button for submitting a drop
    $('#drop_modal input:button[btn-action="submit_drop_delay"]').on('click', function(){
        var drop_data = pending_drop;

        var delay = $(this).parent().parent().find('input[type="number"]').val();
		if(~~delay >= 0){
        	self.drop(drop_data.slot_num, drop_data.machine_alias, delay);
		}
		else{
			$(this).closest('#drop_modal').find('.form-feedback').html("That's in the past now, you retard.");
		}
    });

    // Hitting 'enter' on the delay field
    $('#drop_delay_form').on('submit', function () {
       	var drop_data = pending_drop;

       	var delay = $(this).parent().parent().find('input[type="number"]').val();
	
		if(~~delay >= 0){	
  			self.drop(drop_data.slot_num, drop_data.machine_alias, delay);
    	}
		else{
			$(this).closest('#drop_modal').find('.form-feedback').html("That's in the past now, you retard.");
		}
	});

    $('#drop_modal input:button[btn-action="cancel_drop"]').on('click', function(){
        $('#drop_modal').modal('hide');
    });
};

WebsocketConn.prototype.init_ws_events = function(cb){
    var self = this;

    self.socket.on('connect', function(){
        $('#websocket_status_alert').css('display', 'none');
    });

    self.socket.on('stat_recv', function(data){
        self.process_incoming_data(data);
    });

    self.socket.on('ibutton_recv', function(data){
        self.process_incoming_data(data);
    });

    self.socket.on('machine_recv', function(data){
        self.process_incoming_data(data);
    });

    self.socket.on('drop_recv', function(data){
        self.process_incoming_data(data);
    });

    self.socket.on('balance_recv', function(data){
        self.process_incoming_data(data);
    });

    self.socket.on('disconnect', function(){
        $('#websocket_status_alert').css('display', 'block');
    });

    self.socket.on('close', function(){
        $('#websocket_status_alert').css('display', 'block');
    });

    self.socket.on('reconnect', function(){
        $('#websocket_status_alert').css('display', 'block');
    });

    self.socket.on('reconnecting', function(){
        //console.log('reconnected');
    });

    cb();
};

WebsocketConn.prototype.process_queue = function(){
    var self = this;

    if(self.request_queue.length > 0){
        self.requesting = true;
        self.current_request = self.request_queue.pop();

        self.current_request.run_command();
    }
};

WebsocketConn.prototype.prep_request = function(request){
    var self = this;

    if(self.requesting == false){
        self.requesting = true;
        self.current_request = request;

        self.current_request.run_command();

    } else {
        self.request_queue.push(request);
    }
};

WebsocketConn.prototype.process_incoming_data = function(data){
    var self = this;
    if(self.current_request != null){
        self.current_request.run_callback(data);
    } else {
        //console.log(data);
    }

    self.current_request = null;
    self.requesting = false;

    self.process_queue();
};

WebsocketConn.prototype.connect = function(){
    var self = this;

    var callback = function(data){

        if(data.substr(0, 2) == 'OK'){
            self.authed = true;
            data = data.split(': ');
            $('#credits').html(data[1]);
        } else {
            self.authed = false;
            $('#invalid_ibutton').slideToggle();
        }
    };

    var command = function(){
        self.socket.emit('ibutton', {ibutton: self.ibutton});
    };

    var req = new Request(command, callback);

    self.prep_request(req);
};

WebsocketConn.prototype.drop = function(slot_num, machine_alias, delay){
    var self = this;

    var machine_command = function(){
        self.socket.emit('machine', {machine_id: machine_alias});
    };

    var machine_callback = function(data){
        var drop_command = function(){
            $('#drop_modal').modal('hide');
            $('#dropping_modal').modal({
                keyboard: false
            });

            self.socket.emit('drop', {slot_num: slot_num, delay: delay});

            var interval_id = setInterval(function(){
                $('#drop_countdown').html(delay);
                delay--;

                if(delay == -1){
                    clearInterval(interval_id);
                }
            }, 1000);
        };

        var drop_callback = function(data){

            if(data.substr(0, 2) == 'OK'){
                $('#dropping_modal_body').html('Dropping, run!!');

                self.get_balance();

            } else {
                $('#dropping_modal_body').html(data);
            }
        };

        var drop_req = new Request(drop_command, drop_callback);

        self.prep_request(drop_req);


    };

    var req = new Request(machine_command, machine_callback);

    self.prep_request(req);
};

WebsocketConn.prototype.stat = function(){
    var self = this;

    var callback = function(data){
        self.process_queue();
    };

    var command = function(){
        self.socket.emit('stat', {});
    };

    var req = new Request(command, callback);

    self.prep_request(req);
};

WebsocketConn.prototype.machine = function(machine_alias){
    var self = this;

    var callback = function(data){
        self.process_queue();
    };

    var command = function(){
        self.socket.emit('machine', {machine_id: machine_alias});
    };

    var req = new Request(command, callback);

    self.prep_request(req);
};

WebsocketConn.prototype.get_balance = function(){
    var self = this;

    var callback = function(data){

        if(data.substr(0, 2) == 'OK'){
            data = data.split(': ');
            $('#credits').html(data[1]);
        } else {
            self.authed = false;
            $('#invalid_ibutton').slideToggle();
        }

        self.process_queue();
    };

    var command = function(){
        self.socket.emit('getbalance', {});
    };

    var req = new Request(command, callback);

    self.prep_request(req);
};

