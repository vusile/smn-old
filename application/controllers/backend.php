<?php
class backend extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->database();
		
		
		$this->load->library('grocery_CRUD');	
	}	

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
			$theUser = $this->ion_auth->user()->row();
			$user = $theUser->id;
			
			if($theUser->read_mwongozo == 1)
			{
			
				$this->db->where('user',$user);
				$composers = $this->db->get('piano_composers');
				
				
				
				$datas['datasent'] = '<ul>';
				
				if($composers->num_rows() > 0)
				{
					$composer = $composers->row();
					$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/piano_composers/" . $composer->id), "My Profile" , 'title="My Profile"') . "</li>"; 
				}
				$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/mwongozo"), "Mwongozo wa Ku-upload Nyimbo" , 'title="Mwongozo wa Ku-upload Nyimbo"') . "</li>"; 
				$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/piano_uploaded_songs/1"), "Approved Songs" , 'title="Approved Songs"') . "</li>"; 
				$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/piano_uploaded_songs/0"), "Songs Pending Review" , 'title="Songs Pending Review"') . "</li>"; 
				if($this->ion_auth->is_admin())
				{
					$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/piano_newsletter"), "Newsletter" , 'title="Newsletter"') . "</li>"; 
					$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/piano_emails"), "Emails" , 'title="Emails"') . "</li>"; 
					$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/piano_faq"), "FAQ" , 'title="FAQ"') . "</li>"; 
					$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/piano_pages"), "Pages & Blog Entries" , 'title="Pages & Blog Entries"') . "</li>"; 
					$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/piano_ads"), "Ads" , 'title="Ads"') . "</li>"; 
					$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/piano_backend_users"), "Users" , 'title="Users"') . "</li>"; 
					$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/piano_requests"), "Song Requests" , 'title="Song Requests"') . "</li>"; 
					$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/piano_contributions_account"), "Contributions" , 'title="Contributions"') . "</li>"; 
					$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/piano_composers"), "Composers" , 'title="Composers"') . "</li>"; 
					$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/piano_recording_studios"), "Recording Studios" , 'title="Recording Studios"') . "</li>"; 
					$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/piano_music_schools"), "Music Schools" , 'title="Music Schools"') . "</li>"; 
					$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/piano_singing_groups"), "Singing Groups" , 'title="Singing Groups"') . "</li>"; 
					$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/reassign_form"), "Re-assign Composer" , 'title="Re-assign Composer"') . "</li>"; 
					$datas['datasent'] .= '<li   style = "background: #3366FF">' . anchor(site_url("backend/associate_form"), "Composer - Uploader" , 'title="Composer - Uploader"') . "</li>"; 
				}
				
				$datas['datasent'] .= '</ul>';
				$header['title'] = 'Swahili Music Notes Dashboard';
							
				$this->load->view('backend-header',$header);
				$this->load->view('dashboard',$datas);
			}
			else 
			{
				$this->db->where('url', 'mwongozo-wa-ku-upload-nyimbo');
				$pages = $this->db->get('piano_pages');
				$page = $pages->row();
				$data['h1'] = $header['title'] = $page->title;
				
				$data['results'] ='';
				
				if($theUser->read_mwongozo == 2)
					$data['results'] .= "<span style = 'color:red; font-weight: bold'>Haujakubali Mwongozo wa ku-upload nyimbo kwa kuweka tick kwenye ki-box hapo chini. Kama hautaki kuukubali, <a href = '" . base_url() . "'>Endelea Kuangalia Nyimbo Nyingine</a></span><br><br>";
				
				$data['results'] .= $page->text;
				
				
				$data['results'] .= '<form action = "backend/read_mwongozo/' .  $user . '" method = "post"><div style = "float: left; clear: none; width: 30px"><input type = "checkbox" name="nimesoma"></div><div style = "float: left; clear: right; width: 650px"><label for ="nimesoma"><strong><span style = "color:red">Nimesoma, nimeelewa na nitazingatia yote yalivyoandikwa kwenye mwongozo huu. Na niko tayari kushiriki kikamilifu juhudi zote za kuboresha nyimbo zinazokuwa uploaded Swahili Music Notes.</span></strong></label></div><br><br><input type = "submit" value = "Nipeleke Nika-Upload"></form>';
					
				//$sidebar = $this->sidebar();
				$this->load->view('Header',$header);
				$this->load->view('Page',$data);
				//$this->load->view('Sidebar',$sidebar);
				$this->load->view('Footer');
			}
		
			
		}
	}
	
	function read_mwongozo($user_id)
	{
		if(isset($_POST['nimesoma']))
		{
			$this->db->where('id',$user_id);
			$this->db->update('piano_backend_users',array('read_mwongozo'=>1));
			$this->index();
		}
		else
		{
			$this->db->where('id',$user_id);
			$this->db->update('piano_backend_users',array('read_mwongozo'=>2));
			$this->index();
		}
	}
	
	function mwongozo()
	{
	
		$theUser = $this->ion_auth->user()->row();
		$user = $theUser->id;
		$this->db->where('url', 'mwongozo-wa-ku-upload-nyimbo');
		$pages = $this->db->get('piano_pages');
		$page = $pages->row();
		$data['h1'] = $header['title'] = $page->title;
		
		$data['results'] ='';
		
		if($theUser->read_mwongozo == 2 or $theUser->read_mwongozo == 0 )
			$data['results'] .= "<span style = 'color:red; font-weight: bold'>Haujakubali Mwongozo wa ku-upload nyimbo kwa kuweka tick kwenye ki-box hapo chini. Kama hautaki kuukubali, <a href = '" . base_url() . "'>Endelea Kuangalia Nyimbo Nyingine</a></span><br><br>";
			
		if($theUser->read_mwongozo == 1)
			$data['results'] .= "<span style = 'color:red; font-weight: bold'>Umeshaukubali Mwongozo Huu</a></span><br><br>";
		
		$data['results'] .= $page->text;
		
		
		$data['results'] .= '<form action = "backend/read_mwongozo/' .  $user . '" method = "post"><div style = "float: left; clear: none; width: 30px"><input type = "checkbox" name="nimesoma"';
		
		if($theUser->read_mwongozo == 1) 
			$data['results'] .= "checked";
		
		$data['results'] .= '></div><div style = "float: left; clear: right; width: 650px"><label for ="nimesoma"><strong><span style = "color:red">Nimesoma, nimeelewa na nitazingatia yote yalivyoandikwa kwenye mwongozo huu. Na niko tayari kushiriki kikamilifu juhudi zote za kuboresha nyimbo zinazokuwa uploaded Swahili Music Notes.</span></strong></label></div><br><br><input type = "submit" value = "Nipeleke Nika-Upload"></form>';
			
		//$sidebar = $this->sidebar();
		$this->load->view('Header',$header);
		$this->load->view('Page',$data);
		//$this->load->view('Sidebar',$sidebar);
		$this->load->view('Footer');
	}

	function make_url_title($name,$table,$id)
	{
		 $url = strtolower(url_title($title));
                               

		$this->db->where('url',$url);
		$obj=$this->db->get($table);
	   
		if($obj->num_rows() > 0)
		{
			$this->db->where('id',$id);
			$this->db->where('url',$url);
			$obj=$this->db->get($table);
		   
			if( $obj->num_rows() == 0 )
				$url = $this->make_url_title($url . '-' . $url,$table,$id);
		}
	   
		return $url;
	}
	
	function _example_output($output = null)
	{
		$CI =& get_instance();
		$CI->load->library('ion_auth');
		
		if (!$CI->ion_auth->logged_in())
			redirect('login');
		
		else
			$this->load->view('example.php',$output);	
	}
	
	function piano_faq()
	{
		$output = $this->grocery_crud->render();
		$this->_example_output($output);
	}
	
	function piano_uploaded_songs($status)
	{
		$this->grocery_crud->set_rules('jina_la_wimbo','Jina la Wimbo','required');
		$this->grocery_crud->set_rules('image_au_PDF','PDF ya Nota','required');
		$this->grocery_crud->set_rules('category','Category','required');
		$this->grocery_crud->set_rules('mtunzi','Mtunzi','required');
		$this->grocery_crud->where('approved',$status);
		$this->grocery_crud->set_field_upload('image_au_PDF','uploads/files');
		$this->grocery_crud->set_field_upload('midi','uploads/files');
		$this->grocery_crud->set_field_upload('nota_original','uploads/files');
		$this->grocery_crud->display_as('image_au_PDF','PDF');
		$this->grocery_crud->callback_after_insert(array($this,'upload_song_callback'));
		$this->grocery_crud->callback_after_update(array($this,'update_song_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_song_callback'));
		$this->grocery_crud->set_relation('mtunzi','piano_composers','name');
		$this->grocery_crud->set_relation_n_n('category','piano_songs_categories','piano_categories','songID','catID','title','priority');
		$this->grocery_crud->set_theme('datatables');

		$this->grocery_crud->set_subject('Song');
		
		if(!$this->ion_auth->is_admin())
		{
			$this->grocery_crud->where('uploaded_by',$this->ion_auth->user()->row()->id);
			$this->grocery_crud->order_by('jina_la_wimbo');
			$this->grocery_crud->unset_fields('uploaded_by','approved','url','uploaded_date','not_reviewed');
			$this->grocery_crud->unset_columns('category','uploaded_by','approved','url','image_au_PDF','midi','mtunzi_mpya','not_reviewed');
			$this->grocery_crud->unset_delete();
			$this->grocery_crud->unset_export();
		}
		else
		{
			$this->grocery_crud->order_by('uploaded_date');
			//$this->grocery_crud->unset_fields('uploaded_date');
			$this->grocery_crud->unset_columns('category','approved','url','image_au_PDF','midi','not_reviewed');
			$this->grocery_crud->set_relation('uploaded_by','piano_backend_users','{first_name} {last_name}');
		}

		$output = $this->grocery_crud->render();
		$this->_example_output($output);
	}
	
	function get_new_composer($mtunzi_mpya)
	{
	}
	
	function piano_music_schools()
	{
		$this->grocery_crud->set_field_upload('logo','uploads/files');
		$this->grocery_crud->set_field_upload('additional_document','uploads/files');
		if(!$this->ion_auth->is_admin())
		{
			$this->grocery_crud->unset_fields('url','user');
			$this->grocery_crud->unset_columns('url','user');
		}
		$this->grocery_crud->set_relation('user','piano_backend_users','{first_name} {last_name}');
		$this->grocery_crud->callback_after_insert(array($this,'upload_school_callback'));
		$this->grocery_crud->callback_after_update(array($this,'upload_school_callback'));
		$output = $this->grocery_crud->render();
		$this->_example_output($output);
	}	
	
	function upload_school_callback($post_array,$primary_key)
	{
		$data = array ('url'=> $this->make_url_title($post_array['name'], 'piano_music_schools', $primary_key));
		$this->db->where('id',$primary_key);
		$this->db->update('piano_music_schools',$data);
		return;
	}
	
	function piano_recording_studios()
	{
		$this->grocery_crud->set_field_upload('logo','uploads/files');
		$this->grocery_crud->set_field_upload('additional_document','uploads/files');
		if(!$this->ion_auth->is_admin())
		{
			$this->grocery_crud->unset_fields('url','user');
			$this->grocery_crud->unset_columns('url','user');
		}
		$this->grocery_crud->set_relation('user','piano_backend_users','{first_name} {last_name}');
		$this->grocery_crud->callback_after_insert(array($this,'upload_studio_callback'));
		$this->grocery_crud->callback_after_update(array($this,'upload_studio_callback'));
		$output = $this->grocery_crud->render();
		$this->_example_output($output);
	}
	
	function upload_studio_callback($post_array,$primary_key)
	{
		$data = array ('url'=> $this->make_url_title($post_array['name'], 'piano_recording_studios', $primary_key));
		$this->db->where('id',$primary_key);
		$this->db->update('piano_recording_studios',$data);
	}
	
	function piano_singing_groups()
	{
		$this->grocery_crud->set_field_upload('logo','uploads/files');
		$this->grocery_crud->set_field_upload('additional_document','uploads/files');
		if(!$this->ion_auth->is_admin())
		{
			$this->grocery_crud->unset_fields('url','user');
			$this->grocery_crud->unset_columns('url','user');
		}
		$this->grocery_crud->set_relation('user','piano_backend_users','{first_name} {last_name}');
		$this->grocery_crud->callback_after_insert(array($this,'upload_group_callback'));
		$this->grocery_crud->callback_after_update(array($this,'upload_group_callback'));
		$output = $this->grocery_crud->render();
		$this->_example_output($output);
	}
	
	function upload_group_callback($post_array,$primary_key)
	{
		$data = array ('url'=> $this->make_url_title($post_array['name'], 'piano_singing_groups', $primary_key));
		$this->db->where('id',$primary_key);
		$this->db->update('piano_singing_groups',$data);
	}
	
	function piano_newsletter()
	{
		$this->grocery_crud->set_relation_n_n('mwanzo', 'piano_temp_mwanzo', 'piano_uploaded_songs', 'newsletter', 'song', 'jina_la_wimbo','priority');
		$this->grocery_crud->set_relation_n_n('katikati', 'piano_temp_katikati', 'piano_uploaded_songs', 'newsletter', 'song', 'jina_la_wimbo','priority');
		$this->grocery_crud->set_relation_n_n('nyinginezo', 'piano_temp_nyinginezo', 'piano_uploaded_songs', 'newsletter', 'song', 'jina_la_wimbo','priority');
		$this->grocery_crud->set_relation_n_n('articles', 'piano_temp_posts', 'piano_pages', 'newsletter', 'article', 'title','priority');
		$output = $this->grocery_crud->render();
		$this->_example_output($output);
	}
	
	
	function upload_song_callback($post_array,$primary_key)
	{
		$theUser = $this->ion_auth->user()->row();
		$user = $theUser->id;
		
		//if($post_array['mtunzi'] == 233)
		if($post_array['mtunzi'] == 242)
		{
			$jina_la_mtunzi_mpya = ucwords(strtolower($post_array['mtunzi_mpya']));
			$composer_url = $this->convert_url('piano_composers', 'url', $post_array['mtunzi_mpya']);
			$composer_data = array(
				'name' => $jina_la_mtunzi_mpya,
				'url'=> $composer_url
			);
			
			$mtunzi_name = $jina_la_mtunzi_mpya;
			$this->db->insert('piano_composers',$composer_data);
			$data['mtunzi'] = $this->db->insert_id();
		}
		else
		{
			$this->db->where('id',$post_array['mtunzi']);
			$comp = $this->db->get('piano_composers');
			$mtunzi_name = $comp->row()->name;
		}
		
		$data['uploaded_date'] = date('Y-m-d');
		$data['url'] = $this->convert_url('piano_uploaded_songs','url',$post_array['jina_la_wimbo'],$mtunzi_name);
		$data['jina_la_wimbo'] = ucwords(strtolower($post_array['jina_la_wimbo']));
		$data['approved'] = 0;
		if(!$this->ion_auth->is_admin())
		{
			$data['uploaded_by'] = $user;
		
		}
				
		$this->db->where('id',$primary_key);
		$this->db->update('piano_uploaded_songs',$data);
		
		$this->db->where('id',$primary_key);
		$uploaded_song = $this->db->get('piano_uploaded_songs');
		
		
		$theUser = $this->ion_auth->user()->row();
		$user = $theUser->id;
		$this->db->where('id',$user);
		$user_data = $this->db->get('piano_backend_users');
		$uploader = $user_data->row();
		
		$this->db->where('id',2);
		$emails = $this->db->get('piano_emails');
		$email = $emails->row();
		
		$this->load->library('email');
		
		/*$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'mymail.brinkster.com';
		$config['smtp_user'] = 'admin@swahilimusicnotes.com';
		$config['smtp_pass'] = 'immaculata';
		$config['smtp_port'] = '25';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;
		$config['charset']='utf-8';  
		$config['newline']="\r\n";  

		$this->email->initialize($config);*/

		
		$this->email->from('admin@swahilimusicsheet.com', 'Swahili Music Notes');
		$this->email->to($uploader->email);
		$this->email->cc('admin@swahilimusicsheet.com'); 
		$this->email->subject($email->subject);
		
		$message = '';
		$message .= '<html><head></head><body>';
		$message .= str_replace('[SONGNAME]',$uploaded_song->row()->jina_la_wimbo,$email->message);
		$message .= '</body></html>';
		$this->email->message($message);
		$this->email->set_alt_message(strip_tags($message));
		if(!$this->email->send())
		{
			$error['error'] = $this->email->print_debugger();
			$error['date'] = date('Y-m-d');	
			$this->db->insert('piano_log',$error);
		}
	//	die();
		
		return;
	}
	
	function before_update_song_callback($post_array,$primary_key)
	{
		$this->db->where('id',$primary_key);
		$song = $this->db->get('piano_uploaded_songs');
		
		$data = array (
			'song_id' => $song->row()->id,
			'old_status' => $song->row()->approved
		);
		
		$this->db->insert('piano_old_status',$data);
		
		return;
	}
	
	function update_song_callback($post_array,$primary_key)
	{
		$this->db->where('id',$primary_key);
		$songs = $this->db->get('piano_uploaded_songs');
		$song = $songs->row();
		
		$this->db->where('song_id',$primary_key);
		$statuses = $this->db->get('piano_old_status');
		$status = $statuses->row();
		
		$this->db->where('id',$song->mtunzi);
		$composers = $this->db->get('piano_composers');
		$composer = $composers->row();
		
		$theUser = $this->ion_auth->user()->row();
		$user = $theUser->id;
		
		$this->db->where('id',$song->uploaded_by);
		$user_data = $this->db->get('piano_backend_users');
		$uploader = $user_data->row();
		
		/*Check Composer Email to send email*/
		if($status->old_status == 0 and $song->approved==1)
		{
	
			if($composer->email != '')
			{
				$this->db->where('id',1);
				$emails = $this->db->get('piano_emails');
				$email = $emails->row();
				
				$this->load->library('email');
				
				$this->email->from('admin@swahilimusicnotes.com', 'Swahili Music Notes');
				$this->email->to($composer->email);
				//$this->email->cc('admin@swahilimusicsheet.com'); 
				$this->email->subject(str_replace('[NAME]', $composer->name, $email->subject));
				
				$message = '';
				$message .= '<html><head></head><body>';
				$msg = $email->message;
				$msg = str_replace('[NAME]',$composer->name,$msg);
				$msg = str_replace('[SONGNAME]',$song->jina_la_wimbo,$msg);
				$link =  strip_tags(base_url() . "song/" . $song->url);	
				$msg = str_replace('[LINK]', $link ,$msg);
				$message .= $msg;
				$message .= '</body></html>';
				$this->email->message($message);
				$this->email->set_alt_message(strip_tags($message));
				if(!$this->email->send())
				{
					$error['error'] = $this->email->print_debugger();
					$error['date'] = date('Y-m-d');	
					$this->db->insert('piano_log',$error);
				}
				$this->email->clear();
				
			}
			/*Send Email to Uploader */
			
			$this->db->where('id',3);
			$emails = $this->db->get('piano_emails');
			$email = $emails->row();
			
			$this->email->from('admin@swahilimusicsheet.com', 'Swahili Music Notes');
			$this->email->to($uploader->email);
			//$this->email->cc('admin@swahilimusicsheet.com'); 
			
			$this->email->subject(str_replace('[NAME]', $uploader->first_name, $email->subject));
			
			$message = '';
			$message .= '<html><head></head><body>';
			$msg = $email->message;
			$msg = str_replace('[SONGNAME]',$song->jina_la_wimbo,$msg);
			$link = strip_tags(base_url() . "song/" . $song->url);	
			$msg = str_replace('[LINK]',$link ,$msg);
			$message .= $msg;
			$message .= '</body></html>';
			$this->email->message($message);
			$this->email->set_alt_message(strip_tags($message));
			if(!$this->email->send())
			{
				$error['error'] = $this->email->print_debugger();
				$error['date'] = date('Y-m-d');	
				$this->db->insert('piano_log',$error);
			}
			$this->email->clear();
		}
		
		else if(($status->old_status == 0 or $status->old_status == 1) and $song->approved==0 and $song->not_reviewed != '')
		{

			$this->db->where('id',4);
			$emails = $this->db->get('piano_emails');
			$email = $emails->row();
			
			$this->email->from('admin@swahilimusicsheet.com', 'Swahili Music Notes');
			$this->email->to($uploader->email);
	//		$this->email->cc('admin@swahilimusicsheet.com'); 
			
			$this->email->subject(str_replace('[NAME]', $uploader->first_name, $email->subject));
			
			$message = '';
			$message .= '<html><head></head><body>';
			$msg = $email->message;
			$msg = str_replace('[SONGNAME]',$song->jina_la_wimbo,$msg);
			$msg = str_replace('[SABABU]',$song->not_reviewed,$msg);
			$link = strip_tags(base_url() . "backend/piano_uploaded_songs/0/edit/" . $song->id);
			$msg = str_replace('[EDITLINK]', $link,$msg);
			$message .= $msg;
			$message .= '</body></html>';
			$this->email->message($message);
			$this->email->set_alt_message(strip_tags($message));
			if(!$this->email->send())
			{
				$error['error'] = $this->email->print_debugger();
				$error['date'] = date('Y-m-d');	
				$this->db->insert('piano_log',$error);
			}			
		}
		
		$this->db->where('song_id',$primary_key);
		$this->db->delete('piano_old_status');
	}
	
	function piano_composers($id=0)
	{
		$this->grocery_crud->callback_after_insert(array($this,'composers_callback'));
		$this->grocery_crud->callback_after_update(array($this,'composers_callback'));
		$this->grocery_crud->set_field_upload('photo','uploads/files');
		
		if($id !=0 and !$this->ion_auth->is_admin())
		{
			$this->grocery_crud->unset_fields('url','user');
			$this->grocery_crud->unset_columns('url','user');
			$this->grocery_crud->unset_delete();
			$this->grocery_crud->unset_export();
			$this->grocery_crud->unset_add();
			$this->grocery_crud->where('id',$id);
		}
		$this->grocery_crud->set_theme('datatables');
		$output = $this->grocery_crud->render();

		$this->_example_output($output);
	}
	
	function composers_callback($post_array, $primary_key)
	{
		$this->load->library('image_moo');
		$this->db->where('id',$primary_key);
		$composers = $this->db->get('piano_composers');
		$composer=$composers->row();
		
		if($composer->photo != '')
		{
			$source_image = 'uploads/files/' . $composer->photo;
			$sizes = getimagesize($source_image);
			
			
			if($sizes[0] >= $sizes[1] and $sizes[0] > 200)				
				$this->image_moo->load($source_image)->resize(200,999999999999)->save($source_image,$overwrite=TRUE);
			else if($sizes[0] <= $sizes[1] and $sizes[1] > 266)
				$this->image_moo->load($source_image)->resize(999999999999,266)->save($source_image,$overwrite=TRUE);
		}
		
		if($composer->url == '')
		{
			$data['url'] = $this->convert_url('piano_composers','url',$post_array['name'],$post_array['name']);
			
			$this->db->where('id',$primary_key);
			$this->db->update('piano_composers',$data);
		}
	}
	
	function piano_backend_users()
	{
		$this->grocery_crud->set_theme('datatables');
		$output = $this->grocery_crud->render();

		$this->_example_output($output);
	}	
	
	function piano_pages()
	{
		$this->grocery_crud->set_theme('datatables');
		$output = $this->grocery_crud->render();

		$this->_example_output($output);
	}
	
	function piano_ads()
	{
		$this->grocery_crud->set_field_upload('image','uploads/ads');
		$this->grocery_crud->set_theme('datatables');
		$output = $this->grocery_crud->render();

		$this->_example_output($output);
	}
	
	function piano_emails()
	{
		$output = $this->grocery_crud->render();

		$this->_example_output($output);
	}
	
	function convert_url($table, $column, $text,$composer)
	{
		
		$cleanurl = preg_replace('/[^A-Za-z0-9\s]/i', ' ', $text); 
		// eliminates extra white spaces created above 
		$cleanurl = preg_replace('/\s\s+/', ' ', $cleanurl); 
		// replaces white space with a hyphen 
		$cleanurl = str_replace(' ', '-', $cleanurl); 
		// removes any hyphen from beginning of string 
		$cleanurl = preg_replace('/^-/', '', $cleanurl); 
		// removes any hyphen from end of string 
		$cleanurl = preg_replace('/-$/', '', $cleanurl); 
		// makes all letters lower case 
		$cleanurl = strtolower($cleanurl); 
		
		//$cleanurl = $this->check_clean_url($table,$column,$cleanurl,$composer);
		
		$this->db->where($column,$cleanurl);
		$cleancheck = $this->db->get($table);
		
		if($cleancheck->num_rows() == 0)
		{
			return $cleanurl;
		}
		else
		{

			$cleanurl = $cleanurl . '-' . $this->convert_url($table, $column, $composer,$composer);
			return $cleanurl;
		}
		
		//return $cleanurl;
			
		
	}
	
	function check_clean_url($table,$field,$cleanurl,$composer)
	{
		
	}
	
	function piano_contributions_account()
	{
		$output = $this->grocery_crud->render();
		$this->_example_output($output);
	}
	
	function piano_requests()
	{
		$this->grocery_crud->set_relation('mtunzi','piano_composers','name');
		$output = $this->grocery_crud->render();
		$this->_example_output($output);
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