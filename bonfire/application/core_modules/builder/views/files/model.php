<?php

$model = '<?php if (!defined(\'BASEPATH\')) exit(\'No direct script access allowed\');

class ' . ucfirst($controller_name) . '_model extends BF_Model {

	protected $table		= "' . $table_name . '";
	protected $key			= "' . $primary_key_field . '";
	protected $soft_deletes	= ' . $this->input->post('use_soft_deletes') . ';
	protected $date_format	= "datetime";
	protected $set_created	= ' . $this->input->post('use_created') . ';
	protected $set_modified = ' . $this->input->post('use_modified') . ';';

// use the created field? Add field and custom name if chosen.
if ($this->input->post('use_created') == 'true') {
    $model .= '
	protected $created_field = "' . $this->input->post('created_field') . '";';
}

// use the created field? Add field and custom name if chosen.
if ($this->input->post('use_modified') == 'true') {
    $model .= '
	protected $modified_field = "' . $this->input->post('modified_field') . '";';
}

// use the status field? Add field and custom name if chosen.
if ($this->input->post('use_status') == 'true') {
    $model .= '
	protected $status_field = "' . $this->input->post('status_field') . '";';
}

// use the position field? Add field and custom name if chosen.
if ($this->input->post('use_position') == 'true') {
    $model .= '
	protected $position_field = "' . $this->input->post('position_field') . '";';
}

/* Grid Area */

$model .= '
            public function __construct(){
                parent::__construct();
                $config = array(
                "table" => $this->table,                
                ';
if ($this->input->post('use_status') == 'true') {
    $model .= '"status_field" => $this->status_field,';
}
if ($this->input->post('use_position') == 'true') {    
    $model .= <<<EOT
        "position_field" => \$this->position_field,
        "order"=>array(
            "sortby" => \$this->position_field,
            "order"  => "ASC",
        )
EOT;
}

$model .= '
            );
            $this->load->library("CH_Grid_generator", $config, "grid");
            }';

$model .= '
            public function read($req_data) {
                $this->grid->initialize(array(
                    "req_data" => $req_data
                ));
                return $this->grid->get_result();
            }';


if($this->input->post('use_position') == 'true'){
    $model .= <<<EOT

    public function get_max_position(\$status = "") {
        \$this->db->select(array("MAX(" . \$this->position_field . ") AS max_position"));
        if (\$status == 'active') {
            \$this->db->where(\$this->status_field, 1);
        } else if (\$status == 'inactive') {
            \$this->db->where(\$this->status_field, 0);
        }
        \$query = \$this->db->get(\$this->table);

        \$arrayOfMaxPosition = array_shift(\$query->result_array());
        if (!empty(\$arrayOfMaxPosition['max_position'])) {
            return \$arrayOfMaxPosition['max_position'];
        } else {
            return FALSE;
        }
    }

    public function get_min_position(\$status = "") {
        \$this->db->select(array("MIN(" . \$this->position_field . ") AS min_position"));
        if (\$status == 'active') {
            \$this->db->where(\$this->status_field, 1);
        } else if (\$status == 'inactive') {
            \$this->db->where(\$this->status_field, 0);
        }
        \$query = \$this->db->get(\$this->table);

        \$arrayOfMinPosition = array_shift(\$query->result_array());
        if (!empty(\$arrayOfMinPosition['min_position'])) {
            return \$arrayOfMinPosition['min_position'];
        } else {
            return FALSE;
        }
    }

EOT;

}

/* End Of Grid Area */


$model .=
        '
}
';

echo $model;
?>
