<?php 

set_time_limit(0);
ini_set('memory_limit','1024M');

function process($date)
{
	// get data
	$data = get_data('https://nfdc.faa.gov/webContent/56DaySub/'.$date.'/STARDP.zip','STARDP.txt');

	$cycle = strtotime($date);
	echo 'cycle:'.$cycle;
	
	$star = array();
	$dp = array();
	
	$lines = explode("\n",$data);
	foreach($lines as $line)
	{
		$record_type = substr($line,0,1);
		if($record_type == 'S')
		{
			$data = array(
						'recordtype' => $record_type,
						'sequence' => substr($line,1,5),
						'type_code' => substr($line,10,2),
						'latitude' => substr($line,13,14),
						'longitude' => substr($line,21,9),
						'identifier' => substr($line,30,6),
						'icao_region' => substr($line,36,2),
						'star_code' => substr($line,38,13),
						'transition_name' => substr($line,51,110),
						'numbered_fix' => substr($line,161,62),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$star[] = $data;
		}else // D
		{
			$data = array(
						'recordtype' => $record_type,
						'sequence' => substr($line,1,5),
						'type_code' => substr($line,10,2),
						'latitude' => substr($line,13,14),
						'longitude' => substr($line,21,9),
						'identifier' => substr($line,30,6),
						'icao_region' => substr($line,36,2),
						'dp_code' => substr($line,38,13),
						'transition_name' => substr($line,51,110),
						'numbered_fix' => substr($line,161,62),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$dp[] = $data;
		}
	}
	
	file_put_contents('./data/stardp_arrivals.json',json_encode($star));
	file_put_contents('./data/stardp_departures.json',json_encode($dp));
}
