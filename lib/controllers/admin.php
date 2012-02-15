<?php
/**
 * Created by JetBrains PhpStorm.
 * User: seanmcgary
 * Date: 9/18/11
 * Time: 11:16 PM
 * To change this template use File | Settings | File Templates.
 */
 
class lib_controllers_admin extends lib_controllers_baseController
{
    private $auth;
    public function __construct()
    {
        parent::__construct();
        //var_dump($_SESSION);
        if(!$_SESSION['drink_loggedIn']['drink_admin'])
        {
            echo json_encode(array('status' => 'false', 'msg' => 'permission denied'));

            $this->auth = false;
        }
        else
        {
            $this->auth = true;
        }
            
    }

    public function get_item_details($item_id)
    {
        $res = $this->item_model->get_item_details($item_id);

        if($res != false)
        {
            echo json_encode(array('status' => 'true', 'item' => $res));
        }
        else
        {
            echo json_encode(array('status' => 'false'));
        }
    }

    public function get_item_select($item_id = null)
    {
        $items = $this->item_model->get_all_items();

        $slot_select = $this->load->view('presenters/item_select', array('items' => $items, 'item_id' => $item_id), true);

        echo json_encode(array('status' => 'true', 'select' => $slot_select, 'item_data' => $items));
    }

    public function edit_slot()
    {
        if($this->auth)
        {
            $post_list = array('available', 'state', 'item_id', 'slot_num', 'machine_id');

            $post = $this->input->post_array($post_list);

            $errors = false;
            $error_msg = '';

            foreach($post as $key => &$value)
            {
                if($value == '')
                {
                    $errors = true;
                    $error_msg = 'Please fill in all fields';
                    break;
                }
            }

            if($errors == false)
            {
                $res = $this->machine_model->update_slot($post['slot_num'], $post['machine_id'], $post);
                $machines = $this->machine_model->get_machines_with_slots();
                echo json_encode(array('status' => 'true', 'machines' => $machines));
            }
            else
            {
                echo json_encode(array('status' => 'false', 'msg' => $error_msg));
            }
        }
    }

    public function remove_slot()
    {
        if($this->auth)
        {
            $post_list = array('machine_id', 'slot_num');

            $post = $this->input->post_array($post_list);

            //printr($post);

            $this->machine_model->remove_slot($post['slot_num'], $post['machine_id']);

            echo json_encode(array('status' => 'true'));
        }
    }

    public function set_slot_status()
    {
        if($this->auth)
        {
            $post_list = array('machine_id', 'slot_num', 'status');

            $post = $this->input->post_array($post_list);

            $this->machine_model->set_slot_status($post['slot_num'], $post['machine_id'], $post['status']);

            echo json_encode(array('status' => 'true'));
        }
    }

    public function get_user_for_uid()
    {
        if($this->auth)
        {
            $uid = $this->input->post('username');

            $res = $this->drink->search_user_by_uid($uid);

            if($res !== null)
            {
                $user = array();
                $user['credits'] = $res['drinkbalance'][0];
                $user['uid'] = $uid;
                $user['cn'] = $res['cn'][0];


                echo json_encode(array('status' => 'true', 'user' => $user));
            }
            else
            {
                echo json_encode(array('status' => 'false'));
            }
        }
    }

    public function edit_credits()
    {
        if($this->auth)
        {
            $post_list = array('uid', 'credits', 'edit_type');

            $post = $this->input->post_array($post_list);

            $errors = false;
            $error_msg = '';
            foreach($post as $key => $val)
            {
                if($val == '')
                {
                    $errors = true;
                    $error_msg = 'Please fill in all fields<br>';
                }
            }

            if(intval($post['credits']) == 0 && $post['credits'] != 0){
                $errors = true;
                $error_msg .= 'Credit value must be a positive or negative integer';
            }

            if($errors == false)
            {
                $new_credits = null;
                $reason = '';
                if($post['edit_type'] == 'add')
                {
                    $user_credits = $this->drink->get_user_credits($post['uid']);

                    $new_credits = $user_credits + intval($post['credits']);

                    $reason = 'add';

                }
                else if($post['edit_type'] == 'fixed')
                {
                    $new_credits = $post['credits'];
                    $reason = 'fixed';
                }
                else
                {
                    echo json_encode(array('status' => 'false', 'msg' => 'Invalid edit type'));
                    return;
                }

                $res = $this->drink->update_user_credits($post['uid'], $new_credits);

                $direction = 'in';
                if(intval($post['credits']) < 0)
                {
                    $direction = 'out';
                }

                $this->admin_model->insert_money_log($post['uid'], $_SESSION['drink_loggedIn']['uid'], intval($post['credits']), $direction, $reason);

                if($res)
                {
                    echo json_encode(array('status' => 'true', 'credits' => $new_credits));
                }
                else
                {
                    echo json_encode(array('status' => 'false', 'msg' => 'Error updating balance'));
                }

            }
            else
            {
                echo json_encode(array('status' => 'false', 'msg' => $error_msg));
            }
        }
    }

    public function add_new_item()
    {
        if($this->auth)
        {
            $post_list = array('item_name', 'item_price');

            $post = $this->input->post_array($post_list);

            $errors = false;
            $error_msg= '';

            foreach($post as $item)
            {
                if($item == '')
                {
                    $errors = true;
                }
            }

            if($errors == true)
            {
                $error_msg = 'Please fill in all fields.';

                echo json_encode(array('status' => 'false', 'msg' => $error_msg));
            }
            else
            {
                $res = $this->item_model->add_new_item($post);

                if($res != false)
                {
                    echo json_encode(array('status' => 'true', 'item' => $res));
                }
                else
                {
                    echo json_encode(array('status' => 'false', 'msg' => 'Error inserting item'));
                }
            }
        }
    }

    public function remove_item()
    {
        if($this->auth)
        {
            $item_id = $this->input->post('item_id');

            printr($item_id);

            $res = $this->item_model->remove_item($item_id);

            if($res != false)
            {
                echo json_encode(array('status' => 'true'));
            }
            else
            {
                echo json_encode(array('status' => 'false', 'msg' => 'Item could not be removed'));
            }
        }
    }

    public function edit_item()
    {
        if($this->auth)
        {
            $post_list = array('item_name', 'item_price', 'item_id');

            $post = $this->input->post_array($post_list);

            $errors = false;

            foreach($post as $item)
            {
                if($item == '')
                {
                    $errors = true;
                }
            }

            if($errors == false)
            {
                $res = $this->item_model->update_item($post);

                if($res)
                {
                    echo json_encode(array('status' => 'true'));
                }
                else
                {
                    echo json_encode(array('status' => 'false', 'msg' => 'Error updating item'));
                }
            }
            else
            {
                echo json_encode(array('status' => 'false', 'msg' => 'Please fill in all fields'));
            }
        }
    }
}