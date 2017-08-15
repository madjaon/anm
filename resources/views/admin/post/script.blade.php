<script>
	$(function () {
		
	});
	function checkPostType(id, check=1)
	{
		if($('#type_id_'+id).is(':checked')) {
			//type main
			$('#make_primary_'+id).show();
		} else {
			//type main
			if($('input[name="type_main_id"]').val() == id) {
				$('input[name="type_main_id"]').val('');
			}
			$('#primary_'+id).hide();
			$('#make_primary_'+id).hide();
		}
		return;
	}
	function checkKey(id, key, name, check=1)
	{
		$('.post-type-list').each(function(index){
			var $li = $(this);
			type_id = $li.find('.type_id');
			if(check === 1) {
				if(type_id.is(':checked')) {
					$li.find('.'+key).hide();
					$li.find('.make_'+key).show();
				}
			} else {
				$li.find('.'+key).hide();
				$li.find('.make_'+key).show();
			}
		});
		$('input[name="'+name+'"]').val(id);
		$('#'+key+'_'+id).show();
		$('#make_'+key+'_'+id).hide();
	}
	//script for index:
	function updateStatus(id, field)
	{
		$.ajax(
		{
			type: 'post',
			url: '{{ url("admin/post/updateStatus") }}',
			data: {
				'id': id,
				'field': field,
				'_token': '{{ csrf_token() }}'
			},
			beforeSend: function() {
	            $('#'+field+'_'+id).html('...');
	        },
			success: function(data)
			{
				if(data == 1) {
					window.location.reload();
				} else {
					alert('Xảy ra lỗi! Chưa thể cập nhật! Vui lòng refresh trang.');
					window.location.reload();
				}
			},
			error: function(xhr)
			{
				alert("An error occured: " + xhr.status + " " + xhr.statusText);
				window.location.reload();
			}
		});
	}
	//update status selected: 1
	//call update type selected: 2
	//delete selected: 3
	function actionSelected(action)
	{
		var check = $('input:checkbox:checked.id').val();
		if(check) {
			if(action == 1) {
				callupdatestatus('status');
			} else if(action == 2) {
				callupdatetypebox();
			} else {
				calldelete();
			}
		} else {
			alert('Bạn chưa chọn cái nào!');
		}
	}
	function callupdatestatus(field)
	{
		confirm = confirm('Bạn có chắc chắn muốn làm điều này không?')
		if(confirm) {
			var id = $('input:checkbox:checked.id').map(function () {
			  	return this.value;
			}).get();
			$.ajax(
			{
				type: 'post',
				url: '{{ url("admin/post/callupdatestatus") }}',
				data: {
					'id': id,
					'field': field,
					'_token': '{{ csrf_token() }}'
				},
				beforeSend: function() {
		            $('#loadMsg1').html('Status Updating...');
		        },
				success: function(data)
				{
					if(data == 1) {
						window.location.reload();
					} else {
						alert('Xảy ra lỗi! Chưa thể cập nhật! Vui lòng refresh trang.');
						window.location.reload();
					}
				},
				error: function(xhr)
				{
					alert("An error occured: " + xhr.status + " " + xhr.statusText);
					window.location.reload();
				}
			});
		} else {
			window.location.reload();
		}
	}
	//call delete selected
	function calldelete()
	{
		confirm = confirm('Bạn có chắc chắn muốn xóa?')
		if(confirm) {
			var id = $('input:checkbox:checked.id').map(function () {
			  	return this.value;
			}).get();
			$.ajax(
			{
				type: 'post',
				url: '{{ url("admin/post/calldelete") }}',
				data: {
					'id': id,
					'_token': '{{ csrf_token() }}'
				},
				beforeSend: function() {
		            $('#loadMsg3').html('Deleting...');
		        },
				success: function(data)
				{
					if(data == 1) {
						window.location.reload();
					} else {
						alert('Xảy ra lỗi! Chưa thể cập nhật! Vui lòng refresh trang.');
						window.location.reload();
					}
				},
				error: function(xhr)
				{
					alert("An error occured: " + xhr.status + " " + xhr.statusText);
					window.location.reload();
				}
			});
		} else {
			window.location.reload();
		}
	}
	function callupdatetypebox()
	{
		$('#myModalPostTypeSelect').modal('toggle');
	}
	function callupdatetype()
	{
		confirm = confirm('Bạn có chắc chắn muốn làm điều này không?')
		if(confirm) {
			var id = $('input:checkbox:checked.id').map(function () {
			  	return this.value;
			}).get();
			var type_id = $('input:checkbox:checked.type_id').map(function () {
			  	return this.value;
			}).get();
			var type_main_id = $('input[name="type_main_id"]').val();
			//validate
			if(id.length <= 0 || type_id.length <= 0 || type_main_id == '') {
				alert('Bạn chưa chọn đầy đủ các mục (post, thể loại, thể loại chính (primary)!');
				$('#myModalPostTypeSelect').modal('hide');
				window.location.reload();
			} else {
				$.ajax(
				{
					type: 'post',
					url: '{{ url("admin/post/callupdatetype") }}',
					data: {
						'id': id,
						'type_id': type_id,
						'type_main_id': type_main_id,
						'_token': '{{ csrf_token() }}'
					},
					beforeSend: function() {
			            $('#indexposttype').prop('disabled', true);
			        },
					success: function(data)
					{
						$('#indexposttype').prop('disabled', false);
						$('#myModalPostTypeSelect').modal('hide');
						if(data == 1) {
							alert('Ok! My darling!');
							window.location.reload();
						} else {
							alert('Xảy ra lỗi! Chưa thể cập nhật! Vui lòng refresh trang.');
							window.location.reload();
						}
					},
					error: function(xhr)
					{
						$('#indexposttype').prop('disabled', false);
						$('#myModalPostTypeSelect').modal('hide');
						alert("An error occured: " + xhr.status + " " + xhr.statusText);
						window.location.reload();
					}
				});
			}
			//end validate
		} else {
			window.location.reload();
		}
	}

</script>