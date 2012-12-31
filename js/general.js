function goToCategory(url) {
	window.location.replace("category/" + url);
//window.location = 'http://www.swahilimusicnotes/piano/index.php/category/' + url;
}

function mtunziChecker() {
	if ($('#mtunzi_mpya').is(':checked'))
	{
		$('#jina_mtunzi_mpya').removeAttr('disabled');
		$('#mtunzi').attr('disabled', true);
	}
	else
	{
		$('#jina_mtunzi_mpya').attr('disabled', true);
		$('#mtunzi').removeAttr('disabled');
	}
}
	


