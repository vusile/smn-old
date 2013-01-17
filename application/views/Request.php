 <section id="intro">
      <hgroup>
      <h1 style = 'color: #000;display: inline;'><?php echo $h1 ?></h1>&nbsp;&nbsp;&nbsp;&nbsp;<a>Home</a> > <?php echo $h1; ?>
	  <?php echo $results; ?>
      </hgroup>

   </section>

<div class="holder_content">
<?php 

$attributes = array ('id'=>'request', 'name'=>'request', 'class'=>"wufoo page", 'autocomplete'=>'off');
echo form_open ('song_request/', $attributes); 

?>
<ul style = 'list-style-type: none;'>

<li  class="notranslate      ">
<label class="desc" for="song">
Jina la Wimbo:
<span id="req_4" class="req">*</span>
</label>
<div>
<input id="song" name="song" type="text" spellcheck="false" class="field text medium validate[required]" value="<?php echo set_value('song'); ?>" maxlength="255" tabindex="1" /> 
</div>
</li>

<li class="notranslate      ">
<label class="desc" for="lyrics">
Maneno (kama unayafahamu):

</label>
<div>
<textarea name = 'lyrics' id = 'lyrics' class="field textarea medium"  tabindex="2" ><?php echo set_value('lyrics'); ?></textarea>
</div>
</li>

<li  class="notranslate      ">
<label class="desc" for="mtunzi">
Jina la Mtunzi:
</label>
<div>
<select id="mtunzi" name="mtunzi" tabindex="3">
<option value = "">Chagua Jina la Mtunzi</option>
<?php foreach($composers->result() as $composer): ?>
	<?php if($composer->id == 242) continue; ?>
	<option value = "<?php echo $composer->id ?>"><?php echo $composer->name ?></option>
<?php endforeach; ?>
</select>
</div>
</li>

<li  class="notranslate      ">
<label class="desc" for="mtunzi_mpya">
Jina la Mtunzi Halipo Hapo Juu:
</label>
<div>
<input id="mtunzi_mpya" name="mtunzi_mpya" type="text" spellcheck="false" class="field text medium" value="<?php echo set_value('mtunzi_mpya'); ?>" maxlength="255" tabindex="4" /> 
 
</div>
</li>

<li class="notranslate      ">
<label class="desc" for="name">
Name:
<span id="req_4" class="req">*</span>
</label>
<div>
<input id="name" name="name" type="text" spellcheck="false" class="field text medium validate[required] text-input" value="<?php echo set_value('name'); ?>" maxlength="255" tabindex="5" /> 

</div>
</li>


<li  class="notranslate      ">
<label class="desc" for="email">
Email:
<span id="req_1" class="req">*</span>
</label>
<div>
<input id="email" name="email" type="email" spellcheck="false" class="field text medium validate[custom[email]]" value="<?php echo set_value('email'); ?>" maxlength="255" tabindex="6" /> 
</div>
</li>

<li class="notranslate      ">
<label class="desc"  for="phone">
Phone Number:

</label>
<div>
<input id="phone" name="phone" type="text" spellcheck="false" class="field text medium text-input" value="<?php echo set_value('phone'); ?>" maxlength="255" tabindex="7" /> 
</div>
</li>

<li class="buttons ">
<div>

<input id="source" name="source" type="hidden" value="<?php echo $source; ?>"/>
<input id="saveForm" name="saveForm" class="btTxt submit" type="submit" value=" Send Request "/>
</div>
</li>

</ul>
</form> 
<div style = 'clear: both; padding-top:20px;'></div>
	</div>