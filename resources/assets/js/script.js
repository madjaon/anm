// Suggestion Box jQuery Plugin
!function(t){t.fn.suggestionBox=function(n){function e(t){T=O.find("li:eq("+t+") a").attr("href"),O.find("li:eq("+t+")").addClass("selected")}function i(t){O.find("li:eq("+t+")").removeClass("selected")}function r(){T="#",J=-1,O.find("li").removeClass("selected")}function s(){var t=O.find("li").size();J===t-1?(i(J),r()):(i(J),J++,e(J))}function o(){J>0?(i(J),J--,e(J)):-1==J?(i(J),J=O.find("li").size()-1,e(J)):(i(0),r())}function u(){O.css("display","none"),window.location=T}function a(n){b=x.val(),t.ajax({url:n,data:K,dataType:"json",success:function(t){var n=!0,i=J;M.results&&t.results&&(n=JSON.stringify(M.results[J])!==JSON.stringify(t.results[J])),w(t),m(),i>-1&&x.val()===b&&!n&&(J=i,e(J)),j.ajaxSuccess(t)},error:function(t){j.ajaxError(t)}})}function f(n){var e=t(n.target).parent("li");return e.parent().children().index(e)}function c(){var t=l(x,"border-bottom-width")+l(x,"border-top-width"),n=l(x,"padding-bottom")+l(x,"padding-top");O.css({position:"absolute",left:x.offset().left+j.leftOffset,top:x.offset().top+(x.height()+t+n+j.topOffset)})}function l(t,n){return parseInt(t.css(n).replace("px",""))}function d(){j.fadeOut?O.fadeOut():O.css("display","none"),r()}function h(){j.fadeIn?O.fadeIn():O.css("display","block")}function g(){var t=p()+j.widthAdjustment;"auto"==j.menuWidth?O.css({"min-width":t}):"constrain"==j.menuWidth&&O.css({width:t})}function p(){return x.width()+l(x,"border-left-width")+l(x,"border-right-width")+l(x,"padding-left")+l(x,"padding-right")}function v(n){var e='<div id="suggestion-header">'+j.heading+'</div> <ul id="suggestion-box-list">';return t.each(n.results,function(n,i){if(!i.suggestion||!i.url)return!1;E=!0;var r="";return i.attr&&t.each(i.attr,function(t,n){for(var e=Object.keys(n),i=0;i<e.length;i++)r+=e[i]+'="'+n[e[i]]+'" '}),e+='<li><a href="'+i.url+'" '+r+">"+i.suggestion+"</a></li>",n===j.results-1?!1:void 0}),e+="</ul>"}function m(){r(),E=!1;var t=j.filter?S(x.val()):M;if(t&&t.results)var n=v(t);q?E?(O.html(n),g(),h()):j.showNoSuggestionsMessage&&x.val().length>0?(g(),h(),O.html('<div id="no-suggestions">'+j.noSuggestionsMessage+"</div>")):d():d()}function w(n){M=n?n instanceof Object?n:t.parseJSON(n):{}}function y(n){t.ajax({url:n,dataType:"json",success:function(t){w(t)},error:function(t){console.log(t)}})}function S(n){var e;if(filterPattern=j.filterPattern.replace("{INPUT}",n),!n)return{};if(M&&M.results){var i=new RegExp(filterPattern,"i");e=t.grep(M.results,function(t){return i.test(t.suggestion)})}j.sort&&e.sort(j.sort);var r=JSON.stringify({results:e});return t.parseJSON(r)}var x=this,j=t.extend({topOffset:0,leftOffset:0,widthAdjustment:0,delay:400,heading:"Suggestions",results:10,fadeIn:!0,fadeOut:!1,menuWidth:"auto",showNoSuggestionsMessage:!1,noSuggestionsMessage:"No Suggestions Found",filter:!1,filterPattern:"({INPUT})",ajaxError:function(t){console.log(t)},ajaxSuccess:function(t){},enterKeyAction:function(){u()},paramName:"search"},n);t("body").append('<div id="suggestion-box"></div>'),x.attr("autocomplete","off");var O=t("#suggestion-box");c();var b,N=13,A=38,I=40,P=27,J=-1,T="#",k=!1,D=null,E=!1,q=!1,K={},M={};return O.on({mousemove:function(t){"A"===t.target.nodeName&&(i(J),J=f(t),e(J),k=!0)},mouseout:function(t){"A"===t.target.nodeName&&(k=!1,i(J),r())},click:function(t){"A"===t.target.nodeName&&O.css("display","none")}}),x.on({blur:function(){q=!1,k||d()},focus:function(){q=!0,t(this).val()&&m(M)},keyup:function(t){t.which!==A&&t.which!==I&&t.which!==P&&t.which!==N&&(j.url&&(r(),D&&clearTimeout(D)),j.url&&(K[j.paramName]=x.val(),D=setTimeout(function(){a(j.url)},j.delay)),j.filter&&m())},keydown:function(t){"none"!==O.css("display")&&(t.which==I&&(t.preventDefault(),s()),t.which==A&&(t.preventDefault(),o()),t.which===N&&J>-1&&(t.preventDefault(),j.enterKeyAction()),t.which==P&&(t.preventDefault(),d()))},paste:function(){setTimeout(function(){x.keyup()},200)}}),t(window).resize(function(){c()}),{getSuggestions:function(t){return a(t),this},addSuggestions:function(t){return w(t),this},loadSuggestions:function(t){return y(t),this},getJson:function(){return JSON.stringify(M)},moveUp:function(){return o(),this},moveDown:function(){return s(),this},selectedUrl:function(){return T},selectedSuggestion:function(){return O.find("li:eq("+J+")").text()},position:function(){return J},select:function(t){return i(J),J=t,e(t),this},reset:function(){return i(J),r(),this},show:function(){return x.focus(),m(),this},hide:function(){return d(),this},url:function(t){return j.url=t,this},fadeIn:function(t){return j.fadeIn=t,this},fadeOut:function(t){return j.fadeOut=t,this},delay:function(t){return j.delay=t,this},heading:function(t){return j.heading=t,this},results:function(t){return j.results=t,this},ajaxError:function(t){return j.ajaxError=t,this},ajaxSuccess:function(t){return j.ajaxSuccess=t,this},filter:function(t){return j.filter=t,this},filterPattern:function(t){return j.filterPattern=t,this},sort:function(t){return j.sort=t,this},enterKeyAction:function(t){return j.enterKeyAction=t,this},destroy:function(){return x.unbind(this),O.remove(),null}}}}(jQuery);
//# sourceMappingURL=maps/suggestion-box.min.js.map

$(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $('[data-toggle="tooltip"]').tooltip();
  $('#search').suggestionBox({
    filter: false,
    widthAdjustment: -8,
    leftOffset: 4,
    topOffset: 0,
    menuWidth: 'constrain', // auto
    // highlightMatch: true,
    heading:"Gợi ý tìm kiếm",
    results: 6,
    delay: 200,
    paramName: 's',
    url: '/livesearch',
  }).loadSuggestions('/livesearch');
})

// // suggestion boxes' top positions
// topOffset: 0,

// // suggestion boxes' left position
// leftOffset: 0,

// // suggestion boxes' width
// widthAdjustment: 0,

// // The number of milliseconds to wait until to consider the user to have stopped typing. 
// // An ajax call to the given suggestion url will be made after this time.
// delay: 400, 

// // The heading displayed in the suggestion box
// heading: 'Suggestions',

// // The maximum number of results to display in the suggestion box
// results: 10,

// // enable a fade in effect
// fadeIn: true,

// // enable a fade out effect
// fadeOut: false,

// // 'auto': will calculate the width based on the content
// // 'constrain': will set the width to the size of the search box and constrain the content to it.
// menuWidth: 'auto',

// // Shows the noSuggestionsMessage when no suggestions can be found
// showNoSuggestionsMessage: false,

// // The message to be shown when no suggestions have been found and showNoSuggestionsMessage is true
// noSuggestionsMessage: 'No Suggestions Found',

// // apply the filterPattern to the suggestions as the user types. set true use json data. set false use ajax request
// filter: false,

// // A regex expression to apply using the filter. Use {INPUT} to inject the user input in to the pattern
// filterPattern: "({INPUT})",

// // callbacks
// ajaxError: function (e) {
//   console.log(e);
// },

// ajaxSuccess: function (data) {
// },

// enterKeyAction: function () {
//   goToSelection();
// },

// // The parameter name you would like to use in your query string for requests
// paramName: 'search',

// // The url of the JSON or server side script where you would like to make an ajax call to get the suggestions
// url: null,

// // A sort function to sort filtered results, this is passed directly into javascripts' native sort function if supplied (only works when filter is on)
// sort: null

// JSON FORMAT:

// {
//   "results": [
//     {
//       "suggestion": "Fender Standard Stratocaster",
//       "url": "#"
//     },
//     {
//       "suggestion": "Fender American Deluxe Stratocaster",
//       "url": "suggestion1.html",
//       "attr" : [
//         {
//           "class" : "suggestion"
//         }
//       ]
//     },
//     {
//       "suggestion": "Fender Telecaster",
//       "url": "suggestion2.html"
//     },
//     {
//       "suggestion": "Fender Jaguar",
//       "url": "suggestion3.html"
//     },
//     {
//       "suggestion": "Fender Jazzmaster",
//       "url": "suggestion3.html"
//     },
//     {
//       "suggestion": "Gibson Les Paul",
//       "url": "suggestion4.html"
//     },
//     {
//       "suggestion": "Gibson SG",
//       "url": "suggestion5.html"
//     }
//   ]
// }
