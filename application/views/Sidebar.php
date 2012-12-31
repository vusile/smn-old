
	<aside>
		<div id = "sidebar" >
		
		<?php if(isset($uploader_songs)): ?>
		<section class="group">
         <h3>Other Songs Uploaded by <?php echo $uploader ?></h3>

		<?php foreach($uploader_songs->result() as $uploader_song): ?>
			<p style = 'margin-bottom: 5px; font-weight: normal;'><a style = 'font-weight: normal;' href="song/<?php echo $uploader_song->surl; ?>"><?php echo $uploader_song->jina_la_wimbo ?></a> - <?php echo $uploader_song->name ?></p>
		<?php endforeach; ?>
         
         
		</section>
		<?php endif; ?>
		
		<section class="group">
        <h3>5 Most Recently Uploaded Songs</h3>
		<?php foreach($recent_songs->result() as $recent_song): ?>
			<p style = 'margin-bottom: 5px;'><a style = 'font-weight: normal;' href="song/<?php echo $recent_song->surl; ?>"><?php echo $recent_song->jina_la_wimbo ?></a> - <?php echo $recent_song->name ?></p>
		<?php endforeach; ?>
         
		</section>
		
		
		<section class="group">
		<?php $ad = $featured_ad->row(); ?>
		<?php 
			if($ad->file != '') 
				$href = 'uploads/ads/' . $ad->file; 
			else if ($ad->url != '')
				$href = $ad->url;
		
		?>
        <h3><a target = '_blank' href = '<?php echo $href; ?>'><?php echo $ad->title; ?></a></h3>
		<a target = '_blank' href = '<?php echo $href; ?>'><img src = 'uploads/ads/<?php echo $ad->image ?>' /></a>
		<p style = 'margin-bottom: 5px;' ><?php echo $ad->copy; ?></p>
		<?php if ($ad->file_text != ''):?>
		<br><a target = '_blank' href = '<?php echo $href; ?>'> <?php echo $ad->file_text; ?></a>
        <?php endif; ?>
		</section>

		
		
		
		<section class="group">
         <h3>Top 3 Uploaders</h3>

		<?php foreach($top_uploaders->result() as $top_uploader): ?>
			<p style = 'margin-bottom: 5px; '><?php echo ucwords(strtolower($top_uploader->uploader)); ?> - <?php echo $top_uploader->songs; ?> Songs</p>
		<?php endforeach; ?>
         
         
		</section>		
		
		
		<section class="group">
         <h3>News</h3>

			<?php 
			if($news->num_rows() > 0)
			{
			foreach ($news->result() as $entry):
			?>	
			<h4 style = 'text-align: left;'><a style = 'font-weight: normal' href = 'page/<?php echo $entry->url ?>' ><?php echo $entry->title; ?></a></h4>
			<?php echo truncate(strip_tags($entry->text),70); ?><a style = 'font-weight: normal' href = 'page/<?php echo $entry->url ?>'>Read More</a>
			<br><br>
			<?php endforeach; 
			}
			?>
         
		</section>
			
		</div>
</aside>
