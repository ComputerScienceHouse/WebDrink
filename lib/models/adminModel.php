<?php
/**
 * @author Sean McGary <sean@seanmcgary.com>
 */
class lib_models_adminModel extends lib_models_baseModel
{
    
    public function __construct()
    {
        parent::__construct();

    }

    public function insert_money_log($uid, $admin, $amount, $direction, $reason)
    {
        $sql = "INSERT INTO money_log(username, admin, amount, direction, reason)
                    VALUES('" . $uid . "', '".$admin."', ".$amount.", '".$direction."', '".$reason."')";

        $this->query($sql);
    }

    public function get_drop_log()
    {
        $sql = "SELECT * FROM drop_log
                    LEFT JOIN machines USING(machine_id)
                    LEFT JOIN drink_items USING(item_id)
                ORDER BY time DESC";

        $res = $this->query($sql)->result_array();

        return $res;
    }

    public function get_money_log()
    {
        $sql = "SELECT * FROM money_log
                ORDER BY time DESC";

        $res = $this->query($sql)->result_array();

        return $res;
    }



}
