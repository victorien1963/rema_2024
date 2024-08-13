<?php
 	include('../edit/cuteeditor_files/include_CuteEditor.php');
	list($HOSTNAME) = explode(".",$_SERVER[HTTP_HOST]);
	$path = $_GET['path'];
	$editor = new CuteEditor();
	$editor->ID = 'txt_main';
	$editor->FilesPath = '../edit/cuteeditor_files';
	$editor->SecurityPolicyFile =  $HOSTNAME.'.config';
	$editor->AutoConfigure = "Simple";
	$editor->EditorWysiwygModeCss="../edit/cuteeditor_files/php.css";
	$editor->ThemeType = "OfficeXp";
	$editor->URLType = "Default";
	$editor->Width="100%";
	$editor->Height=560;
	$editor->LoadHTML($path);
    $editor->Draw();
    $editor = null; /* Inserts and initializes the textarea */ 
?>


