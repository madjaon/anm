function checkPos(t){var o=(t-1e3)/2-scrollWidth-3,s=(t-1e3)/2-scrollWidth+1;t<1300?$(".scrollSticky").hide():($(".scrollSticky").show(),$("#scrollRight").css({top:110,right:s,position:"absolute",display:"block"}),$("#scrollLeft").css({top:110,left:o,position:"absolute",display:"block"}))}var scrollWidth=160;checkPos($(window).width()),$(function(){$(window).resize(function(){checkPos($(window).width())})}),$(document).scroll(function(){var t=$(document).scrollTop();$("#scrollLeft").each(function(){var o=$(this),s=parseInt(o.attr("data-top"));t>s?o.css("top",t-s+parseInt(o.attr("data-top"))+10):o.css("top",parseInt(o.attr("data-top")))}),$("#scrollRight").each(function(){var o=$(this),s=parseInt(o.attr("data-top"));t>s?o.css("top",t-s+parseInt(o.attr("data-top"))+10):o.css("top",parseInt(o.attr("data-top")))})});