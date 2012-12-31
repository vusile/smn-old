<?php

$this->session->set_userdata(array ('current_page' => uri_string()));
$this->session->set_userdata(array ('current_page_title' => $h1));


?>
<section id="intro">
      <hgroup>
      <h1 style = 'color: #000;display: inline;'><?php echo $h1; ?></h1>&nbsp;&nbsp;&nbsp;&nbsp;<a href = '<?php echo base_url(); ?>'>Home</a> > <?php echo $h1; ?>&nbsp;&nbsp;&nbsp;&nbsp;

      </hgroup>
   </section>
   <!--end intro-->
   <!--start holder-->
   <div class="holder_content">
	<div style = 'clear: both; padding-top:0px;'></div>
	<?php if (isset($res->logo) and $res->logo!=''):?>
		<img src = 'uploads/files/<?php echo $res->logo; ?>' alt = '<?php echo $res->name; ?>' title = '<?php echo $res->name; ?>' />
	<?php endif; ?>	


	<?php if (isset($res->phone) and $res->phone!=''):?>
		<br><br><strong>Phone:</strong> <?php echo $res->phone; ?>
	<?php endif; ?>
	<?php if (isset($res->description) and $res->description!=''):?>
		<br><br><strong>Maelezo:</strong> <?php echo $res->description; ?>
	<?php endif; ?>
		<?php if (isset($res->additional_document) and $res->additional_document !=''):?>
		<br><strong>Download our</strong> &gt;
		<a href = 'uploads/files/<?php echo $res->additional_document ?>'> <?php if(isset($res->additional_document_name)) echo $res->additional_document_name; else " Details Document"; ?>  </a>
	<?php endif; ?>
	<div style = 'clear: both; padding-top:20px;'></div>
	</div>