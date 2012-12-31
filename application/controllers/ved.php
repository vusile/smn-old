<?php
class Ved extends CI_Controller {
	function index($table,$offset='',$resource='')
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}
		else
		{
			$this->load->model('Vedmodel');
			$this->load->model('Vedmodel');
			$this->load->library('table');
			$this->load->library('pagination');
			
			$config['base_url'] = base_url().'ved/index/'.$table;
			
			if($resource != '')
				$config['total_rows'] = $resource->num_rows();	
			else
				$config['total_rows'] = $this->db->count_all($table);	
				
			$config['per_page'] = 5;
			$config['uri_segment'] = 4;
			
			$this->pagination->initialize($config);
		
			$data['title'] = ucfirst(str_replace('_',' ',$table));
			$datas = array();
			$datas['pk'] = $pk = $this->Vedmodel->get_primary_key($table);
			
			if($resource != '')
				$datas['data'] = $resource;
			else
			{
				if($this->session->userdata($table)!='')
				{
					
					$this->db->select($pk . ',' . $this->session->userdata($table));
				}
				$datas['data'] = $this->db->get($table, $config['per_page'],$this->uri->segment(4));
			}	
			$datas['table_name'] = $table;
			
			$type_info = array();
			$types = $this->Vedmodel->data_type($this->db->database,$table);
			foreach ($types->result() as $type)
				$type_info[$type->col] = $type->type;
				
			$datas['type_info'] = $type_info;
			$this->load->view('Header',$data);
			$this->load->view('Viewer',$datas);
			$this->load->view('Footer');
		}
	}
	
	
	function listOfTables()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}
		else
		{
			$this->load->model('Vedmodel');
			$tables = array (array ('test_terms','name,slug'));
			$data['datasent'] = $this->Vedmodel->list_tables($tables);
			$this->load->view('testpage',$data);
		}
	}
	
	
//VED ENDS HERE
	
}