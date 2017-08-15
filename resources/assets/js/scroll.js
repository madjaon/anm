var scrollWidth = 160;
checkPos($(window).width());
$(function () {
  $(window).resize(function () {
    checkPos($(window).width());
  });
});
function checkPos(windowWidth) {
  var posLeft = (windowWidth - 1000) / 2 - scrollWidth - 3;
  var posRight = (windowWidth - 1000) / 2 - scrollWidth + 1;
  if (windowWidth < 1300) {
    $('.scrollSticky').hide();
  } else {
    $('.scrollSticky').show();
    $("#scrollRight").css({ top: 110, right: posRight, position: "absolute",display:"block" });
    $("#scrollLeft").css({ top: 110, left: posLeft, position: "absolute",display:"block" });
  }
}
$(document).scroll(function () {
  var scrollTop = $(document).scrollTop();
  $('#scrollLeft').each(function () {
    var $scroll = $(this);
    var parentTop = parseInt($scroll.attr('data-top'));
    if (scrollTop > parentTop) {
      $scroll.css('top', scrollTop - parentTop + parseInt($scroll.attr('data-top')) + 10);
    } else {
      $scroll.css('top', parseInt($scroll.attr('data-top')));
    }
  });
  $('#scrollRight').each(function () {
    var $scroll = $(this);
    var parentTop = parseInt($scroll.attr('data-top'));
    if (scrollTop > parentTop) {
      $scroll.css('top', scrollTop - parentTop + parseInt($scroll.attr('data-top')) + 10);
    } else {
      $scroll.css('top', parseInt($scroll.attr('data-top')));
    }
  });
});
