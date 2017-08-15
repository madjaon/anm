<script type="text/javascript" src="/adminlte/plugins/tinymce/tinymce.min.js"></script>
<link rel="stylesheet" type="text/css" href="/adminlte/plugins/fancybox/source/jquery.fancybox.css" media="screen" />
<script type="text/javascript" src="/adminlte/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
<style type=text/css>.fancybox-inner {height:500px !important;}</style>
<script type="text/javascript">
	$(function () {
		$(".iframe-btn").fancybox({"width":"100%","height":"auto","type":"iframe","autoScale":false});
		tiny_mce();
		tinyMCE.get('textarea.elm1').setContent(tinyMCE.get('textarea.elm1').getContent()+_newdata);
		tinyMCE.triggerSave();
	});
	function tiny_mce()
	{
	    tinymce.init({
	    	entity_encoding : "raw", // TinyMCE UTF-8 saving to MySQL Database
	        selector: "textarea.elm1",
	        theme: "modern",
	        width: 700,
	        height: 400,
	        // width: 800,
	        // height: 300,
	//        language: 'vi',
	        plugins: [
	             "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
	             "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
	             "save table contextmenu directionality emoticons template paste textcolor"
	       	],
					content_css: "/adminlte/plugins/tinymce/skins/lightgray/content.min.css",
					toolbar: "undo redo | bold italic | formatselect fontselect fontsizeselect | forecolor backcolor | removeformat | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image media | link unlink", // | mybutton
					//add more button
					// setup: function (editor) {
					// 	editor.addButton('mybutton', {
					// 	  type: 'listbox',
					// 	  text: 'Chèn',
					// 	  icon: false,
					// 	  onselect: function (e) {
					// 	    editor.insertContent(this.value());
					// 	  },
					// 	  values: [
					// 	    { text: 'Nguyên liệu', value: '&nbsp;<img src="/img/food1.png" alt="Nguyên liệu">' },
					// 	    { text: 'Cách làm', value: '&nbsp;<img src="/img/food2.png" alt="Cách làm">' },
					// 	    // { text: 'Chúc bạn nấu ăn thành công!', value: 'Chúc bạn nấu ăn thành công!' }
					// 	  ],
					// 	  onPostRender: function () {
					// 	    // Select the second item by default
					// 	    this.value('&nbsp;<em>Some italic text!</em>');
					// 	  }
					// 	});
					// },
				  //end add more button

	       	style_formats: [
	            {title: 'Bold text', inline: 'b'},
	            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
	            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
	            {title: 'Example 1', inline: 'span', classes: 'example1'},
	            {title: 'Example 2', inline: 'span', classes: 'example2'},
	            {title: 'Table styles'},
	            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
	        ],
	        relative_urls: false,
	        remove_script_host: false,
	        invalid_elements : "div,script,abbr,acronym,address,applet,area,bdo,big,blockquote,button,caption,cite,code,col,colgroup,dd,del,dfn,input,ins,isindex,kbd,label,legend,map,menu,noscript,optgroup,option,param,textarea,var,ruby,samp,select,rtc,hr",
	        extended_valid_elements : "iframe[src|width|height|name|align]",
	//        paste_as_text: true,
	//        paste_word_valid_elements: "b,strong,i,em,h1,h2",
	//        paste_webkit_styles: "color font-size",
	//        paste_retain_style_properties: "color font-size",
	//        paste_merge_formats: false,
	//        paste_convert_word_fake_lists: false,
	        external_filemanager_path:"/adminlte/plugins/tinymce/plugins/filemanager/",
	        filemanager_title:"Quản lý tập tin",
	        filemanager_access_key:"{{ AKEY }}",
	        external_plugins: { "filemanager" : "plugins/filemanager/plugin.min.js"}
	     });
	}
	//anh thumb
	function GetFilenameFromPath()
	{
	    var filePath = $('#url_abs').val();
	    var first_url = filePath.substring(0,filePath.lastIndexOf("/")+1);
	    var last_url = filePath.substring(filePath.lastIndexOf("/")+1);
	    $('#url_abs').val(first_url + 'thumb/' + last_url);
	}
	function GetFilenameFromPath2(id, thumb='')
	{
	    var filePath = $('#'+id).val();
	    var first_url = filePath.substring(0,filePath.lastIndexOf("/")+1);
	    var last_url = filePath.substring(filePath.lastIndexOf("/")+1);
	    if(thumb=='') {
	    	$('#'+id).val(first_url + last_url);
	    } else {
	    	$('#'+id).val(first_url + 'thumb/' + last_url);
	    }
	}
</script>