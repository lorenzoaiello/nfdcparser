<?php

set_time_limit(0);
ini_set('memory_limit','1024M');

function process($date)
{
	// get data
	$data = get_data('https://nfdc.faa.gov/webContent/56DaySub/'.$date.'/ILS.zip','ILS.txt');

	$cycle = strtotime($date);
	echo 'cycle:'.$cycle;
	
	$ils1 = array();
	$ils2 = array();
	$ils3 = array();
	$ils4 = array();
	$ils5 = array();
	$ils6 = array();
	
	$lines = explode("\n",$data);
	foreach($lines as $line)
	{
		$record_type = substr($line,0,4);
		if($record_type == 'ILS1')
		{
			$data = array(
						'recordtype' => $record_type,
						'site_number' => substr($line,4,11),
						'ils_runwayid' => substr($line,15,3),
						'ils_type' => substr($line,18,10),
						'ident_code' => substr($line,28,6),
						'effective_date' => substr($line,34,10),
						'airport_name' => substr($line,44,50),
						'city' => substr($line,94,40),
						'state_code' => substr($line,134,2),
						'state' => substr($line,136,20),
						'region_code' => substr($line,156,3),
						'airport_ident' => substr($line,159,4),
						'rwy_length' => substr($line,163,5),
						'rwy_width' => substr($line,168,4),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$ils1[] = $data;
		}elseif($record_type == 'ILS2')
		{
			$data = array(
						'recordtype' => $record_type,
						'site_number' => substr($line,4,11),
						'ils_runwayid' => substr($line,15,3),
						'ils_type' => substr($line,18,10),
						'op_status' => substr($line,29,22),
						'effective_date' => substr($line,50,10),
						'lat_antenna_formatted' => substr($line,60,14),
						'lat_antenna_seconds' => substr($line,74,11),
						'lon_antenna_formatted' => substr($line,85,14),
						'lon_antenna_seconds' => substr($line,99,11),
						'coord_source' => substr($line,110,2),
						'loc_dis_aer' => substr($line,112,7),
						'loc_dis_centerline' => substr($line,119,4),
						'loc_dir_centerline' => substr($line,123,1),
						'dist_source' => substr($line,124,2),
						'site_elevation' => substr($line,126,7),
						'loc_freq' => substr($line,133,7),
						'loc_backcourse' => substr($line,140,15),
						'loc_width' => substr($line,155,5),
						'loc_width_threshold' => substr($line,160,7),
						'loc_distance' => substr($line,167,7),
						'loc_dir' => substr($line,174,1),
						'loc_services' => substr($line,175,2),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$ils2[] = $data;
		}elseif($record_type == 'ILS3')
		{
			$data = array(
						'recordtype' => $record_type,
						'site_number' => substr($line,4,11),
						'ils_runwayid' => substr($line,15,3),
						'ils_type' => substr($line,18,10),
						'op_status' => substr($line,28,22),
						'effective_date' => substr($line,50,10),
						'lat_gs_formatted' => substr($line,60,14),
						'lat_gs_seconds' => substr($line,74,11),
						'lon_gs_formatted' => substr($line,85,14),
						'lon_gs_seconds' => substr($line,99,11),
						'coord_source' => substr($line,110,2),
						'loc_dis_aer' => substr($line,112,7),
						'loc_dis_centerline' => substr($line,119,4),
						'loc_dir_centerline' => substr($line,123,1),
						'dist_source' => substr($line,124,2),
						'site_elevation' => substr($line,126,7),
						'gs_classtype' => substr($line,133,15),
						'gs_angle' => substr($line,148,5),
						'gs_freq' => substr($line,153,7),
						'elevation' => substr($line,160,8),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$ils3[] = $data;
		}elseif($record_type == 'ILS4')
		{
			$data = array(
						'recordtype' => $record_type,
						'site_number' => substr($line,4,11),
						'ils_runwayid' => substr($line,15,3),
						'ils_type' => substr($line,18,10),
						'op_status' => substr($line,28,22),
						'effective_date' => substr($line,50,10),
						'lat_dme_formatted' => substr($line,60,14),
						'lat_dme_seconds' => substr($line,74,11),
						'lon_dme_formatted' => substr($line,85,14),
						'lon_dme_seconds' => substr($line,99,11),
						'coord_source' => substr($line,110,2),
						'loc_dis_aer' => substr($line,112,7),
						'loc_dis_centerline' => substr($line,119,4),
						'loc_dir_centerline' => substr($line,123,1),
						'dist_source' => substr($line,124,2),
						'site_elevation' => substr($line,126,7),
						'dist_channel' => substr($line,133,4),
						'dist_dme' => substr($line,137,7),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$ils4[] = $data;
		}elseif($record_type == 'ILS5')
		{
			$data = array(
						'recordtype' => $record_type,
						'site_number' => substr($line,4,11),
						'ils_runwayid' => substr($line,15,3),
						'ils_type' => substr($line,18,10),
						'op_status' => substr($line,28,22),
						'effective_date' => substr($line,50,10),
						'lat_dme_formatted' => substr($line,60,14),
						'lat_dme_seconds' => substr($line,74,11),
						'lon_dme_formatted' => substr($line,85,14),
						'lon_dme_seconds' => substr($line,99,11),
						'coord_source' => substr($line,110,2),
						'loc_dis_aer' => substr($line,112,7),
						'loc_dis_centerline' => substr($line,119,4),
						'loc_dir_centerline' => substr($line,123,1),
						'dist_source' => substr($line,124,2),
						'site_elevation' => substr($line,126,7),
						'type' => substr($line,135,15),
						'loc_ident' => substr($line,150,2),
						'name' => substr($line,152,30),
						'freq' => substr($line,182,3),
						'ident_str' => substr($line,185,25),
						'ndb_status' => substr($line,210,22),
						'service' => substr($line,232,30),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$ils5[] = $data;
		}else // RMK
		{
			$data = array(
						'recordtype' => $record_type,
						'site_number' => substr($line,4,11),
						'ils_runwayid' => substr($line,15,3),
						'ils_type' => substr($line,18,10),
						'remarks_text' => substr($line,28,350),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$ils6[] = $data;
		}
	}
	
	file_put_contents('./data/ils_basedata.json',json_encode($ils1));
	file_put_contents('./data/ils_localizer.json',json_encode($ils2));
	file_put_contents('./data/ils_glideslope.json',json_encode($ils3));
	file_put_contents('./data/ils_dme.json',json_encode($ils4));
	file_put_contents('./data/ils_markerbeacon.json',json_encode($ils5));
	file_put_contents('./data/ils_remarks.json',json_encode($ils6));
}
