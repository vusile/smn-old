<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<style type='text/css'>
body
{
	font-family: Arial;
	font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
	text-decoration: underline;
}
</style>
</head>
<body>
	<div>
		<a href='<?php echo site_url('backend/logout')?>'>Logout</a> |
		<a href='<?php echo site_url('backend')?>'>Dashboard</a> |
		<a href='<?php echo site_url('backend/piano_uploaded_songs/0/add')?>'>Upload</a> |
		<a href='<?php echo site_url('backend/piano_uploaded_songs/1')?>'>Approved Songs</a> |
		<a href='<?php echo site_url('backend/piano_uploaded_songs/0')?>'>Songs Pending Review</a>
		<?php if($this->ion_auth->is_admin()): ?>
			 | <a href='<?php echo site_url('backend/piano_emails')?>'>Emails</a> |
			<a href='<?php echo site_url('backend/piano_pages')?>'>Pages & Blogs</a> |
			<a href='<?php echo site_url('backend/piano_ads')?>'>Ads</a> |
			<a href='<?php echo site_url('backend/piano_backend_users')?>'>Uploaders</a> | 
			<a href='<?php echo site_url('backend/piano_requests')?>'>Requests</a> |		 
			<a href='<?php echo site_url('backend/piano_contributions_account')?>'>Contributions</a> |
			<a href='<?php echo site_url('backend/piano_composers')?>'>Composers</a> |
			<a href='<?php echo site_url('backend/piano_music_schools')?>'>Music Schools</a> |
			<a href='<?php echo site_url('backend/piano_recording_studios')?>'>Recording Studios</a> |
			<a href='<?php echo site_url('backend/piano_singing_groups')?>'>Singing Groups</a>
		<?php endif; ?>
	</div>
	<div style='height:20px;'></div>  
    <div>
		<?php echo $output; ?>
    </div>
</body>
</html>
