<?php 

set_time_limit(0);
ini_set('memory_limit','1024M');

function process($date)
{
	// get data
	$data = get_data('https://nfdc.faa.gov/webContent/56DaySub/'.$date.'/CDR.zip','CDR.txt');

	$cycle = strtotime($date);
	echo 'cycle:'.$cycle;
	
	$cdr = array();
	
	$lines = explode("\n",$data);
	foreach($lines as $line)
	{
		$parts = explode(',',$line);
		$data = array(
					'route_code' => $parts[0],
					@'origin' => $parts[1],
					@'destination' => $parts[2],
					@'departure_fix' => $parts[3],
					@'route_string' => $parts[4],
					@'artcc' => $parts[5],
					'cycle' => $cycle,
					);
		foreach($data as $key => $value)
		{
			$data[$key] = trim($value);
		}
		
		$cdr[] = $data;
	}
	
	file_put_contents('./data/cdr.json',json_encode($cdr));
}