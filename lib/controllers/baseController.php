<?php
/**
 * @author Sean McGary <sean@seanmcgary.com>
 */
 
class lib_controllers_baseController extends core_controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load_model('lib_models_machineModel', 'machine_model');
        $this->load_model('lib_models_adminModel', 'admin_model');
        $this->load_model('lib_models_itemModel', 'item_model');
        $this->load_model('lib_models_userModel', 'user_model');

        $this->page = core_loadFactory::get_inst('lib_libraries_pageFramework', 'page');

        $this->drink = core_loadFactory::get_inst('lib_libraries_drink', 'drink');


        if(!isset($_SESSION['loggedIn']))
        {
            $user_data = array();
            $user_data['cn'] = $_SERVER['WEBAUTH_LDAP_CN'];
            $user_data['uid'] = $_SERVER['WEBAUTH_USER'];

            $user_data['drink_admin'] = $this->drink->is_user_drink_admin($user_data['uid']);


            $_SESSION['loggedIn'] = $user_data;
            
        }

        $_SESSION['loggedIn']['drink_credits'] = $this->drink->get_user_credits($_SESSION['loggedIn']['uid']);
    }
}