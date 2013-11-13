<?php

$dataset = 'harfix';

$date = get_date();

switch($dataset)
{
	case "aff":
		$model = 'aff';
		break;
	case "apt":
		$model = 'apt';
		break;
	case "arb":
		$model = 'arb';
		break;
	case "ats":
		$model = 'ats';
		break;
	case "awos":
		$model = 'awos';
		break;
	case "awy":
		$model = 'awy';
		break;
	case "cdr":
		$model = 'cdr';
		break;
	case "com":
		$model = 'com';
		break;
	case "fix":
		$model = 'fix';
		break;
	case "fss":
		$model = 'fss';
		break;
	case "harfix":
		$model = 'harfix';
		break;
	case "natfix":
		$model = 'natfix';
		break;
	case "twr":
		$model = 'twr';
		break;
	default:
		echo "Invalid dataset";
		exit;
		break;	
}

require_once('./functions/'.$model.'.php');
$header = '
; Generated with OpenFMS v1.0
; Created on '.date("Y-m-d").'
; Dataset '.strtoupper($model).'
; NFDC Rotation '.$date.'
';
process($date);
	
function get_date()
{
	$page = file_get_contents('https://nfdc.faa.gov/xwiki/bin/view/NFDC/56+Day+NASR+Subscription');
	$url = explode('<h2>Current</h2>',$page);
	$url = explode('">',$url[1]);
	$url = explode('<a href="/xwiki/bin/view/NFDC/56DaySub-',$url[0]);
	$date = $url[1];
	
	//return $date;
	//return '2013-06-27';
	//return '2013-05-02';
	return '2013-03-07';
}

function get_data($url,$internal_filename)
{
	// download zip to tmp
	$curl_handle=curl_init();
	curl_setopt($curl_handle,CURLOPT_URL,$url);
	curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
	curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
	$buffer = curl_exec($curl_handle);
	curl_close($curl_handle);
	
	// write file
	$file_name = time();
	file_put_contents('./tmp/'.$file_name.'.zip',$buffer);
	
	// unzip
	$zip = new ZipArchive;
	$res = $zip->open('./tmp/'.$file_name.'.zip');
	if ($res === TRUE) {
		echo 'ok';
		$zip->extractTo('./tmp/');
		$zip->close();
	} else {
		echo 'failed, code:' . $res;
	}
	
	// load file into memory
	$file_data = file_get_contents('./tmp/'.$internal_filename);
	
	// delete zip and folder
	unlink('./tmp/'.$file_name.'.zip');
	unlink('./tmp/'.$internal_filename);
	
	return $file_data;
}
