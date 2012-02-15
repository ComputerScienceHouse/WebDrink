/**
 * Created by JetBrains PhpStorm.
 * User: seanmcgary
 * Date: 2/15/12
 * Time: 10:41 AM
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
                        '{{#if this.drink_admin}}' +
                        '<input type="button" class="btn btn-info" btn-action="edit_slot" slot_num="{{slot_num}}" value="Edit">'+
                        '{{/if}}' +
                    '</td>'+
                '</tr>'+
                '{{/each}}'+
            '</tbody>'+
        '</table>'+
    '</div>'+
'</div>'+
'<hr>'+
'{{/each}}';

var manage_user_form = '' +
    '<h3 id="username">{{cn}}</h3>' +
    '<label class="form-inline"><span id="curr_credits">{{credits}}</span></label>' +
    '<input type="number" name="credits" id="credit_input" value="0" username="{{uid}}">' +
    '<select name="edit_type" id="edit_type">' +
        '<option value="add">Add Credits</option>' +
        '<option value="fixed">Fix Amount</option>' +
    '</select>' +
    '<input type="submit" value="Submit" class="btn btn-success">';

var user_drops = ''+
    '<div class="tab-content global-tab" tab_content_id="user_drops">' +
        '<h2>Your Drop History</h2>' +
        '<table class="machine-table">' +
            '<thead>' +
                '<tr>' +
                    '<th>Time</th>'+
                    '<th>Slot</th>'+
                    '<th>Machine</th>'+
                    '<th>Item Name</th>'+
                    '<th>Item Price</th>'+
                    '<th>Status</th>'+
                '</tr>'+
            '</thead>'+
            '<tbody>'+
                '{{#each drops}}' +
                '<tr>'+
                    '<td>{{date_added}}</td>'+
                    '<td>{{slot}}</td>'+
                    '<td>{{display_name}}</td>'+
                    '<td>{{item_name}}</td>'+
                    '<td>{{current_item_price}}<td>'+
                    '<td>{{status}}</td>'+
                '</tr>'+
                '{{/each}}' +
            '</tbody>'+
        '</table>'+
    '</div>';

function process_machines(sel, machine_data){
    // compile machines
    var machines = Handlebars.compile(machine_temp);
    machines = machines({machine: machine_data});

    sel.html(machines);

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

    $('input:button[btn-action="edit_slot"]').on('click', function(){
        var slot_num = $(this).attr('slot_num'),
            alias = $(this).parent().parent().parent().parent().attr('alias');

        Ext.Ajax.request({
            url: page_data.get_slot_data + '/' + slot_num + '/' + alias,
            success: function(response, opts){
                var obj = Ext.decode(response.responseText);

                if(obj.status == true){
                    $('#edit_modal').modal();
                    $('#edit_slot_num').html(obj.slot.slot_num);
                    $('#edit_machine_name').html(obj.slot.display_name);

                    $('#edit_slot_form').attr('slot_num', obj.slot.slot_num);
                    $('#edit_slot_form').attr('machine_id', obj.slot.machine_id);

                    var items = [];

                    for(var i in obj.items){
                        items.push(obj.items[i].item_name);
                        $('#slot_item').append('<option value="' + obj.items[i].item_id + '"' + ((obj.items[i].item_id == obj.slot.item_id) ? 'selected' : '') + '>' + obj.items[i].item_name + '</option>');
                    }

                    $('#available').val(obj.slot.available);

                    if(obj.slot.status == 'enabled'){
                        $('#state opt4ion[value="enabled"]').attr('selected', 'true');
                    } else {
                        $('#state option[value="disabled"]').attr('selected', 'true');
                    }

                }
            },
            failure: function(response, opts){

            }
        });
    });
}

function get_user_drops(selector){
    Ext.Ajax.request({
        url: page_data.user_drops,
        success: function(response, opts){
            var obj = Ext.decode(response.responseText);

            console.log(obj);

            var drops = Handlebars.compile(user_drops);
            drops = drops({drops: obj});

            console.log(drops);

            $('#user_drops').html(drops);
        },
        failure: function(response, opts){

        }
    })
}