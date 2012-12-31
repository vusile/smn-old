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
	<div style = 'float:left; clear: none; width: 210px' >
	<?php if (isset($composer->photo) and $composer->photo!=''):?>
		<img src = 'uploads/files/<?php echo $composer->photo; ?>' alt = '<?php echo $composer->name; ?>' title = '<?php echo $composer->name; ?>' />
	<?php endif; ?>
	</div>
	<div style = 'float:left; clear: none; margin-left: 5px; width:520px;'>
	<?php if (isset($composer->phone) and $composer->phone!=''):?>
		<strong>Phone:</strong> <?php echo $composer->phone; ?>
	<?php endif; ?>
	<?php if (isset($composer->details) and $composer->details!=''):?>
		<br><br><strong>Maelezo:</strong> <?php echo $composer->details; ?>
	<?php endif; ?>
	
	<?php if (isset($composer->jimbo) and $composer->jimbo!=''):?>
		<br><strong>Jimbo:</strong> <?php echo $composer->jimbo; ?><br>
	<?php endif; ?>
	<?php if (isset($composer->parokia) and $composer->parokia!=''):?>
		<br><strong>Parokia:</strong> <?php echo $composer->parokia; ?>
	<?php endif; ?>
	</div>
	<div style = 'clear: both; padding-top:10px;'></div>
	<?php 
		$a_z = range('A','Z'); 
		foreach ($a_z as $letter)
		echo "<a href = '" . current_url() . "#$letter'>$letter</a> &nbsp;&nbsp;";
	?>
 <Br>
	<div style = 'clear: both; padding-top:10px;'></div>
	
	<?php
		$current_char = '';
		foreach ($songs->result() as $song) {
			if ($song->first_char != $current_char) {
				$current_char = $song->first_char;
				echo '<br /><strong><a name = "' . strtoupper($current_char) . '" >' . strtoupper($current_char) . '</a></strong><br />-----<br />';
			}
		$id = base64_encode($song->id);
			echo "<h2 style = 'display:inline; font-size: 14px; text-align: left; font-weight: normal;'><a href = 'song/" . $song->url . "'>" . $song->jina_la_wimbo . "</a> - " . $song->name . "</h2>";
		  
		if($song->midi != '')
			  echo " <img  src = 'images/midiicon.png' />";
		 if($song->lyrics != '')
			  echo "&nbsp;<img  src = 'images/lyrics.png' />";     
		   echo " <br />";
		}  
	?>
	

	
	
	<div style = 'clear: both; padding-top:20px;'></div>
	</div>