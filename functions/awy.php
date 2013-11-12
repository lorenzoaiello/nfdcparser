<?php 

set_time_limit(0);
ini_set('memory_limit','1024M');


function process($date)
{
	// get data
	$data = get_data('https://nfdc.faa.gov/webContent/56DaySub/'.$date.'/AWY.zip','AWY.txt');

	$cycle = strtotime($date);
	echo 'cycle:'.$cycle;
	
	$awy1 = array();
	$awy2 = array();
	$awy3 = array();
	$awy4 = array();
	$awy5 = array();
	$awy6 = array();
	
	$lines = explode("\n",$data);
	foreach($lines as $line)
	{
		$record_type = substr($line,0,4);
		if($record_type == 'AWY1')
		{
			$data = array(
						'recordtype' => $record_type,
						'designation' => substr($line,4,5),
						'airway_type' => substr($line,9,1),
						'airway_point_sequence_number' => substr($line,10,5),
						'effective_date' => substr($line,15,10),
						'track_angle_outbound_rnav' => substr($line,25,7),
						'distance_to_changeover_rnav' => substr($line,32,5),
						'track_angle_inbound_rnav' => substr($line,37,7),
						'distance_to_next_point' => substr($line,44,6),
						'bearing' => substr($line,50,6),
						'segment_magnetic_course' => substr($line,56,6),
						'segment_magnetic_course_opposite' => substr($line,62,6),
						'distance_to_next_point_in_segment' => substr($line,68,6),
						'point_to_point_mea_n' => substr($line,74,5),
						'point_to_point_mea_a' => substr($line,79,6),
						'point_to_point_mea_n_opposite' => substr($line,85,5),
						'point_to_point_mea_a_opposite' => substr($line,90,6),
						'point_to_point_altitude_max' => substr($line,96,5),
						'point_to_point_moca' => substr($line,101,5),
						'airway_gap_flag' => substr($line,106,1),
						'distance_to_changeover_point' => substr($line,107,3),
						'minimum_crossing_altitude_n' => substr($line,110,5),
						'minimum_crossing_altitude_a' => substr($line,115,7),
						'minimum_crossing_altitude_n_opposite' => substr($line,122,5),
						'minimum_crossing_altitude_a_opposite' => substr($line,127,7),
						'gap_signal_indicator' => substr($line,134,1),
						'us_airspace_indicator' => substr($line,135,1),
						'navaid_magnetic_variation' => substr($line,136,5),
						'navaid_artcc' => substr($line,141,3),
						'to_point' => substr($line,144,33),
						'next_mea_point' => substr($line,177,40),
						'point_to_point_gnss_mea_n' => substr($line,217,5),
						'point_to_point_gnss_mea_a' => substr($line,222,6),
						'point_to_point_gnss_mea_n_opposite' => substr($line,228,5),
						'point_to_point_gnss_mea_a_opposite' => substr($line,233,6),
						'record_sequence_number' => substr($line,239,7),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$awy1[] = $data;
		}elseif($record_type == 'AWY2')
		{
			$data = array(
						'recordtype' => $record_type,
						'designation' => substr($line,4,5),
						'airway_type' => substr($line,9,1),
						'airway_point_sequence_number' => substr($line,10,5),
						'navaid_name' => substr($line,15,30),
						'navaid_type' => substr($line,45,19),
						'navaid_type_category' => substr($line,64,15),
						'navaid_state_post' => substr($line,89,2),
						'icao_region' => substr($line,81,2),
						'navaid_latitude' => substr($line,83,14),
						'navaid_longitude' => substr($line,97,14),
						'mra' => substr($line,111,5),
						'navaid_id' => substr($line,116,4),
						'from_point' => substr($line,120,40),
						'record_sequence_number' => substr($line,239,7),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			if($data != array())
			{
				$awy2[] = $data;
			}
		}elseif($record_type == 'AWY3')
		{
			$data = array(
						'recordtype' => $record_type,
						'designation' => substr($line,4,5),
						'airway_type' => substr($line,9,1),
						'airway_point_sequence_number' => substr($line,10,5),
						'navaid_name' => substr($line,15,30),
						'navaid_type' => substr($line,45,19),
						'navaid_state_post' => substr($line,64,2),
						'navaid_latitude' => substr($line,66,14),
						'navaid_longitude' => substr($line,80,14),
						'record_sequence_number' => substr($line,239,7),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			if($data != array())
			{
				$awy3[] = $data;
			}
		}elseif($record_type == 'AWY4')
		{
			$data = array(
						'recordtype' => $record_type,
						'designation' => substr($line,4,5),
						'airway_type' => substr($line,9,1),
						'airway_point_sequence_number' => substr($line,10,5),
						'remarks_text' => substr($line,15,202),
						'record_sequence_number' => substr($line,239,7),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			if($data != array())
			{
				$awy4[] = $data;
			}
		}elseif($record_type == 'AWY5')
		{
			$data = array(
						'recordtype' => $record_type,
						'designation' => substr($line,4,5),
						'airway_type' => substr($line,9,1),
						'airway_point_sequence_number' => substr($line,10,5),
						'remarks_text' => substr($line,15,202),
						'record_sequence_number' => substr($line,239,7),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			if($data != array())
			{
				$awy5[] = $data;
			}
		}else // RMK
		{
			$data = array(
						'recordtype' => $record_type,
						'designation' => substr($line,4,5),
						'airway_type' => substr($line,9,1),
						'remark_sequence_number' => substr($line,10,3),
						'remark_reference' => substr($line,13,6),
						'remarks_text' => substr($line,19,220),
						'record_sequence_number' => substr($line,239,7),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			if($data != array())
			{
				$awy6[] = $data;
			}
		}
	}
	
	file_put_contents('./data/awy_meadata.json',json_encode($awy1));
	file_put_contents('./data/awy_pointdesc.json',json_encode($awy2));
	file_put_contents('./data/awy_changeoverpointdesc.json',json_encode($awy3));
	file_put_contents('./data/awy_airwayremark.json',json_encode($awy4));
	file_put_contents('./data/awy_changeoverpointexception.json',json_encode($awy5));
	file_put_contents('./data/awy_remarks.json',json_encode($awy6));
}
