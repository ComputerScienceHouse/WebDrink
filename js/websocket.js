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
    });
};

WebsocketConn.prototype.init_click_events = function(){
    var self = this;
};

WebsocketConn.prototype.init_ws_events = function(cb){
    var self = this;

    self.socket.on('connect', function(){
        console.log('ws connected');
    });

    self.socket.on('stat_recv', function(data){
        console.log("stat_recv");
        self.process_incoming_data(data);
    });

    self.socket.on('ibutton_recv', function(data){
        console.log('ibutton_recv');
        self.process_incoming_data(data);
    });

    self.socket.on('machine_recv', function(data){
        console.log('machine_recv');
        self.process_incoming_data(data);
    });

    self.socket.on('drop_recv', function(data){
        console.log('drop_recv');
        self.process_incoming_data(data);
    });

    self.socket.on('disconnect', function(){

    });

    self.socket.on('close', function(){

    });

    self.socket.on('reconnect', function(){

    });

    self.socket.on('reconnecting', function(){
        console.log('reconnected');
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
        console.log("no callback");
        console.log(data);
    }

    self.current_request = null;
    self.requesting = false;

    self.process_queue();
};

WebsocketConn.prototype.connect = function(){
    var self = this;

    var callback = function(data){
        self.authed = true;
    };

    var command = function(){
        self.socket.emit('ibutton', {ibutton: ibutton});
    };

    var req = new Request(command, callback);

    self.prep_request(req);
};

WebsocketConn.prototype.drop = function(){
    var self = this;
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


};

