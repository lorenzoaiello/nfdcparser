<?php 

set_time_limit(0);
ini_set('memory_limit','1024M');

function process($date)
{
	// get data
	$data = get_data('https://nfdc.faa.gov/webContent/56DaySub/'.$date.'/HARFIX.zip','HARFIX.txt');

	$cycle = strtotime($date);
	echo 'cycle:'.$cycle;
	
	$harfix = array();
	
	$lines = explode("\n",$data);
	foreach($lines as $line)
	{
		$parts = explode(',',$line);
		$data = array(
					'ident' => substr($line,0,77),
					'latitude' => substr($line,78,12),
					'longitude' => substr($line,91,13),
					'type' => substr($line,105,1),
					'class' => substr($line,107,11),
					'pitch' => substr($line,119,1),
					'catch' => substr($line,121,1),
					'waypoint' => substr($line,123,1),
					'cycle' => $cycle,
					);
		foreach($data as $key => $value)
		{
			$data[$key] = trim($value);
		}
		
		$harfix[] = $data;
	}
	
	file_put_contents('./data/harfix.json',json_encode($harfix));
}