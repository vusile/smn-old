<script>
	jQuery(document).ready(function(){
		jQuery("#form").validationEngine();
	});	
</script>

<div style = "float: left; clear: none;" id="stylized" class="myform">
		<?php
			$disabled = '';
			echo validation_errors('<li class="validation_error">', '</li>'); 
			echo $this->upload->display_errors('<li class="validation_error">', '</li>');

			$attributes = array ('id'=>'form', 'name'=>'form');
			
			if($this->session->userdata($table_name . '_edit')!='')
			{
				if(isset($id))
					echo form_open_multipart( str_replace('ID',$id,$this->session->userdata($table_name . '_edit')),$attributes);
				else
					echo form_open_multipart($this->session->userdata($table_name . '_edit'),$attributes);
			}
				
			else
				echo form_open ('action/update/' . $table_name .'/'.$id, $attributes);
			
			

			echo "<h1>Editing ". str_replace('_',' ',ucfirst($table_name)) . "</h1>";

			$fields = $query->list_fields();
			
			//print_r($fields);exit;
			$ref_fields = array ();
			foreach ($rel as $col => $fields_list)
				$ref_fields[$col] = $fields_list->list_fields();

			foreach ($query->result() as $item)
			{
				foreach ($fields as $field)
				{
					if($this->session->userdata($table_name)!='')
					{
						$show_fields = explode(',',$this->session->userdata($table_name));
						if(!in_array($field,$show_fields) or $pk==$field or $field == 'spec_sheet')
							continue;
					}
					else
					{

						$disabled = '';
						
					}	
					if($pk==$field or $field =='order_column' or $field == 'spec_sheet' or isset($additional_fields['hide_' . $field]))
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
						if(isset($additional_fields[$field . '_on_change']))
							$options .= "<select id = '". $required .  $referring[$field] ."' name = '" . $referring[$field] . "' " . $additional_fields[$field . '_on_change'] . ">";
						else
							$options .= "<select id = '". $required .  $referring[$field] ."' name = '" . $referring[$field] . "'>";
							
						$options .= "<option  value = '' >Select One</option>";	
						
						foreach ($rel[$field]->result() as $referenced)
						{
							if($item->$field == $referenced->id )
								$selected = 'selected';
							else
								$selected = '';
							
							if($field == 'uploaded_by')
								$options .= "<option $selected value = '" . $referenced->id ."' >" . $referenced->first_name . '</option>';
							else
								$options .= "<option $selected value = '" . $referenced->id ."' >" . $referenced->$ref_fields[$field][1] . '</option>';
						}
						$options .= '</select><br />';
						echo $options;
					}
					else
					{
						$value = $item->$field;
						
						if($this->session->userdata($table_name . '_' . $field . '_img') != '')
						{	
							if($value == '')
								echo "<p class = 'formlinks'>No Image</p>";
							else
								echo str_replace("IMG",$value,$this->session->userdata($table_name . '_' . $field .'_img') ) . '<br /><br />';
							if($this->session->userdata($table_name . '_' . $field) != '')
								echo '<label>Change ' . str_replace('_',' ',ucfirst($field)) . ':</label>' . $this->session->userdata($table_name . '_' . $field) . '<br />';
						}
						
						else if($type_info[$field] == 'text')
							echo "<textarea " .$required . " style='width: 400px; height: 300px' name = '$field' >".$value ."</textarea><br />";
						else if($type_info[$field] == 'tinyint')
						{
							if($value == 1)
								$chk = "checked='checked'";
							else
								$chk = '';
								
							echo "<input ". $required  ." type = 'checkbox' name = '$field' $chk  value='" . $value ."' />";
						}
						else
						{
						
							echo '<input '. $required . ' type = "text" ' . $disabled . ' id = "' . $field . '" name = "' . $field . '" value= "' . $value . '" /><br />';
							
						}

					}	
					
					if(isset($additional_fields[$table_name . '_' . 'append_' . $field]))
						echo $additional_fields[$table_name . '_' . 'append_' . $field];
						
					if($this->session->userdata($table_name . '_edit_append_' . $field) != '')
						echo ($this->session->userdata($table_name . '_edit_append_' . $field));
				}
			}
				
				
		?>
		<br>
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
		</form>
</div>