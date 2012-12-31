 <?php header("Expires: 0"); header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); header("cache-control: no-store, no-cache, must-revalidate"); header("Pragma: no-cache");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo $title; ?></title>
<base href = '<?php echo base_url(); ?>' />
<link type = 'text/css' rel = 'stylesheet' media = 'screen' href = 'styles/default.css' />
<!--<link type = 'text/css' rel = 'stylesheet' media = 'screen' href = 'styles/jquery-ui-1.8.16.custom.css' />-->
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->
<!--<script type="text/javascript" src="code.jquery.com/jquery-latest.min.js"></script>-->
<link href='styles/validationEngine.jquery.css' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="js/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="js/general.js"></script>
<link rel="stylesheet" href="styles/jquery-ui-1.8.17.custom.css" type="text/css"/>
<link rel="stylesheet" href="styles/jquery.ui.all.css" type="text/css"/>
<script type = 'text/javascript' language = 'javascript' src = 'js/jquery-ui-1.8.17.custom.min.js'></script>
<script type="text/javascript" src="js/jquery.limit-1.2.source.js"></script>
<script type="text/javascript" src="js/jscripts/tiny_mce/tiny_mce.js"></script>
<link href="media/css/demo_table.css" media="screen" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" src="js/jquery.asmselect.js"></script>

	<script type="text/javascript">

		$(document).ready(function() {
			$("select[multiple]").asmSelect({
				addItemTarget: 'bottom',
				animate: true,
				highlight: true,
				sortable: true
			});
			
		}); 

	</script>

	<link rel="stylesheet" type="text/css" href="styles/jquery.asmselect.css" />-->

<script>
	$(function() {
		$( "#date_of_composition" ).datepicker({dateFormat: 'DD, d MM, yy',changeMonth: true,
			changeYear: true});
	});
	</script>
	
<script type="text/javascript">

	tinyMCE.init({
			mode : "textareas",
			//elements : "ajaxfilemanager,ajaxfilemanager2",
			theme : "advanced",
			plugins : "advimage,advlink,media,contextmenu",
			theme_advanced_buttons1: "bold,italic,underline,image,bullist,numlist,format,justifyleft,justifycenter,justifyright,justifyfull,link,unlink",
			theme_advanced_buttons2: "",
			theme_advanced_buttons3: "",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			extended_valid_elements : "hr[class|width|size|noshade]",
			file_browser_callback : "ajaxfilemanager",
			paste_use_dialog : false,
			theme_advanced_resizing : true,
			theme_advanced_resize_horizontal : true,
			apply_source_formatting : true,
			force_br_newlines : true,
			force_p_newlines : false,	
			relative_urls : false
		});
		
	function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = "<?php echo base_url() ?>js/jscripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php";
			var view = 'detail';
			switch (type) {
				case "image":
				view = 'thumbnail';
					break;
				case "media":
					break;
				case "flash": 
					break;
				case "file":
					break;
				default:
					return false;
			}
            tinyMCE.activeEditor.windowManager.open({
                url: "<?php echo base_url() ?>js/jscripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php?view=" + view,
                width: 782,
                height: 440,
                inline : "yes",
                close_previous : "no"
            },{
                window : win,
                input : field_name
            });
            
	}



</script>
<link href="facebox/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
<script src="facebox/facebox.js" type="text/javascript"></script>
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="expires" content="FRI, 13 APR 1999 01:00:00 GMT">
<script>
 $(document).ready(function(){

				$("#search").autocomplete({
				source: "suggest/",
				minLengh: 2
				});

            });

</script>
<META name="swahili" content="NOINDEX, NOFOLLOW, NOARCHIVE">
</head>
<body>
<div style = 'margin-bottom:10px'><?php echo anchor(site_url("backend/logout"), 'Logout'); ?>&nbsp; &nbsp; <?php echo anchor(site_url("backend"), 'Dashboard'); ?>&nbsp; &nbsp; <a href = 'backend/piano_uploaded_songs/0/add'>Upload Song</a></div>

<div style = "width: 1000px; margin: 0px auto; float: left;">

	