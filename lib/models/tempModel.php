<?php
/**
 * Created by JetBrains PhpStorm.
 * User: seanmcgary
 * Date: 2/14/12
 * Time: 2:53 PM
 * To change this template use File | Settings | File Templates.
 */
class lib_models_tempModel extends lib_models_baseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_temps()
    {
        return $this->query("SELECT * FROM temperature_log
                                LEFT JOIN machines USING(machine_id)
                             ORDER BY time DESC LIMIT 300")->result_array();
    }

    public function get_temps_for_machine($machine_id, $limit = null)
    {
        $sql = "SELECT * FROM temperature_log
                WHERE machine_id=".$machine_id."
                ORDER BY time DESC";

        if($limit != null)
        {
            $sql .= " LIMIT ".$limit;
        }

        return $this->query($sql)->result_array();
    }
}