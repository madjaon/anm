function bookpaging(page) {
  var postId = document.getElementById('postId').value;
  $.ajax(
  {
    type: 'post',
    url: '/bookpaging',
    data: {
      'id': postId,
      'page': page
    },
    beforeSend: function() {
      scrollTo();
      $('.spinner').attr('style', 'display:inline-block');
    },
    success: function(data)
    {
      $('.spinner').attr('style', 'display:none');
      $('#booklist').html(data);
      return false;
    },
    error: function(xhr)
    {
      $('.spinner').attr('style', 'display:none');
      return false;
    }
  });
}
function scrollTo() {
  $('html, body').animate({ scrollTop: $('#booklistbox').offset().top }, 'fast');
  return false;
}
