<script>
	jQuery(document).ready(function(){
		jQuery("#form").validationEngine();
	});	
</script>
	<div style = "float: left; clear: none;"  id="stylized" class="myform">

		<?php
			$disabled = '';
			$select = '';
			
			echo validation_errors('<li class="validation_error">', '</li>'); 
			echo $this->upload->display_errors('<li class="validation_error">', '</li>');

			$attributes = array ('id'=>'form', 'name'=>'form');
			
			if($this->session->userdata($table_name . '_add')!='')
				echo form_open_multipart( $this->session->userdata($table_name . '_add'),$attributes);
				
			else
				echo form_open ('action/save/'.$table_name, $attributes);
				
			echo "<br><h1 style = 'clear: both;'>Adding to " . str_replace('_',' ',ucfirst($table_name)) . "</h1>";
			
	
			$fields = $this->db->list_fields($table_name);
			$ref_fields = array ();
			foreach ($rel as $col => $fields_list)
				$ref_fields[$col] = $fields_list->list_fields();

				foreach ($fields as $field)
				{
					if($this->session->userdata($table_name)!='')
					{
						$show_fields = explode(',',$this->session->userdata($table_name));
						if(!in_array($field,$show_fields) or $pk==$field or $field == 'spec_sheet')
							continue;
					}
					else
						$disabled = '';
						
					/*print_r($hide);
					die();*/
					if($pk==$field or $field == 'order_column' or $field == 'spec_sheet' or isset($additional_fields['hide_' . $field]))
						continue;
					
	
					echo '<label>';
					if(isset($validate[$field]))
					{
						$required = $validate[$field];
						echo '<span style = "color: red">* </span>';
					}
					
					else $required = '';
					echo str_replace('_',' ',ucfirst($field)) . ': </label>';

					
					if(isset($additional_fields[$field . '_hidden']))
						$hidden = $additional_fields[$field . '_hidden'];
					else
						$hidden = '';
					if(isset($additional_fields[$field]))
						echo $additional_fields[$field];
						
						
				
					else if(element($field, $referring))
					{
							
						$options = '';
						if(isset($additional_fields[$field . '_on_change']) and isset($additional_fields[$field . '_multiple']))
							$options .= "<select  ". $required . $hidden." id = '". $referring[$field] ."' name = '" . $referring[$field] . "' " . $additional_fields[$field . '_on_change'] . $additional_fields[$field . '_multiple'] . ">";
							
						else if (isset($additional_fields[$field . '_on_change']))
							$options .= "<select ". $required . $hidden." id = '". $referring[$field] ."' name = '" . $referring[$field] . "' " . $additional_fields[$field . '_on_change']  . ">";
						else if (isset($additional_fields[$field . '_multiple']))
						
							$options .= "<select " . $required . $hidden." id = '". $referring[$field] ."' name = '" . $referring[$field] . "' " . $additional_fields[$field . '_multiple']  . ">";

						else
							$options .= "<select " . $required. $hidden." id = '". $referring[$field] ."' name = '" . $referring[$field] . "'>";
							
						$options .= "<option  value = '' >Select One</option>";	
						foreach ($rel[$field]->result() as $referenced)
						{
							if($this->session->userdata($table_name . '_selected_'. $field)!='' and $this->session->userdata($table_name . '_selected_'. $field)==$referenced->id )
								$options .= "<option selected = 'selected' value = '" . $referenced->id ."' >" . $referenced->$ref_fields[$field][1] . "</option>";	
							else
								$options .= "<option  value = '" . $referenced->id ."' >" . $referenced->$ref_fields[$field][1] . "</option>";	
						}
						$options .= '</select><br />';
					
						echo $options;
					}
					else
					{
						$value = set_value($field);
						
						if($this->session->userdata($table_name . '_' . $field) != '')
							echo $this->session->userdata($table_name . '_' . $field) . '<br />';
						
						else if($type_info[$field] == 'text')
							echo "<textarea " . $required .$hidden." style='width: 400px; height: 300px' name = '$field' >".$value ."</textarea><br />";
						else if($type_info[$field] == 'tinyint')
							echo "<input " . $required  .   $hidden." type = 'checkbox' name = '$field' checked = 'checked' value='1' />";
						else	
							echo "<input " . $required .$hidden." type = 'text' $disabled id = '" . $field . "' name = '" . $field . "' value='" . $value ."' /><br />";
													
					}
					if(isset($additional_fields[$table_name . '_' . 'append_' . $field]))
						echo $additional_fields[$table_name . '_' . 'append_' . $field];
						
					if($this->session->userdata($table_name . '_' . 'append_' . $field) != '')
						echo $this->session->userdata($table_name . '_' . 'append_' . $field . '_label') . $this->session->userdata($table_name . '_' . 'append_' . $field);

					
					
					//echo '</div>';
					//echo '</div>';
					
				}
				

		?>
	

		<div class = 'row' style = 'width: 400px; margin: 0px auto;'>
		<div class = 'submit' >
		<button class = 'save' type = 'submit'>Save</button>
		<!--<input type = 'submit' class = 'submit' value = 'Save' />-->
		</div>
		<div class = 'reset'>
		<button type = 'reset'>Reset</button>
		<!--<input type = 'reset' value = 'Reset' />-->
		</div>
		</div>
		<!--</div>-->
		</form>
		</div>