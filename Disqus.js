$(document).ready(function() {
	$('.comment_selector').click(function () { 
		$(this).find('input').attr('checked', 'true');
		var flag = $(this).find('input').val();
		var label = $(this).find('input').attr("id");
	
	if (flag == 'no'){
		$(this).find('input').val(label);
	} else {
		$(this).find('input').val("no");
	}    
	});
});