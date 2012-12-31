<!DOCTYPE html>
<!-- saved from url=(0043)http://www.swahilimusicsheet.com/blog -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<title>Swahili Music Notes Newsletter</title>
<!--<base href="http://www.swahilimusicsheet.com/">--><base href=".">
<link rel="icon" href="http://www.swahilimusicsheet.com/images/favicon.gif" type="image/x-icon">
 <!--[if lt IE 9]>
 <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

<!--background-image: url(http://www.swahilimusicsheet.com/images/bg.png);-->
</head>
<body style = "width: 600px;">
   <div class="bg">
    <!--start container-->
    <div id="container">
    <!--start header-->

      <a href="http://www.swahilimusicsheet.com/" id="logo"><img src="http://www.swahilimusicsheet.com/images/logo.png" alt="Swahili Music Notes Logo"></a> 
	  <h1 style = "font-family: Tahoma,Georgia; margin:0; font-size:20px;"><?php echo $title; ?></h1>


   <!--end intro-->
   <!--start holder-->
   <div class="holder_content" style = "width:600px">
   <?php echo $special_message; ?>

	<table style = "width:600px;" cellpadding="10">
		<tr>
		<td style = "width:290px; vertical-align: top;">
	<h2 style='text-align: left; color: #31ab48; font-family: Trebuchet, Helvetica, Georgia'>Mwanzo</h2>
	<?php foreach($mwanzo->result() as $mwz): ?>
	<a href = "http://www.swahilimusicsheet.com/song/<?php echo $mwz->url ?>"><?php echo $mwz->jina_la_wimbo ?></a> - <?php echo $watunzi[$mwz->mtunzi] ?><br>
	<?php endforeach; ?>
	</td><td style = "width:290px; vertical-align: top;">
	<h2 style='text-align: left; color: #31ab48; font-family: Trebuchet, Helvetica, Georgia'>Katikati</h2>
	<?php foreach($katikati->result() as $mwz): ?>
	<a href = "http://www.swahilimusicsheet.com/song/<?php echo $mwz->url ?>"><?php echo $mwz->jina_la_wimbo ?></a> - <?php echo $watunzi[$mwz->mtunzi] ?><br>
	<?php endforeach; ?>
	</td>
	</tr>
	<tr>
	<td style = "width:290px; vertical-align: top;">
	<h2 style='text-align: left; color: #31ab48; font-family: Trebuchet, Helvetica, Georgia'>Nyinginezo</h2>
	<?php foreach($nyinginezo->result() as $mwz): ?>
	<a href = "http://www.swahilimusicsheet.com/song/<?php echo $mwz->url ?>"><?php echo $mwz->jina_la_wimbo ?></a> - <?php echo $watunzi[$mwz->mtunzi] ?><br>
	<?php endforeach; ?>
	</td>
	<td colspan=2 style = "width:290px; vertical-align: top;">
	<h2 style='text-align: left; color: #31ab48; font-family: Trebuchet, Helvetica, Georgia'>Taarifa Mbalimbali</h2>
	<?php foreach($articles->result() as $mwz): ?>
	<a href = "http://www.swahilimusicsheet.com/song/<?php echo $mwz->url ?>"><?php echo $mwz->title ?></a><br>
	<?php endforeach; ?>
	</td>
	</tr>
	<tr >
	<td colspan=2 style = "vertical-align: top;">
	<h2 style='text-align: left; color: #31ab48; font-family: Trebuchet, Helvetica, Georgia'>Requests</h2>
	<?php foreach($requests->result() as $request): ?>
	<?php echo $request->jina_la_wimbo; ?><br>
	<?php endforeach; ?>
	</td>
	</tr>
	</table>
	</div>
	
	

   </div>
   <!--end container-->
   <!--start footer-->
   
   <!--end footer-->
   </div>
   <!--end bg-->
   <!-- Free template distributed by http://freehtml5templates.com -->
  
</body></html>