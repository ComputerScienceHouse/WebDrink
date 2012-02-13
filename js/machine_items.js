/**
 * Created by JetBrains PhpStorm.
 * User: seanmcgary
 * Date: 10/11/11
 * Time: 4:26 PM
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(function(){
    var item_template = '<tr item_id="{{item_id}}">' +
                            '<td>' +
                                '<div class="item" field_name="item_name" item_id="{{item_id}}" contenteditable="false">{{{item_name}}}</div>' +
                            '</td>' +
                            '<td>' +
                                '<div class="item" field_name="item_price" item_id="{{item_id}}" contenteditable="false">{{item_price}}</div>' +
                            '</td>' +
                            '<td>' +
                                '<input type="button" class="action-button orange" action="edit-item" item_id="{{item_id}}" value="Edit">' +
                                '<input type="button" class="action-button red" action="delete-item" item_id="{{item_id}}" value="Delete">' +
                            '</td>' +
                        '</tr>';
    var can_submit = true;

    $('#new_item').live('submit', function(){
        
        $(this).find('input').each(function(index){
            if($(this).val().length == 0){
                can_submit = false;
            }
        });

        if(can_submit){
            Ext.Ajax.request({
                url: add_new_item,
                form: 'new_item',
                success: function(response, opts){
                    var obj = Ext.decode(response.responseText);

                    if(obj.status == 'true'){
                        console.log(obj.item);

                        var table_row = Mustache.to_html(item_template, obj.item);

                        $('#current_items').append(table_row);

                    } else {
                        // display error message
                    }
                },
                failure: function(response, opts){

                }
            })
        }

        return false;
    });

    $('.action-button[action="delete-item"]').live('click', function(){
        var item_id = $(this).attr('item_id');

        var fields = {item_id: item_id};

        var parent = $(this).parent().parent();

        Ext.Ajax.request({
            url: remove_item,
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

    $('.action-button[action="edit-item"]').live('click', function(){
        var self = $(this);
        var item_id = $(this).attr('item_id');

        $('.item[item_id="' + item_id + '"]').attr('contenteditable', 'true');

        $(this).attr('action', 'save-item');
        $(this).attr('value', 'Save');

    });

    $('.action-button[action="save-item"]').live('click', function(){
        var self = $(this);
        var item_id = $(this).attr('item_id');

        console.log($('.item[field_name="save-item"][item_id="' + item_id + '"]'));

        var fields = {};

        var can_submit = true;

        $('.item[item_id="' + item_id + '"]').each(function(index){
            var field_id = $(this).attr('field_name');

            fields[field_id] = $(this).html();

            if(fields[field_id].length == 0){
                can_submit = false;
            }
        });

        if(can_submit == true){
            fields.item_id = item_id;
            Ext.Ajax.request({
                url: edit_item,
                success: function(response, opts){
                    var obj = Ext.decode(response.responseText);

                    if(obj.status == 'true'){
                        
                        self.attr('action', 'edit-item');
                        self.attr('value', 'Edit');

                        $('.item[item_id="' + item_id + '"]').attr('contenteditable', 'false');
                    }
                },
                failure: function(response, opts){

                },
                params: fields
            });

        } else {
            console.log('fill in all fields');
        }

        
    });
});