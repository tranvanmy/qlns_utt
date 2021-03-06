<?php
/*error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
*/

function nhapTatCa(){
	$list_nhap_ok = array();
	$list_nhap_err = array();
	for ($j = 0; $j < count($_SESSION["file_list_import"]); $j++) {
		$filename = $_SESSION["file_list_import"][$j];
		require_once("_NhapFile.php");
		list($retCode, $data) = xuLyFile2('../../upload_capnhat/' . $filename);
		
		$ttcb = isset($data['ttcb']) ? $data['ttcb'] : false;
		if (!$ttcb){
			$hoten = "<font color='red'>Lỗi khi đọc</font>";
			$namsinh = "Lỗi khi đọc";
		} else {
			$hoten = $ttcb['hoten'];
			$namsinh = $ttcb['namsinh'];
		}
		$row = array();
		$row['cmnd'] = 123;
		$row['filename'] = $filename;
		$row['hoten'] = $hoten;
		$row['retcode'] = $retCode;
		$row['data'] = $data;
		
		if ($retCode == 0){
			$list_nhap_ok[] = $row;
		} else {
			$list_nhap_err[] = $row;
		}
	}
	
	// remove all
	$files = scandir('../../upload_capnhat/', 1);
	//var_dump($files);
	for ($i = 0; $i < count($files); $i++){
		if ($files[$i][0] != "." 
			&& $files[$i][0] != "o" && $files[$i][0] != "d" 
			&& $files[$i] != "ReadMe.txt"){
			unlink("../../upload_capnhat/".$files[$i]);
		}
	}

	return array($list_nhap_ok, $list_nhap_err);
}