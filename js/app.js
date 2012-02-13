/**
 * Created by JetBrains PhpStorm.
 * User: seanmcgary
 * Date: 2/12/12
 * Time: 6:57 PM
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(function(){
    var websocket_conn = new WebsocketConn(ibutton);

    websocket_conn.stat();
});