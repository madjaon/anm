<script>
	$(function () {
		
	});
	
	//update status selected: 1
	//call update type selected: 2
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
				url: '{{ url("admin/contact/callupdatestatus") }}',
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
				url: '{{ url("admin/contact/calldelete") }}',
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