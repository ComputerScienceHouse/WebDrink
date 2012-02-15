<?php
/**
 * Created by JetBrains PhpStorm.
 * User: seanmcgary
 * Date: 2/14/12
 * Time: 2:35 PM
 * To change this template use File | Settings | File Templates.
 */
class lib_controllers_api extends lib_controllers_baseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_user_drops($username)
    {
        $drops = $this->user_model->get_user_drops($username);
        header('Content-Type: application/json');
        echo json_encode($drops);
    }

    public function get_all_drops()
    {
        $all_drops = $this->admin_model->get_drop_log();
        header('Content-Type: application/json');
        echo json_encode($all_drops);
    }

    public function get_money_log()
    {
        $money_log = $this->admin_model->get_money_log();
        header('Content-Type: application/json');
        echo json_encode($money_log);
    }

    public function get_temps_for_machine($machine_alias)
    {

    }

    public function get_all_temps()
    {
        $temps = $this->temp_model->get_temps();
        header('Content-Type: application/json');
        echo json_encode($temps);
    }

    public function get_slot_data($slot_num, $machine_alias)
    {
        $machine_id = $this->machine_model->get_machine_id_for_alias($machine_alias);

        if($machine_id != false)
        {
            $slot = $this->machine_model->get_slot($machine_id['machine_id'], $slot_num);
            $items = $this->item_model->get_all_items();

            header('Content-Type: application/json');
            echo json_encode(array('status' => true, 'slot' => $slot, 'items' => $items));
        }
        else
        {
            header('Content-Type: application/json');
            echo json_encode(array('status' => false));
        }
    }
}