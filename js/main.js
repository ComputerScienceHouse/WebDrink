/**
 * Created by JetBrains PhpStorm.
 * User: seanmcgary
 * Date: 9/11/11
 * Time: 7:07 PM
 * To change this template use File | Settings | File Templates.
 */
var slot_template = '<tr slot_id="{{slot_id}}">' +
                            '<td><div class="slot" field_name="slot_num" slot_id="{{slot_id}}" machine_id="{{machine_id}}" contenteditable="true">{{slot_id}}</div></td>' +
                            '<td><div class="slot" field_name="item_id" slot_id="{{slot_id}}" machine_id="{{machine_id}}" item_id="none">{{{select}}}</div></td>' +
                            //'<td><div class="slot" field_name="price" slot_id="{{slot_id}}" machine_id="{{machine_id}}" contenteditable="true">{{price}}</div></td>' +
                            '<td><div class="item" field_name="price" slot_id="{{slot_id}}" machine_id="{{machine_id}}">{{price}}</div></td>' +
                            '<td><div class="slot" field_name="available" slot_id="{{slot_id}}" machine_id="{{machine_id}}" contenteditable="true">{{available}}</div></td>' +
                            '<td>' +
                                '<input type="button" class="action-button green" action="drop" machine_id="{{machine_id}}" slot_id="{{slot_id}}" value="Drop">' +
                                '<input type="button" class="action-button orange" action="save" machine_id="{{machine_id}}" slot_id="{{slot_id}}" value="Save">' +
                                '<input type="button" class="action-button red" action="delete" machine_id="{{machine_id}}" slot_id="{{slot_id}}" value="Delete">' +
                                '<input type="button" class="action-button green" action="enable" machine_id="{{machine_id}}" slot_id="{{slot_id}}" value="Enable">' +
                            '</td>' +
                        '</tr>';
$(document).ready(function(){
    //DrinkTabs.init('tab-link', 'global-tab');

    (new DrinkTabs()).init('tab-link', 'global-tab');
    (new DrinkTabs()).init('log-tab-link', 'log-tab');

    $('.action-button[action="edit"]').live('click', function(){
        var slot_id = $(this).attr('slot_id');
        var machine_id = $(this).attr('machine_id');

        $('div.slot[slot_id="' + slot_id + '"][machine_id="' + machine_id + '"]').attr('contenteditable', 'true');
        var item_id = $('div[slot_id="' + slot_id + '"][machine_id="' + machine_id + '"][field_name="item_id"]').attr('item_id');
        
        Ext.Ajax.request({
            url: get_item_select + '/' + item_id,
            method: 'POST',
            success: function(response, opts){
                var obj = Ext.decode(response.responseText);

                if(obj.status == 'true'){
                    $('div[slot_id="' + slot_id + '"][machine_id="' + machine_id + '"][field_name="item_id"]').attr('contenteditable', 'false');

                    $('div[slot_id="' + slot_id + '"][machine_id="' + machine_id + '"][field_name="item_id"]').html(obj.select);
                    
                    $('.chzn-select').chosen();


                }

                console.log(obj);
            },
            failure: function(response, opts){

            }
        });


        $(this).attr('action', 'save');
        $(this).attr('value', 'Save');
    });

    $('.chzn-select').live('change', function(){
        var self = $(this);

        var price = self.parent().parent().parent().find('div[field_name="price"]');

        Ext.Ajax.request({
            url: get_item_details + '/' + self.val(),
            method: 'POST',
            success: function(response, opts){
                var obj = Ext.decode(response.responseText);

                if(obj.status == 'true'){
                    price.html(obj.item.item_price);
                }
            }
        })
    });

    $('.action-button[action="save"]').live('click', function(){
        var self = $(this);

        var slot_id = $(this).attr('slot_id');
        var machine_id = $(this).attr('machine_id');
        
        var fields = {};

        var can_submit = true;

        var button = $(this);

        $('div[slot_id="' + slot_id + '"][machine_id="' + machine_id + '"]').each(function(index){
            var field_id = $(this).attr('field_name');

            fields[field_id] = $(this).html();

            if(fields[field_id].length == 0){
                can_submit = false;
            }
        });

        var select_field = $('div[slot_id="' + slot_id + '"][machine_id="' + machine_id + '"][field_name="item_id"] select');

        var item_name = '';

        if(select_field.val().length == 0){
            can_submit = false;
        } else {
            fields['item_id'] = select_field.val();
            item_name = select_field.get(0).options[select_field.get(0).selectedIndex].text;
        }

        
        fields['old_slot_num'] = ((slot_id.length > 0) ? slot_id : $('div[slot_id="' + slot_id + '"][machine_id="' + machine_id + '"][field_name="slot_num"]').html());
        fields['machine_id'] = machine_id;


        Ext.Ajax.request({
            url: update_slot,
            success: function(response, opts){
                var obj = Ext.decode(response.responseText);

                if(obj.status == 'true'){
                    $('div[slot_id="' + slot_id + '"][machine_id="' + machine_id + '"]').attr('contenteditable', 'false');
                    $('div[slot_id="' + slot_id + '"][machine_id="' + machine_id + '"][field_name="item_id"]').html(item_name);

                    $('div[slot_id="' + slot_id + '"][machine_id="' + machine_id + '"][field_name="item_id"]').attr('item_id', obj.item_id);

                    $('div[slot_id="' + slot_id + '"][machine_id="' + machine_id + '"]').attr('slot_id', obj.slot_id);

                    self.parent().parent().attr('slot_id', obj.slot_id);

                    var drop_button = $('.action-button[slot_id="' + slot_id + '"][machine_id="' + machine_id + '"][action="drop"]');

                    if(parseInt(fields['available']) == 0){
                        drop_button.attr('class', 'action-button disabled');
                        drop_button.attr('disabled', 'true');
                    } else {
                        drop_button.attr('class', 'action-button green');
                        drop_button.attr('disabled', 'false');
                    }

                    button.attr('action', 'edit');
                    button.attr('value', 'Edit');
                    
                } else {
                    console.log('error');
                }
            },
            failure: function(response, opts){
                
            },
            params: fields
        });
        
    });

    $('.action-button[action="new_slot"]').live('click', function(){
        var slot_vals = {};
        var machine_id = $(this).attr('machine_id');

        var machine_table = $('.machine-table#' + machine_id);

        slot_vals['machine_id'] = machine_id;

        console.log(machine_table.find('tr').length);

        if(machine_table.find('tr').length > 0){

            //slot_vals['slot_id'] = machine_table.find('tr').length;
            slot_vals['slot_id'] = "";
        } else {
            
            slot_vals['slot_id'] = 1;
        }
        
        slot_vals['price'] = '0';
        slot_vals['available'] = '0';

        Ext.Ajax.request({
            url: get_item_select,
            method: 'POST',
            success: function(response, opts){
                var obj = Ext.decode(response.responseText);

                if(obj.status == 'true'){
                    slot_vals.select = obj.select;
                    var slot = Mustache.to_html(slot_template, slot_vals);

                    machine_table.append($(slot));

                    $('.chzn-select').chosen();
                }

                console.log(obj);
            },
            failure: function(response, opts){

            }
        });
    });

    $('.action-button[action="delete"]').live('click', function(){
        var machine_id = $(this).attr('machine_id');
        var slot_id = $(this).attr('slot_id');

        var fields = {machine_id: machine_id, slot_num: slot_id};

        var parent = $(this).parent().parent();

        Ext.Ajax.request({
            url: remove_slot,
            success: function(response, opts){
                var obj = Ext.decode(response.responseText);

                if(obj.status == 'true'){
                    parent.remove();
                } else {
                    console.log('error');
                }
            },
            failure: function(response, opts){

            },
            params: fields
        });
    });

    function set_status(machine_id, slot_id, status, callback){
        var fields = {machine_id: machine_id, slot_num: slot_id, status: status};
        console.log(fields);
        Ext.Ajax.request({
            url: set_slot_status,
            success: function(response, opts){
                var obj = Ext.decode(response.responseText);

                if(obj.status == 'true'){
                    callback();
                } else {
                    console.log('error');
                }
            },
            failure: function(response, opts){

            },
            params: fields
        });
    }

    $('.action-button[action="enable"]').live('click', function(){
        var machine_id = $(this).attr('machine_id');
        var slot_id = $(this).attr('slot_id');

        var button = $(this);

        set_status(machine_id, slot_id, 'enabled', function(){
            button.attr('class', 'action-button orange');
            button.attr('value', 'Disable');
            button.attr('action', 'disable');

            var available = parseInt($('div[slot_id="' + slot_id + '"][machine_id="' + machine_id + '"][field_name="available"]').html());

            if(available > 0){

                var drop_button = $('.action-button[slot_id="' + slot_id + '"][machine_id="' + machine_id + '"][action="drop"]');
                drop_button.attr('class', 'action-button green');
                drop_button.removeAttr('disabled');
            }
        });
    });

    $('.action-button[action="disable"]').live('click', function(){
        var machine_id = $(this).attr('machine_id');
        var slot_id = $(this).attr('slot_id');

        var button = $(this);

        set_status(machine_id, slot_id, 'disabled', function(){
            button.attr('class', 'action-button green');
            button.attr('value', 'Enable');
            button.attr('action', 'enable');

            var drop_button = $('.action-button[slot_id="' + slot_id + '"][machine_id="' + machine_id + '"][action="drop"]');
            drop_button.attr('class', 'action-button disabled');
            drop_button.attr('disabled', 'true');
        });
        


    });

    $('#search_user').live('submit', function(){
        console.log('test');
        if($('#username').val().length > 0){
            Ext.Ajax.request({
                url: search_user,
                form: 'search_user',
                success: function(response, opts){
                    var obj = Ext.decode(response.responseText);

                    if(obj.status == 'true'){
                        console.log('success');

                        $('#user_info').html(obj.user);

                    } else {
                        console.log('error');
                    }

                },
                failure: function(response, opts){

                }
            });
        } else {
            console.log('fill in username');
        }

        return false;
    });

    $('#edit_user').live('submit', function(){

        if($('#credits').val().length > 0){

            var uid = $(this).attr('uid');

            Ext.Ajax.request({
                url: edit_credits,
                form: 'edit_user',
                success: function(response, opts){
                    var obj = Ext.decode(response.responseText);

                    if(obj.status == 'true'){
                        console.log(obj);
                        $('#curr_credits').html(obj.credits);
                    } else {
                        console.log('error');
                    }
                },
                failure: function(response, opts){

                },
                params: {uid: uid}
            });
        } else {

        }

        return false;
    });

});