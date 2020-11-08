<?php  
defined('BASEPATH') OR exit('No direct script access allowed');
	
class Common_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	public function Save($data,$table)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	
	public function update($data,$table,$where)
	{
		$this->db->where($where);
		$this->db->update($table, $data);
		return true;
	}
	
	public function common_delete($table,$where)
	{
		$this->db->where($where);
		$this->db->delete($table); 
		return true;
	}
	
	public function getAllParameters($parameter = array())
  	{
		if(!empty($parameter))
		{
			$select 		= (isset($parameter['select']) && !empty($parameter['select'])) ? $parameter['select'] : "*";
			$table 			= (isset($parameter['table']) && !empty($parameter['table'])) ? $parameter['table'] : false;
			$whereArr 		= (isset($parameter['whereArr']) && !empty($parameter['whereArr'])) ? $parameter['whereArr'] : false;
			$order 			= (isset($parameter['order']) && !empty($parameter['order'])) ? $parameter['order'] : false;
			$sort 			= (isset($parameter['sort']) && !empty($parameter['sort'])) ? $parameter['sort'] : false;
			$sLimit 		= (isset($parameter['sLimit']) && !empty($parameter['sLimit'])) ? $parameter['sLimit'] : false;
			$offset 		= (isset($parameter['offset']) && !empty($parameter['offset'])) ? $parameter['offset'] : false;
			$result_array 	= (isset($parameter['result_array']) && !empty($parameter['result_array'])) ? $parameter['result_array'] : false;
			$num_rows 		= (isset($parameter['num_rows']) && !empty($parameter['num_rows'])) ? $parameter['num_rows'] : false;
			$db_group 		= (isset($parameter['db_group']) && !empty($parameter['db_group'])) ? $parameter['db_group'] : "default";
			
			if(!empty($table))
			{
				if($db_group !="default")
					$this->load->database($db_group, TRUE);
			
				$this->db->select($select);
				$this->db->from($table);
				if($whereArr!="")
				$this->db->where($whereArr);
				if($sLimit!='' && $offset!='')
				$this->db->limit($sLimit,$offset);
				elseif($sLimit!='')
				$this->db->limit($sLimit);
				if($order!='' && $sort!='')
				{
					$this->db->order_by($order,$sort);
				}
				$query = $this->db->get();

				if($query->num_rows() == 0)
					return false;				  
				else
				{
					if($num_rows==true)
					return $query->num_rows();
					if($result_array==true)
						$result = $query->result_array();
					else
						$result = $query->result();
					return $result;				  
				}
			}
			
		}
	}

	public function getParameters($parameter = array())
  	{
		if(!empty($parameter))
		{
			$select 		= (isset($parameter['select']) && !empty($parameter['select'])) ? $parameter['select'] : "*";
			$table 			= (isset($parameter['table']) && !empty($parameter['table'])) ? $parameter['table'] : false;
			$whereArr 		= (isset($parameter['whereArr']) && !empty($parameter['whereArr'])) ? $parameter['whereArr'] : false;
			$result_array 	= (isset($parameter['result_array']) && !empty($parameter['result_array'])) ? $parameter['result_array'] : false;
			
			if(!empty($table))
			{
				$this->db->select($select);
				$this->db->from($table);
				if($whereArr!='')
				$this->db->where($whereArr);
				$query = $this->db->get();
				//echo $this->db->last_query();
				if($query->num_rows() == 0)
					return false;				  
				else
				{
					if($result_array==true)
						$result = $query->result_array();
					else
						$result = $query->result();
					return $result[0];				  
				}
			}
		}
	}

	public function get_num_of_rows($parameter = array())
	{
		if(!empty($parameter))
		{
			$select 		= (isset($parameter['select']) && !empty($parameter['select'])) ? $parameter['select'] : "*";
			$table 			= (isset($parameter['table']) && !empty($parameter['table'])) ? $parameter['table'] : false;
			$whereArr 		= (isset($parameter['whereArr']) && !empty($parameter['whereArr'])) ? $parameter['whereArr'] : false;
			
			if(!empty($table))
			{
				$this->db->select($select);
				$this->db->from($table);
				if($whereArr!="")
				$this->db->where($whereArr);
				$query = $this->db->get();
				return $query->num_rows();
			}
		}
	}
	
	public function IsExistCheck($data)
	{
		if(!empty($parameter))
		{
			$select 		= (isset($parameter['select']) && !empty($parameter['select'])) ? $parameter['select'] : "*";
			$table 			= (isset($parameter['table']) && !empty($parameter['table'])) ? $parameter['table'] : false;
			$whereArr 		= (isset($parameter['whereArr']) && !empty($parameter['whereArr'])) ? $parameter['whereArr'] : false;
			$result_array 	= (isset($parameter['result_array']) && !empty($parameter['result_array'])) ? $parameter['result_array'] : false;
			
			if(!empty($table))
			{
				$this->db->select($select);
				$this->db->from($table);
				if($whereArr!='')
				$this->db->where($whereArr);
				$query = $this->db->get();
				if($query->num_rows() == 0)
					return false;				  
				else
					return true;
			}
		}
	}
	
	public function PageConfigDataFilter($whereArrr,$counter)
	{

		$column_search = array();
		$column_order = array();

		$table = 'page_option';
		if($counter)
			$select = 'COUNT('.$table.'.id) as total_data';
		else
			$select = "*";
		

		$this->db->select($select);
		$this->db->from($table);
		$this->db->where("is_deleted",0);
		
		$i = 0;  
		if(!empty($column_search) && isset($column_search) && isset($_POST['search']['value'])){
			foreach ($column_search as $item) // loop column 
			{			
				if(trim($_POST['search']['value'])) // if datatable send POST for search
				{
					if($i===0) // first loop
					{
						$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
						$this->db->like($item, trim($_POST['search']['value']));
					}
					else
					{
						$this->db->or_like($item, trim($_POST['search']['value']));
					}
	 
					if(count($column_search) - 1 == $i) //last loop
						$this->db->group_end(); //close bracket
				}
				$i++;
			}
		}

		if(!empty($column_order) && isset($_POST['order'])){
			if(isset($_POST['order'])) // here order processing
			{
				$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($this->order))
			{
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}else if(!empty($column_order)){ 
			$this->db->order_by($table.'.id','DESC');
		}
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{ 
			if($counter)
				return $query->result()[0]->total_data;//return $query->num_rows();

			else
				return $query->result();
		}
		return false;
	}
	
	public function UserRequestDataFilter($whereArrr,$counter)
	{

		$column_search = array('u_name','email','phone');
		$column_order = array();

		$table = 'requests';
		if($counter)
			$select = 'COUNT('.$table.'.id) as total_data';
		else
			$select = "*";
		

		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($table.".is_deleted",0);
		
		$i = 0;  
		if(!empty($column_search) && isset($column_search) && isset($_POST['search']['value'])){
			foreach ($column_search as $item) // loop column 
			{			
				if(trim($_POST['search']['value'])) // if datatable send POST for search
				{
					if($i===0) // first loop
					{
						$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
						$this->db->like($item, trim($_POST['search']['value']));
					}
					else
					{
						$this->db->or_like($item, trim($_POST['search']['value']));
					}
	 
					if(count($column_search) - 1 == $i) //last loop
						$this->db->group_end(); //close bracket
				}
				$i++;
			}
		}

		if(!empty($column_order) && isset($_POST['order'])){
			if(isset($_POST['order'])) // here order processing
			{
				$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($this->order))
			{
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}else if(!empty($column_order)){ 
			$this->db->order_by($table.'.id','DESC');
		}
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{ 
			if($counter)
				return $query->result()[0]->total_data;//return $query->num_rows();

			else
				return $query->result();
		}
		return false;
	}

	public function CountryDataFilter($whereArrr,$counter)
	{

		$column_search = array('nicename');
		$column_order = array();

		$table = 'countries';
		if($counter)
			$select = 'COUNT('.$table.'.id) as total_data';
		else
			$select = "*";
		

		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($table.".is_deleted",0);
		
		$i = 0;  
		if(!empty($column_search) && isset($column_search) && isset($_POST['search']['value'])){
			foreach ($column_search as $item) // loop column 
			{			
				if(trim($_POST['search']['value'])) // if datatable send POST for search
				{
					if($i===0) // first loop
					{
						$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
						$this->db->like($item, trim($_POST['search']['value']));
					}
					else
					{
						$this->db->or_like($item, trim($_POST['search']['value']));
					}
	 
					if(count($column_search) - 1 == $i) //last loop
						$this->db->group_end(); //close bracket
				}
				$i++;
			}
		}

		if(!empty($column_order) && isset($_POST['order'])){
			if(isset($_POST['order'])) // here order processing
			{
				$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($this->order))
			{
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}else if(!empty($column_order)){ 
			$this->db->order_by($table.'.id','DESC');
		}
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{ 
			if($counter)
				return $query->result()[0]->total_data;//return $query->num_rows();

			else
				return $query->result();
		}
		return false;
	}

	public function RoleDataFilter($whereArrr,$counter)
	{

		$column_search = array('role_name');
		$column_order = array();

		$table = 'roles';
		if($counter)
			$select = 'COUNT('.$table.'.id) as total_data';
		else
			$select = "*";
		

		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($table.".is_deleted",0);
		
		$i = 0;  
		if(!empty($column_search) && isset($column_search) && isset($_POST['search']['value'])){
			foreach ($column_search as $item) // loop column 
			{			
				if(trim($_POST['search']['value'])) // if datatable send POST for search
				{
					if($i===0) // first loop
					{
						$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
						$this->db->like($item, trim($_POST['search']['value']));
					}
					else
					{
						$this->db->or_like($item, trim($_POST['search']['value']));
					}
	 
					if(count($column_search) - 1 == $i) //last loop
						$this->db->group_end(); //close bracket
				}
				$i++;
			}
		}

		if(!empty($column_order) && isset($_POST['order'])){
			if(isset($_POST['order'])) // here order processing
			{
				$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($this->order))
			{
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}else if(!empty($column_order)){ 
			$this->db->order_by($table.'.id','DESC');
		}
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{ 
			if($counter)
				return $query->result()[0]->total_data;//return $query->num_rows();

			else
				return $query->result();
		}
		return false;
	}

	public function UserDataFilter($whereArrr,$counter)
	{

		$column_search = array('u_name','u_email','user_name');
		$column_order = array();

		$table = 'user';
		if($counter)
			$select = 'COUNT('.$table.'.id) as total_data';
		else
			$select = $table.".*,roles.role_name";
		

		$this->db->select($select);
		$this->db->from($table);
		$this->db->join("roles","roles.id = ".$table.".role_id","left");
		$this->db->where($table.".is_deleted",0);
		
		$i = 0;  
		if(!empty($column_search) && isset($column_search) && isset($_POST['search']['value'])){
			foreach ($column_search as $item) // loop column 
			{			
				if(trim($_POST['search']['value'])) // if datatable send POST for search
				{
					if($i===0) // first loop
					{
						$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
						$this->db->like($item, trim($_POST['search']['value']));
					}
					else
					{
						$this->db->or_like($item, trim($_POST['search']['value']));
					}
	 
					if(count($column_search) - 1 == $i) //last loop
						$this->db->group_end(); //close bracket
				}
				$i++;
			}
		}

		if(!empty($column_order) && isset($_POST['order'])){
			if(isset($_POST['order'])) // here order processing
			{
				$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($this->order))
			{
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}else if(!empty($column_order)){ 
			$this->db->order_by($table.'.id','DESC');
		}
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{ 
			if($counter)
				return $query->result()[0]->total_data;//return $query->num_rows();

			else
				return $query->result();
		}
		return false;
	}

	public function PaymentDataFilter($whereArrr,$counter)
	{
		$table = 'payments';
		$column_search = array();
		$column_order = array();

		if($counter)
			$select = 'COUNT('.$table.'.id) as total_data';
		else
			$select = $table.".txnid,".$table.".status,donation_type.type_name,donation.id,donation.name,donation.email,donation.cell,donation.amount";

		$this->db->select($select);
		$this->db->from($table);
		$this->db->join("donation","donation.id = ".$table.".donation_id","left");
		$this->db->join("donation_type","donation_type.id = donation.type_id","left");
		
		if(!empty($whereArrr))
			$this->db->where($whereArrr);
		
		$i = 0;  
		if(!empty($column_search) && isset($column_search) && isset($_POST['search']['value'])){
			foreach ($column_search as $item) // loop column 
			{			
				if(trim($_POST['search']['value'])) // if datatable send POST for search
				{
					if($i===0) // first loop
					{
						$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
						$this->db->like($item, trim($_POST['search']['value']));
					}
					else
					{
						$this->db->or_like($item, trim($_POST['search']['value']));
					}
	 
					if(count($column_search) - 1 == $i) //last loop
						$this->db->group_end(); //close bracket
				}
				$i++;
			}
		}

		if(!empty($column_order) && isset($_POST['order'])){
			if(isset($_POST['order'])) // here order processing
			{
				$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($this->order))
			{
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}else if(empty($column_order)){ 
			$this->db->order_by($table.'.id','DESC');
		}
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{ 
			if($counter)
				return $query->result()[0]->total_data;//return $query->num_rows();

			else
				return $query->result();
		}
		return false;
	}
	
}
?>