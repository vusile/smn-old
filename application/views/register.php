<script>   
		jQuery(document).ready(function(){
			jQuery("#register").validationEngine();
		});
</script>
<section id="intro">
      <hgroup>
      <h1 style = 'color: #000;display: inline;'><?php echo $h1; ?></h1>&nbsp;&nbsp;&nbsp;&nbsp;<a href='<?php echo base_url(); ?>' >Home</a> > Register
	  <br>
	
      </hgroup>
   </section>
   <!--end intro-->
   <!--start holder-->
   <div class="holder_content">
	<div style = 'clear: both; padding-top:10px;'></div>
<span class="message"><?php if(strlen(validation_errors()!='')) echo 'You were not registered because of:' .  validation_errors(); ?></span>
<?php 

$attributes = array ('id'=>'register', 'name'=>'register', 'class'=>"wufoo page", 'autocomplete'=>'off');
echo form_open ('register_user/', $attributes); 

?>
<span class = "message"><?php if(isset($success)) echo $success; ?></span>

<ul>

<li class="notranslate      ">
<label class="desc" for="fname">
First Name:
<span id="req_4" class="req">*</span>
</label>
<div>
<input id="fname" name="fname" type="text" spellcheck="false" class="field text medium validate[required] text-input" value="<?php echo set_value('fname'); ?>" maxlength="255" tabindex="1" /> 

</div>
</li>

<li class="notranslate      ">
<label class="desc" for="lname">
Last Name:
<span id="req_4" class="req">*</span>
</label>
<div>
<input id="lname" name="lname" type="text" spellcheck="false" class="field text medium validate[required] text-input" value="<?php echo set_value('lname'); ?>" maxlength="255" tabindex="2" /> 

</div>
</li>

<li  class="notranslate      ">
<label class="desc" for="email">
Email:
<span id="req_1" class="req">*</span>
</label>
<div>
<input id="email" name="email" type="email" spellcheck="false" class="field text medium validate[custom[email]]" value="<?php echo set_value('email'); ?>" maxlength="255" tabindex="4" /> 
</div>
</li>
<li class="notranslate      ">
<label class="desc" for="confirm_email">
Confirm Email:
<span id="req_1" class="req">*</span>
</label>
<div>
<input id="confirm_email" name="confirm_email" type="email" spellcheck="false" class="field text medium validate[custom[email]],equals[email]" value="<?php echo set_value('confirm_email'); ?>" maxlength="255" tabindex="5" /> 
</div>
</li>
<li class="notranslate      ">
<label class="desc"  for="phone">
Phone Number:
<span id="req_4" class="req">*</span>
</label>
<div>
<input id="phone" name="phone" type="text" spellcheck="false" class="field text medium validate[required] text-input" value="<?php echo set_value('phone'); ?>" maxlength="255" tabindex="6" /> 
</div>
</li>
<li  class="notranslate      ">
<label class="desc" for="password">
Password:
<span id="req_4" class="req">*</span>
</label>
<div>
<input id="password" name="password" type="password" spellcheck="false" class="field text medium validate[required]" value="" maxlength="255" tabindex="7" /> 
</div>
</li>
<li class="notranslate      ">
<label class="desc" for="confirm_password">
Confirm Password:
<span id="req_1" class="req">*</span>
</label>
<div>
<input id="confirm_password" name="confirm_password" type="password" spellcheck="false" class="field text medium validate[required],equals[password]" value="" maxlength="255" tabindex="8" /> 
</div>
</li>
<li  
class="notranslate altInstruct     "><label class="desc"  for="captcha">
Captcha:
<span id="req_1" class="req">*</span>
</label>
<p class="instruct" id="instruct1"><small>Enter the text in the box below (Case Sensitive)</small></p>
<p class="instruct" id="instruct1"><?php echo $cap['image']; ?></p><br />

<div>
<input id="captcha" name="captcha" type="text" spellcheck="false" class="field text medium, validate[required]" value="" maxlength="255" tabindex="9" /> 

</div>

</li>
<li class="buttons ">
<div>

<input id="saveForm" name="saveForm" class="btTxt submit" type="submit" value=" Register "
 /></div>
</li>

</ul>
</form> 
<div style = 'clear: both; padding-top:20px;'></div>
	</div>
	               
