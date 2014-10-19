<?php

class CH_Grid_generator {

    protected $CI;
    protected $key = 'id';
    protected $select = array();
    protected $where = array();
    protected $sort = array();
    protected $order = array();
    protected $search = array();
    protected $between = array();
    protected $join = array();
    protected $group_by = array();
    protected $table = "";
    protected $status_field = "status";
    protected $created_on_field = "created_on";
    protected $position_field = "position";
    protected $message = "";
    protected $count = 0;
    protected $action = array(
        "toggleStatus" => "_toggle_status",
        "delete" => "_delete",
        "deleteSelected" => "_delete_selected",
        "changePosition" => "_change_position"
    );
    //pagination fields
    protected $per_page = 10;
    protected $page = 1;
    protected $total_pages = 0;
    protected $offset = 0;
    protected $next = 0;
    protected $previous = 0;
    protected $record_from = 0;
    protected $record_to = 0;
    protected $pagination_options = array('5', '10', '25', '50', '100');
    public $req_data = array();

    public function __construct(array $config) {
        $this->CI = & get_instance();
        $this->initialize($config);
    }

    //public functions
    public function initialize($config) {
        if ($this->_validate($config)) {
            foreach ($config as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function get_result() {
        $this->_fire_action();
        $this->_prep_query();

        $this->count = $this->CI->db->get()->num_rows();

        $this->_paginate();

        $this->CI->db->limit($this->per_page);
        $this->CI->db->offset($this->offset);

        $q = $this->CI->db->get();

        //echo 'query :::: <br/>'.$this->CI->db->last_query();

        $this->CI->db->flush_cache();


        if ($q->num_rows() != 0) {
            $data = array();
            if ($this->message != NULL) {
                $data['message'] = $this->message;
            }
            $data['result'] = $q->result();
            $data['data'] = $this->req_data;
            /* $data['pagination'] = array(
              "total_count" => $this->count,
              "total_pages" => $this->total_pages,
              "record_from" => $this->record_from,
              "record_to" => $this->record_to,
              "page" => $this->page,
              "next" => $this->next,
              "previous" => $this->previous
              );
              $data['query'] = $this->CI->db->last_query(); */
            $data['pagination'] = $this->print_pagination();
            return $data;
        } else {
            return FALSE;
        }
    }

    //private functions
    private function _fire_action() {
        if ($this->_validate($this->action)) {
            if (isset($this->req_data['action']) && $this->_validate($this->req_data['action'])) {
                foreach ($this->action as $action => $method) {
                    if ($this->req_data['action'] == $action) {
                        $this->message = $this->$method();
                    }
                }
            }
        }
    }

    private function _prep_query() {
        $this->CI->db->start_cache();

        if (isset($this->req_data['category'])) {
            switch ($this->req_data['category']) {
                case 'active':
                    //$this->where = array($this->status_field => 1);
                    $this->CI->db->where($this->status_field, 1);
                    break;

                case 'inactive':
                    //$this->where = array($this->status_field => 0);                    
                    $this->CI->db->where($this->status_field, 0);
                    break;

                case 'newest':
                    $this->CI->db->order_by($this->created_on_field, "DESC");
                    //$this->sort = array("sortby" => $this->created_on_field, "order" => "DESC");
                    break;

                case 'oldest':
                    $this->CI->db->order_by($this->created_on_field, "ASC");
                    //$this->sort = array("sortby" => $this->created_on_field, "order" => "ASC");
                    break;

                default:
                    break;
            }
        }

        //select
        if ($this->_validate($this->select)) {
            $this->CI->db->select($this->select);
        }

        //from
        $this->CI->db->from($this->table);

        //join
        if ($this->_validate($this->join)) {
            foreach ($this->join as $table => $cond_type) {
                if (is_array($cond_type) && $this->_validate($cond_type)) {
                    $this->CI->db->join($table, $cond_type['condition'], isset($cond_type['type']) ? $cond_type['type'] : "inner" );
                }
            }
        }

        //where
        if ($this->_validate($this->where)) {
            foreach ($this->where as $column => $value) {
                $this->CI->db->where($column, $value);
            }
        }

        //between
        if (isset($this->req_data['between']) && $this->_validate($this->req_data['between'])) {
            //$this->_data['between'] = $this->req_data['between'];    	
            foreach ($this->req_data['between'] as $field => $from_to) {
                if (is_array($from_to) && $this->_validate($from_to) && !empty($from_to['from']) && !empty($from_to['to'])) {
                    $this->CI->db->where("{$field} BETWEEN '{$from_to['from']}' AND '{$from_to['to']}'");
                }
            }
        }

        //search
        if (isset($this->req_data['search']) && $this->_validate($this->req_data['search'])) {
            //$this->_data['search'] = $this->req_data['search'];   	
            foreach ($this->req_data['search'] as $field => $value) {
                if ($this->_validate($field) && $this->_validate($value)) {
                    $this->CI->db->like($field, $value, "after");
                }
            }
        }

        //sort
        if (isset($this->req_data['sortby']) && $this->_validate($this->req_data['sortby']) && $this->_validate($this->req_data['order'])) {
            $this->CI->db->order_by($this->req_data['sortby'], $this->req_data['order']);
        }
        if ($this->_validate($this->sort)) {
            $this->CI->db->order_by($this->sort['sortby'], $this->sort['order']);
        }
        if ($this->_validate($this->order)) {
            $this->CI->db->order_by($this->order['sortby'], $this->order['order']);
        }

        //group by
        if (is_array($this->group_by) && $this->_validate($this->group_by)) {
            $this->CI->db->group_by($this->group_by);
        }


        $this->CI->db->stop_cache();
    }

    protected function _validate($var) {
        if (isset($var) && !empty($var) && $var != NULL) {
            return TRUE;
        }
        return FALSE;
    }

    private function _paginate() {
        $this->page = ( isset($this->req_data['page']) && $this->_validate($this->req_data['page']) ) ? (int) $this->req_data['page'] : 1;
        if (isset($this->req_data['per_page']) && !empty($this->req_data['per_page']) && is_numeric($this->req_data['per_page'])) {
            $this->per_page = $this->req_data['per_page'];
        }

        if (!is_int($this->page)) {
            $this->page = 1;
        }

        $this->total_pages = ceil($this->count / $this->per_page);

        if ($this->total_pages > 0) {
            if ($this->page > 0 && $this->page > $this->total_pages) {
                $this->page = $this->total_pages;
            } else if ($this->page <= 0) {
                $this->page = 1;
            }
        } else {
            $this->page = 1;
        }

        if (($this->page + 1) <= $this->total_pages) {
            $this->next = $this->page + 1;
        }

        if (($this->page - 1) > 0) {
            $this->previous = $this->page - 1;
        }

        $this->offset = ($this->page - 1) * $this->per_page;
        $this->record_from = $this->offset + 1;
        $this->record_to = ($this->offset + $this->per_page > $this->count) ? $this->count : $this->offset + $this->per_page;
    }

    private function _delete_selected() {
        if (isset($this->req_data) && $this->_validate($this->req_data)) {
            if (isset($this->req_data['checked']) && !empty($this->req_data['checked'])) {
                $i = 0;
                foreach ($this->req_data['checked'] as $value) {
                    $this->CI->db->where($this->key, $value);
                    if ($this->CI->db->delete($this->table)) {
                        $i++;
                    }
                }
                if ($i === count($this->req_data['checked'])) {
                    return "{$i} rows successfully deleted";
                } else {
                    return "Deletion failed";
                }
            } else {
                return "No checkboxes selected";
            }
        }
    }

    private function _delete() {
        if (isset($this->req_data) && $this->_validate($this->req_data)) {
            if (isset($this->req_data['delete_id']) && !empty($this->req_data['delete_id'])) {
                $this->CI->db->where($this->key, $this->req_data['delete_id']);
                if ($this->CI->db->delete($this->table)) {
                    return "Row successfully deleted";
                } else {
                    return "Deletion failed";
                }
            }
        }
    }

    private function _toggle_status() {
        if (isset($this->req_data) && $this->_validate($this->req_data)) {
            if (isset($this->req_data['id']) && !empty($this->req_data['id'])) {
                $id = $this->req_data['id'];
                $table = $this->CI->db->dbprefix($this->table);
                $q = "UPDATE {$table} SET {$this->status_field} = IF({$table}.{$this->status_field} = 1 , 0, 1) WHERE {$table}.id = {$id}";
                $this->CI->db->query($q);
            }
        }
    }

    private function _change_position() {
        if ($this->req_data != NULL) {
            $state = $this->req_data['state'];
            $currentPosition = $this->req_data['position'];
            $id = $this->req_data['id'];
            $table = $this->CI->db->dbprefix($this->table);
            $status_cond = "";

            if (isset($this->req_data['category']) && $this->req_data['category'] == 'active') {
                $status_cond = " AND {$this->status_field} = 1";
            } else if (isset($this->req_data['category']) && $this->req_data['category'] == 'inactive') {
                $status_cond = " AND {$this->status_field} = 0";
            }

            if ($state == "up") {
                $query = "SELECT id , {$this->position_field} FROM {$table} ";
                $query .= "WHERE {$this->position_field} = ";
                $query .= "( SELECT min( {$this->position_field} ) FROM {$table} WHERE {$this->position_field} > {$currentPosition} {$status_cond} )";
                $resultSet = $this->CI->db->query($query);
                $result = array_shift($resultSet->result_array());
            } else {
                $query = "SELECT id , {$this->position_field} FROM {$table} ";
                $query .= "WHERE {$this->position_field} = ";
                $query .= "( SELECT max( {$this->position_field} ) FROM {$table} WHERE {$this->position_field} < {$currentPosition} {$status_cond} )";
                $resultSet = $this->CI->db->query($query);
                $result = array_shift($resultSet->result_array());
            }

            $id2 = $result['id'];
            $position2 = $result[$this->position_field];

            $query = "";
            $query = "UPDATE {$table} SET {$this->position_field} = {$currentPosition} WHERE id = {$id2}";
            $this->CI->db->query($query);

            $query = "";
            $query = "UPDATE {$table} SET {$this->position_field} = {$position2} WHERE id = {$id}";
            $this->CI->db->query($query);
        }
    }

    //Grid builder functions

    public function print_grid_filters($config) {
        $output = "";
        if (!empty($config) && is_array($config)) {
            $output .= $this->print_hidden_fields();
            foreach ($config as $key => $value) {
                switch ($key) {
                    case 'category':
                        $output .= $this->print_category($value);
                        break;
                    case 'search_field':
                        $output .= $this->print_serach_field($value);
                        break;
                    case 'search_field_with_filter':
                        $output .= $this->print_search_field_with_filter($value);
                        break;
                    case 'search_dropdown':
                        $output .= $this->print_search_dropdown($value);
                        break;
                    case 'between':
                        $output .= $this->print_between($value);
                        break;
                    default:
                        break;
                }
            }
            $output .= $this->print_submit_button();
            $output .= $this->print_reset_button();
            $output .= $this->print_delete_button();
        }
        return $output;
    }

    public function print_hidden_fields() {
        $output = <<<EOT
                <input type="hidden" value="" name="sortby" id="sortby" class="reset-input">
                <input type="hidden" value="" name="order" id="order" class="reset-input">
                <input type="hidden" value="" name="action" id="action" class="reset-input">
EOT;
        return $output;
    }

    public function print_category($config) {
        $output = "";
        if (!empty($config) && is_array($config)) {
            $output .= "<select name='category' class='category-dropdown reset-dropdown' >";
            $output .= "<option value='all'>All</option>";
            foreach ($config as $key => $value) {
                $output .= "<option value='{$key}'>{$value}</option>";
            }
            $output .= "</select>";
        }
        return $output;
    }

    public function print_serach_field($param, $wrap_start_tag = "", $wrap_end_tag = "") {
        $output = "";
        if (!empty($param)) {
            $output .= $wrap_start_tag;
            foreach ($param as $key => $value) {
                $output .= "<input type='text' class='search-field reset-input' name='search[{$key}]' placeholder='{$value}' />&nbsp;&nbsp;";
            }
            $output .= $wrap_end_tag;
        }
        return $output;
    }

    public function print_search_field_with_filter($param, $wrap_start_tag = "", $wrap_end_tag = "") {
        $output = "";
        if (!empty($param) && is_array($param)) {
            $output .= $wrap_start_tag;
            foreach ($param as $k => $v) {
                if (!empty($v) && is_array($v)) {
                    $i = 0;
                    $j = 1;
                    foreach ($v as $key => $value) {
                        //echo ' :in in: ';
                        if ($i == 0) {
                            $output .= "<input type='text' class='search-field reset-input' rel_id='serach_filed{$j}' name='search[{$key}]' />&nbsp;&nbsp;";
                            $output .= "<select class='search-field-dropdown reset-dropdown' rel='serach_filed{$j}' >";
                        }
                        $output .= "<option value='{$key}'>{$value}</option>";
                        $i++;
                    }
                    $output .= "</select>&nbsp;&nbsp;";
                    $j++;
                }
            }
            $output .= $wrap_start_tag;
        }
        return $output;
    }

    public function print_search_dropdown($config, $wrap_start_tag = "", $wrap_end_tag = "") {
        $output = "";
        if (!empty($config) && is_array($config)) {
            foreach ($config as $column => $ar) {
                if (!empty($ar) && is_array($ar)) {
                    if (!empty($wrap_start_tag)) {
                        $output .= $wrap_start_tag;
                    }
                    $output .= "<select name='search[{$column}]' class='search-dropdown reset-dropdown' >";
                    foreach ($ar as $value => $label) {
                        $output .= "<option value='{$value}'>{$label}</option>";
                    }
                    $output .= "</select>";
                    if (!empty($wrap_end_tag)) {
                        $output .= $wrap_end_tag;
                    }
                }
            }
        }
        return $output;
    }

    public function print_between($config, $wrap_start_tag = "", $wrap_end_tag = "") {
        $output = "";
        if (!empty($config) && is_array($config)) {
            foreach ($config as $value => $label) {
                if (!empty($wrap_start_tag)) {
                    $output .= $wrap_start_tag;
                }
                $output .= <<<EOT
                        <input name="between[{$value}][from]" value="" placeholder="{$label} From" class="reset-input"/>
                        <input name="between[{$value}][to]" value="" placeholder="{$label} To" class="reset-input" />
                        {$wrap_end_tag}
EOT;
                if (!empty($wrap_end_tag)) {
                    $output .= $wrap_end_tag;
                }
            }
        }
        return $output;
    }

    public function print_delete_button($text = "Delete Selected", $class = "delete-selected btn-danger") {
        return $this->_button($text, $class);
    }

    public function print_submit_button($text = "Find", $class = "submit-filters") {
        return $this->_button($text, $class);
    }

    public function print_reset_button($text = "Reset", $class = "reset-filters") {
        return $this->_button($text, $class);
    }

    public function print_pagination() {
        $options = "";
        if (!empty($this->pagination_options)) {
            foreach ($this->pagination_options as $value) {
                if ($value == $this->per_page) {
                    $options .= '<option value="' . $value . '" selected="selected">' . $value . '</option>';
                } else {
                    $options .= '<option value="' . $value . '">' . $value . '</option>';
                }
            }
        }

        $output = <<<PAGE
        <table class="inner_pagination" style="width:100%">
                <tr>
                    <td align="left">
                        <div>Per Page :                             
                        <select class="per_page span2 reset-dropdown" name="per_page" id="per_page">
                            {$options}
                        </select>
                        </div>
                    </td>
                    <td colspan="5" align="center">
                        <span><a class="first_page pagination_link" href="javascript:void(0);" value="1" title="First Page">&nbsp</a></span>
                        <span><a class="prev_page pagination_link" href="javascript:void(0);" value="{$this->previous}" title="Previous Page">&nbsp</a></span>
                        <span>Page</span>
                        <input type="text" class="page span1 reset-input" id="page" size="2" value="{$this->page}" name="page" style="text-align: center;width:25px;">
                        <span>Of</span>
                        <span class="last-page-number">{$this->total_pages}</span>
                        <span><a class="next_page pagination_link" href="javascript:void(0);" value="{$this->next}" title="Next Page">&nbsp</a></span>
                        <span><a class="last_page pagination_link" href="javascript:void(0);" value="{$this->total_pages}" title="Last Page">&nbsp</a></span>
                    </td>
                    <td>
                        <div class="ajax_refresh_and_loading">
                        </div>
                    </td>
                    <td align="right">
                        <span>Displaying</span>
                        <span class="page-starts-from">{$this->record_from}</span>
                        <span>-</span>
                        <span class="page-ends-to">{$this->record_to}</span> Of <span class="total_items" id="total_items">{$this->count}</span> Records</span>
                    </td>

                </tr>
            </table>
PAGE;
        return $output;
    }

    private function _button($text = "Button", $class = "button") {
        $output = "";
        $output .= "<button type='button' class='btn {$class}' title='{$text}' data-original-title=''>{$text}</button>";
        return $output;
    }

}