<?php 

set_time_limit(0);
ini_set('memory_limit','1024M');

function process($date)
{
	// get data
	$data = get_data('https://nfdc.faa.gov/webContent/56DaySub/'.$date.'/PFR.zip','PFR.txt');

	$cycle = strtotime($date);
	echo 'cycle:'.$cycle;
	
	$pfr1 = array();
	$pfr2 = array();
	
	$lines = explode("\n",$data);
	foreach($lines as $line)
	{
		$record_type = substr($line,0,4);
		if($record_type == 'PFR1')
		{
			$data = array(
						'recordtype' => $record_type,
						'origin_ident' => substr($line,4,5),
						'destination_ident' => substr($line,9,5),
						'type' => substr($line,14,3),
						'route_sequence' => substr($line,17,2),
						'route_type' => substr($line,19,30),
						'area_description' => substr($line,49,75),
						'route_description' => substr($line,124,40),
						'aircraft_limitations' => substr($line,164,50),
						'hours1' => substr($line,214,50),
						'hours2' => substr($line,229,15),
						'hours3' => substr($line,243,15),
						'route_limitations' => substr($line,259,20),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$pfr1[] = $data;
		}else // PFR2
		{
			$data = array(
						'recordtype' => $record_type,
						'origin_ident' => substr($line,4,5),
						'destination_ident' => substr($line,9,5),
						'type' => substr($line,14,3),
						'route_sequence' => substr($line,17,2),
						'segment_sequence' => substr($line,19,3),
						'segment_ident' => substr($line,22,48),
						'segment_type' => substr($line,70,7),
						'fix_state' => substr($line,77,2),
						'icao_region' => substr($line,79,2),
						'type_code' => substr($line,81,2),
						'type_description' => substr($line,83,20),
						'radial_distance' => substr($line,103,7),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$pfr2[] = $data;
		}
	}
	
	file_put_contents('./data/pfr_basedata.json',json_encode($pfr1));
	file_put_contents('./data/pfr_routesegments.json',json_encode($pfr2));
}
