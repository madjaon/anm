function errorreporting(){$.ajax({type:"post",url:"/errorreporting",data:{url:window.location.href},beforeSend:function(){$("#errorreporting").attr("style","display:none"),$(".spinner").attr("style","display:inline-block")},success:function(){return $(".spinner").attr("style","display:none"),$("#errormessage").html('<span class="badge badge-pill badge-success">Báo lỗi thành công! Cảm ơn bạn rất nhiều!</span>'),!1},error:function(e){return $(".spinner").attr("style","display:none"),$("#errormessage").html('<span class="badge badge-pill badge-success">Báo lỗi thành công! Cảm ơn bạn rất nhiều!</span>'),!1}})}function epchap(e){var n=document.getElementById("p").value,t=document.getElementById("e").value;return!(!n||!t)&&(e||(e=null),void $.ajax({type:"post",url:"/epchap",data:{p:n,e:t,s:e},beforeSend:function(){$(".online").html('<div class="loading"></div>')},success:function(e){return $(".online").html(e),!1},error:function(e){return $(".online").html("Mời bạn tải lại trang"),!1}}))}$(function(){var e=document.getElementById("prev").value,n=document.getElementById("next").value;document.onkeydown=function(t){switch(t.keyCode){case 37:window.location.href=e;break;case 39:window.location.href=n}},epchap()});