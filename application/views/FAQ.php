  <section id="intro">
      <hgroup>
      <h1 style = 'color: #000;display: inline;'><?php echo $h1 ?></h1>&nbsp;&nbsp;&nbsp;&nbsp;<a>Home</a> > <?php echo $h1; ?>
	  
      </hgroup>

   </section>
   <!--end intro-->
   <!--start holder-->
   <div class="holder_content">
	<div style = 'clear: both; padding-top:20px;'></div>
	<?php foreach($faq->result() as $qn): ?>
		<?php echo $qn->faq ?><div style = 'clear: both; margin-top:20px; border-top: 1px solid #CCC'></div>
	<?php endforeach; ?>
	<div style = 'clear: both; padding-top:20px;'></div>
	</div>