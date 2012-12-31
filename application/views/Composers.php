<?php

$this->session->set_userdata(array ('current_page' => uri_string()));
$this->session->set_userdata(array ('current_page_title' => $h1));


?>
<section id="intro">
      <hgroup>
      <h1 style = 'color: #000;display: inline;'><?php echo $h1; ?></h1>&nbsp;&nbsp;&nbsp;&nbsp;<a href = '<?php echo base_url(); ?>'>Home</a> > <?php echo $h1; ?>&nbsp;&nbsp;&nbsp;&nbsp;

	  <form style = 'display: inline; '>
		<select name = 'categories' id = 'categories' onchange="goToCategory(this.value)">
			<option value = ''>-- Change Category --</option>
			<?php foreach ($categories->result() as $category): ?>
				<option value = '<?php echo $category->url; ?>'><?php echo $category->title; ?></option>
			<?php endforeach; ?>
		</select>
	  </form>
	  <br>
	  <!--<a name="fb_share" style = ></a> 
<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" 
        type="text/javascript">
</script>-->
	<p><!--Intro Text--></p>
      </hgroup>
   </section>
   <!--end intro-->
   <!--start holder-->
   <div class="holder_content">
	<div style = 'clear: both; padding-top:10px;'></div>
	<?php 
		$a_z = range('A','Z'); 
		foreach ($a_z as $letter)
		echo "<a href = '" . current_url() . "#$letter'>$letter</a> &nbsp;&nbsp;";
	?>
 
	<div style = 'clear: both; padding-top:10px;'></div>
	
	<?php
		$current_char = '';
		foreach ($composers->result() as $composer) {
			if ($composer->first_char != $current_char) {
				$current_char = $composer->first_char;
				echo '<br /><strong><a name = "' . strtoupper($current_char) . '" >' . strtoupper($current_char) . '</a></strong><br />-----<br />';
			}
		
		echo "<h2 style = 'font-size: 14px; text-align: left; font-weight: normal;'><a href = 'composer/" . $composer->url . "'>" . $composer->name . " (" . $composer->counts . ")</a></h2>";
		  
		}  
	?>
	

	
	
	<div style = 'clear: both; padding-top:20px;'></div>
	</div>