<?php
class main extends CI_Controller {

	function index()
	{
		$header['title'] = 'Swahili Music Notes | Swahili Music Sheet';
		
		
		$query = "SELECT cat.*, cat.title title, COUNT( cat_song.songID ) count
			FROM piano_categories cat, piano_songs_categories cat_song, piano_uploaded_songs song
			WHERE cat_song.catID = cat.id
			AND song.id = cat_song.songID
			AND song.approved =1
			GROUP BY cat_song.catID
			ORDER BY cat.title";
			
		$data['categories'] = $this->db->query($query);
		
		$this->db->where('approved', 1);
		$songs = $this->db->get('piano_uploaded_songs');
		
		$data['h1'] ='Swahili Music Notes';
		
		$data['intro'] = $header['meta_description'] = "Swahili Music Notes is the ultimate source of Swahili Music Sheet (Notes). The Website features Music Sheet of Music by <a href = 'composers'>Tanzanian Composers</a>. It's free to upload and download music sheet. There are currently " . $songs->num_rows() . " songs." ;
		
		$sidebar = $this->sidebar(0,1);
		
		$this->load->view('Header',$header);
		$this->load->view('Home',$data);
		$this->load->view('Sidebar',$sidebar);
		$this->load->view('Footer');
	}
	
	function piano($url1='',$url2='')
	{
	 	if($url1=='')
	 		redirect(base_url());
	 	else
	 		redirect(base_url().$url1 .'/'.$url2);
	}
	
	function category($url)
	{
		if($url=='')
			redirect(base_url());
				
		$this->db->where('url',$url);
		$categories = $this->db->get('piano_categories');
		
		if($categories->num_rows() > 0)
		{
			$category = $categories->row();
			$data['h1'] = $header['title'] = $category->title;
			$catID = $category->id;
			//$this->db->get('');
			
			
			$query = "SELECT piano_uploaded_songs.id, piano_uploaded_songs.url, midi, lyrics, jina_la_wimbo, mtunzi, name, LEFT(jina_la_wimbo, 1) AS first_char FROM piano_uploaded_songs, piano_composers WHERE approved = 1 AND piano_uploaded_songs.mtunzi = piano_composers.id AND LEFT(jina_la_wimbo,1) BETWEEN 'A' AND 'Z' AND piano_uploaded_songs.id IN  ( select songID from piano_songs_categories where catID = " . $catID . ") ORDER BY jina_la_wimbo";
			
			$data['songs'] = $this->db->query($query);
			
			$this->db->order_by('title');
			$data['categories']  = $this->db->get('piano_categories');
			$sidebar = $this->sidebar();
			
			$this->load->view('Header',$header);
			$this->load->view('Category',$data);
			$this->load->view('Sidebar',$sidebar);
			$this->load->view('Footer');
		}
		else
			redirect(base_url());

	}
	
	function schools()
	{
		$this->db->order_by('title');

				
		$data['h1'] = $header['title'] = "Tanzania Music Schools";

		$query = "SELECT *, LEFT(name, 1) AS first_char FROM piano_music_schools where LEFT(name,1) BETWEEN 'A' AND 'Z' ORDER BY name";
	
		$data['prefix'] = 'schools';
		$data['results'] = $this->db->query($query);
		$data['categories']  = $this->db->get('piano_categories');
		
		$sidebar = $this->sidebar();
		$this->load->view('Header',$header);
		$this->load->view('Summary',$data);
		$this->load->view('Sidebar',$sidebar);
		$this->load->view('Footer');
	}
	
	function groups()
	{
		$this->db->order_by('title');
		$data['categories']  = $this->db->get('piano_categories');

				
		$data['h1'] = $header['title'] = "Tanzania Singing Groups";
		$query = "SELECT *, LEFT(name, 1) AS first_char FROM piano_singing_groups where LEFT(name,1) BETWEEN 'A' AND 'Z' ORDER BY name";
	
		$data['prefix'] = 'groups';
		$data['results'] = $this->db->query($query);
		
		$sidebar = $this->sidebar();
		$this->load->view('Header',$header);
		$this->load->view('Summary',$data);
		$this->load->view('Sidebar',$sidebar);
		$this->load->view('Footer');
	}
	
	function studios()
	{
		$this->db->order_by('title');
		$data['categories']  = $this->db->get('piano_categories');
				
		$data['h1'] = $header['title'] = "Tanzania Recording Studios";
		$query = "SELECT *, LEFT(name, 1) AS first_char FROM piano_recording_studios where LEFT(name,1) BETWEEN 'A' AND 'Z' ORDER BY name";
	
		$data['prefix'] = 'studios';
		$data['results'] = $this->db->query($query);
		
		$sidebar = $this->sidebar();
		$this->load->view('Header',$header);
		$this->load->view('Summary',$data);
		$this->load->view('Sidebar',$sidebar);
		$this->load->view('Footer');
	}
	
	function composers()
	{
		$query = "SELECT composers.*, composers.name name, composers.url url, COUNT( songs.id ) counts, LEFT(composers.name, 1) AS first_char
			FROM piano_uploaded_songs songs,piano_composers composers
			WHERE songs.mtunzi = composers.id
			AND songs.approved =1
			GROUP BY songs.mtunzi
			ORDER BY composers.name";
			
		$data['composers'] = $this->db->query($query);
		
		//$data['results'] = '';
		//foreach($composers_obj->result() as $comp)
			//$data['results'] .= "<a href = 'composer/" . $comp->url . "'>" . $comp->name .  " (" . $comp->counts . ")</a><Br>";
		
		$this->db->order_by('title');
		$data['categories']  = $this->db->get('piano_categories');
				
		$data['h1'] = $header['title'] = "Tanzanian Composers";
		$sidebar = $this->sidebar();
		$this->load->view('Header',$header);
		$this->load->view('Composers',$data);
		$this->load->view('Sidebar',$sidebar);
		$this->load->view('Footer');

		
	}
	
	function detail($table,$url)
	{
	
		switch($table)
		{
			case 'schools':
			$table='piano_music_schools';
			break;
			
			case 'studios':
			$table='piano_recording_studios';
			break;			
			
			case 'groups':
			$table='piano_singing_groups';
			break;	
		}
		
		
		$this->db->where('url',$url);
		$obj = $this->db->get($table);
		$data['res'] = $obj->row();
		
		$this->db->order_by('title');
		$data['categories']  = $this->db->get('piano_categories');
		$data['h1'] = $header['title'] = $data['res']->name;
		$header['meta_description'] = $data['res']->description;
		$sidebar = $this->sidebar();
		
		$this->load->view('Header',$header);
		$this->load->view('Detail',$data);
		$this->load->view('Sidebar',$sidebar);
		$this->load->view('Footer');
	}
	
	
	function composer($url)
	{
		if($url=='')
			redirect(base_url());


		$this->db->where('url',$url);
		$composers = $this->db->get('piano_composers');
		$data['composer'] = $composer = $composers->row();
		$data['h1'] = $header['title'] = 'Songs by ' . $composer->name;
		$header['meta_description'] = 'These are songs by ' . $composer->name . '. '  . strip_tags($composer->details);
		//$this->db->get('');
		
		
		$query = "SELECT piano_uploaded_songs.id, piano_uploaded_songs.url, midi, lyrics, jina_la_wimbo, mtunzi, name, LEFT(jina_la_wimbo, 1) AS first_char FROM piano_uploaded_songs, piano_composers WHERE approved = 1 AND piano_uploaded_songs.mtunzi = piano_composers.id AND LEFT(jina_la_wimbo,1) BETWEEN 'A' AND 'Z' AND mtunzi = ". $composer->id ." ORDER BY jina_la_wimbo";
		
		$data['songs'] = $this->db->query($query);
		
		$this->db->order_by('title');
		$data['categories']  = $this->db->get('piano_categories');
		$sidebar = $this->sidebar(0,1);
		
		$this->load->view('Header',$header);
		$this->load->view('Category',$data);
		$this->load->view('Sidebar',$sidebar);
		$this->load->view('Footer');
	

	}
	
	function song($url)
	{
		if($url=='')
			redirect(base_url());
				
		$this->db->where('url',$url);
		$songs = $this->db->get('piano_uploaded_songs');
		
		if($songs->num_rows() > 0)
		{
			$song = $songs->row();
			
			$this->db->where('id',$song->mtunzi);
			$composers = $this->db->get('piano_composers');
			$composer = $composers->row();
			$data['composer'] = $composer;
			$data['h1'] = $header['title'] = $song->jina_la_wimbo . ' by <a href = "composer/' . $composer->url . '">' . $composer->name . '</a>';
			if($song->lyrics != '')
				$header['meta_description'] = strip_tags($song->lyrics);
				
			$data['song_title'] = ucwords($song->jina_la_wimbo);
			$data['lyrics'] = $song->lyrics;
			$data['mtunzi'] = $song->mtunzi;
			$data['pdf'] = $song->image_au_PDF;
			$data['midi'] = $song->midi;
			if($song->date_of_composition != '')
				$data['composition'] = $song->date_of_composition;
			if($song->place_of_composition != '')
				$data['place'] = $song->place_of_composition;
			$uploaderID = $song->uploaded_by;
			$data['songID'] = $songID = $song->id;
			

			$the_song_categories = $this->db->query('select * from piano_categories where id in (select catID from piano_songs_categories where songID = ' . $songID . ')');
		
			
			$categories_list  = '';
			$i = 0;
			foreach($the_song_categories->result() as $the_song_category)
			{
				if($i ==0)
				{
					$data['crumb_category_url'] = $the_song_category->url;
					$data['crumb_category_title'] = $the_song_category->title;
				}
				$categories_list .=  $the_song_category->title . ', ';
				$i++;
			}
			$data['categories_list'] = substr($categories_list ,0,-2);
			
			
			
			$this->db->where('id',$uploaderID);
			$uploader = $this->db->get('piano_backend_users');
			
			$uploadedBy = $uploader->row();
			
			$sidebar['uploader'] = $data['uploader'] = ucwords($uploadedBy->first_name . ' ' . $uploadedBy->last_name);
			
			$this->db->order_by('title');
			$data['categories']  = $this->db->get('piano_categories');
			$sidebar = $this->sidebar($uploaderID);
			
			$this->load->view('Header',$header);
			$this->load->view('Song',$data);
			$this->load->view('Sidebar',$sidebar);
			$this->load->view('Footer');
		}
		else
			redirect(base_url());

	}
	
	function sidebar($uploader_id =0,$home=0)
	{
		/*$this->db->order_by('id','desc');
		
		$this->db->where('approved' , 1);
		$this->db->limit(5);
		$data['recent_songs'] = $this->db->get('piano_uploaded_songs');*/
		
		$query = 'select songs.*, composers.*, songs.url as surl, composers.url as curl from piano_uploaded_songs as songs, piano_composers as composers where songs.mtunzi = composers.id and songs.approved = 1 order by songs.id desc limit 5';
		
		$data['recent_songs'] = $this->db->query($query);
		
		
		if($uploader_id != 0)
		{
			$data['uploader_songs'] = $this->db->query('SELECT songs.*, composers.*, songs.url as surl, composers.url as curl, songs.id *0 + RAND( ) AS random_record FROM piano_uploaded_songs as songs, piano_composers as composers where uploaded_by = ' . $uploader_id . ' and approved = 1 and composers.id = songs.mtunzi ORDER BY random_record LIMIT 3');
		}
		
		
		
		$data['top_uploaders'] = $this->db->query('SELECT COUNT( uploads.jina_la_wimbo ) songs, CONCAT( users.first_name,  " ", users.last_name ) uploader
			FROM  `piano_uploaded_songs` AS uploads, piano_backend_users users
			WHERE approved =1
			AND uploads.uploaded_by = users.id
			GROUP BY uploaded_by
			ORDER BY songs DESC 
			LIMIT 3'
		);
		
		if($home == 1)
			$data['featured_ad'] = $this->db->query('select * from piano_ads where featured=1');
		else
			$data['featured_ad'] = $this->db->query('select * from piano_ads order by RAND() limit 1');
		
		
		
		$this->db->where('type',2);
		$this->db->limit(3);
		$this->db->order_by('id','desc');
		$data['news'] = $this->db->get('piano_pages');
		
		return $data;
	}
	
	function contact($success = 0)
	{
		$this->db->where('url', 'contact-us');
		$pages = $this->db->get('piano_pages');
		$page = $pages->row();
		$data['h1'] = $header['title'] = $page->title;
		$data['results'] = $page->text;
		
		if($success == 1)
			$data['results'] .= '<p style = "color: red; font-weight: bold;">Your message was sent succesfully.</p>';
		if($success == 2)
			$data['results'] .= '<p style = "color: red; font-weight: bold;">Whoops, something went terribly wrong.</p>';
			
		$sidebar = $this->sidebar();
		
		$this->load->view('Header',$header);
		$this->load->view('Contact',$data);
		$this->load->view('Sidebar',$sidebar);
		$this->load->view('Footer');
		
		
	}
	
	function about()
	{
		$this->page('about-us');
	}
	
	function resources()
	{
		$this->page('resources');
	}
	
	function the_directory()
	{
	
		$header['title'] = "Directory of Tanzania's Composers | Music Schools | Music Studios";
		
		$data['h1'] = "Directory";
		$data['intro'] = $header['meta_description'] = "Welcome to Tanzania's Directory of Composers, Music Schools and Music Studios.";
		
		$query = "SELECT composers.*, composers.name name, COUNT( songs.id ) counts
			FROM piano_uploaded_songs songs,piano_composers composers
			WHERE songs.mtunzi = composers.id
			AND songs.approved =1
			GROUP BY songs.mtunzi
			ORDER BY composers.name";
			
		$composers_obj = $this->db->query($query);
		
		$data['composers'] = $composers_obj->num_rows();
		$data['schools'] = $this->db->count_all('piano_music_schools');
		$data['studios'] = $this->db->count_all('piano_recording_studios');
		$data['groups'] = $this->db->count_all('piano_singing_groups');
		
		$sidebar = $this->sidebar();
		$this->load->view('Header',$header);
		$this->load->view('Directory',$data);
		$this->load->view('Sidebar',$sidebar);
		$this->load->view('Footer');
	}
	
	function page($url='')
	{

		$this->db->where('url', $url);
		$pages = $this->db->get('piano_pages');
		$page = $pages->row();
		$data['h1'] = $header['title'] = $page->title;
		$data['results'] = $page->text;
			
		$sidebar = $this->sidebar();
		$this->load->view('Header',$header);
		$this->load->view('Page',$data);
		$this->load->view('Sidebar',$sidebar);
		$this->load->view('Footer');
	}
	
	function blog()
	{
		$this->db->where('type',2);
		$this->db->order_by('id','desc');
		$data['h1'] = $header['title'] = "Swahili Music Notes Blog";
		$data['entries'] = $this->db->get('piano_pages');
		$sidebar = $this->sidebar();
		$this->load->view('Header',$header);
		$this->load->view('Blog',$data);
		$this->load->view('Sidebar',$sidebar);
		$this->load->view('Footer');
		
	}
	
	
	function register($success = 0)
	{
		$this->load->helper('captcha');
		$vals = array(
		'img_path'	 => './captcha/',
		'img_url'	 => 'captcha/',
		'font_path'	 => './captcha/fonts/arial.ttf',
		'img_width'	 => '200',
		'img_height' => 50,
		);
		
		$data['cap'] = create_captcha($vals);
	
		$cap_data = array(
		'captcha_time'	=> $data['cap']['time'],
		'ip_address'	=> $this->input->ip_address(),
		'word'	 => $data['cap']['word']
		);

		$query = $this->db->insert_string('piano_captcha', $cap_data);	
		$this->db->query($query);
		
		if($success == 1)
			$data['success'] = 'An email has been sent to you to confirm your registration';
		else if($success == 2)
			$data['success'] = 'Oops, something went wrong, please try to register again, and let us know if you encounter this problem again';
		
		//$header = $this->gen_menu();
		$sidebar = $this->sidebar();
		$data['h1']=$header['title'] = 'Register';
		$this->load->view('Header',$header);
		$this->load->view('register',$data);
		$this->load->view('Sidebar',$sidebar);
		$this->load->view('Footer');
	}
	
	function register_user()
	{
		if(isset($_POST))
		{
			$this->form_validation->set_rules('fname', 'First Name', 'required');
			$this->form_validation->set_rules('lname', 'Last Name', 'required');
			$this->form_validation->set_rules('phone', 'Phone Number', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|callback_validate_email|matches[confirm_email]');
			$this->form_validation->set_rules('captcha', 'The Captcha', 'required|callback_validate_captcha');
			$this->form_validation->set_error_delimiters('<li>','</li>');
			$this->form_validation->set_rules('password', 'Password', 'required|matches[confirm_password]');
			
			if ($this->form_validation->run() == TRUE)
			{	
				 $config = array(
					'apikey' => '2363b91c22c27dd8ee135922e440c521-us4',      // Insert your api key
					'secure' => FALSE   // Optional (defaults to FALSE)
					);
				$this->load->library('MCAPI', $config, 'mail_chimp');
				
				$merge_vars = array('FNAME'=>$_POST['fname'], 'LNAME'=>$_POST['lname']);
				
				if($this->mail_chimp->listSubscribe('f1359f6fa2', $_POST['email'], $merge_vars, 'html',false)) {
					//echo "success";
				}
				
				
				
				$username = $_POST['email'];
				$password = $_POST['password'];
				$email = $_POST['email'];
				$additional_data = array(
					'first_name' => $_POST['fname'],
					'last_name' => $_POST['lname'],
					'phone' => $_POST['phone']
				);								
		//		$group = array('1'); // Sets user to admin. No need for array('1', '2') as user is always set to member by default

				if($this->ion_auth->register($username, $password, $email, $additional_data))
				{
					$data['results'] = "You've completed your registration.";
					$data['h1'] = $header['title'] = "Registration";
					$sidebar = $this->sidebar();
					$this->load->view('Header',$header);
					$this->load->view('Page',$data);
					$this->load->view('Sidebar',$sidebar);
					$this->load->view('Footer');
				}
				else
					$this->register(2);
			}
			
			else
				$this->register();
		}
		
		else
			redirect('register');
	}
	
	function send_message()
	{
		if(isset($_POST))
		{
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('subject', 'Subject', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('message', 'The Message', 'required');
			
			$this->form_validation->set_error_delimiters('<li>','</li>');
			
			if ($this->form_validation->run() == TRUE)
			{	
				$this->load->library('email');
				
				$config['protocol'] = 'smtp';
				$config['smtp_host'] = 'mymail.brinkster.com';
				$config['smtp_user'] = 'admin@swahilimusicsheet.com';
				$config['smtp_pass'] = 'immaculata';
				$config['smtp_port'] = '25';
				$config['mailtype'] = 'html';
				$config['wordwrap'] = TRUE;
				$config['charset']='utf-8';  
				$config['newline']="\r\n";  

				$this->email->initialize($config);

				$this->email->from('admin@swahilimusicsheet.com', 'Swahili Music Notes');
				$this->email->to('admin@swahilimusicsheet.com'); 
				
				
				$this->email->subject('Enquery!');
				$message = '<html><head></head><body>';
				$message .= 'Name: ' . $_POST['name'] . '<br><br>';
				$message .= 'E-mail: ' . $_POST['email'] . '<br><br>';
				if(isset($_POST['phone']))
					$message .= 'Phone: ' . $_POST['phone'] . '<br><br>';
				$message .= 'Subject: ' . $_POST['subject'] . '<br><br>';
				$message .= 'Message: '. $_POST['message'] . '<br><br>';
				$message .= '<strong>Administrator,<br>Swahili Music Notes</strong></body></html>';	
				$this->email->message($message);	

				if($this->email->send())
				{
					$data['results'] = "You're message has been sent.";
					
					$data['h1'] = $header['title'] = "Message Sent Successfully";
					$sidebar = $this->sidebar();
					$this->load->view('Header',$header);
					$this->load->view('Page',$data);
					$this->load->view('Sidebar',$sidebar);
					$this->load->view('Footer');
				}
				else
					$this->contact(2);
				
			}
			
			else
				$this->contact(2);
		}
		
		else
			redirect('contact/3');
	}
	
	
	function validate_email($email)
	{
		if ($this->ion_auth->email_check($email))	
		{
			$this->form_validation->set_message('validate_email', 'This Email is already taken, try another one please.');
			return FALSE;
		}	
		else
			return TRUE;
			
	}
	
	function activated()
	{
		$header = $this->gen_menu();
		$header['title'] = 'Successful Registration';
		
		$data['message'] = 'Your successfully activated your account. Now you can <a href = "login">login</a> and request a proforma invoice';
		
		$this->load->view('Header',$header);
		$this->load->view('general',$data);
		$this->load->view('Sidebar');
		$this->load->view('Footer');
	}
	
	function login($success = 0)
	{
		
		if($success == 1)
			$data['success'] = 'Incorrect Login Details';
		
		if($success == 2)
			$data['success'] = 'You have successfully logged out';
		
		if($success == 3)
			$data['success'] = 'You have successfully reset your password';
			
		else $data['success'] = '';
		
		//$header = $this->gen_menu();
		$data['h1']=$header['title'] = 'Login';
		$sidebar = $this->sidebar();
		$this->load->view('Header',$header);
		$this->load->view('login',$data);
		$this->load->view('Sidebar',$sidebar);
		$this->load->view('Footer');
	}
	
	function login_user()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == TRUE)
		{
			$identity = $_POST['email'];
			$password = $_POST['password'];
			$remember = false; // remember the user
			if($this->ion_auth->login($identity, $password, $remember))
			{
				if ($this->session->userdata('current_page')!='')
					redirect($this->session->userdata('current_page'));
				else
					redirect(base_url());
			}
			else
				redirect('login/1');
		}
		else
			$this->login();
	
	}
	
	function logout()
	{
		if($this->ion_auth->logout())
			redirect('login/2');
	}
	
	function suggest()
	{
		$return_array = array();
		$this->db->where('approved', 1);
		$this->db->like('jina_la_wimbo', $_GET['term']  );
		$results = $this->db->get('piano_uploaded_songs');
		//echo json_encode($this->db->last_query());
	
		foreach ($results->result() as $result){
			$temp['value'] = $result->jina_la_wimbo . ' - ' . $result->mtunzi;
			array_push ($return_array,$temp);
		}
		
		echo json_encode($return_array);
	}
	
	function find()
	{
		if(isset($_POST['search']))
		{
			

			//$this->db->where('approved',1);
			//$results = $this->db->get('piano_uploaded_songs');
			
			/*
			$this->db->select('piano_uploaded_songs.*, piano_composers.*');
			$this->db->from('piano_uploaded_songs');
			$this->db->where('approved',1);
			$this->db->like('jina_la_wimbo', $search_string[0] );
			$results = $this->db->join('piano_composers', 'piano_uploaded_songs.mtunzi = piano_composers.id');
			*/
			$query = "select songs.*, composers.*, songs.url as surl, composers.url as curl from piano_uploaded_songs as songs, piano_composers as composers where songs.jina_la_wimbo like '%" . $_POST['search'] . "%'  and approved = 1 and songs.mtunzi = composers.id";

			$search_string = explode(' ' , $_POST['search']); 
			
			
			
			foreach ($search_string as $string)
			{
				if(strlen($string) > 4)
				{
					
				$query .= " UNION select songs.*, composers.*, songs.url as surl, composers.url as curl from piano_uploaded_songs as songs, piano_composers as composers where songs.jina_la_wimbo like '%" . $string . "%'  and approved = 1 and songs.mtunzi = composers.id";
				break;
				}

				
			}
			
			$results = $this->db->query($query);
			
			//$header	= $this->gen_menu();
			$header['title'] = $data['h1'] = 'Search Results';
			$data['results'] = '';
			
			if($results->num_rows() == 0)
				$data['results'] = 'No songs matched your search term. Send a <a href = "request/search">Song Request Here</a>';
			
			foreach($results->result() as $result)
			{
				$data['results'] .= "<a href = 'song/" . $result->surl . "'>" . $result->jina_la_wimbo . "</a> - <a href = 'composer/" . $result->curl . "'>"  . $result->name . "</a><br><br>";
			}
			
			//$data['results'] = $this->db->last_query();
			
			
			$sidebar = $this->sidebar();
			$this->load->view('Header',$header);
			$this->load->view('Page',$data);
			$this->load->view('Sidebar',$sidebar);
			$this->load->view('Footer');
			
		}
	}
	
	function request($source,$success=0)
	{
		$this->db->where('url', 'song-request');
		$pages = $this->db->get('piano_pages');
		$page = $pages->row();
		$data['h1'] = $header['title'] = $page->title;
		$data['results'] = '<br><br>' . $page->text . '<br>';
		$data['source'] = $source;
		
		if($success == 1)
			$data['results'] .= '<p style = "color: red; font-weight: bold;">Your request was sent succesfully.</p>';
		if($success == 2)
			$data['results'] .= '<p style = "color: red; font-weight: bold;">Whoops, something went terribly wrong. Please try again.</p>';
			
		$sidebar = $this->sidebar();
		
		$this->load->view('Header',$header);
		$this->load->view('Request',$data);
		$this->load->view('Sidebar',$sidebar);
		$this->load->view('Footer');
	
	}
	
	function song_request()
	{
		if(isset($_POST))
		{
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('song', 'Subject', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			
			
			$this->form_validation->set_error_delimiters('<li>','</li>');
			
			if ($this->form_validation->run() == TRUE)
			{	
			
				$jina = $_POST['song'];
				if(isset($_POST['mtunzi']))
					if($_POST['mtunzi'] != '')
						$jina .= ' by ' . $_POST['mtunzi'];			
				
				$data = array (
					'jina_la_wimbo'=>$jina,
					'mwombaji' =>$_POST['name'],
					'email'=>$_POST['email'],
					'source'=>$_POST['source'],
	
				);
				
				if(isset($_POST['lyrics']))
					if($_POST['lyrics'] != '')
						$data['additional_details'] = $_POST['lyrics'];
						
				$this->db->insert('piano_requests',$data);
			
				
/*				$config['protocol'] = 'smtp';
				$config['smtp_host'] = 'mymail.brinkster.com';
				$config['smtp_user'] = 'admin@swahilimusicsheet.com';
				$config['smtp_pass'] = 'immaculata';
				$config['smtp_port'] = '25';
				$config['mailtype'] = 'html';
				$config['wordwrap'] = TRUE;
				$config['charset']='utf-8';  
				$config['newline']="\r\n";  

				$this->email->initialize($config);*/

				$this->load->library('email');
				$this->email->from('admin@swahilimusicsheet.com', 'Swahili Music Notes');
				$this->email->to('admin@swahilimusicsheet.com'); 
				
				
				$this->email->subject('Song Request!');
				$message = '<html><head></head><body>';
				$message .= 'Name: ' . $_POST['name'] . '<br><br>';
				$message .= 'E-mail: ' . $_POST['email'] . '<br><br>';
				if(isset($_POST['phone']))
					$message .= 'Phone: ' . $_POST['phone'] . '<br><br>';
				$message .= 'Song: ' . $_POST['song'] . '<br><br>';
				$message .= 'Lyrics: '. $_POST['lyrics'] . '<br><br>';
				$message .= 'mtunzi: ' . $_POST['mtunzi'] . '<br><br>';
				$message .= '<strong>Administrator,<br>Swahili Music Notes</strong></body></html>';	
				$this->email->message($message);	

				if($this->email->send())
				{
					$data['results'] = "You're message has been sent.";
					
					$data['h1'] = $header['title'] = "Message Sent Successfully";
					$sidebar = $this->sidebar();
					$this->load->view('Header',$header);
					$this->load->view('Page',$data);
					$this->load->view('Sidebar',$sidebar);
					$this->load->view('Footer');
				}
				else
					$this->request('email',2);
				
			}
			
			else
				$this->request('validation',2);
		}
		
		else
			redirect('request/post/3');
	}
	
	function sitemap()
	{
		$this->load->helper('file');
		
		
		$this->db->order_by('title');
		$categories=$this->db->get('piano_categories');
		
		$data['html'] = '';
	
		foreach ($categories->result() as $category)
		{
			$data['html'] .= '<h2 style = "float: left;"><a href = "category/' . $category->url . '">' . $category->title . '</a></h2><br><br>';
			
			$query = 'select songs.jina_la_wimbo jina, songs.mtunzi mtunzi, songs.url url from piano_uploaded_songs as songs, piano_songs_categories as cats where catID = ' . $category->id . ' and cats.songID = songs.id and songs.approved = 1';
			

			$songs=$this->db->query($query);
			
			foreach($songs->result() as $song)
			{
				$data['html'] .= '<h3 style = "font-size: 14px;margin-left: 7px;"><a title = "' . $category->title . '" href = "song/'. $song->url . '">' . $song->jina . '</a> - ' . $song->mtunzi .'</h3>';
				
			}
			$data['html'] .= '<br><Br>';

		}
		
		$data['html'] .= '<h2 style = "float: left;"><a href="blog">Swahili Music Notes Blog</a></h2><br><br>';
		$data['html'] .= '<h2 style = "float: left;"><a href="about">About Swahili Music Notes</a></h2><br><br>';
		$data['html'] .= '<h2 style = "float: left;"><a href="contact">Contact Us</a></h2><br><br>';
		$data['html'] .= '<h2 style = "float: left;"><a href="directory">Directory</a></h2><br><br>';
		$data['html'] .= '<h2 style = "float: left;"><a href="resources">Resources</a></h2><br><br>';

		
		$data['h1'] = $header['title'] = 'Swahili Music Notes Sitemap';
		$data['results'] = $data['html'];
		
		$sidebar = $this->sidebar();
		
		$this->load->view('Header',$header);
		$this->load->view('Page',$data);
		$this->load->view('Sidebar',$sidebar);
		$this->load->view('Footer');
		
	}
	
	function xml_sitemap()
	{
		$this->load->helper('file');
		
		$this->db->order_by('title');
		$categories=$this->db->get('piano_categories');
		
		$xml = '<?xml version="1.0" encoding="UTF-8"?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		

		$xml .= '<url><loc>' . base_url() . '</loc><lastmod>' . date('Y-m-d') . '</lastmod><changefreq>weekly</changefreq><priority>1</priority></url>';
		
		foreach ($categories->result() as $category)
		{
			
			$xml .= '<url><loc>' . base_url() . 'category/' . $category->url . '</loc><changefreq>weekly</changefreq><priority>.9</priority></url>';
			$query = 'select songs.jina_la_wimbo jina, songs.mtunzi, songs.url from piano_uploaded_songs as songs, piano_songs_categories as cats where catID = ' . $category->id . ' and cats.songID = songs.id and songs.approved = 1';
			
			$songs=$this->db->query($query);
			
			foreach($songs->result() as $song)
			{
				
				$xml .= '<url><loc>' . base_url() . 'song/' . $song->url . '</loc><changefreq>monthly</changefreq><priority>.8</priority></url>';
				
			}
				
		}
		
		$xml .= '<url><loc>' . base_url() . 'about</loc><priority>.7</priority></url>';
		$xml .= '<url><loc>' . base_url() . 'contact</loc><priority>.7</priority></url>';
		$xml .= '<url><loc>' . base_url() . 'directory</loc><priority>.7</priority></url>';
		$xml .= '<url><loc>' . base_url() . 'blog</loc><priority>.7</priority></url>';
		$xml .= '<url><loc>' . base_url() . 'resources</loc><priority>.7</priority></url>';
			
	
		$xml .= '</urlset>';
		
		if ( ! write_file('sitemap.xml', $xml))
		{
			 echo 'Unable to write the xml file';
		}
		else
		{
			echo 'xml Sitemap was updated';
			$this->pingGoogleSitemaps('http://www.swahilimusicsheet.com/sitemap.xml');
		}
	}
	
	function pingGoogleSitemaps( $url_xml )
	{
	   $status = 0;
	   $google = 'www.google.com';
	   if( $fp=@fsockopen($google, 80) )
	   {
		  $req =  'GET /webmasters/sitemaps/ping?sitemap=' .
				  urlencode( $url_xml ) . " HTTP/1.1\r\n" .
				  "Host: $google\r\n" .
				  "User-Agent: Mozilla/5.0 (compatible; " .
				  PHP_OS . ") PHP/" . PHP_VERSION . "\r\n" .
				  "Connection: Close\r\n\r\n";
		  fwrite( $fp, $req );
		  while( !feof($fp) )
		  {
			 if( @preg_match('~^HTTP/\d\.\d (\d+)~i', fgets($fp, 128), $m) )
			 {
				$status = intval( $m[1] );
				break;
			 }
		  }
		  fclose( $fp );
	   }
	   //return( $status );
	   echo $status;
	}
	
	function update_composers()
	{
		//$this->db->where('id',1);
		$datas = array();
		$composers = $this->db->get('piano_composers');
		//echo $composers->num_rows();
		
		
		
		foreach($composers->result() as $composer)
		{
			$this->db->where('mtunzi',$composer->name);
			$songs = $this->db->get('piano_uploaded_songs');
			foreach($songs->result() as $song)
			{
				$data = array(
					'id'=>$song->id,
					'mtunzi'=>$composer->id
				);
				$datas[]=$data;
			}
		}
			//$this->db->where('mtunzi',$composer->name);
		$this->db->update_batch('piano_uploaded_songs',$datas,'id');
	}
	
	function donations()
	{
		$this->db->order_by('transaction_type');
		$data['contributions'] = $this->db->get('piano_contributions_account');
		$header['title'] = $data['h1'] = 'Donations & Expenditures';
		$sidebar = $this->sidebar();
		$this->db->order_by('title');
		$data['categories']  = $this->db->get('piano_categories');
		$this->load->view('Header',$header);
		$this->load->view('Contributions',$data);
		$this->load->view('Sidebar',$sidebar);
		$this->load->view('Footer');
	}
	
	function newsletter()
	{
		$watunzi = array();
		$watunzi_object = $this->db->get('piano_composers');
		foreach($watunzi_object->result() as $mtunzi)
			$watunzi[$mtunzi->id] = $mtunzi->name;
		
		$data['watunzi'] = $watunzi;
	
		$this->db->limit(1);
		$newsletters = $this->db->get('piano_newsletter');
		$newsletter = $newsletters->row();
		$id = $newsletter->id;
		$data['title'] = $newsletter->subject;
		$data['special_message'] = $newsletter->special_messages;
		
		//echo $id;
		
		$this->db->where('newsletter',$id);
		$mwanzo = $this->db->get('piano_temp_mwanzo');
		
		
		
		$nyimbo_za_mwanzo = array();
		foreach($mwanzo->result() as $mwz)
			$nyimbo_za_mwanzo[] = $mwz->song;
		
		//print_r($nyimbo_za_mwanzo);
		
		$this->db->where_in('id',$nyimbo_za_mwanzo);
		$data['mwanzo'] = $this->db->get('piano_uploaded_songs');
		
		$this->db->where('newsletter',$id);
		$kati = $this->db->get('piano_temp_katikati');
		
		$nyimbo_za_kati = array();
		foreach($kati->result() as $kt)
			$nyimbo_za_kati[] = $kt->song;
		
		$this->db->where_in('id',$nyimbo_za_kati);
		$data['katikati'] = $this->db->get('piano_uploaded_songs');
		
		$this->db->where('newsletter',$id);
		$nyinginezo = $this->db->get('piano_temp_nyinginezo');
		
		$nyimbo_nyingine = array();
		foreach($nyinginezo->result() as $nyingine)
			$nyimbo_nyingine[] = $nyingine->song;
		
		$this->db->where_in('id',$nyimbo_nyingine);
		$data['nyinginezo'] = $this->db->get('piano_uploaded_songs');
		
		$this->db->where('newsletter',$id);
		$posts = $this->db->get('piano_temp_posts');
		
		$newsletter_posts = array();
		foreach($posts->result() as $post)
			$newsletter_posts[] = $post->article;
		
		$this->db->where_in('id',$newsletter_posts);
		$data['articles'] = $this->db->get('piano_pages');
		
		$this->db->order_by('jina_la_wimbo');
		$data['requests'] = $this->db->get('piano_requests');
		
		$this->load->view('Newsletter',$data);
		
	}
	
	function forgot($error='')
	{
		$header['title'] = $data['h1'] = 'Forgot Password';
		$sidebar = $this->sidebar();
		
		if($error != '')
			$data['message'] = $error;
		
		$this->load->view('Header',$header);
		$this->load->view('Forgot',$data);
		$this->load->view('Sidebar',$sidebar);
		$this->load->view('Footer');
	}
	
	function forgot_password()
	{
		$this->form_validation->set_rules('email', 'Email Address', 'required');
		if ($this->form_validation->run() == false) {
			//setup the input
			$this->data['email'] = array('name'    => 'email',
										 'id'      => 'email',
										);
			//set any errors and display the form
			$data['message'] = validation_errors();
			$this->forgot($data['message']);
		}
		else {
			//run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($this->input->post('email'));

			if ($forgotten) { //if there were no errors
				//$this->session->set_flashdata('message', $this->ion_auth->messages());
				$data['message'] = $this->ion_auth->messages();
				$this->forgot($data['message']);
				
				//redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else {
				//$this->session->set_flashdata('message', $this->ion_auth->errors());
				$data['message'] = $this->ion_auth->errors();
				$this->forgot($data['message']);
				//redirect("auth/forgot_password", 'refresh');
			}
		}
	}

	function reset_password($code,$error='')
	{
		
		if($error != '')
			$data['message'] = $error;
		
		$data['code'] = $code;
		
		$header['title'] = $data['h1'] = 'Reset my Password';
		$sidebar = $this->sidebar();
		$this->load->view('Header',$header);
		$this->load->view('Reset',$data);
		$this->load->view('Sidebar',$sidebar);
		$this->load->view('Footer');
	}
	
	function reset()
	{
		$this->form_validation->set_rules('password', 'Password', 'required|matches[confirm]');
			
		if ($this->form_validation->run() == TRUE)
		{	
		
			
			$this->db->where('forgotten_password_code',$_POST['code']);
			$users = $this->db->get('piano_backend_users');
			$user = $users->row();
			
			$data = array(
						'password' => $_POST['password']
						 );
				
			$this->db->where('user_email',$user->email);
			$oldies = $this->db->get('piano_users');
			
			if($oldies->num_rows() > 0)
			{
				$oldie = $oldies->row();
				$this->db->where('ID', $oldie->ID);
				$this->db->delete('piano_users');
			}
			//echo $this->db->last_query();
			//die();
			
			
			if($this->ion_auth->update($user->id, $data))
				$this->login(3);
		}
		else
			$this->reset_password($_POST['code'], validation_errors());
	}
	
	function report_song($id)
	{
		$this->db->where('id',$id);
		$song = $this->db->get('piano_uploaded_songs');
		
		$details = $song->row();
		
		$song_name = $details->jina_la_wimbo;
		
		$data['songID'] = $id;
		$data['song_name'] = $song_name;
		
		$header['title'] = $data['h1'] = "I want to report " . $song_name;
		$sidebar = $this->sidebar();
		$this->load->view('Header',$header);
		$this->load->view('Report',$data);
		$this->load->view('Sidebar',$sidebar);
		$this->load->view('Footer');
		
	}
	
	function send_report($id)
	{
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('message', 'Kasoro', 'required');
			
			
		$this->form_validation->set_error_delimiters('<li>','</li>');
		
		if ($this->form_validation->run() == TRUE)
		{
			$this->db->where('id',$id);
			$song = $this->db->get('piano_uploaded_songs');
			
			$details = $song->row();
			
			$header['title'] = $data['h1'] = "Report Sent";
			$sidebar = $this->sidebar();

			$this->load->library('email');
			$this->email->from('admin@swahilimusicsheet.com', 'Swahili Music Notes');
			$this->email->to('admin@swahilimusicsheet.com'); 
			
			
			$this->email->subject($_POST['subject']);
			$message = '<html><head></head><body>';
			$message .= 'Name: ' . $_POST['name'] . '<br><br>';
			$message .= 'E-mail: ' . $_POST['email'] . '<br><br>';
			if(isset($_POST['phone']))
				$message .= 'Phone: ' . $_POST['phone'] . '<br><br>';
			$message .= 'Song ID: ' . $id . '<br><br>';
			
			$message .= 'Message: ' . $_POST['message'] . '<br><br>';
			$message .= '<strong>Administrator,<br>Swahili Music Notes</strong></body></html>';	
			$this->email->message($message);	

			echo $message;
			
			die();
			
			if($this->email->send())
			{
				$data['results'] = "You're message has been sent.";
				
				$data['h1'] = $header['title'] = "Message Sent Successfully";
				$sidebar = $this->sidebar();
				$this->load->view('Header',$header);
				$this->load->view('Page',$data);
				$this->load->view('Sidebar',$sidebar);
				$this->load->view('Footer');
			}
			else
				$this->request('email',2);
			
		}
			
		else
			$this->request('validation',2);

	}
	
}