<?php 

set_time_limit(0);
ini_set('memory_limit','1024M');

function process($date)
{
	// get data
	$data = get_data('https://nfdc.faa.gov/webContent/56DaySub/'.$date.'/TWR.zip','TWR.txt');

	$cycle = strtotime($date);
	echo 'cycle:'.$cycle;
	
	$twr1 = array();
	$twr2 = array();
	$twr3 = array();
	$twr4 = array();
	$twr5 = array();
	$twr6 = array();
	$twr7 = array();
	$twr8 = array();
	$twr9 = array();
	
	$lines = explode("\n",$data);
	foreach($lines as $line)
	{
		$record_type = substr($line,0,5);
		if($record_type == 'TWR1')
		{
			$data = array(
						'recordtype' => $record_type,
						'sensor_ident' => substr($line,5,4),
						'sensor_type' => substr($line,9,10),
						'commissioning_status' => substr($line,19,1),
						'commissioning_date' => substr($line,20,10),
						'navaid_flag' => substr($line,30,1),
						'station_latitude' => substr($line,31,14),
						'station_longitude' => substr($line,45,15),
						'elevation' => substr($line,60,7),
						'survey_method_code' => substr($line,67,1),
						'station_frequency' => substr($line,68,7),
						'second_station_frequency' => substr($line,75,7),
						'station_telephone_number' => substr($line,83,14),
						'second_station_telephone_number' => substr($line,96,14),
						'site_number' => substr($line,110,11),
						'city' => substr($line,121,40),
						'state_post' => substr($line,161,2),
						'effective_date' => substr($line,163,10),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$twr1[] = $data;
		}else
		{
			$data = array(
						'recordtype' => $record_type,
						'sensor_ident' => substr($line,5,4),
						'sensor_type' => substr($line,9,10),
						'remarks' => substr($line,19,236),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$awos2[] = $data;
		}
	}
	
	file_put_contents('./data/cdr.json',json_encode($cdr));
}