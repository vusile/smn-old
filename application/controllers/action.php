<?php
class Action extends CI_Controller {
	
	function add($table)
	{
		$this->vedlib->add($table);
	}
	
	function save($table)
	{
		$this->vedlib->save($table);
	}
	
	function edit($table,$id)
	{
		$this->vedlib->edit($table,$id);
	}
	
	function update($table,$id)
	{
		$this->vedlib->update($table,$id);
	}
	
	function confirm($table,$id)
	{
		$this->vedlib->confirm($table,$id);
	}
	
	function delete($table,$pk,$id)
	{
		$this->vedlib->delete($table,$pk,$id);
	}
	
	function get_song_categories($id = 0)
	{
		$songs_categories_array = array();
		$category_select = '<select multiple = "multiple" name = "category[]" id = "category">';
		
		if($id != 0)
		{
			$this->db->where('songID',$id);
			$songs_categories = $this->db->get('piano_songs_categories');
			
			foreach ($songs_categories->result() as $songs_category)
			{
				$songs_categories_array[] = $songs_category->catID;
			}
		}
	
		$this->db->order_by('title');
		$categories=$this->db->get('piano_categories');
		
		foreach($categories->result() as $category)
		{
			if ($id != 0 and in_array($category->id,$songs_categories_array))
				$category_select .= '<option selected = "selected" value = "' . $category->id . '">' . $category->title . '</option>';
			else
				$category_select .= '<option value = "' . $category->id . '">' . $category->title . '</option>';
		}

		$category_select .= '</select>';		
		
		return $category_select;

	}
	
	///SONG UPLOAD
	
	function check_song_sheet()
	{
		if (isset($_FILES['image_au_PDF']) && !empty($_FILES['image_au_PDF']['name']))
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_song_sheet', 'Please upload song sheet');
			return FALSE;
		}
	}
	
	function upload_song_form()
	{
		$data = array();
		$data['category'] = $this->get_song_categories();
		$data['image_au_PDF'] = '<input class = "validate[required]" type = "file" id = "image_au_PDF" name = "image_au_PDF" />';
		$data['midi'] = '<input type = "file" id = "midi" name = "midi" />';
		
		$data['mtunzi'] = '<select name = "mtunzi" id = "mtunzi">';
		$data['mtunzi'] .= '<option value = "">Select One</option>';
		
		$this->db->order_by('name');
		$composers = $this->db->get('piano_composers');
		foreach($composers->result() as $composer)
			$data['mtunzi'] .= '<option value = "' . $composer->id . '">' . $composer->name . '</option>';
		$data['mtunzi'] .= '</select>';
		$data['hide_uploaded_by'] = '';
		$data['hide_response_to'] = '';
		$data['hide_approved'] = '';
		$data['hide_maelezo_ya_utunzi'] = '';
		$data['hide_url'] = '';
		$data['piano_uploaded_songs_append_mtunzi'] = '<label>Mtunzi hayupo kwenye list:</label> <input type ="checkbox" name ="mtunzi_mpya" id="mtunzi_mpya" value = "yes" onclick = "mtunziChecker()" />';
		$data['piano_uploaded_songs_append_mtunzi'] .= '<label>Mtunzi Mpya:<span class = "small">Tafadhali Andika Jina Zima la Mtunzi.</span></label> <input disabled="disabled" type ="text" name ="jina_mtunzi_mpya"  id ="jina_mtunzi_mpya"  />';
		$data['piano_uploaded_songs_append_mtunzi'] .= '<label>Maelezo ya Ziada:<span class = "small">Mfano: Andika "Harmony by Mr. XXX YYY".</span></label> <input type ="text" name ="maelezo_ya_utunzi"  id ="maelezo_ya_utunzi"  />';
		
		$this->session->set_userdata(array ('piano_uploaded_songs_add' => 'action/upload_song'));
		$this->vedlib->add('piano_uploaded_songs',$data);
	}
	
	
	///AD
	function new_ad()
	{
	
		$data['file'] = '<input type = "file" id = "file" name = "file" />';
		$data['image'] = '<input type = "file" id = "image" name = "image" multiple />';
		$this->session->set_userdata(array ('piano_ads_add' => 'action/save_ad'));
		
		$this->vedlib->add('piano_ads',$data);	
	
	}
	
	function edit_ad($table, $id)
	{
		$this->db->where('id',$id);
		$ads = $this->db->get('piano_ads');
		$ad = $ads->row();
		
		if($ad->file == '')
			$data['file'] = '<input type = "file" id = "file" name = "file" />';
		else
		{
			$data['piano_ads_append_file'] = '';
			$data['file'] = '<a href ="uploads/ads/' . $ad->file . '">View File</a>';
			$data['piano_ads_append_file'] .= '<label>Change File</label> <input type = "file" name = "file" id = "file" />';
		}
		if($ad->image == '')
			$data['image'] = '<input type = "file" id = "image" name = "image" />';
			
		else
		{	
			$data['piano_ads_append_image'] = '';
			$data['image'] = '<img src ="uploads/ads/' . $ad->image . '">';
			$data['piano_ads_append_image'] .= '<label>Change Image</label> <input type = "file" name = "image" id = "image" />';
		}

		$this->session->set_userdata(array ('piano_ads_edit' => 'action/save_ad/1/'.$id));
		$this->vedlib->edit('piano_ads',$id,$data);	
	
	}
	
	
	function save_ad($update = 0, $id=0)
	{
	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('copy', 'Ad Copy', 'required');
		$this->form_validation->set_rules('title', 'Ad Title', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			redirect('action/new_ad/fail/required');
		}
		
		else
		{
			$ad_data = array (
				'title' => $_POST['title'],
				'copy' => $_POST['copy'],
				'featured' => $_POST['featured'],
				'show' => $_POST['show']
			);
			
			if(!empty($_POST['url']))
				$ad_data['url'] = $_POST['url'];
				
			if(!empty($_POST['file_text']))
				$ad_data['file_text'] = $_POST['file_text'];
			
			if (!empty($_FILES['file']['name']))
			{
				// Specify configuration for File 1
				//$config['upload_path'] = '../uploads/files/';
				$config['upload_path'] = 'uploads/ads/';
				$config['allowed_types'] = 'gif|jpg|png';    
				
				// Initialize config for File 1
				$this->upload->initialize($config);
	 
				// Upload file 1
				if ($this->upload->do_upload('file'))
				{
					$data = $this->upload->data();
					$ad_data['file'] = $data['file_name'];
				}
				else
				{
					redirect('action/new_ad/fail/pdf/1');
					
				}
			}
			
			if (!empty($_FILES['image']['name']))
			{
				// Specify configuration for File 1
				//$config['upload_path'] = '../uploads/files/';
				$config['upload_path'] = 'uploads/ads/';
				$config['allowed_types'] = 'gif|jpg|png';    
				
				// Initialize config for File 1
				$this->upload->initialize($config);
	 
				// Upload file 1
				if ($this->upload->do_upload('image'))
				{
					$data = $this->upload->data();
					$ad_data['image'] = $data['file_name'];
				}
				else
				{
					redirect('action/new_ad/fail/pdf/2');
					
				}
			}
			
			if($update==1)
			{
				$this->db->where('id',$id);
				if($this->db->update('piano_ads',$ad_data))
					redirect('backend/view_piano_ads');
			}			
			else
				if($this->db->insert('piano_ads',$ad_data))
					redirect('backend/view_piano_ads');
			
		}
	}
	
	///END AD
	
	function upload_song ()
	{
		$theUser = $this->ion_auth->user()->row();
		$user = $theUser->id;
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('jina_la_wimbo', 'Jina la Wimbo', 'required');
		$this->form_validation->set_rules('category', 'Category', 'required');
		$this->form_validation->set_rules('image_au_PDF', 'Image au PDF', 'check_song_sheet');
		if(isset($_POST['mtunzi']))
			$this->form_validation->set_rules('mtunzi', 'Mtunzi', 'required');
		if(isset($_POST['jina_mtunzi_mpya']))
			$this->form_validation->set_rules('jina_mtunzi_mpya', 'Mtunzi', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->upload_song_form();
		}
	
		
		if(isset($_POST['mtunzi']))
		{
			
			$mtunzi = $_POST['mtunzi'];
			$this->db->where('id',$mtunzi);
			$watunzi = $this->db->get('piano_composers');
			$mtunzi_details = $watunzi->row();
			$mtunzi_name = $mtunzi_details->name;
		}
		else if(isset($_POST['jina_mtunzi_mpya']))
		{
			$jina_la_mtunzi_mpya = ucwords(strtolower($_POST['jina_mtunzi_mpya']));
			$composer_url = $this->convert_url('piano_composers', 'url', $_POST['jina_mtunzi_mpya'], $_POST['jina_mtunzi_mpya']);
			$composer_data = array(
				'name' => $jina_la_mtunzi_mpya,
				'url'=> $composer_url
			);
			
			$mtunzi_name = $jina_la_mtunzi_mpya;
			$this->db->insert('piano_composers',$composer_data);
			$mtunzi = $this->db->insert_id();
		}	
		if (!empty($_FILES['image_au_PDF']['name']))
        {
            // Specify configuration for File 1
            //$config['upload_path'] = '../uploads/files/';
            $config['upload_path'] = 'uploads/files/';
            $config['allowed_types'] = 'gif|jpg|png|pdf';    
			
            // Initialize config for File 1
            $this->upload->initialize($config);
 
            // Upload file 1
            if ($this->upload->do_upload('image_au_PDF'))
            {
                $data = $this->upload->data();
				$sheetname = $data['file_name'];
            }
            else
            {
				redirect('action/upload_song_form/fail/pdf');
                
            }
 
			if (!empty($_FILES['midi']['name']))
			{
				// Config for File 2 - can be completely different to file 1's config
				// or if you want to stick with config for file 1, do nothing!
				//$config2['upload_path'] = '../uploads/files/';
				$config2['upload_path'] = 'uploads/files/';
				$config2['allowed_types'] = '*';
				$this->upload->initialize($config2);

	 
				// Initialize the new config
	 
				// Upload the second file
				if ($this->upload->do_upload('midi'))
				{
					$data = $this->upload->data();
					$midiname = $data['file_name'];
				}
				else
				{
					redirect('action/upload_song_form/fail/midi');
				}
 
			}
			
			$url = $this->convert_url('piano_uploaded_songs', 'url', $_POST['jina_la_wimbo'],$mtunzi_name);
			
			
			
			$jina_la_wimbo = ucwords(strtolower($_POST['jina_la_wimbo']));
			
			$insert_data = array (
				'jina_la_wimbo'=> $jina_la_wimbo,
				'mtunzi'=>$mtunzi,
				'image_au_PDF'=>$sheetname,
				'uploaded_by'=>$user,
				'approved' => 0,
				'url' => $url
			);
			
			if($this->ion_auth->is_admin())
				$insert_data['approved'] = 1;
			
			
			if(isset($midiname))
				$insert_data['midi'] = $midiname;
				
			if(isset($_POST['lyrics']))
				$insert_data['lyrics'] = $_POST['lyrics'];
				
			if(isset($_POST['maelezo_ya_utunzi']))
				$insert_data['maelezo_ya_utunzi'] = $_POST['maelezo_ya_utunzi'];

			if(isset($_POST['date_of_composition']) and trim($_POST['date_of_composition']) != '')
				$insert_data['date_of_composition'] = date('Y-m-d',strtotime($_POST['date_of_composition']));		
			
			if(isset($_POST['place_of_composition']))
				$insert_data['place_of_composition'] =$_POST['place_of_composition'];
			
			if($this->db->insert('piano_uploaded_songs',$insert_data))
			{
				$id = $this->db->insert_id(); 
				$this->db->where('id',$user);
				$user_data = $this->db->get('piano_backend_users');
				
				$rows = array();
				foreach($_POST['category'] as $category)
				{
					$rows[] = array('songID' => $id, 'catID' => $category);
				}
				
				$this->db->insert_batch('piano_songs_categories', $rows);

				$user_info = $user_data->row();
			
				$user_name = $user_info->first_name;
				$user_email = $user_info->email;
				
			
				$this->load->library('email');
				
				$config['protocol'] = 'smtp';
				$config['smtp_host'] = 'mymail.brinkster.com';
				$config['smtp_user'] = 'admin@swahilimusicnotes.com';
				$config['smtp_pass'] = 'immaculata';
				$config['smtp_port'] = '25';
				$config['mailtype'] = 'html';
				$config['wordwrap'] = TRUE;
				$config['charset']='utf-8';  
				$config['newline']="\r\n";  

				$this->email->initialize($config);

				$this->email->from('admin@swahilimusicnotes.com', 'Swahili Music Notes');
				$this->email->to($user_email); 
				//$this->email->cc('admin@swahilimusicnotes.com'); 
				
				$this->email->subject('Umefanikiwa ku-upload wimbo!');
				$message = '<html><head></head><body>';
				$message .= 'Habari ndugu ' . $user_name . ',<br>Hii ni kukutaarifu kuwa umefanikiwa ku-upload wimbo wa ' . $_POST['jina_la_wimbo'] . '. Tafadhali subiri kidogo, wakati tunaupitia na kuhakikisha kuwa kila kitu kipo kamili.<br><br>';
				$message .= '<strong>Administrator,<br>Swahili Music Notes</strong></body></html>';	
				$this->email->message($message);	

				$this->email->send();
				
				//TO ADMIN
				
				$this->email->from('admin@swahilimusicnotes.com', 'Swahili Music Notes');
				$this->email->to('manotamjb@gmail.com'); 
				$this->email->cc('admin@swahilimusicnotes.com'); 
				

				$this->email->subject('Wimbo Unahitaji Review!');
				$message = '<html><head></head><body>';
				$message .= 'Habari ndugu Admin. Hii ni kukutaarifu kuwa wimbo <strong>' . $_POST['jina_la_wimbo'] . '</strong> umekuwa uploaded na <strong>'.$user_name.'</strong>. Tafadhali bofya link ifuatayo ili ku-review > <a href="' . base_url() . 'action/edit_song/piano_uploaded_songs/' . $id . '">Review</a></body></html>';
				
				$this->email->message($message);	

				$this->email->send();

				//echo $this->email->print_debugger();

				redirect('backend/view_uploaded_songs/0');
			}
        }	
	}
	
	function edit_composer($table,$id)
	{
		$data['hide_url'] = '';
		if($id != 0)
		{
			$this->db->where('id',$id);
			$composers = $this->db->get('piano_composers');
			$this->session->set_userdata(array ('piano_composers_edit' => 'action/save_composer/' . $id));
			
			$composer = $composers->row();
			$data['photo'] = '<img src = "' . base_url() . 'uploads/files/' . $composer->photo . '">';
			$data['piano_composers_append_photo'] = '<label>Change Photo</label> <input type = "file" name = "photo" id = "photo" />';
			$this->vedlib->edit($table,$id,$data);
		}
		
		else
		{
			$data['piano_composers_append_photo'] = '<label>Photo</label> <input type = "file" name = "photo" id = "photo" />';
			$this->vedlib->add($table,$data);
		}
	}
	
	function save_composer($id=0)
	{
		//$this->load->library('form_validation');
		//$this->form_validation->set_rules('name', 'Name', 'required');
		

			
		if (!empty($_FILES['photo']['name']))
        {
			
            // Specify configuration for File 1
            //$config['upload_path'] = '../uploads/files/';
            $config['upload_path'] = 'uploads/files/';
            $config['allowed_types'] = 'jpg|png|gif'; 
 
            // Initialize config for File 1
            $this->upload->initialize($config);
 
            // Upload file 1
            if ($this->upload->do_upload('photo'))
            {
				
                $data = $this->upload->data();
				$photoname = $data['file_name'];
				$source_image = 'uploads/files/' . $data['raw_name'] . $data['file_ext'];
				$upload_width = $data['image_width'];
				$upload_height = $data['image_height'];
				
				$this->load->library('image_moo');
				
				if($upload_width >= $upload_height and $upload_width > 200)				
					$this->image_moo->load($source_image)->resize(200,999999999999)->save($source_image,$overwrite=TRUE);
				else if($upload_width <= $upload_height and $upload_height > 266)
					$this->image_moo->load($source_image)->resize(999999999999,200)->save($source_image,$overwrite=TRUE);
            }
			
			else
			{
				$error = array('error' => $this->upload->display_errors());
				redirect('action/edit_song/' . $songID . '/fail/PDF');
			}	
        }
		
		
		$composer = ucwords(strtolower($_POST['name']));
		
		if($id==0)
			$url = $this->convert_url('piano_composers', 'url', $_POST['name'], $_POST['name']);
		
		$data = array (
			'name'=>$composer
		);
		
		if(isset($url))
			$data['url'] = $url;
		
		if(isset($photoname))
			$data['photo'] = $photoname;

		if(isset($_POST['email']))
			$data['email'] = $_POST['email'];
			
		if(isset($_POST['phone']))
			$data['phone'] = $_POST['phone'];		
			
		if(isset($_POST['details']))
			$data['details'] = $_POST['details'];		
			
		if(isset($_POST['jimbo']))
			$data['jimbo'] =$_POST['jimbo'];
		
		if (isset($_POST['parokia']))
			$data['parokia'] = $_POST['parokia'];		
			
		if (isset($_POST['user']))
			$data['user'] = $_POST['user'];
			
		if($id != 0)
		{
			$this->db->where('id',$id);
			if($this->db->update('piano_composers',$data))
				redirect('backend/view_composers');
		}
		
		else
		{
			if($this->db->insert('piano_composers',$data))
				redirect('backend/view_composers');
		}
		
	}
	
	function edit_song($table,$id)
	{
		$this->session->set_userdata(array ('piano_uploaded_songs_edit' => 'action/update_song/' . $id));	
		$data['category']=$this->get_song_categories($id);
		$this->db->where('songID',$id);
		$reasons = $this->db->get('piano_not_reviewed_reasons');
		
		$this->db->where('id',$id);
		$songs = $this->db->get('piano_uploaded_songs');
		
		$song = $songs->row();
		
		foreach($reasons->result() as $reason)
		{
			if($this->ion_auth->is_admin())
				$reason_not_reviewed = '<label>Sababu ya kuto-review:</label><textarea name = "reason">' . $reason->reason . '</textarea>';
			else
				$reason_not_reviewed = '<label>Sababu ya kuto-review:</label><p class = "formlinks">' . $reason->reason . '</p>';
		}
		
		if(!isset($reason_not_reviewed) and $this->ion_auth->is_admin())
			$reason_not_reviewed = '<label>Sababu ya kuto-review:</label><textarea name = "reason"></textarea>';
		
	
		if(isset($reason_not_reviewed))
			$data['piano_uploaded_songs_append_lyrics'] = $reason_not_reviewed;
		
		$data['image_au_PDF'] = '<a href = "' . base_url() . ' uploads/files/' . $song->image_au_PDF . '">Check PDF</a>';
		$data['piano_uploaded_songs_append_image_au_PDF'] = '<label>Change PDF</label> <input type = "file" name = "image_au_PDF" id = "image_au_PDF" />';
		if($song->midi != '')
		{
			$data['midi'] = '<a href = "' . base_url() . 'uploads/files/' . $song->midi . '">Listen to MIDI</a>';
			$data['piano_uploaded_songs_append_midi'] = '<label>Change Midi</label> <input type = "file" name = "midi" id = "midi" />';
			if($this->ion_auth->is_admin())
				$data['piano_uploaded_songs_append_midi'] .= '<label>Un-assign Midi</label> <a href = "action/unassign_midi/' . $id . '">Unassign</a>';
		}
		else
		{
			$data['hide_midi'] = '';
			$data['piano_uploaded_songs_append_image_au_PDF'] .= '<label>Upload Midi</label> <input type = "file" name = "midi" id = "midi" />';
			
		}	
		if(!$this->ion_auth->is_admin())
		{
			$data['hide_uploaded_by'] = '';
			$data['hide_approved'] = '';
			$data['hide_url'] = '';
		}
			
		$data['mtunzi'] = '<select name = "mtunzi" id = "mtunzi">';
		$data['mtunzi'] .= '<option value = "">Select One</option>';
		
		$this->db->order_by('name');
		$composers = $this->db->get('piano_composers');
		foreach($composers->result() as $composer)
		{
			if($composer->id == $song->mtunzi)
				$data['mtunzi'] .= '<option selected = "selected" value = "' . $composer->id . '">' . $composer->name . '</option>';
			else
				$data['mtunzi'] .= '<option value = "' . $composer->id . '">' . $composer->name . '</option>';
		}	
		
		$data['mtunzi'] .= '</select>';	
			
		$data['hide_maelezo_ya_utunzi'] = '';
		$data['piano_uploaded_songs_append_url'] = "<input type = 'hidden' name = 'current_status' value = '" . $song->approved . "' />";
		$data['piano_uploaded_songs_append_mtunzi'] = '<label>Maelezo ya Ziada:<span class = "small">Mfano: Andika "Harmony by Mr. XXX YYY".</span></label> <input type ="text" name ="maelezo_ya_utunzi"  id ="maelezo_ya_utunzi" ';
		if($song->maelezo_ya_utunzi != '')
			$data['piano_uploaded_songs_append_mtunzi'] .= 'value = "' . $song->maelezo_ya_utunzi . '" ';
		$data['piano_uploaded_songs_append_mtunzi'] .= '/>';
		
		$this->vedlib->edit($table,$id,$data);
	}
	
	function update_song($songID)
	{
	
		$user = $this->ion_auth->user()->row();
		$user = $user->id;
		
		$this->db->where('id',$songID);
		$uploaders=$this->db->get('piano_uploaded_songs');
		
		foreach($uploaders->result() as $uploader)
			$uploader_id = $uploader->uploaded_by;
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('jina_la_wimbo', 'Jina la Wimbo', 'required');
		$this->form_validation->set_rules('mtunzi', 'Mtunzi', 'required');
		$this->form_validation->set_rules('category[]', 'Category', 'required');
		

		if ($this->form_validation->run() == FALSE)
		{
			redirect('action/edit_song/' . $songID . '/fail/validation');
		}
	
		if (!empty($_FILES['image_au_PDF']['name']))
        {
			
            // Specify configuration for File 1
            //$config['upload_path'] = '../uploads/files/';
            $config['upload_path'] = 'uploads/files/';
            $config['allowed_types'] = 'jpg|pdf'; 
 
            // Initialize config for File 1
            $this->upload->initialize($config);
 
            // Upload file 1
            if ($this->upload->do_upload('image_au_PDF'))
            {
				
                $data = $this->upload->data();
				$sheetname = $data['file_name'];
            }
			
			else
			{
				$error = array('error' => $this->upload->display_errors());
				redirect('action/edit_song/' . $songID . '/fail/PDF');
			}	
        }
		
		if (!empty($_FILES['midi']['name']) and isset($_FILES['midi']['name']))
		{
			// Config for File 2 - can be completely different to file 1's config
			// or if you want to stick with config for file 1, do nothing!
			//$config2['upload_path'] = '../uploads/files/';
			$config2['upload_path'] = 'uploads/files/';
			$config2['allowed_types'] = '*';
			$this->upload->initialize($config2);
			
			// Initialize the new config
 
			// Upload the second file
			if ($this->upload->do_upload('midi'))
			{
				$data = $this->upload->data();
				$midiname = $data['file_name'];
			}
			else
			{
				
				redirect('action/edit_song/' . $songID . '/fail/midi');
				
			}
			

		}

		
		$jina_la_wimbo = ucwords(strtolower($_POST['jina_la_wimbo']));
		
		$update_data = array (
			'jina_la_wimbo'=>$jina_la_wimbo,
			'mtunzi'=>$_POST['mtunzi']
		);
		
		
		if(isset($_POST['approved']))
			$update_data['approved'] = $_POST['approved'];

		if(isset($_POST['maelezo_ya_utunzi']))
			$update_data['maelezo_ya_utunzi'] = $_POST['maelezo_ya_utunzi'];
			
		if(isset($_POST['date_of_composition']))
			if(trim($_POST['date_of_composition']) != '' or $_POST['date_of_composition'] != null)
				$update_data['date_of_composition'] = date('Y-m-d',strtotime($_POST['date_of_composition']));		
			
		if(isset($_POST['place_of_composition']))
			$update_data['place_of_composition'] =$_POST['place_of_composition'];
		
		if (isset($sheetname))
			$update_data['image_au_PDF'] = $sheetname;
		
		
		if(isset($midiname))
			$update_data['midi'] = $midiname;
			
		if(isset($_POST['lyrics']))
			$update_data['lyrics'] = $_POST['lyrics'];
			
		$this->db->where('id',$songID);

		if($this->db->update('piano_uploaded_songs',$update_data))
		{				
			$this->db->where('songID',$songID);
			$this->db->delete('piano_songs_categories');
			
			if($this->ion_auth->is_admin() and isset($_POST['reason']) and $_POST['reason'] != '')
			{
				$this->db->where('songID',$songID);
				$this->db->delete('piano_not_reviewed_reasons');
				$this->db->insert('piano_not_reviewed_reasons',array('songID'=>$songID, 'reason'=>$_POST['reason']));
			}
		
			$rows = array();
			foreach($_POST['category'] as $category)
			{
				$rows[] = array('songID' => $songID, 'catID' => $category);
			}
			
			$this->db->insert_batch('piano_songs_categories', $rows);			
			
			if(!$this->ion_auth->is_admin())
				$this->user_updated_song_email_to_admin($songID);
			else if($this->ion_auth->is_admin() and $_POST['approved'] == 1 and $_POST['current_status'] == 0)
				$this->admin_reviewed_song_email_to_user($songID,$uploader_id);
			else if($this->ion_auth->is_admin() and $_POST['approved'] == 0 and $_POST['reason'] != '')
				$this->admin_not_reviewed_song_email_to_user($songID,$uploader_id,$_POST['reason']);
			
				
			redirect('backend/view_uploaded_songs/0');
		}	
	}
	
	function user_updated_song_email_to_admin($songID)
	{
			$this->db->where('id',$songID);
			$songs = $this->db->get('piano_uploaded_songs');
			$song = $songs->row();
	
			$this->load->library('email');
			
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = 'mymail.brinkster.com';
			$config['smtp_user'] = 'admin@swahilimusicnotes.com';
			$config['smtp_pass'] = 'immaculata';
			$config['smtp_port'] = '25';
			$config['mailtype'] = 'html';
			$config['wordwrap'] = TRUE;
			$config['charset']='utf-8';  
			$config['newline']="\r\n";  

			$this->email->initialize($config);

			$this->email->from('admin@swahilimusicnotes.com', 'Swahili Music Notes');
			

			$this->email->subject('Wimbo umekuwa edited!');
				
			$message = '';
			$message .= '<html><head></head><body>';
			$message .= 'Wimbo';
			
			$message .= ' unaoitwa <b>' . ucfirst($_POST['jina_la_wimbo']) . '</b>';
			$message .= ' umekuwa "edited" na sasa uko live kwenye site.<br><br>Ili kuuona wimbo huo, tembelea ukurasa huu > <a href="' . base_url() . 'song/' . $song->url . '">' . ucfirst($_POST['jina_la_wimbo']) . '</a> <b><br><br>';
			$message .= 'Wako katika Kristu,<br><br>Vusile Terence Silonda,<br>Web Master,<br><a href="http://www.swahilimusicsheet.com">Swahili Music Notes</a></body></html>';

			$this->email->message($message);	
			$this->email->set_alt_message(strip_tags($message));
			$this->email->to('admin@swahilimusicnotes.com'); 
			$this->email->send();
			//$this->email->print_debugger();
			//die();
	}
	
	function admin_reviewed_song_email_to_user($songID,$user)
	{
		
		$this->db->where('id',$user);
		$user_data = $this->db->get('piano_backend_users');
		
		
		foreach ($user_data->result() as $user_info)
		{
			$user_name = $user_info->first_name . ' ' . $user_info->last_name;
			$user_email = $user_info->email;
		}
		
		
		$this->db->where('id',$songID);
		$songs = $this->db->get('piano_uploaded_songs');
		$song = $songs->row();
		
		
		$this->load->library('email');
		
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'mymail.brinkster.com';
		$config['smtp_user'] = 'admin@swahilimusicnotes.com';
		$config['smtp_pass'] = 'immaculata';
		$config['smtp_port'] = '25';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;
		$config['charset']='utf-8';  
		$config['newline']="\r\n";  

		$this->email->initialize($config);

		$this->email->from('admin@swahilimusicnotes.com', 'Swahili Music Notes');
		
		//$this->email->cc('admin@swahilimusicnotes.com'); 
		

		$this->email->subject('Wimbo umekuwa reviewed!');
			
		$message = '';
		$message .= '<html><head></head><body>';
		$message .= 'Ndugu ' . $user_name . '<br><br>';
		
		$message .= 'Wimbo unaoitwa <b>' . ucfirst($_POST['jina_la_wimbo']) . '</b>';
		$message .= ' umekuwa "Reviewed" na sasa uko live kwenye site.<br><br>Ili kuuona wimbo huo, tembelea ukurasa huu > <a href="' . base_url() . 'song/' . $song->url . '">' . ucfirst($_POST['jina_la_wimbo']) . '</a> <b><br><br>';
		$message .= 'Wako katika Kristu,<br><br>Vusile Terence Silonda,<br>Web Master,<br><a href="' . base_url() . '">Swahili Music Notes</a></body></html>';

		$this->email->message($message);	
		$this->email->set_alt_message(strip_tags($message));
		$this->email->to($user_email); 
		$this->email->send();
		//$this->email->print_debugger();
		//die();
	}
	
	function admin_not_reviewed_song_email_to_user($songID,$user,$msg)
	{
		
		$this->db->where('id',$user);
		$user_data = $this->db->get('piano_backend_users');
		
		foreach ($user_data->result() as $user_info)
		{
			$user_name = $user_info->first_name . ' ' . $user_info->last_name ;
			$user_email = $user_info->email;
		}
		
		$this->load->library('email');
		
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'mymail.brinkster.com';
		$config['smtp_user'] = 'admin@swahilimusicnotes.com';
		$config['smtp_pass'] = 'immaculata';
		$config['smtp_port'] = '25';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;
		$config['charset']='utf-8';  
		$config['newline']="\r\n";  

		$this->email->initialize($config);

		$this->email->from('admin@swahilimusicnotes.com', 'Swahili Music Notes');
		
		$this->email->cc('admin@swahilimusicnotes.com'); 
		

		$this->email->subject('Wimbo HAUJAWA reviewed!');
			
		$message = '';
		$message .= '<html><head></head><body>';
		$message .= 'Ndugu ' . $user_name . '<br><br>';
		
		$message .= 'Pole sana, wimbo unaoitwa <b>' . ucfirst($_POST['jina_la_wimbo']) . '</b>';
		$message .= ' haujawa "Reviewed". Sababu ya kuto-review ni: ' . $msg ;
		$message .= '<br><br>';
		$message .= 'Wako katika Kristu,<br><br>Vusile Terence Silonda,<br>Web Master,<br><a href="http://www.swahilimusicsheet.com">Swahili Music Notes</a></body></html>';

		$this->email->message($message);	
		$this->email->set_alt_message(strip_tags($message));
		$this->email->to($user_email); 
		$this->email->send();
		//$this->email->print_debugger();
		//die();
	}
	
	function unassign_midi($id)
	{
		$this->db->query('update piano_uploaded_songs set midi = NULL where id = ' . $id);
		redirect('action/edit_song/piano_uploaded_songs/' . $id);
		
	}

	function register_user()
	{
		/*$username = 'jj';
		$password = '123456';
		$email = 'jj@gmail.com';
		$additional_data = array(
								'first_name' => 'Jj',
								'last_name' => 'Okocha',
								);								
		//$group = array('1'); // Sets user to admin. No need for array('1', '2') as user is always set to member by default

		if($this->ion_auth->register($username, $password, $email, $additional_data, $group))
			echo "Success";
		else
			echo "Failure";*/
			
		//$this->db->where('ID',1);
		$this->db->where('ID > ',154);
		$users = $this->db->get('piano_users');
		
		foreach($users->result() as $user)
		{
			$i=0;
			$this->db->where('user_id',$user->ID);
			$this->db->where_in('meta_key',array('first_name','last_name'));
			//$this->db->where('meta_key','last_name');
			$usermeta = $this->db->get('piano_usermeta');
			foreach($usermeta->result() as $um)
			{	
				if($i==0)
					$first_name = $um->meta_value;
				else
					$last_name = $um->meta_value;
				$i++;
			}
			
			$username = $user->user_login;
			$password = $user->user_pass;
			$email = $user->user_email;
			$additional_data = array(
									'first_name' => $first_name,
									'last_name' => $last_name
									);								
			//$group = array('1'); // Sets user to admin. No need for array('1', '2') as user is always set to member by default

			if($this->ion_auth->register($username, $password, $email, $additional_data))
				echo  $first_name . " " . $last_name . " was Successfully Registered";
			else
				echo "Unfortunately, while registering " . $first_name . " " . $last_name . ", an error occured" ;
		}
		
			
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
		
		$cleanurl = $this->check_clean_url($table,$column,$cleanurl,$composer);
		
		return $cleanurl;
			
		
	}
	
	function check_clean_url($table,$field,$cleanurl,$composer)
	{
		$this->db->where($field,$cleanurl);
		$cleancheck = $this->db->get($table);
		
		if($cleancheck->num_rows() == 0)
		{
			return $cleanurl;
		}
		else
		{

			$cleanurl = $cleanurl . '-' . $this->convert_url($table, $field, $composer,$composer);
			return $cleanurl;
		}
	}
	
	function temp()
	{
	
		$this->db->where('id > ', 155);
		$this->db->limit(20);
		$songs = $this->db->get('piano_composers');
		$urls = array();
		
		foreach($songs->result() as $song)
		{
			$url = $this->convert_url('piano_composers', 'url', $song->name,$song->id);
			$urls[] = array('id' => $song->id, 'url'=>$url);
		}	
		
		//print_r($urls);
		
		$this->db->update_batch('piano_composers', $urls, 'id');
	}
	
	function reassign()
	{
		$data = array('mtunzi'=>$_POST['to']);
		$this->db->where('mtunzi',$_POST['from']);
		if($this->db->update('piano_uploaded_songs',$data))
			redirect('backend/reassign_form');
	}	
	
	function associate()
	{
		$data = array('user'=>$_POST['user']);
		$this->db->where('id',$_POST['composer']);
		if($this->db->update('piano_composers',$data))
			redirect('backend/associate_form');
	}
	
	
		
}