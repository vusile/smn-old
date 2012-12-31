  <section id="intro">
      <hgroup>
      <h1 style = 'color: #000;display: inline;'><?php echo $h1 ?></h1>&nbsp;&nbsp;&nbsp;&nbsp;<a>Home</a> > <?php echo $h1; ?>
	  
      </hgroup>

   </section>
   <!--end intro-->
   <!--start holder-->
   <div class="holder_content">
	<div style = 'clear: both; padding-top:20px;'></div>
	<?php 
		if($entries->num_rows() > 0){
		foreach ($entries->result() as $entry):
	?>	
	<h2 style = 'text-align: left;'><a href = 'page/<?php echo $entry->url ?>' ><?php echo $entry->title; ?></a></h2>
	<?php echo truncate(strip_tags($entry->text),300); ?><a href = 'page/<?php echo $entry->url ?>'>Read More</a>
	<br><br>
	<?php endforeach; 
		}
	?>
	<div style = 'clear: both; padding-top:20px;'></div>
	</div>