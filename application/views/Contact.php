 <section id="intro">
      <hgroup>
      <h1 style = 'color: #000;display: inline;'><?php echo $h1 ?></h1>&nbsp;&nbsp;&nbsp;&nbsp;<a>Home</a> > <?php echo $h1; ?>
	  <?php echo $results; ?>
      </hgroup>

   </section>

<div class="holder_content">
<?php 

$attributes = array ('id'=>'register', 'name'=>'register', 'class'=>"wufoo page", 'autocomplete'=>'off');
echo form_open ('send_message/', $attributes); 

?>
<ul style = 'list-style-type: none;'>
<li class="notranslate      ">
<label class="desc" for="name">
Name:
<span id="req_4" class="req">*</span>
</label>
<div>
<input id="name" name="name" type="text" spellcheck="false" class="field text medium validate[required] text-input" value="<?php echo set_value('name'); ?>" maxlength="255" tabindex="1" /> 

</div>
</li>


<li  class="notranslate      ">
<label class="desc" for="email">
Email:
<span id="req_1" class="req">*</span>
</label>
<div>
<input id="email" name="email" type="email" spellcheck="false" class="field text medium validate[custom[email]]" value="<?php echo set_value('email'); ?>" maxlength="255" tabindex="2" /> 
</div>
</li>

<li class="notranslate      ">
<label class="desc"  for="phone">
Phone Number:

</label>
<div>
<input id="phone" name="phone" type="text" spellcheck="false" class="field text medium text-input" value="<?php echo set_value('phone'); ?>" maxlength="255" tabindex="3" /> 
</div>
</li>
<li  class="notranslate      ">
<label class="desc" for="subject">
Subject:
<span id="req_4" class="req">*</span>
</label>
<div>
<input id="subject" name="subject" type="text" spellcheck="false" class="field text medium validate[required]" value="" maxlength="255" tabindex="4" /> 
</div>
</li>

<li class="notranslate      ">
<label class="desc" for="message">
Message:
<span id="req_1" class="req">*</span>
</label>
<div>
<textarea name = 'message' id = 'message' class="field textarea medium validate[required]"  tabindex="5" ></textarea>
</div>
</li>

<li class="buttons ">
<div>

<input id="saveForm" name="saveForm" class="btTxt submit" type="submit" value=" Send Message "
 /></div>
</li>

</ul>
</form> 
<div style = 'clear: both; padding-top:20px;'></div>
	</div>