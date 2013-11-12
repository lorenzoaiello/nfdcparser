<?php

set_time_limit(0);
ini_set('memory_limit','1024M');

function process($date)
{
	// get data
	$data = get_data('https://nfdc.faa.gov/webContent/56DaySub/'.$date.'/ATS.zip','ATS.txt');

	$cycle = strtotime($date);
	echo 'cycle:'.$cycle;
	
	$ats1 = array();
	$ats2 = array();
	$ats3 = array();
	$ats4 = array();
	$ats5 = array();
	$ats6 = array();
	
	$lines = explode("\n",$data);
	foreach($lines as $line)
	{
		$record_type = substr($line,0,4);
		if($record_type == 'ATS1')
		{
			$data = array(
						'recordtype' => $record_type,
						'airway_designation' => substr($line,4,2),
						'airway_id' => substr($line,6,12),
						'rnav_indicator' => substr($line,18,1),
						'airway_type' => substr($line,19,1),
						'airway_point_sequence' => substr($line,20,5),
						'effective_date' => substr($line,25,10),
						'track_angle_outbound_rnav' => substr($line,35,7),
						'distance_to_changeover_rnav' => substr($line,42,5),
						'track_angle_inbound_rnav' => substr($line,47,7),
						'distance_to_next_point' => substr($line,54,6),
						'bearing' => substr($line,60,6),
						'segment_magnetic_course' => substr($line,66,6),
						'segment_magnetic_course_opposite' => substr($line,72,6),
						'distance_to_next_point_segment' => substr($line,78,6),
						'point_to_point_altitude_mea' => substr($line,84,5),
						'point_to_point_direction_mea' => substr($line,89,7),
						'point_to_point_altitude_mea_opposite' => substr($line,96,5),
						'point_to_point_direction_mea_opposite' => substr($line,101,7),
						'point_to_point_altitude_max' => substr($line,108,5),
						'point_to_point_obstruction_clearance' => substr($line,113,5),
						'airway_gap_flag' => substr($line,118,1),
						'distance_to_changeover' => substr($line,119,1),
						'minimum_crossing_altitude' => substr($line,122,5),
						'direction_of_crossing' => substr($line,127,7),
						'minimum_crossing_altitude_opposite' => substr($line,134,5),
						'direction_of_crossing_opposite' => substr($line,139,7),
						'gap_signal_coverage' => substr($line,146,1),
						'us_airspace_indicator' => substr($line,147,1),
						'navaid_magnetic_variation' => substr($line,148,5),
						'navaid_artcc' => substr($line,153,3),
						'to_point' => substr($line,156,40),
						'next_mea_point' => substr($line,196,50),
						'point_to_point_gnss_mea_n' => substr($line,246,5),
						'point_to_point_gnss_mea_a' => substr($line,251,7),
						'point_to_point_gnss_mea_n_opposite' => substr($line,259,5),
						'point_to_point_gnss_mea_a_opposite' => substr($line,264,7),
						'record_sort_sequence' => substr($line,271,7),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			if($data != array())
			{
				$ats1[] = $data;
			}
		}elseif($record_type == 'ATS2')
		{
			$data = array(
						'recordtype' => $record_type,
						'airway_designation' => substr($line,4,2),
						'airway_id' => substr($line,6,12),
						'rnav_indicator' => substr($line,18,1),
						'airway_type' => substr($line,19,1),
						'point_sequence_number' => substr($line,20,5),
						'navaid_fix_name' => substr($line,25,40),
						'navaid_fix_type' => substr($line,65,25),
						'navaid_fix_type_category' => substr($line,90,15),
						'navaid_fix_state_post' => substr($line,105,2),
						'icao_region' => substr($line,107,2),
						'navaid_fix_latitude' => substr($line,109,14),
						'navaid_fix_longitude' => substr($line,123,14),
						'fix_mra' => substr($line,137,5),
						'navaid_id' => substr($line,142,4),
						'from_point' => substr($line,146,57),
						'record_sort_sequence' => substr($line,270,7),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			if($data != array())
			{
				$ats2[] = $data;
			}
		}elseif($record_type == 'ATS3')
		{
			$data = array(
						'recordtype' => $record_type,
						'airway_designation' => substr($line,4,2),
						'airway_id' => substr($line,6,12),
						'rnav_indicator' => substr($line,18,1),
						'airway_type' => substr($line,19,1),
						'point_sequence_number' => substr($line,20,5),
						'navaid_facility_name' => substr($line,25,30),
						'navaid_facility_type' => substr($line,55,25),
						'navaid_facility_state_post' => substr($line,80,2),
						'navaid_facility_latitude' => substr($line,82,14),
						'navaid_facility_longitude' => substr($line,96,14),
						'record_sort_sequence' => substr($line,270,7),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			if($data != array())
			{
				$ats3[] = $data;
			}
		}elseif($record_type == 'ATS4')
		{
			$data = array(
						'recordtype' => $record_type,
						'airway_designation' => substr($line,4,2),
						'airway_id' => substr($line,6,12),
						'rnav_indicator' => substr($line,18,1),
						'airway_type' => substr($line,19,1),
						'point_sequence_number' => substr($line,20,5),
						'remarks_text' => substr($line,25,200),
						'record_sort_sequence' => substr($line,270,7),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			if($data != array())
			{
				$ats4[] = $data;
			}
		}elseif($record_type == 'ATS5')
		{
			$data = array(
						'recordtype' => $record_type,
						'airway_designation' => substr($line,4,2),
						'airway_id' => substr($line,6,12),
						'rnav_indicator' => substr($line,18,1),
						'airway_type' => substr($line,19,1),
						'point_sequence_number' => substr($line,20,5),
						'remarks_text' => substr($line,25,200),
						'record_sort_sequence' => substr($line,270,7),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			if($data != array())
			{
				$ats5[] = $data;
			}
		}else // RMK
		{
			$data = array(
						'recordtype' => $record_type,
						'airway_designation' => substr($line,4,2),
						'airway_id' => substr($line,6,12),
						'rnav_indicator' => substr($line,18,1),
						'airway_type' => substr($line,19,1),
						'remark_sequence_number' => substr($line,20,3),
						'remarks_reference' => substr($line,23,5),
						'remarks_text' => substr($line,28,200),
						'record_sort_sequence' => substr($line,270,7),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			if($data != array())
			{
				$ats6[] = $data;
			}
		}
	}
	
	file_put_contents('./data/ats_meadata.json',json_encode($ats1));
	file_put_contents('./data/ats_airwaypointdesc.json',json_encode($ats2));
	file_put_contents('./data/ats_changeoverpointremarks.json',json_encode($ats3));
	file_put_contents('./data/ats_airwaypointremarks.json',json_encode($ats4));
	file_put_contents('./data/ats_changeoverpointexception.json',json_encode($ats5));
	file_put_contents('./data/ats_airwayremark.json',json_encode($ats6));
}
