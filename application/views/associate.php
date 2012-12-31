<script>
	jQuery(document).ready(function(){
		jQuery("#form").validationEngine();
	});	
</script>
	<div style = "float: left; clear: none;"  id="stylized" class="myform">

		<?php

			
			echo validation_errors('<li class="validation_error">', '</li>'); 
			echo $this->upload->display_errors('<li class="validation_error">', '</li>');

			$attributes = array ('id'=>'form', 'name'=>'form');
							
			echo form_open ('action/associate', $attributes);
				
			echo "<br><h1 style = 'clear: both;'>Associate Composer and Uploader</h1>";
				
	
			echo '<label>';
			echo '<span style = "color: red">* </span>';
			
			echo 'Composer : </label>';	
				
				
			$fromOptions = '';		
			$toOptions = '';		
						
			$fromOptions .= "<select  id = 'composer' name = 'composer'  >";
										
							
			$fromOptions .= "<option  value = '' >Select One</option>";	
			foreach ($composers->result() as $composer)
				$fromOptions .= "<option value = '" . $composer->id ."' >" . $composer->name . "</option>";	
			
			$fromOptions .= '</select><br />';
					
			echo $fromOptions;
			
			echo '<label>';
			echo '<span style = "color: red">* </span>';
			
			echo 'User : </label>';	
			$toOptions .= "<select  id = 'user' name = 'user'  >";
										
							
			$toOptions .= "<option  value = '' >Select One</option>";	
			foreach ($users->result() as $user)
				$toOptions .= "<option value = '" . $user->id ."' >" . $user->first_name . ' ' . $user->last_name .  "</option>";	
			
			$toOptions .= '</select><br />';
					
			echo $toOptions;
				

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