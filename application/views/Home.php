	 <section id="intro">
		
      <hgroup>
      <h1><?php echo $h1; ?></h1>
		<p style = 'font-size: 14px;'> <?php echo $intro; ?></p>
      </hgroup>
	</section>
<div class="holder_content">
	<div style = 'clear: both; padding-top:30px;'></div>
	
	
	<?php
		$i = 1;
		$j = 0;
		foreach($categories->result() as $category): 
	?>
		<section class="group<?php echo $i; ?>">
			<h2 style = 'font-size:14px; font-weight: normal;'><a href = 'category/<?php echo $category->url ?>'><?php echo $category->title ?> (<?php echo $category->count ?>)</a></h2>
			<a class="photo_hover3" href="category/<?php echo $category->url ?>"><img src="images/<?php echo $category->image ?>" width="145" height="100" alt="<?php echo $category->title;  ?>"/></a>
		</section>
	<?php 
		if($i == 1)
		{
			$i++;
		}
		$j++;
		
		if($j==4):
	?>
		<div style = 'clear: both; padding-top:10px;'></div>
	<?php
		$j=0;
		$i=1;
		endif;	
		endforeach; 
	?>
      
	<div style = 'clear: both; padding-top:20px;'></div>
	</div>
