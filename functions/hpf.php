<?php

set_time_limit(0);
ini_set('memory_limit','1024M');

function process($date)
{
	// get data
	$data = get_data('https://nfdc.faa.gov/webContent/56DaySub/'.$date.'/HPF.zip','HPF.txt');
	
	// process data
	$cycle = strtotime($date);
	echo 'cycle:'.$cycle;
	
	$hp1 = array();
	$hp2 = array();
	$hp3 = array();
	$hp4 = array();
	
	$lines = explode("\n",$data);
	foreach($lines as $line)
	{
		$record_type = substr($line,0,3);
		if($record_type == 'HP1')
		{
			$data = array(
						'recordtype' => $record_type,
						'name' => substr($line,4,80),
						'number' => substr($line,84,3),
						'effective_date' => substr($line,87,11),
						'hold_direction' => substr($line,98,3),
						'hold_magnetic' => substr($line,101,3),
						'azimuth' => substr($line,104,5),
						'ils_ident' => substr($line,109,7),
						'navaid_ident' => substr($line,116,7),
						'addtl_facility' => substr($line,123,12),
						'inbound_crs' => substr($line,135,3),
						'turning_dir' => substr($line,138,3),
						'alt_all' => substr($line,141,7),
						'alt_170' => substr($line,148,7),
						'alt_200' => substr($line,155,7),
						'alt_265' => substr($line,162,7),
						'alt_280' => substr($line,169,7),
						'alt_310' => substr($line,176,7),
						'fix' => substr($line,183,36),
						'artcc' => substr($line,119,3),
						'lat_fix' => substr($line,222,14),
						'lon_fix' => substr($line,236,14),
						'high_artcc' => substr($line,250,3),
						'low_artcc' => substr($line,253,3),
						'lat_navaid' => substr($line,256,14),
						'lon_navaid' => substr($line,270,14),
						'leg_length' => substr($line,284,8),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$hp1[] = $data;
		}elseif($record_type == 'HP2')
		{
			$data = array(
						'recordtype' => $record_type,
						'name' => substr($line,4,80),
						'number' => substr($line,84,3),
						'chart_desc' => substr($line,87,21),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$hp2[] = $data;
		}elseif($record_type == 'HP3')
		{
			$data = array(
						'recordtype' => $record_type,
						'name' => substr($line,4,80),
						'number' => substr($line,84,3),
						'alts_speeds' => substr($line,87,15),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$hp3[] = $data;
		}else
		{
			$data = array(
						'recordtype' => $record_type,
						'name' => substr($line,4,80),
						'number' => substr($line,84,3),
						'label' => substr($line,87,100),
						'remarks' => substr($line,187,300),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$hp4[] = $data;
		}
	}
	
	file_put_contents('./data/hp_basedata.json',json_encode($hp1));
	file_put_contents('./data/hp_charting.json',json_encode($hp2));
	file_put_contents('./data/hp_otheraltspeed.json',json_encode($hp3));
	file_put_contents('./data/hp_remarks.json',json_encode($hp4));
}
