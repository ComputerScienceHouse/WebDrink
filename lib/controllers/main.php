<?php
/**
 * @author Sean McGary <sean@seanmcgary.com>
 */
 
class lib_controllers_main extends lib_controllers_baseController
{
    public function __construct()
    {
        parent::__construct();
        
    }

    public function index()
    {
        $data['machines'] = $this->machine_model->get_machines_with_slots();

        $data['items'] = $this->item_model->get_all_items();

        $data['user_drops'] = $this->user_model->get_user_drops($_SESSION['drink_loggedIn']['uid']);

        $all_drops = $this->admin_model->get_drop_log();
        $data['drop_log'] = $this->load->view('presenters/drop_log', array('drops' => $all_drops), true);

        $money_log = $this->admin_model->get_money_log();
        $data['money_log'] = $this->load->view('presenters/money_log', array('money' => $money_log), true);

        $rendered_data = array();

        $rendered_data['machines'] = $this->load->view('presenters/machines', $data, true);
        $rendered_data['admin'] = $this->load->view('presenters/admin', array(), true);
        $rendered_data['manage_items'] = $this->load->view('presenters/manage_items', $data, true);
        $rendered_data['temps'] = $this->load->view('presenters/temps', array(), true);
        $rendered_data['logs'] = $this->load->view('presenters/logs', $data, true);

        $rendered_data['user_drops'] = $this->load->view('presenters/user_drops', $data, true);

        $rendered_data['ibutton'] = $this->drink->get_user_ibutton($_SERVER['WEBAUTH_USER']);

        
        $this->page->render('mainIndex_view', $rendered_data);
    }

    public function index2()
    {
        $rendered_data['machines'] = $this->machine_model->get_machines_with_slots();
        $rendered_data['machine_template'] = $this->load->view('mustache_templates/machines', array(), true);
        $rendered_data['ibutton'] = $this->drink->get_user_ibutton($_SERVER['WEBAUTH_USER']);

        $this->load->view('webdrink', array('page_data' => json_encode($rendered_data), 'cn' => $_SERVER['WEBAUTH_LDAP_CN']));
    }

    public function logout()
    {
        unset($_SESSION['drink_loggedIn']);

        session_destroy();

        redirect('https://members.csh.rit.edu');
    }
}