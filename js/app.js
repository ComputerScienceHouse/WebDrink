/**
 * Created by JetBrains PhpStorm.
 * User: seanmcgary
 * Date: 2/12/12
 * Time: 6:57 PM
 * To change this template use File | Settings | File Templates.
 */
var machine_temp = ''+
'{{#each machine}}'+
'<div class="row">'+
    '<div class="span12">'+
        '<h2>{{display_name}}</h2>'+
        '<table class="table table-condensed table-striped" alias="{{alias}}">'+
            '<thead>'+
                '<tr>'+
                    '<th>Slot</th>'+
                    '<th>Name</th>'+
                    '<th>Price</th>'+
                    '<th>Available</th>'+
                    '<th>Actions</th>'+
                '</tr>'+
            '</thead>'+
            '<tbody>'+
                '{{#each this.slots}}'+
                '<tr>'+
                    '<td>{{slot_num}}</td>'+
                    '<td>{{item_name}}</td>'+
                    '<td>{{item_price}}</td>'+
                    '<td>{{available}}</td>'+
                    '<td>'+
                        '<input type="button" class="btn btn-primary" btn-action="drop" slot_num="{{slot_num}}" value="Drop">'+
                        '<input type="button" class="btn btn-info" value="Edit">'+
                    '</td>'+
                '</tr>'+
                '{{/each}}'+
            '</tbody>'+
        '</table>'+
    '</div>'+
'</div>'+
'<hr>'+
'{{/each}}';

$(document).ready(function(){
    console.log(page_data);
    var websocket_conn = new WebsocketConn(page_data.ibutton);

    websocket_conn.stat();

    // compile machines
    var machines = Handlebars.compile(machine_temp);
    machines = machines({machine: page_data.machines});

    $('#machines').html(machines);

    $('input:button[btn-action="drop"]').on('click', function(){
        var slot_num = $(this).attr('slot_num'),
            machine_alias = $(this).parent().parent().parent().parent().attr('alias');

        pending_drop = {slot_num: slot_num, machine_alias: machine_alias};

        $('#drop_modal').modal({
            keyboard: false
        });

        $('#drop_modal').on('hidden', function(){
            pending_drop = null;
        });
    });

});