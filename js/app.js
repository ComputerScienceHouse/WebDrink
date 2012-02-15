/**
 * Created by JetBrains PhpStorm.
 * User: seanmcgary
 * Date: 2/12/12
 * Time: 6:57 PM
 * To change this template use File | Settings | File Templates.
 */

$(document).ready(function(){

    $('#machines').css('display', 'block');

    var websocket_conn = new WebsocketConn(page_data.ibutton);

    websocket_conn.stat();

    process_machines($('#machines'), page_data.machines);

    get_user_drops($('#user_drops'));

    // setup navigation
    $('#navbar_items li a').on('click', function(){
        if(!($(this).parent().hasClass('active'))){
            $('#navbar_items li.active').removeClass('active');

            $(this).parent().addClass('active');

            $('.page_content').css('display', 'none');

            $('.page_content#' + $(this).attr('content_id')).css('display', 'block');
        }
    });

    $('#close_edit').on('click', function(){
        $('#edit_modal').modal('hide');
    })

});