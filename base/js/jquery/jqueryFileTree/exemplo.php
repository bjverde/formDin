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
		$(document).ready( function() {
			$('#container_id').fileTree({
				root: './',
				script: 'jqueryFileTreeDir.php',
				expandSpeed: 1000,
				collapseSpeed: 1000,
				folderEvent:'click',
				folderDblClick:function( dir,container){ $("#fldDir").val( dir) },
				multiFolder: false,
				onlyDir:false
			}, function(file) {
				alert(file);
			});
		});
		function click(e)
		{
			alert( e);
		}
	</script>
    </head>
    <body>
		<table width="100%" height="100%" border="0" cellpadding="0px" cellspacing="0px" style="border:1px solid gray;">
			<tr>
				<td height="26px" style="border-bottom:1px solid gray;padding:1px;background-image:url(headerbg.gif);background-repeat: repeat-x;" >
					Selecione o Diretório
				</td>
			</tr>
			<tr>
				<td>
					<div id="container_id">
					</div>
				</td>
			</tr>
    </body>
</html>
