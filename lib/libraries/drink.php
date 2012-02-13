<?php
/**
 * Created by JetBrains PhpStorm.
 * User: seanmcgary
 * Date: 9/18/11
 * Time: 9:12 PM
 * To change this template use File | Settings | File Templates.
 */
 
class lib_libraries_drink
{
    private $drink_ldap_user;
    private $drink_ldap_pass;
    private $ldap_server;
    private $user_dn;

    private $ldap_conn;


    public function __construct()
    {
        $drink_conf = json_decode(file_get_contents(LIBPATH.'config/drink_conf.json'), true);

        $this->drink_ldap_user = $drink_conf['drink_username'];
        $this->drink_ldap_pass = $drink_conf['drink_password'];
        $this->ldap_server = $drink_conf['ldap_server'];

        $this->user_dn = 'ou=Users,dc=csh,dc=rit,dc=edu';

        $this->ldap_conn = ldap_connect($this->ldap_server);

        $ldap_bind = ldap_bind($this->ldap_conn, $this->drink_ldap_user, $this->drink_ldap_pass);

        if(!$ldap_bind)
        {
            echo 'Ldap bind error...';
        }
    }

    public function is_user_drink_admin($uid)
    {
        $filter = "(uid=".$uid.")";
        $fields = array('drinkAdmin');

        $res = ldap_search($this->ldap_conn, $this->user_dn, $filter, $fields);

        $results = ldap_get_entries($this->ldap_conn, $res);

        $results = (bool)$results[0]['drinkadmin'][0];

        return $results;
    }

    public function get_user_ibutton($uid)
    {
        $filter = "(uid=".$uid.")";
        $fields = array('ibutton');

        $res = ldap_search($this->ldap_conn, $this->user_dn, $filter, $fields);

        $results = ldap_get_entries($this->ldap_conn, $res);

        $results = $results[0]['ibutton'][0];

        return $results;
    }

    public function get_user_credits($uid)
    {
        $filter = "(uid=".$uid.")";
        $fields = array('drinkBalance');

        $res = ldap_search($this->ldap_conn, $this->user_dn, $filter, $fields);

        $results = ldap_get_entries($this->ldap_conn, $res);

        $results = $results[0]['drinkbalance'][0];

        return $results;
    }

    public function search_user_by_uid($uid)
    {

        $filter = "(uid=".$uid.")";

        $res = ldap_search($this->ldap_conn, $this->user_dn, $filter);

        $results = ldap_get_entries($this->ldap_conn, $res);

        if($results['count'] > 0)
        {
            return $results[0];
        }
        else
        {
            return null;
        }
    }

    public function update_user_credits($uid, $credits)
    {
        $replace_val = array('drinkBalance' => $credits);

        $dn = 'uid='.$uid.','.$this->user_dn;

        $result = ldap_mod_replace($this->ldap_conn, $dn, $replace_val);

        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }

    }
}