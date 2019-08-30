$(document).ready(function(){

	$('.comment_selector').click(function(){
		$(this).find('input').attr('checked', 'true');
		var flag = $(this).find('input').val();
		var label = $(this).find('input').attr("id");

		if (flag == 'no'){
			$(this).find('input').val(label);
		} else {
			$(this).find('input').val("no");
		}
	});

	$('#edit_shortname').click(function(){
		$('#edit_shortname>span').attr('class', 'fa fa-unlock');
		$('#disqus_forum_url').attr('readonly', false);
	});

});