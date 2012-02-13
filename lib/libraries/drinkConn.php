<?php
/**
 * Created by JetBrains PhpStorm.
 * User: seanmcgary
 * Date: 9/25/11
 * Time: 11:49 PM
 * To change this template use File | Settings | File Templates.
 */

class lib_libraries_drinkConn
{
    public $drink_addresses;
    private $drink_conn;

    public function __construct()
    {
        $this->drink_addresses = array('ld' => 'ld.csh.rit.edu',
                                        'd' => 'd.csh.rit.edu',
                                        's' => 's.csh.rit.edu');

        $this->drink_conn = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    }
    
    public function drop_drink($machine_alias, $slot_num, $delay = 0)
    {
        //echo "test";
        if(socket_connect($this->drink_conn, $this->drink_addresses[$machine_alias], 4242))
        {
            echo "success foo";

            //var_dump("foo");
            $stat = "STAT\n";
            //$res = socket_send($this->drink_conn, $stat, strlen($stat), MSG_EOF);

            //$recv = socket_read($this->drink_conn, 1024);

            //var_dump($recv);

            
            
        }
        else
        {
            return socket_strerror(socket_last_error());
        }
    }
}
