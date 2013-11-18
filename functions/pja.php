<?php

set_time_limit(0);
ini_set('memory_limit','1024M');

function process($date)
{
	// get data
	$data = get_data('https://nfdc.faa.gov/webContent/56DaySub/'.$date.'/PJA.zip','PJA.txt');
	
	// process data
	$cycle = strtotime($date);
	echo 'cycle:'.$cycle;
	
	$pja1 = array();
	$pja2 = array();
	$pja3 = array();
	$pja4 = array();
	$pja5 = array();
	
	$lines = explode("\n",$data);
	foreach($lines as $line)
	{
		$record_type = substr($line,0,4);
		if($record_type == 'PJA1')
		{
			$data = array(
						'recordtype' => $record_type,
						'pja_id' => substr($line,4,6),

						'navaid_ident' => substr($line,10,4),
						'navaid_type' => substr($line,14,2),
						'navaid_desc' => substr($line,16,25),
						'azimuth' => substr($line,41,6),
						'distance' => substr($line,47,8),
						'navaid_name' => substr($line,55,30),
						'pja_state_code' => substr($line,85,2),
						'pja_state' => substr($line,87,30),
						'pja_city' => substr($line,117,30),

						'pja_lat_formatted' => substr($line,147,14),
						'pja_lat_seconds' => substr($line,161,12),
						'pja_lon_formatted' => substr($line,173,14),
						'pja_lon_seconds' => substr($line,188,12),

						'airport_name' => substr($line,200,50),
						'airport_site_number' => substr($line,250,11),
						'pja_dropzone' => substr($line,261,50),
						'pja_maxalt' => substr($line,311,8),
						'pja_radius' => substr($line,319,5),
						'sectional_chart' => substr($line,324,3),
						'area_published' => substr($line,327,3),
						'addtl_text' => substr($line,330,100),
						'fss_ident' => substr($line,430,4),
						'fss_name' => substr($line,434,30),

						'pja_use' => substr($line,464,8),
						'volume' => substr($line,472,1),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$pja1[] = $data;
		}elseif($record_type == 'PJA2')
		{
			$data = array(
						'recordtype' => $record_type,
						'pja_id' => substr($line,4,6),

						'times' => substr($line,10,75),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$pja2[] = $data;
		}elseif($record_type == 'PJA3')
		{
			$data = array(
						'recordtype' => $record_type,
						'pja_id' => substr($line,4,6),

						'usergroup' => substr($line,10,75),
						'description' => substr($line,85,75),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$pja3[] = $data;
		}elseif($record_type == 'PJA4')
		{
			$data = array(
						'recordtype' => $record_type,
						'pja_id' => substr($line,4,6),

						'facility_id' => substr($line,10,4),
						'facility_name' => substr($line,14,48),
						'loc_id' => substr($line,62,4),
						'com_freq' => substr($line,66,8),
						'com_chart' => substr($line,74,1),
						'mil_freq' => substr($line,75,8),
						'mil_chart' => substr($line,83,1),
						'sector' => substr($line,84,30),
						'altitude' => substr($line,114,20),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$pja4[] = $data;
		}else
		{
			$data = array(
						'recordtype' => $record_type,
						'pja_id' => substr($line,4,6),

						'remarks' => substr($line,10,300),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$pja5[] = $data;
		}
	}
	
	file_put_contents('./data/pja_basedata.json',json_encode($pja1));
	file_put_contents('./data/pja_times.json',json_encode($pja2));
	file_put_contents('./data/pja_usergroup.json',json_encode($pja3));
	file_put_contents('./data/pja_contact.json',json_encode($pja4));
	file_put_contents('./data/pja_remarks.json',json_encode($pja5));
}
