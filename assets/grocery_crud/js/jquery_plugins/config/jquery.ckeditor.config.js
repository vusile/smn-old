$(function(){
	$( 'textarea.texteditor' ).ckeditor({
		toolbar:'Full',
		filebrowserBrowseUrl : 'http://www.swahilimusicnotes.com/ckfinder/ckfinder.html',
		filebrowserImageBrowseUrl : 'http://www.swahilimusicnotes.com/ckfinder/ckfinder.html?type=Images',
		filebrowserFlashBrowseUrl : 'http://www.swahilimusicnotes.com/ckfinder/ckfinder.html?type=Flash',
		filebrowserUploadUrl : 'http://www.swahilimusicnotes.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
		filebrowserImageUploadUrl : 'http://www.swahilimusicnotes.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
		filebrowserFlashUploadUrl : 'http://www.swahilimusicnotes.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
		filebrowserWindowWidth : '1000',
		filebrowserWindowHeight : '700'
	
	
	});
	$( 'textarea.mini-texteditor' ).ckeditor({
	
		toolbar :
		[
			{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Link','Unlink'] },
			{ name: 'paragraph', items : [ 'NumberedList','BulletedList','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
			{ name: 'insert', items : [ 'Image','HorizontalRule','MediaEmbed' ] },
			{ name: 'styles', items : [ 'Styles'/*,'Format'*/] }
		],
		width:700,
		filebrowserBrowseUrl : 'http://www.swahilimusicnotes.com/ckfinder/ckfinder.html',
		filebrowserImageBrowseUrl : 'http://www.swahilimusicnotes.com/ckfinder/ckfinder.html?type=Images',
		filebrowserFlashBrowseUrl : 'http://www.swahilimusicnotes.com/ckfinder/ckfinder.html?type=Flash',
		filebrowserUploadUrl : 'http://www.swahilimusicnotes.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
		filebrowserImageUploadUrl : 'http://www.swahilimusicnotes.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
		filebrowserFlashUploadUrl : 'http://www.swahilimusicnotes.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
		filebrowserWindowWidth : '1000',
		filebrowserWindowHeight : '700',
		extraPlugins: 'MediaEmbed',
		format_p: [{ element : 'p', attributes : { 'class' : 'contentFonts' } }],
		forcePasteAsPlainText : true,
		pasteFromWordRemoveStyles : true,
		stylesSet :[
			{ name : 'Introduction Emphasis', element : 'strong' }
		]
		
	
	
	});
});