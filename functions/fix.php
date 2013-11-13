<?php

set_time_limit(0);
ini_set('memory_limit','1024M');

function process($date)
{
	// get data
	$data = get_data('https://nfdc.faa.gov/webContent/56DaySub/'.$date.'/FIX.zip','FIX.txt');
	
	// process data
	$cycle = strtotime($date);
	echo 'cycle:'.$cycle;
	
	$fix1 = array();
	$fix2 = array();
	$fix3 = array();
	$fix4 = array();
	$fix5 = array();
	
	$lines = explode("\n",$data);
	foreach($lines as $line)
	{
		$record_type = substr($line,0,4);
		if($record_type == 'FIX1')
		{
			$data = array(
						'recordtype' => $record_type,
						'artcc_code' => substr($line,4,4),
						'artcc_name' => substr($line,8,40),
						'site_location' => substr($line,48,30),
						'cross_reference' => substr($line,78,50),
						'facility_type' => substr($line,128,5),
						'effective_date' => substr($line,133,10),
						'site_state' => substr($line,143,30),
						'site_state_post' => substr($line,173,2),
						'site_latitude_formatted' => substr($line,175,14),
						'site_latitude_seconds' => substr($line,189,11),
						'site_longitude_formatted' => substr($line,200,14),
						'site_longitude_seconds' => substr($line,214,11),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$fix1[] = $data;
		}elseif($record_type == 'FIX2')
		{
			$data = array(
						'recordtype' => $record_type,
						'artcc_code' => substr($line,4,4),
						'site_location' => substr($line,8,30),
						'facility_type' => substr($line,38,5),
						'site_remarks_element' => substr($line,43,4),
						'site_remarks_text' => substr($line,47,200),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$fix2[] = $data;
		}elseif($record_type == 'FIX3')
		{
			$data = array(
						'recordtype' => $record_type,
						'artcc_code' => substr($line,4,4),
						'site_location' => substr($line,8,30),
						'facility_type' => substr($line,38,5),
						'frequency' => substr($line,43,8),
						'altitude' => substr($line,51,10),
						'special_usage' => substr($line,61,17),
						'location_identifier' => substr($line,78,4),
						'associated_state' => substr($line,82,30),
						'associated_state_post' => substr($line,112,2),
						'associated_city' => substr($line,114,40),
						'airport_name' => substr($line,154,50),
						'latitude_formatted' => substr($line,204,14),
						'latitude_seconds' => substr($line,218,11),
						'longitude_formatted' => substr($line,229,14),
						'longitude_seconds' => substr($line,243,11),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$fix3[] = $data;
		}elseif($record_type == 'FIX4')
		{
			$data = array(
						'recordtype' => $record_type,
						'artcc_code' => substr($line,4,4),
						'site_location' => substr($line,8,30),
						'facility_type' => substr($line,38,5),
						'frequency' => substr($line,43,8),
						'altitude' => substr($line,51,10),
						'special_usage' => substr($line,61,17),
						'location_identifier' => substr($line,78,4),
						'associated_state' => substr($line,82,30),
						'associated_state_post' => substr($line,112,2),
						'associated_city' => substr($line,114,40),
						'airport_name' => substr($line,154,50),
						'latitude_formatted' => substr($line,204,14),
						'latitude_seconds' => substr($line,218,11),
						'longitude_formatted' => substr($line,229,14),
						'longitude_seconds' => substr($line,243,11),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$fix4[] = $data;
		}else
		{
			$data = array(
						'recordtype' => $record_type,
						'artcc_code' => substr($line,4,4),
						'site_location' => substr($line,8,30),
						'facility_type' => substr($line,38,5),
						'frequency' => substr($line,43,8),
						'frequency_remark' => substr($line,51,2),
						'frequency_text' => substr($line,53,200),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$fix5[] = $data;
		}
	}
	
	file_put_contents('./data/fix_basedata.json',json_encode($fix1));
	file_put_contents('./data/fix_navaid.json',json_encode($fix2));
	file_put_contents('./data/fix_ils.json',json_encode($fix3));
	file_put_contents('./data/fix_remarks.json',json_encode($fix4));
	file_put_contents('./data/fix_charting.json',json_encode($fix5));
}
