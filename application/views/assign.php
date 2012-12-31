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
							
			echo form_open ('action/reassign', $attributes);
				
			echo "<br><h1 style = 'clear: both;'>Reassign Songs by Composer</h1>";
				
	
			echo '<label>';
			echo '<span style = "color: red">* </span>';
			
			echo 'From : </label>';	
				
				
			$fromOptions = '';		
			$toOptions = '';		
						
			$fromOptions .= "<select  id = 'from' name = 'from'  >";
										
							
			$fromOptions .= "<option  value = '' >Select One</option>";	
			foreach ($composers->result() as $composer)
				$fromOptions .= "<option value = '" . $composer->id ."' >" . $composer->name . "</option>";	
			
			$fromOptions .= '</select><br />';
					
			echo $fromOptions;
			
			echo '<label>';
			echo '<span style = "color: red">* </span>';
			
			echo 'To : </label>';	
			$toOptions .= "<select  id = 'to' name = 'to'  >";
										
							
			$toOptions .= "<option  value = '' >Select One</option>";	
			foreach ($composers->result() as $composer)
				$toOptions .= "<option value = '" . $composer->id ."' >" . $composer->name . "</option>";	
			
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