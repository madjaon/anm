<script>
	$(function () {
		
	});
	function callupdate()
	{
		var id = $('input:checkbox.id').map(function () {
		  	return this.value;
		}).get();
		var position = $('input[name^="position"]').map(function () {
		  	return this.value;
		}).get();
		$.ajax(
		{
			type: 'post',
			url: '{{ url("admin/postep/callupdate") }}',
			data: {
				'id': id,
				'position': position,
				'_token': '{{ csrf_token() }}'
			},
			beforeSend: function() {
	            $('#loadMsg').html('Updating...');
	        },
			success: function(data)
			{
				if(data) {
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
	//script for index:
	function updateStatus(id, field)
	{
		$.ajax(
		{
			type: 'post',
			url: '{{ url("admin/postep/updateStatus") }}',
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
	//delete selected: 3
	function actionSelected(action)
	{
		var check = $('input:checkbox:checked.id').val();
		if(check) {
			if(action == 1) {
				callupdatestatus('status');
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
				url: '{{ url("admin/postep/callupdatestatus") }}',
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
				url: '{{ url("admin/postep/calldelete") }}',
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

</script>