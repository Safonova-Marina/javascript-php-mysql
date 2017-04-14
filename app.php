<?php
header('Content-Type: text/html; charset=utf-8');

$user_name = strip($_POST['inputUserName']);
$name = strip($_POST['inputName']);
$email = strip($_POST['inputEmail']);
$text = strip(($_POST['inputText']));

$suc = false;
$upl = "";

$re1 = '/^[A-Za-z0-9]{3,}$/';
$re2 = '/^[A-Za-z0-9]{3,}$/';
$re3 = '/^([a-z0-9_-]+\.)*[a-z0-9_-]+@([0-9a-z][a-z0-9_-]*[0-9a-z])(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/';
$re4 = '/^[A-Za-z0-9_-\ \.\,]{20,}$/';

$er = '';
if(!isset($user_name) || !preg_match($re1, $user_name)) {$er .= '1';}
if(!isset($name) || !preg_match($re2, $name)) {$er .= '2';}
if(!isset($email) || !preg_match($re3, $email)) {$er .= '3';}

if ($er == "") {
	$suc = true;
	//begin work with file
	if ($_FILES['inputFile']['name'] != null) {
		if (!file_exists("./upload")) {
			mkdir("./upload");
		}
		$ext = substr($_FILES['inputFile']['name'], 1 + strrpos($_FILES['inputFile']['name'], "."));
		$upl = "./upload/".date_format(new DateTime(), 'd-m-Y-H-i-s').".".$ext;
		move_uploaded_file($_FILES['inputFile']['tmp_name'], $upl);
	}
	//end work with file

	//begin work with database
	include("./connect.inc.php");
	$strSQL = "INSERT INTO users (user_name, name, email, text_com, ip, date_create, path_file) VALUES ('".$user_name."','".$name."','".$email."','".$text."','".$_SERVER['REMOTE_ADDR']."', NOW(),'".$upl."')"; 
	mysql_query($strSQL) or die ("He могу выполнить запрос!");
	mysql_close();
	//end work with database
}
else {
	switch ($er) {
		case '1':
			$er_mes = "Incorrect data in the field User Name";break;
		case '2':
			$er_mes = "Incorrect data in the field Name";break;
		case '3':
			$er_mes = "Incorrect data in the field Email";break;
		case '12':
			$er_mes = "Incorrect data in the fields User Name and Name";break;
		case '13':
			$er_mes = "Incorrect data in the fields User Name and Email";break;
		case '23':
			$er_mes = "Incorrect data in the fields Name and Email";break;
		case '123':
			$er_mes = "Incorrect data in the fields User Name, Name and Email";break;
	}
}

$rez = array("er_mes" => $er_mes, "suc" => $suc);
echo json_encode($rez);

function strip($str) {
	$str = strip_tags($str);
	$str = trim($str);
	return $str;
}

?>