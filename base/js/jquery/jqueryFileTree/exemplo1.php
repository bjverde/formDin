<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
	<head>
		<title>jQuery File Tree Demo</title>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
		<script src="jquery.js" type="text/javascript"></script>
		<script src="jquery.easing.js" type="text/javascript"></script>
		<script src="jqueryFileTree.js" type="text/javascript"></script>
		<link href="jqueryFileTree.css" rel="stylesheet" type="text/css" media="screen" />


	<script>
		jQuery(document).ready( function() {
		jQuery('#container_id').fileTree({ root: './' },
			function(file)
			{
				alert(file);
			});
		});
	</script>;
    </head>
    <body>
		<div id="container_id" style="width:200px;height:200px;border:1px solid blue;overflow:auto;">

		</div>

    </body>
</html>
