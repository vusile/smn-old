<section id="intro">
      <hgroup>
      <h1 style = 'color: #000;display: inline;'><?php echo $h1; ?></h1>&nbsp;&nbsp;&nbsp;&nbsp;<a href='<?php echo base_url(); ?>' >Home</a> > Forgot Password
	  <br>
	
      </hgroup>
   </section>
   <!--end intro-->
   <!--start holder-->
   <div class="holder_content">
	<div style = 'clear: both; padding-top:10px;'></div>

<?php 

$attributes = array ('id'=>'register', 'name'=>'register', 'class'=>"wufoo page", 'autocomplete'=>'off');
echo form_open ('reset/', $attributes); 

?>
<span style = 'color: red; font-weight: bold;'><?php if(isset($message)) echo $message; ?></span>

<ul>


<li  class="notranslate      ">
<label class="desc" for="password">
New Password:
<span id="req_1" class="req">*</span>
</label>
<div>
<input id="password" name="password" type="password" spellcheck="false" class="field text medium " value="" maxlength="255" tabindex="1" /> 
</div>
</li>

<li  class="notranslate      ">
<label class="desc" for="password">
Confirm New Password:
<span id="req_1" class="req">*</span>
</label>
<div>
<input id="confirm" name="confirm" type="password" spellcheck="false" class="field text medium " value="" maxlength="255" tabindex="2" /> 
</div>
</li>

<input id="code" name="code" type="hidden" spellcheck="false" class="field text medium " value="<?php echo $code ?>" maxlength="255" tabindex="2" /> 
<li class="buttons ">
<div>

<input id="saveForm" name="saveForm" class="btTxt submit" type="submit" value=" Reset Password "
 /></div>
</li>

</ul>

</form> 
	               
	<div style = 'clear: both; padding-top:20px;'></div>
	</div>