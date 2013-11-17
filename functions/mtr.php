<?php

set_time_limit(0);
ini_set('memory_limit','1024M');

function process($date)
{
	// get data
	$data = get_data('https://nfdc.faa.gov/webContent/56DaySub/'.$date.'/MTR.zip','MTR.txt');

	$cycle = strtotime($date);
	echo 'cycle:'.$cycle;
	
	$mtr1 = array();
	$mtr2 = array();
	$mtr3 = array();
	$mtr4 = array();
	$mtr5 = array();
	$mtr6 = array();
	
	$lines = explode("\n",$data);
	foreach($lines as $line)
	{
		$record_type = substr($line,0,4);
		if($record_type == 'MTR1')
		{
			$data = array(
						'recordtype' => $record_type,
						'route_type' => substr($line,4,3),
						'route_ident' => substr($line,7,5),
						'effective_date' => substr($line,12,8),
						'faa_region' => substr($line,20,3),
						'artcc_ident' => split(substr($line,23,80),4),
						'fss_idents' => split(substr($line,103,160),4),
						'timesofuse' => substr($line,263,50),
						'sequence' => substr($line,514,5),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				if(!is_array($value))
				{
					$data[$key] = @trim($value);
				}
			}
			
			$mtr1[] = $data;
		}elseif($record_type == 'MTR2')
		{
			$data = array(
						'recordtype' => $record_type,
						'route_type' => substr($line,4,3),
						'route_ident' => substr($line,7,5),
						'sop_text' => substr($line,12,100),
						'record_sort_sequence' => substr($line,514,5),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				if(!is_array($value))
				{
					$data[$key] = @trim($value);
				}
			}
			
			$mtr2[] = $data;
		}elseif($record_type == 'MTR3')
		{
			$data = array(
						'recordtype' => $record_type,
						'route_type' => substr($line,4,3),
						'route_ident' => substr($line,7,5),
						'desc_text' => substr($line,12,100),
						'record_sort_sequence' => substr($line,514,5),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				if(!is_array($value))
				{
					$data[$key] = @trim($value);
				}
			}
			
			$mtr3[] = $data;
		}elseif($record_type == 'MTR4')
		{
			$data = array(
						'recordtype' => $record_type,
						'route_type' => substr($line,4,3),
						'route_ident' => substr($line,7,5),
						'terrain_optext' => substr($line,12,100),
						'record_sort_sequence' => substr($line,514,5),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				if(!is_array($value))
				{
					$data[$key] = @trim($value);
				}
			}
			
			$mtr4[] = $data;
		}elseif($record_type == 'MTR5')
		{
			$data = array(
						'recordtype' => $record_type,
						'route_type' => substr($line,4,3),
						'route_ident' => substr($line,7,5),
						'route_point' => substr($line,12,5),
						'lead_text' => split(substr($line,17,228),57),
						'leaving_text' => split(substr($line,245,228),57),
						'related_ident' => substr($line,473,4),
						'navaid_bearing' => substr($line,477,5),
						'navaid_distance' => substr($line,482,4),
						'navaid_lat' => substr($line,486,14),
						'navaid_lon' => substr($line,500,14),
						'record_sort_sequence' => substr($line,514,5),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				if(!is_array($value))
				{
					$data[$key] = @trim($value);
				}
			}
			
			$mtr5[] = $data;
		}else // RMK
		{
			$data = array(
						'recordtype' => $record_type,
						'route_type' => substr($line,4,3),
						'route_ident' => substr($line,7,5),
						'agency_type' => substr($line,12,2),
						'agency_name' => substr($line,14,61),
						'agency_station' => substr($line,75,30),
						'agency_address' => substr($line,105,35),
						'agency_city' => substr($line,140,30),
						'agency_state' => substr($line,170,2),
						'agency_zip' => substr($line,172,10),
						'agency_phone' => substr($line,182,40),
						'agency_autovon_phone' => substr($line,222,1144),
						'agency_hours' => substr($line,237,40),
						'record_sort_sequence' => substr($line,514,5),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				if(!is_array($value))
				{
					$data[$key] = @trim($value);
				}
			}
			
			$mtr6[] = $data;
		}
	}
	
	file_put_contents('./data/mtr_basedata.json',json_encode($mtr1));
	file_put_contents('./data/mtr_sop.json',json_encode($mtr2));
	file_put_contents('./data/mtr_routewidth.json',json_encode($mtr3));
	file_put_contents('./data/mtr_terrainop.json',json_encode($mtr4));
	file_put_contents('./data/mtr_routepoint.json',json_encode($mtr5));
	file_put_contents('./data/mtr_agency.json',json_encode($mtr6));
}
