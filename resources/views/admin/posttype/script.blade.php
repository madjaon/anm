<script>
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
			url: '{{ url("admin/posttype/callupdate") }}',
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
			url: '{{ url("admin/posttype/updateStatus") }}',
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