<?php 

set_time_limit(0);
ini_set('memory_limit','1024M');

function process($date)
{
	// get data
	$data = get_data('https://nfdc.faa.gov/webContent/56DaySub/'.$date.'/AWOS.zip','AWOS.txt');

	$cycle = strtotime($date);
	echo 'cycle:'.$cycle;
	
	$awos1 = array();
	$awos2 = array();
	
	$lines = explode("\n",$data);
	foreach($lines as $line)
	{
		$record_type = substr($line,0,5);
		if($record_type == 'AWOS1')
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
			
			$awos1[] = $data;
		}else // AWOS2
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
	
	file_put_contents('./data/awos_basedata.json',json_encode($awos1));
	file_put_contents('./data/awos_remarks.json',json_encode($awos2));
}
