<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="robots" content="noindex,nofollow" />
	<title>@yield('title')</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="/adminlte/bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Select2 -->
  	<link rel="stylesheet" href="/adminlte/plugins/select2/select2.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="/adminlte/dist/css/AdminLTE.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
	folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="/adminlte/dist/css/skins/_all-skins.min.css">
	<!-- bootstrap datepicker -->
  	<link rel="stylesheet" href="/adminlte/plugins/datepicker/datepicker3.css">
  	<!-- Bootstrap time Picker -->
  	<link rel="stylesheet" href="/adminlte/plugins/timepicker/bootstrap-timepicker.min.css">
  	<!-- bootstrap wysihtml5 - text editor -->
  	<link rel="stylesheet" href="/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<!-- jQuery 2.2.0 -->
	<script src="/adminlte/plugins/jQuery/jQuery-2.2.0.min.js"></script>
	<!-- jQuery UI -->
	<script src="/adminlte/plugins/jQueryUI/jquery-ui.min.js"></script>
	<!-- Bootstrap 3.3.6 -->
	<script src="/adminlte/bootstrap/js/bootstrap.min.js"></script>
	<!-- Select2 -->
	<script src="/adminlte/plugins/select2/select2.full.min.js"></script>
	<!-- bootstrap datepicker -->
	<script src="/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
	<!-- bootstrap time picker -->
	<script src="/adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>
	<!-- Bootstrap WYSIHTML5 -->
	<script src="/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<!-- FastClick -->
	<script src="/adminlte/plugins/fastclick/fastclick.js"></script>
	<!-- AdminLTE App -->
	<script src="/adminlte/dist/js/app.min.js"></script>
	<script type="text/javascript">
		$(function () {
			checkInputNumber();
			//Initialize Select2 Elements
    		$(".select2").select2({allowClear: true});
    		//Initialize Select2 Elements with limit
    		$(".select2limit").select2({allowClear: true, maximumSelectionLength: 1});
			//Date picker
		    $('.datepicker').datepicker({
		    	autoclose: true,
		    	todayBtn: true,
		    	todayHighlight: true,
		    	format:'dd/mm/yyyy',
		    });
		    //Timepicker
		    $(".timepicker").timepicker({
		      showInputs: false,
		      showMeridian: false,
		    });
		    //bootstrap WYSIHTML5 - text editor
			$(".textarea").wysihtml5({
				toolbar: {
				    "font-styles": false, // Font styling, e.g. h1, h2, etc.
				    "emphasis": true, // Italics, bold, etc.
				    "lists": false, // (Un)ordered lists, e.g. Bullets, Numbers.
				    "html": true, // Button which allows you to edit the generated HTML.
				    "link": true, // Button to insert a link.
				    "image": false, // Button to insert an image.
				    "color": true, // Button to change color of font
				    "blockquote": false, // Blockquote
				    //"size": <buttonsize> // options are xs, sm, lg
			    }
			});
			$('.onlyNumber').keypress(function(e) {
				if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
					return false;
				}
			});
	    });
	</script>
</head>