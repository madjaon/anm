function errorreporting(){$.ajax({type:"post",url:"/errorreporting",data:{url:window.location.href},beforeSend:function(){$("#errorreporting").attr("style","display:none"),$(".spinner").attr("style","display:inline-block")},success:function(){return $(".spinner").attr("style","display:none"),$("#errormessage").html('<span class="badge badge-pill badge-success">Báo lỗi thành công! Cảm ơn bạn rất nhiều!</span>'),!1},error:function(n){return $(".spinner").attr("style","display:none"),$("#errormessage").html('<span class="badge badge-pill badge-success">Báo lỗi thành công! Cảm ơn bạn rất nhiều!</span>'),!1}})}function epchap(n){var e=document.getElementById("p").value,r=document.getElementById("e").value;return!(!e||!r)&&(n||(n=null),void $.ajax({type:"post",url:"/epchap",data:{p:e,e:r,s:n},beforeSend:function(){$(".online").html('<div class="loading"></div>')},success:function(n){return $(".online").html(n),!1},error:function(n){return $(".online").html('<img src="/img/error.jpg" alt="anime error">'),!1}}))}$(function(){epchap()});