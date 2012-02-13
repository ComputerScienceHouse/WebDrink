<?php
/**
 * Created by JetBrains PhpStorm.
 * User: seanmcgary
 * Date: 10/17/11
 * Time: 4:25 PM
 * To change this template use File | Settings | File Templates.
 */

class lib_models_userModel extends lib_models_baseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_user_drops($username)
    {
        $sql = "SELECT * FROM drop_log
                    LEFT JOIN machines USING(machine_id)
                    LEFT JOIN drink_items USING(item_id)
                WHERE username='".$username."' ORDER BY time DESC";

        $res = $this->query($sql)->result_array();

        return $res;
    }
}

