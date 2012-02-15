<?php
/**
 * @author Sean McGary <sean@seanmcgary.com>
 */
class lib_models_machineModel extends lib_models_baseModel
{
    
    public function __construct()
    {
        parent::__construct();

    }

    public function get_all_machines()
    {
        return $this->query("SELECT * FROM machines LEFT JOIN machine_aliases USING(machine_id) ORDER BY name ASC")->result_array();
    }

    public function get_machines_with_slots()
    {
        $machines = $this->get_all_machines();

        foreach($machines as &$machine)
        {
            $machine['slots'] = $this->query("SELECT * FROM slots
                                                LEFT JOIN drink_items USING(item_id)
                                             WHERE machine_id=" . $machine['machine_id'] . "
                                             ORDER BY slot_num ASC")->result_array();

            foreach($machine['slots'] as &$slot){
                $slot['drink_admin'] = $_SESSION['drink_loggedIn']['drink_admin'];
            }

            $alias = $this->get_machine_alias($machine['machine_id']);

            $machine['alias'] = $alias['alias'];
        }

        return $machines;
    }
    
    public function get_machine_alias($machine_id)
    {
        $results = $this->query("SELECT * FROM machine_aliases WHERE machine_id=" . $machine_id)->get_one();

        return $results;
    }

    public function update_slot($slot_num, $machine_id, $values)
    {
        if($this->slot_exists($slot_num, $machine_id))
        {
            $sql = "UPDATE slots SET slot_num=".$values['slot_num']. ", item_id=" . $values['item_id'] . ", available=".$values['available'].", status='".$values['state']."'
                        WHERE machine_id=".$machine_id." AND slot_num=".$slot_num;

            $this->query($sql);


        }
        else
        {
            $sql = "INSERT INTO slots(slot_num, machine_id, item_id, available)
                        VALUES(".$values['slot_num'] . ", " . $values['machine_id'] . ", " . $values['item_id'] . ", ".$values['available'] . ")";

            $this->query($sql);
        }

        return $values['item_id'];

    }

    public function slot_exists($slot_num, $machine_id)
    {
        $sql = "SELECT * FROM slots WHERE slot_num=" . $slot_num . " AND machine_id=".$machine_id;

        $res = $this->query($sql);

        if($res->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function remove_slot($slot_num, $machine_id)
    {
        $sql = "DELETE FROM slots WHERE slot_num=".$slot_num." AND machine_id=".$machine_id;

        $this->query($sql);
    }

    public function set_slot_status($slot_num, $machine_id, $status)
    {
        $sql = "UPDATE slots SET status='".$status."' WHERE machine_id=".$machine_id." AND slot_num=".$slot_num;

        $this->query($sql);
    }

    public function get_slot($machine_id, $slot_num)
    {
        $sql = "SELECT * FROM slots
                    LEFT JOIN machines USING(machine_id)
                WHERE machine_id=".$machine_id." AND slot_num=".$slot_num;

        $res = $this->query($sql);

        if($res != false)
        {
            return $this->get_one();
        }
        else
        {
            return false;
        }
    }

    public function get_machine_id_for_alias($alias)
    {
        $sql = 'SELECT machine_id FROM machine_aliases WHERE alias="'.$alias.'"';

        $res = $this->query($sql);

        if($res != false)
        {
            return $this->get_one();
        }
        else
        {
            return false;
        }
    }

}
