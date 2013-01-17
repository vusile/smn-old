<section id="intro">
      <hgroup>
      <h1 style = 'color: #000;display: inline;'><?php echo $h1; ?></h1>&nbsp;&nbsp;&nbsp;&nbsp;<a href = '<?php echo base_url(); ?>'>Home</a> > <a href = 'category/<?php echo $crumb_category_url;?>'><?php echo $crumb_category_title ?></a> > <?php echo $song_title; ?>&nbsp;&nbsp;&nbsp;&nbsp;
	   <form style = 'display: inline; '>
		<select name = 'categories' id = 'categories' onchange="goToCategory(this.value)">
			<option value = ''>-- Change Category --</option>
			<?php foreach ($categories->result() as $category): ?>
				<option value = '<?php echo $category->url; ?>'><?php echo $category->title; ?></option>
			<?php endforeach; ?>
		</select>
	  </form>
	  <br>
	<p style = 'font-weight: bold'>Je unatafuta wimbo? > <a href = 'request/song'>Request a song here</a></p>
      </hgroup>
   </section>
   <!--end intro-->
   <!--start holder-->
   <div class="holder_content">
	<br><p style = 'font-weight: bold; font-size: 14px;'>Je wimbo huu una makosa? <a href = 'report_song/<?php echo $songID ?>'>Report This Song</a></p>
	<div style = 'clear: both; padding-top:10px;'></div>
	<section id = 'lyrics_section'>
	<h3><?php if($lyrics !=''): ?>Maneno ya <?php echo $song_title ?>.<?php endif; ?></h3>

		<?php if($lyrics !='') echo $lyrics; ?>
	
	</section>
	<section id = 'file_section'>
	<a href="http://swahilimusicsheet.com/uploads/files/<?php echo $pdf; ?>"><span class="button">Nota za <?php echo $song_title; ?></span></a><br><br>
	<!--<a name="fb_share" style = 'float: left; clear: both;' ></a> 
<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" 
        type="text/javascript">
</script><Br>-->
	<br>
	<p style = 'font-weight: bold; font-size: 14px;'>Mtunzi: <a href = 'composer/<?php echo $composer->url ?>'><?php echo $composer->name; ?></a></p>
	<?php if(isset($composition)): ?>
		<p style = 'font-weight: bold; font-size: 14px;'>Umetungwa: <?php echo date('d-m-Y',strtotime($composition)); ?></p>
	<?php endif; ?>
	<?php if(isset($place)): ?>
		<p style = 'font-weight: bold; font-size: 14px;'>Mahali: <?php echo $place; ?></p>
	<?php endif; ?>
	<p style = 'font-weight: bold; font-size: 14px;'>Categories: <?php echo $categories_list; ?></p> 
	<p style = 'font-weight: bold; font-size: 14px; margin-bottom:5px;'>Uploaded by <?php echo $uploader ?></p> 
	<?php if($midi != ''): ?>
	<applet code="com.jidul.midiplayer.MidiPlayer" codebase="." archive="http://swahilimusicsheet.com/uploads/files/MidiPlayer.jar" width="250" height="28" style = 'margin-top:10px;'>
	<param name="autostart" value="false" />
	<param name="style" value="medium" />
	
	<param name="file_1" value="http://swahilimusicsheet.com/uploads/files/<?php echo $midi; ?>" />

	<param name="title_1" value="<?php echo strip_tags($h1); ?>" />

	
	</applet><br>
	To download midi, Right Click > <a href = "http://swahilimusicsheet.com/uploads/files/<?php echo $midi; ?>" >Download Midi</a> Then Select "Save Link As" or "Save Target As".
	<?php endif; ?>
	<a href="http://swahilimusicsheet.com/uploads/files/<?php echo $pdf; ?>"><img style = 'float: left; clear: both; margin-top: 4px;' src = 'images/Swahili-music-sheet.jpg' width = 200 height = 276 /></a><br>
	<a href="http://swahilimusicsheet.com/uploads/files/<?php echo $pdf; ?>"><span class="button">Nota za <?php echo $song_title; ?></span></a>
	
	</section>
	
	<div style = 'clear: both; padding-top:20px;'></div>
	</div>
