<?php 

set_time_limit(0);
ini_set('memory_limit','1024M');

function process($date)
{
	// get data
	$data = get_data('https://nfdc.faa.gov/webContent/56DaySub/'.$date.'/NATFIX.zip','NATFIX.txt');

	$cycle = strtotime($date);
	echo 'cycle:'.$cycle;
	
	$cdr = array();
	
	$lines = explode("\n",$data);
	foreach($lines as $line)
	{
		$data = array(
					'ident' => substr($line,2,5),
					'lat' => substr($line,8,7),
					'lon' => substr($line,16,8),
					'artcc_id' => substr($line,26,4),
					'state_postcode' => substr($line,31,2),
					'icao_region' => substr($line,34,2),
					'type' => substr($line,37,7),
					'cycle' => $cycle,
					);
		foreach($data as $key => $value)
		{
			$data[$key] = trim($value);
		}
		
		$cdr[] = $data;
	}
	
	file_put_contents('./data/natfix.json',json_encode($cdr));
}