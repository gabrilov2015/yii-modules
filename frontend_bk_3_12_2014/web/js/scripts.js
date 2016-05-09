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
	
	$('.action-btn').click(function(){
		var action = $(this).attr('data-action');
		var url_ajax = $(this).attr('data-url');
		
		if(action == 'add'){
			var cur_row = $(this).parent().parent('.editable-row');
			var del_url = cur_row.attr('data-del-url');
			var edit_url = cur_row.attr('data-edit-url');
			var inputs = cur_row.find('input');
			var datas = [];
			var keys = [];
			inputs.each(function(i,e){
				datas[i] = {name: $(this).attr('name'), value: $(this).val()};
				keys[i] = $(this).attr('name');
			});
			$.ajax({
			  type: "POST",
			  url: url_ajax,
			  data: datas,
			})
			.done(function( response ) {
				var rs = JSON.parse(response);
				var datas = rs.datas;
				if(rs.status == true){
					var tr = $('<tr></tr>'); 
					tr.attr('data-key',rs.id)
					tr.attr('data-url',edit_url)
					for(var i = 0;i < keys.length;i++){
						var input = '<input type="text" value="'+datas[keys[i]]+'" name="'+keys[i]+'" readonly=readonly class="editable-input">';
						tr.append("<td>"+input+"</td>");
					}
					tr.append("<td><button class='action-btn' data-url='"+del_url+"' data-action='delete'>delete</button></td>");
					tr.find('input.editable-input').each(function(){
						editableItem($(this));
					});
					tr.find('button.action-btn').each(function(){
						deleteItem($(this));
					});
					$('.editable-body').prepend(tr);
					alert('Adding a new item succesful!');
				}else{
					alert('Adding a new item failed!');
				}
			});
		}else if(action == 'edit'){
		
		}else if(action == 'delete'){
			var url_ajax = $(this).attr('data-url');
			var cur_row = $(this).parent().parent();
			var id = cur_row.attr('data-key');
			$.ajax({
			  type: "POST",
			  url: url_ajax,
			  data: {'id':id},
			})
			.done(function( response ) {
				var rs = JSON.parse(response);
				var datas = rs.datas;
				if(rs.status == true){
					cur_row.remove();
					alert('Deleting an item succesful!');
				}else{
					alert('Deleting an item failed!');
				}
			});
		}
	});
	
	$('.editable-input').dblclick(function(){
		if($(this).attr("readonly") == 'readonly'){
			$(this).attr("readonly",false);
		}
	});
	
	$('.editable-input').keyup(function(e){
		if(e.keyCode == 13) {
			var cur_row = $(this).parent().parent();
			var url_ajax = cur_row.attr('data-url');
			var inputs = cur_row.find('input');
			var datas = [];
			var keys = [];
			inputs.each(function(i,e){
				datas[i] = {name: $(this).attr('name'), value: $(this).val()};
				keys[i] = $(this).attr('name');
			});
			inputs.attr("readonly",true);
			$.ajax({
			  type: "POST",
			  url: url_ajax,
			  data: datas,
			})
			.done(function( response ) {
				var rs = JSON.parse(response);
				var datas = rs.datas;
				if(rs.status == true){
					alert('Updating an item succesful!');
				}else{
					alert('Updating an item failed!');
				}
			});
		}
	});
	
	function editableItem(elm){
		elm.dblclick(function(){
			if($(this).attr("readonly") == 'readonly'){
				$(this).attr("readonly",false);
			}
		});
		
		elm.keyup(function(e){
			if(e.keyCode == 13) {
				var cur_row = $(this).parent().parent();
				var url_ajax = cur_row.attr('data-url');
				var inputs = cur_row.find('input');
				var datas = [];
				var keys = [];
				inputs.each(function(i,e){
					datas[i] = {name: $(this).attr('name'), value: $(this).val()};
					keys[i] = $(this).attr('name');
				});
				inputs.attr("readonly",true);
				$.ajax({
				  type: "POST",
				  url: url_ajax,
				  data: datas,
				})
				.done(function( response ) {
					var rs = JSON.parse(response);
					var datas = rs.datas;
					if(rs.status == true){
						alert('Updating an item succesful!');
					}else{
						alert('Updating an item failed!');
					}
				});
			}
		});
	}
	
	function deleteItem(elm){
		elm.click(function(){
			var url_ajax = $(this).attr('data-url');
			var cur_row = $(this).parent().parent();
			var id = cur_row.attr('data-key');
			$.ajax({
			  type: "POST",
			  url: url_ajax,
			  data: {'id':id},
			})
			.done(function( response ) {
				var rs = JSON.parse(response);
				var datas = rs.datas;
				if(rs.status == true){
					cur_row.remove();
					alert('Deleting an item succesful!');
				}else{
					alert('Deleting an item failed!');
				}
			});
		});
	}
	
})(window.jQuery);