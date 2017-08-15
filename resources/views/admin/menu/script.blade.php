<script>
	function updateParentIdSelectBox()
	{
		var type = $('select[name^="type"]').val();
		var parentId = $('input[name^="parentId"]').val();
		$.ajax(
		{
			type: 'post',
			url: '{{ url("admin/menu/updateParentIdSelectBox") }}',
			data: {
				'type': type,
				'parentId': parentId,
				'_token': '{{ csrf_token() }}'
			},
			beforeSend: function() {
	            $('#ParentIdSelectBox').html('Updating...');
	        },
			success: function(data)
			{
				if(data) {
					$('#ParentIdSelectBox').html(data);
				} else {
					$('#ParentIdSelectBox').html('Error! Please load again~');
				}
				return;
			},
			error: function(xhr)
			{
				alert("An error occured: " + xhr.status + " " + xhr.statusText);
				return;
			}
		});
		return;
	}
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
			url: '{{ url("admin/menu/callupdate") }}',
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
	function updateStatus(id, field)
	{
		$.ajax(
		{
			type: 'post',
			url: '{{ url("admin/menu/updateStatus") }}',
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
</script>