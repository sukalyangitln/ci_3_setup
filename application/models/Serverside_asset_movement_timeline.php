<?php
class Serverside_asset_movement_timeline extends CI_Model
{
	function __construct()
	{
	    // Set table name
	    $this->table = 'asset_movement_timeline';
	    // Set orderable column fields
	    $this->column_order = array(null, 'amt_id','amt_type', 'amt_log_paragraph', 'amt_table_name', 'amt_FK_table_id', 'amt_FK_main_category_id', 'amt_FK_sub_category_id', 'amt_dateTime');
	    // Set searchable column fields
	    $this->column_search = array('amt_id','amt_type','amt_log_paragraph','amt_table_name', 'amt_FK_table_id', 'amt_FK_main_category_id','amt_FK_sub_category_id','amt_dateTime');
	    // Set default order
	    $this->order = array('amt_id' => 'DESC');
	}

	/*
	 * Fetch members data from the database
	 * @param $_POST filter data based on the posted parameters
	 */
	public function getRows($postData)
	{
	    $this->_get_datatables_query($postData);
	    if ($postData['length'] != -1) {
	        $this->db->limit($postData['length'], $postData['start']);
	    }
	    $query = $this->db->get();
	    return $query->result();
	}

	/*
	 * Count all records
	 */
	public function countAll()
	{
	    $this->db->from($this->table);
	    return $this->db->count_all_results();
	}

	/*
	 * Count records based on the filter params
	 * @param $_POST filter data based on the posted parameters
	 */
	public function countFiltered($postData)
	{
	    $this->_get_datatables_query($postData);
	    $query = $this->db->get();
	    return $query->num_rows();
	}

	/*
	 * Perform the SQL queries needed for server-side processing requested
	 * @param $_POST filter data based on the posted parameters
	 */
	private function _get_datatables_query($postData)
	{
	    $this->db->from($this->table);

	    $i = 0;
	    // loop searchable columns
	    foreach ($this->column_search as $item) :
	        // if datatable sends POST for search
	        if ($postData['search']['value']) :
	            // first loop
	            if ($i === 0) :
	                // open bracket
	                $this->db->group_start();
	                $this->db->like($item, $postData['search']['value']);
	            else :
	                $this->db->or_like($item, $postData['search']['value']);
	            endif;

	            // last loop
	            if (count($this->column_search) - 1 == $i) :
	                // close bracket
	                $this->db->group_end();
	            endif;
	        endif;
	        $i++;
	    endforeach;

	    if (isset($postData['order'])) :
	        $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
	    elseif (isset($this->order)) :
	        $order = $this->order;
	        $this->db->order_by(key($order), $order[key($order)]);
	    endif;
	}

}