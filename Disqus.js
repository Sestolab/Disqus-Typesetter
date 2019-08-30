$(document).ready(function(){

	$('#edit_shortname').click(function(){
		$('#edit_shortname>span').attr('class', 'fa fa-unlock');
		$('#disqus_forum_url').attr('readonly', false);
	});

});