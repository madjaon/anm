function errorreporting() {
  $.ajax(
  {
    type: 'post',
    url: '/errorreporting',
    data: {
      'url': window.location.href
    },
    beforeSend: function() {
      $('#errorreporting').attr('style', 'display:none');
      $('.spinner').attr('style', 'display:inline-block');
    },
    success: function()
    {
      $('.spinner').attr('style', 'display:none');
      $('#errormessage').html('<span class="badge badge-pill badge-success">Báo lỗi thành công! Cảm ơn bạn rất nhiều!</span>');
      return false;
    },
    error: function(xhr)
    {
      $('.spinner').attr('style', 'display:none');
      $('#errormessage').html('<span class="badge badge-pill badge-success">Báo lỗi thành công! Cảm ơn bạn rất nhiều!</span>');
      return false;
    }
  });
}
$(function () {
  var prev = document.getElementById('prev').value;
  var next = document.getElementById('next').value;
  document.onkeydown = function(e) {
    switch (e.keyCode) {
      case 37:
        window.location.href = prev;
        break;
      case 39:
        window.location.href = next;
        break;
    }
  };
  
})
