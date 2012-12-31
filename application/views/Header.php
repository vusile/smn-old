<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo strip_tags($title); ?></title>
<?php if(isset($meta_description)): ?>
<meta name="description" content= "<?php echo strip_tags($meta_description); ?>" >
<?php endif; ?>
<base href = '<?php echo base_url(); ?>' />
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
 <!--[if lt IE 9]>
 <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
<link rel="shortcut icon" href="images/favicon.gif" type="image/x-icon"/> 
<link rel="stylesheet" type="text/css" href="styles/styles.css"/>
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<link rel="stylesheet" href="styles/jquery-ui-1.8.17.custom.css" type="text/css"/>
<link rel="stylesheet" href="styles/jquery.ui.all.css" type="text/css"/>
<script type = 'text/javascript' language = 'javascript' src = 'js/jquery-ui-1.8.17.custom.min.js'></script>
<script type="text/javascript" src="js/general.js"></script>

<script type = "text/javascript" src='js/snowfall.jquery.js'></script>
<script type = "text/javascript">
$(document).ready(function(){
	$(document).snowfall({round : true, minSize: 5, maxSize:8});
 });
</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-18823668-4']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>


</head>
<body>
<?php
function truncate($mytext,$chars) { 	
	//Number of characters to show  
if(strlen($mytext) < $chars)
		return $mytext;
	else
	{  
		$mytext = substr($mytext,0,$chars);  
		$mytext = substr($mytext,0,strrpos($mytext,' '));  
		return $mytext . '...';  
	}
}
?>
   <div class="bg">
    <!--start container-->
    <div id="container">
    <!--start header-->
    <header>
	<div id = 'login'>
	<?php if (!$this->ion_auth->logged_in()): ?>
	<a href="login">Login</a> | <a href="register">Register</a> | <a href="donations">Donations</a>
	<?php else: ?>
	<a href="logout">Logout</a> | <a href="backend">Dashboard</a> | <a href="donations">Donations</a>
	<?php endif; ?>
	
	</div>
      <!--start logo-->
      <a href="<?php echo base_url(); ?>" id="logo"><img src="images/logo.png"  alt="Swahili Music Notes Logo"/></a>    
	<form  action="find" id = 'searchForm' method = 'post'>
    <input id="search" name = "search" type="text" placeholder="Type here">
    <input id="submit" type="submit" value="Search">
	</form>
      <!--end logo-->
      <!--start menu-->
  	   <nav>
         <ul>
         <li><a href="<?php echo base_url(); ?>" class="current">Home</a></li>
     	
     	 <li><a href="blog">Blog</a></li>
         <li><a href="resources">Resources</a></li>
         <li><a href="directory">Directory</a></li>
         <li><a href="about">About Us</a></li>
         <li><a href="contact">Contact Us</a></li>
         </ul>
      </nav>
  	   <!--end menu-->
      <!--end header-->
	</header>
	<div style = 'clear: both; padding-top:30px;'></div>