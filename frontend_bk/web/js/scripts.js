(function ($) {
	
	$('.multiple-dropdown > label').click(function(){
		$(this).next().toggleClass('collapse-dropdownlist');
	});
	
	$('.editable-dropdown .selection-list .select-arrow').click(function(){
		$(this).next().next().toggle();
	});
	
	$('.editable-dropdown .selection-list input').focus(function(){
		$(this).next().show();
	});
	
	$('.editable-dropdown .selection-list input').focusout(function(){
		//$(this).next().toggle();
	});
	
	$('.editable-dropdown .selection-list input').keyup(function(){
		var txt = $(this).val();
		$(this).next().find('li').each(function(i){
			$( this ).hide();
		});
		$(this).next().find('li:contains('+txt+')').each(function(i){
			$( this ).show();
		});
	});
	
	$('.editable-dropdown > .selection-list li').click(function(){
		$(this).parent().prev().val($(this).html());
		$(this).parent().toggle();
		$(this).parent().find('li').each(function(i){
			$( this ).show();
		});
	});
	
	$('.autocomplete-box input.at-input').keyup(function(e){
		if(e.keyCode == 13) {
			var name = $(this).attr('name');
			var color = '33CCFF';
			var id = '0';
			var val = $(this).val();
			var size = (val.length - 2 > 0) ? val.length - 2 : 1;
			//var size = val.length;
			$(this).before('<div class="tag" style="background-color:#'+color+'"><input type="text" value="'+val+'" readonly size="'+size+'" id="tag-'+id+'" /><span>&times;</span></div>');
			$(this).next().hide();
			$(this).val('').focus();
			$(this).prev().find('span').click(function(){
				$(this).parent().remove();
			});
		}else{
			var txt = $(this).val();
			$(this).next().find('li').each(function(i){
				$( this ).hide();
			});
			$(this).next().find('li:contains('+txt+')').each(function(i){
				$( this ).show();
			});
			if($(this).next().find('li:contains('+txt+')').length > 0 && txt != ''){
				$(this).next().show();
			}else{
				$(this).next().hide();
			}
		}
	});
	
	$('.autocomplete-box ul li').click(function(){
		var name = $(this).parent().attr('data-name');
		var color = $(this).attr('data-color');
		var id = $(this).attr('id');
		var val = $(this).html();
		var size = (val.length - 2 > 0) ? val.length - 2 : 1;
		//var size = val.length;
		$(this).parent().prev().before('<div class="tag" style="background-color:#'+color+'"><input type="text" value="'+val+'" readonly size="'+size+'" id="tag-'+id+'" /><span>&times;</span></div>');
		$(this).parent().toggle();
		$(this).parent().prev().val('').focus();
		$(this).parent().prev().prev().find('span').click(function(){
			$(this).parent().remove();
		});
	});
	
})(window.jQuery);