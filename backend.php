<?php
class backend extends CI_Controller {
	function index()
	{
		$CI =& get_instance();
		$CI->load->library('ion_auth');
		
		if (!$CI->ion_auth->logged_in())
		{
			redirect('login');
		}
		else
		{
			$datas['datasent'] = '<ul>';
			$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/view_uploaded_songs/1"), "Approved Songs" , 'title="Approved Songs"') . "</li>"; 
			$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/view_uploaded_songs/0"), "Songs Pending Review" , 'title="Songs Pending Review"') . "</li>"; 
			if($this->ion_auth->is_admin())
			{
				$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/view/piano_pages"), "Pages & Blog Entries" , 'title="Pages & Blog Entries"') . "</li>"; 
				$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/view_piano_ads"), "Ads" , 'title="Ads"') . "</li>"; 
				$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/view/piano_backend_users"), "Users" , 'title="Users"') . "</li>"; 
				$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/view/piano_requests"), "Song Requests" , 'title="Song Requests"') . "</li>"; 
				$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/view/piano_contributions_account"), "Contributions" , 'title="Contributions"') . "</li>"; 
				$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/view_composers"), "Composers" , 'title="Composers"') . "</li>"; 
				$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/reassign_form"), "Re-assign Composer" , 'title="Re-assign Composer"') . "</li>"; 
				$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/associate_form"), "Composer - Uploader" , 'title="Composer - Uploader"') . "</li>"; 
			}
			
			$datas['datasent'] .= '</ul>';
			$header['title'] = 'Swahili Music Notes Dashboard';
						
			$this->load->view('backend-header',$header);
			$this->load->view('dashboard',$datas);
		}
	}
	
	
	function view($table)
	{
		$this->vedlib->index($table);
	}

	
	
	function view_uploaded_songs($approved = 1,$offset=0)
	{
		$this->session->set_userdata(array ('piano_uploaded_songs_add_function' => 'action/upload_song_form'));
		$this->session->set_userdata(array ('piano_uploaded_songs_edit_function' => 'action/edit_song/piano_uploaded_songs'));
		$this->session->set_userdata(array ('piano_uploaded_songs_delete_function' => 'action/delete_song'));
		
		
		
		if(!$this->ion_auth->is_admin())
		{
			$theUser = $this->ion_auth->user()->row();
			$user = $theUser->id;
			$this->db->select('id,jina_la_wimbo,mtunzi');
			$this->db->where('uploaded_by', $user);
			$this->db->order_by('jina_la_wimbo');
		}
		else
			$this->db->order_by('id','desc');

		$this->db->where('approved', $approved);
		$songs = $this->db->get('piano_uploaded_songs');
		$base_url = 'backend/view_uploaded_songs/' . $approved ;
		$this->vedlib->index('piano_uploaded_songs',$offset,$songs,$base_url);
	}
	
	
	function logout()
	{
		if($this->ion_auth->logout())
			redirect('login/2');
	}
	
	function view_composers($offset=0)
	{
		$this->session->set_userdata(array ('piano_composers_add_function' => 'action/edit_composer/piano_composers/0'));
		$this->session->set_userdata(array ('piano_composers_edit_function' => 'action/edit_composer/piano_composers'));
		$this->session->set_userdata(array ('piano_composers_delete_function' => 'action/delete_composer'));
		
		$this->db->order_by('name');
		$composers = $this->db->get('piano_composers');
		$base_url = 'backend/view_composers/';
		$this->vedlib->index('piano_composers',$offset,$composers,$base_url);
	}
	
	function find()
	{
		$this->session->set_userdata(array ('piano_uploaded_songs_add_function' => 'action/upload_song_form'));
		$this->session->set_userdata(array ('piano_uploaded_songs_edit_function' => 'action/edit_song/piano_uploaded_songs'));
		$this->session->set_userdata(array ('piano_uploaded_songs_delete_function' => 'action/delete_song'));
		
		$search_string = explode(' - ' , $_POST['search']); 
		$this->db->like('jina_la_wimbo', $search_string[0] );
		$results = $this->db->get('piano_uploaded_songs');
		$base_url = 'backend/view_uploaded_songs/';
		$this->vedlib->index('piano_uploaded_songs',1,$results,$base_url);
		
	}
	
	function view_piano_ads()
	{
		$this->session->set_userdata(array ('piano_ads_add_function' => 'action/new_ad'));
		$this->session->set_userdata(array ('piano_ads_edit_function' => 'action/edit_ad/piano_ads'));
		$this->session->set_userdata(array ('piano_ads_delete_function' => 'action/delete_song'));
		$this->vedlib->index('piano_ads');
	}
	
	function reassign_form()
	{
		$this->db->order_by('name');
		$datas['composers'] = $this->db->get('piano_composers');
		$data['title'] = "Re-assign Songs";
		$this->load->view('backend-header',$data);
		$this->load->view('assign',$datas);
		$this->load->view('backend-footer');
		
	}
	
	function associate_form()
	{
		
		$this->db->order_by('name');
		$datas['composers'] = $this->db->get('piano_composers');
		$this->db->order_by('first_name');
		$datas['users'] = $this->db->get('piano_backend_users');
		$data['title'] = "Associate Composer and Uploader";
		$this->load->view('backend-header',$data);
		$this->load->view('associate',$datas);
		$this->load->view('backend-footer');
		
	}
	
	
}