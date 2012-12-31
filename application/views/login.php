<section id="intro">
      <hgroup>
      <h1 style = 'color: #000;display: inline;'><?php echo $h1; ?></h1>&nbsp;&nbsp;&nbsp;&nbsp;<a href='<?php echo base_url(); ?>' >Home</a> > Login
	  <br>
	
      </hgroup>
   </section>
   <!--end intro-->
   <!--start holder-->
   <div class="holder_content">
	<div style = 'clear: both; padding-top:10px;'></div>

<?php 

$attributes = array ('id'=>'register', 'name'=>'register', 'class'=>"wufoo page", 'autocomplete'=>'off');
echo form_open ('login_user/', $attributes); 

?>
<span style = 'color: red; font-weight: bold;'><?php if(isset($success)) echo $success; ?></span>

<ul>


<li  class="notranslate      ">
<label class="desc" for="email">
Email:
<span id="req_1" class="req">*</span>
</label>
<div>
<input id="email" name="email" type="email" spellcheck="false" class="field text medium validate[custom[email]]" value="" maxlength="255" tabindex="4" /> 
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

<li class="buttons ">
<div>

<input id="saveForm" name="saveForm" class="btTxt submit" type="submit" value=" Login "
 /></div>
</li>

</ul>
<p>Did you forget your password? <a href = 'forgot'>Yes, I forgot my password</a></p>
<p>Don't have an account with us? > <a href = 'register'>Register Here</a></p>
</form> 
	               
	<div style = 'clear: both; padding-top:20px;'></div>
	</div>