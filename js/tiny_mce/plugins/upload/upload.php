<?php
//include_once('config.php');

//session_start();

$type = $_REQUEST['type'];
$check_upload = false;
$file_name = '';
$screen_max = 200;

$upload_path = '/img/upload_img/';

$upload_dir = '../../../../img/upload_img/';

$upload_url = "http://".$_SERVER["SERVER_NAME"].$upload_path."";


if (!in_array($type,array('image','media','file'))) 

$type = 'file';

if (isset($_FILES["userfile"]) ) {
	if ( is_dir($upload_dir) ) {
		$file_tmp = $_FILES['userfile']['tmp_name'];
		$file_name = $_FILES["userfile"]["name"];

		if (!file_exists($upload_dir.$file_name)) {
			
			if (is_uploaded_file($file_tmp)) {
				
				if ( move_uploaded_file($file_tmp, $upload_dir.$file_name) ) {
					$check_upload = true;
				}
			}
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
<head>
<title>Download image file</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" content="no-cache"/>

<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
<script>
function selectURL(url) {
	document.passform.fileurl.value = url;
	FileBrowserDialogue.mySubmit();
}
var FileBrowserDialogue = {
	init : function () { },
	mySubmit : function () {
		var URL = document.passform.fileurl.value;
		var win = tinyMCEPopup.getWindowArg("window");
		win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;
		if (typeof(win.ImageDialog) != "undefined") {
			if (win.ImageDialog.getImageData) win.ImageDialog.getImageData();
			if (win.ImageDialog.showPreviewImage) win.ImageDialog.showPreviewImage(URL);
		}
		tinyMCEPopup.close();
	}
}

tinyMCEPopup.onInit.add(FileBrowserDialogue.init, FileBrowserDialogue);
</script>
</head>
<body>
<div class="tabs">
<ul>
	<li id="general_tab" class="current"><span>Download of <?php echo $type; ?></span></li>
</ul>
</div>
<form name="passform"><input name="fileurl" type="hidden" value="" /></form>
<form enctype="multipart/form-data" method="post" action="upload.php">
<input type="hidden" name="type" value="<?php echo $type?>"/>
<div class="panel_wrapper">
	<div id="general_panel" class="panel current">
<?php
/*если картинка загружена - выводим превьюшку и ссылку*/

if ( $check_upload ) {
	echo "
	<a href=\"#\" onclick=\"selectURL('".$upload_path.$file_name."');\">".'
        <img border="0" src="'.$upload_url.$file_name.'" width="200px"/>
        <div style="float: left"><button type="button">&nbsp;&nbsp;Загрузить</button><div style="float: right">
    </a>';
}

/*если картинка еще не загружена выводим форму для загрузки*/
else {
		echo "<table border='0' cellpadding='4' cellspacing='0'>
		<tr>
			<td><label for='userfile'>".ucfirst($type)."</label></td>
			<td><input type='file' id='userfile' name='userfile' style='width: 200px'></td>
		</tr>
		</table>
	</div>
</div>
<div class='mceActionPanel'>
	<div style='float: left'><input type='submit' id='insert' name='upload' value='Download'/></div>";
}	
?>	
	<div style="float: right"><input type="button" id="cancel" name="cancel" value="Cancel" onclick="tinyMCEPopup.close();" /></div>
</div>
</form>

</body>
</html>