<?php
class DB_Model extends CI_Model{
	
	protected $db_table;
	
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
		
		if((property_exists(get_class($this),'table'))){
			
			$this->db_table = $this->db->dbprefix.$this->table;
			
		}else{
			
			$dbclass = strtolower(get_class($this));
			$this->db_table = $this->db->dbprefix.$dbclass;
		
		}
		
	}

/*
| -------------------------------------------------
|  Use Custom Query
| -------------------------------------------------
| 	
*/
	public function query($query){
		$response = $this->db->query($query);
		if($response){
			return true;
		}else{
			return false;
		}
	}
/*
| -------------------------------------------------
|  Search String by where Condition 
| -------------------------------------------------
| 	
*/
	public function search($like,$cond=null){
		$this->db->select('*');
		$this->db->from($this->db_table);
		foreach($like as $key => $val){
			$this->db->like($key, $val);
		}
		if($cond != null){
			foreach($cond as $key => $val){
				$this->db->where($key, $val);
			}
		}
		$response = $this->db->get();
		return $response->result();
		
	}

/*
| -------------------------------------------------
|  Auth Check
| -------------------------------------------------
| 	
*/
	public function auth($array){
		$data = $this->db->get_where($this->db_table,$array,1);
		if($data->num_rows()){
			return $data->row();
		}else{
			return false;
		}
	}
	
/*
| -------------------------------------------------
|  Check Row Existenace
| -------------------------------------------------
| 	
*/


	public function check($array){
		$response = $this->db->get_where($this->db_table,$array);
		
		if($response->num_rows()){
			return $response->row();
		}else{
			return false;
		}
	}

/*
| ----------------------------------------------
|  Fetch all Data DB Table
| ----------------------------------------------
| 	
*/

	public function max($column){
		
		$this->db->select_max($column);
		$response = $this->db->get($this->db_table);
		return $response->row()->{$column};
		
	}
/*
| ----------------------------------------------
|  Fetch all Data DB Table
| ----------------------------------------------
| 	
*/

	public function min($column){
		
		$this->db->select_min($column);
		$response = $this->db->get($this->db_table);
		return $response->row()->{$column};
		
	}
	
/*
| ----------------------------------------------
|  Fetch all Data DB Table
| ----------------------------------------------
| 	
*/

	public function all($column = null,$order = null){
		$response = $this->db->order_by($column,$order)->get($this->db_table);
		return $response->result();
	}
	
/*
| -------------------------------------------------
|  Fetch SELRCTRD Data From DB Table By Column Name
| -------------------------------------------------
| 	
*/

	public function allfield($field ='*'){
		$this->db->select($field);
		$response = $this->db->get($this->db_table);
		return $response->result();
	}

	
	
/*
| ----------------------------------------------
|  Fetch all Data DB Table in Array
| ----------------------------------------------
| 	
*/

	public function allarray($column = null,$order = null){
		$response = $this->db->order_by($column,$order)->get($this->db_table);
		return $response->result_array();
	}
/*
| ----------------------------------------------
|  Fetch Selected column Data form DB Table
| ----------------------------------------------
| 	
*/

	public function allfrom($columns){
		
		$this->db->select($columns);
		$this->db->from($this->db_table);
		$response = $this->db->get();
		return $response->result();
	}
	
	
/*
| ----------------------------------------------
|  Fetch all Data by list of column data form DB Table
| ----------------------------------------------
| 	
*/

	public function allin($column,$array,$select = '*'){
		
		$this->db->select($select);
		$this->db->from($this->db_table);
		$this->db->where_in($column,$array);
		$response = $this->db->get();
		return $response->result();
	}
	
	
	
/*
| ----------------------------------------------
|  Fetch all Data by list of column data form DB Table with limit
| ----------------------------------------------
| 	
*/

	public function allinlimit($column,$array,$limit=null,$select = '*'){
		
		$this->db->select($select);
		$this->db->from($this->db_table);
		$this->db->where_in($column,$array);
		$this->db->limit($limit);
		$response = $this->db->get();
		return $response->result();
	}
	
/*
| ----------------------------------------------
|  Insert Data into DB Table
| ----------------------------------------------
| 	
*/

	public function insert($data){
		$this->db->insert($this->db_table,$data);
		return $this->db->insert_id();
	}



/*
| ----------------------------------------------
|  Update Data in DB Table By Column
| ----------------------------------------------
| 	
*/

	public function updateWhere($data,$array){
		$this->db->update($this->db_table, $data, $array);
	}
	
/*
| ----------------------------------------------
|  Update Data in DB Table 
| ----------------------------------------------
| 	
*/

	public function update($data,$id){
		$this->db->update($this->db_table, $data, ['id'=>$id]);
	}

/*
| -----------------------------------------------
|  Fetch single Data From DB Table By id
| -----------------------------------------------
| 	
*/

	public function find($id){
		$response = $this->db->get_where($this->db_table, array('id' => $id));
		return $response->row();
	}

/*
| -------------------------------------------------
|  Fetch single Data From DB Table By Column Name
| -------------------------------------------------
| 	
*/

	public function first($array){
		$response = $this->db->get_where($this->db_table, $array,1);
		return $response->row();
	}
	
/*
| -------------------------------------------------
|  Fetch Limited Data From DB Table By Column Name
| -------------------------------------------------
| 	
*/

	public function getLimit($limit){
		$response = $this->db->get($this->db_table,$limit);
		return $response->result();
	}
	
/*
| -------------------------------------------------
|  Fetch Limited Data From DB Table By Column Name
| -------------------------------------------------
| 	
*/

	public function getbetween($column,$min,$max,$field='*'){
		$this->db->select($field);
		$this->db->from($this->db_table);
		$this->db->where("$column BETWEEN $min AND $max");
		$response = $this->db->get();
		return $response->result();
	}
/*
| -------------------------------------------------
|  Fetch Multiple Data From DB Table By Column Name
| -------------------------------------------------
| 	
*/

	public function get($array,$column = NULL,$order='ASC'){
		$response = $this->db->order_by($column,$order)->get_where($this->db_table, $array);
		return $response->result();
	}
	public function getAll_DESC($column = NULL,$order='DESC'){
		$response = $this->db->order_by($column,$order)->get($this->db_table);
		return $response->result();
	}
/*
| -------------------------------------------------
|  Fetch SELRCTRD Data From DB Table By Column Name
| -------------------------------------------------
| 	
*/

	public function getfield($array,$select = '*'){
		$this->db->select($select);
		$response = $this->db->get_where($this->db_table, $array);
		return $response->result();
	}
/*
| -------------------------------------------------
|  Fetch SELRCTRD ROW From DB Table By Column Name
| -------------------------------------------------
| 	
*/

	public function firstfield($array,$select = '*'){
		$this->db->select($select);
		$response = $this->db->get_where($this->db_table, $array,1);
		return $response->row();
	}

/*
| -------------------------------------------------
|  Fetch Multiple Data From DB Table By Column Name in Array
| -------------------------------------------------
| 	
*/

	public function getarray($array,$column = NULL,$order='ASC'){
		$response = $this->db->order_by($column,$order)->get_where($this->db_table, $array);
		return $response->result_array();
	}
/*
| -------------------------------------------------
|  Remove Data From DB Table By id
| -------------------------------------------------
| 	
*/
	public function delete($id){
		$this->db->delete($this->db_table, ['id'=>$id]);
	}
	
/*
| -------------------------------------------------
|  Remove Data From DB Table By Column Name
| -------------------------------------------------
| 	
*/
	public function deleteWhere($array){
		$this->db->delete($this->db_table, $array);
	}
	
/*
| -------------------------------------------------
|  Row Count From A table
| -------------------------------------------------
| 	
*/
	
	public function rowCount(){
		return $this->db->count_all_results($this->db_table);
	}

	public function rowFieldCountWhere($array){
		$response = $this->db->get_where($this->db_table,$array);
		return $response->num_rows();
		
	}
/*
| -------------------------------------------------
| LAST ROW From A table
| -------------------------------------------------
| 	
*/
	public function lastRow($id){
		$response = $this->db->limit(1)->order_by($id,'DESC')->get_where($this->db_table);
		return $response->row();
	}

}









