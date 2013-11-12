<?php 

set_time_limit(0);
ini_set('memory_limit','1024M');

function process($date)
{
	// get data
	$data = get_data('https://nfdc.faa.gov/webContent/56DaySub/'.$date.'/ARB.zip','ARB.txt');
	
	// process data
	$cycle = strtotime($date);
	echo 'cycle:'.$cycle;
	
	$arb = array();
	
	$lines = explode("\n",$data);
	foreach($lines as $line)
	{
		$data = array(
					'record_identifier' => substr($line,0,12),
					'center_name' => substr($line,12,40),
					'altitude_structure' => substr($line,52,10),
					'latitude_boundary' => substr($line,62,14),
					'longitude_boundary' => substr($line,76,14),
					'boundary_line_points' => substr($line,90,300),
					'boundary_sequence' => substr($line,390,6),
					'not_legal' => substr($line,396,1),
					'cycle' => $cycle,
					);
		foreach($data as $key => $value)
		{
			$data[$key] = trim($value);
		}
		
		$arb[] = $data;
	}
	
	file_put_contents('./data/arb_artccboundary.json',json_encode($arb));
}