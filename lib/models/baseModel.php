<?php
/**
 * @author Sean McGary <sean@seanmcgary.com>
 */
class lib_models_baseModel extends core_model
{
    public $db;
    protected $results;
    public $insert_id;
    private $load;
    
    public function __construct()
    {
        parent::__construct();

        $this->load = core_loadFactory::get_inst('core_load', 'load');

        $config = $this->load->load_json_config('db_config.json');

        $this->db = new mysqli($config['hostname'], $config['username'], $config['password'], $config['db']);
    }

    public function query($sql)
    {
        $this->results = $this->db->query($sql);

        if(!$this->results)
        {
            echo $this->db->error."\n";
            echo $sql;
            return false;
        }
        else
        {
            $this->insert_id = $this->db->insert_id;
            
            return $this;
        }

    }

    public function result_array()
    {
        $results = array();

        while($row = $this->results->fetch_assoc())
        {
            $results[] = $row;
        }
        
        return $results;
    }

    public function num_rows()
    {
        return @$this->results->num_rows;
    }

    public function get_one()
    {
        $results = null;

        if($this->results->num_rows > 0)
        {
            $results = $this->results->fetch_assoc();
        }

        return $results;

    }

    public function sanitize($string)
    {
        return $this->db->real_escape_string($string);
    }


}
