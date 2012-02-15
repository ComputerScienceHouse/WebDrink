<?php
/**
 * @author Sean McGary <sean@seanmcgary.com>
 */
class lib_models_itemModel extends lib_models_baseModel
{
    
    public function __construct()
    {
        parent::__construct();

    }

    public function get_all_items()
    {
        return $this->query("SELECT * FROM drink_items WHERE state='active' ORDER BY item_name ASC")->result_array();
    }

    public function get_item_details($item_id)
    {
        $sql = "SELECT * FROM drink_items WHERE item_id=".$item_id;

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

    public function add_new_item($item_data)
    {
        $sql = "INSERT INTO drink_items(item_name, item_price) VALUES('" . $this->sanitize($item_data['item_name'])."', ".$this->sanitize($item_data['item_price']).")";

        $res = $this->query($sql);

        if($res != false)
        {
            $item_data['item_id'] = $this->insert_id;
            // update price history

            $res = $this->update_item_price($this->insert_id, $item_data['item_price']);

            if($res != false)
            {

                return $item_data;
            }
            else
            {
                return false;
            }

        }
        else
        {
            return false;
        }
    }

    public function update_item_price($item_id, $item_price)
    {
        $sql = "INSERT INTO drink_item_price_history(item_id, item_price) VALUES(". $item_id.", ". $item_price.")";

        $res = $this->query($sql);

        return $res;
    }

    public function remove_item($item_id)
    {
        $sql = "UPDATE drink_items SET state='inactive' WHERE item_id=".$item_id;

        $item_res = $this->query($sql);

        $sql = "DELETE FROM slots WHERE item_id=".$item_id;

        $slot_res = $this->query($sql);

        if($item_res != false && $slot_res != false)
        {
            return true;
        }
        else
        {
            return false;
        }
        
    }

    public function update_item($item_details)
    {
        // get the item currently in the database

        $item = $this->get_item_details($item_details['item_id']);

        if($item != false && $item != null)
        {
            $item = $this->get_one();
            
            $sql = "UPDATE drink_items
                        SET
                            item_name='".$this->sanitize($item_details['item_name'])."',
                            item_price=".$this->sanitize($item_details['item_price'])."
                        WHERE item_id=".$item_details['item_id'];

            $update_res = $this->query($sql);

            if($update_res != false)
            {

                if($item_details['item_price'] != $item['item_price'])
                {
                    $res = $this->update_item_price($item_details['item_id'], $item_details['item_price']);

                    if($res != false)
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
}
