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
		$record_type = substr($line,0,4);
		if($record_type == 'TWR1')
		{
			$data = array(
						'recordtype' => $record_type,
						'terminal_ident' => substr($line,4,4),
						'effective_date' => substr($line,9,9),

						'site_number' => substr($line,18,11),
						'faa_region' => substr($line,29,3),
						'state_name' => substr($line,32,30),
						'state_postcode' => substr($line,62,2),
						'city_name' => substr($line,64,40),
						'airport_name' => substr($line,104,50),
						'refpoint_lat_formatted' => substr($line,154,14),
						'refpoint_lat_seconds' => substr($line,168,11),
						'refpoint_lon_formatted' => substr($line,179,14),
						'refpoint_lon_seconds' => substr($line,193,11),
						'tiein_fss_ident' => substr($line,204,4),
						'tiein_fss_name' => substr($line,208,30),

						'facility_type' => substr($line,238,12),
						'daily_numhours' => substr($line,250,2),
						'daily_numhours_regularity' => substr($line,252,3),
						'master_airport_ident' => substr($line,255,4),
						'master_airport_services' => substr($line,259,50),
						'dme_type' => substr($line,309,15),

						'offsite_landing_facility' => substr($line,324,50),
						'offsite_city' => substr($line,374,40),
						'offsite_state' => substr($line,414,20),
						'offsite_country' => substr($line,434,25),
						'offsite_post' => substr($line,459,2),
						'faa_region' => substr($line,461,3),

						'radar_lat_formatted' => substr($line,464,14),
						'radar_lat_seconds' => substr($line,478,11),
						'radar_lon_formatted' => substr($line,489,14),
						'radar_lon_seconds' => substr($line,503,11),
						'dme_lat_formatted' => substr($line,514,14),
						'dme_lat_seconds' => substr($line,528,11),
						'dme_lon_formatted' => substr($line,539,14),
						'dme_lon_seconds' => substr($line,553,11),

						'operator_agency' => substr($line,564,40),
						'operator_agency_military' => substr($line,604,40),
						'operator_agency_approach' => substr($line,644,40),
						'operator_agency_approach_secondary' => substr($line,684,40),
						'operator_agency_departure' => substr($line,724,40),
						'operator_agency_departure_secondary' => substr($line,764,40),

						'radio_call' => substr($line,804,26),
						'radio_call_military' => substr($line,830,26),
						'radio_call_approach' => substr($line,856,26),
						'radio_call_approach_secondary' => substr($line,882,26),
						'radio_call_departure' => substr($line,908,26),
						'radio_call_departure_secondary' => substr($line,934,26),

						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$twr1[] = $data;
		}elseif($record_type == 'TWR2')
		{
			$data = array(
						'recordtype' => $record_type,
						'terminal_ident' => substr($line,4,4),
						'hours_pmsv' => substr($line,8,200),
						'hours_macp' => substr($line,208,200),
						'hours_militaryops' => substr($line,408,200),
						'hours_approach' => substr($line,608,200),
						'hours_approach_secondary' => substr($line,808,200),
						'hours_departure' => substr($line,1008,200),
						'hours_departure_secondary' => substr($line,1208,200),
						'hours_tower' => substr($line,1408,200),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$twr2[] = $data;
		}elseif($record_type == 'TWR3')
		{
			$data = array(
						'recordtype' => $record_type,
						'terminal_ident' => substr($line,4,4),

						'freq1' => substr($line,8,44),
						'freq_use1' => substr($line,52,50),
						'freq2' => substr($line,102,44),
						'freq_use2' => substr($line,146,50),
						'freq3' => substr($line,196,44),
						'freq_use3' => substr($line,240,50),
						'freq4' => substr($line,290,44),
						'freq_use4' => substr($line,334,50),
						'freq5' => substr($line,384,44),
						'freq_use5' => substr($line,428,50),
						'freq6' => substr($line,478,44),
						'freq_use6' => substr($line,525,50),
						'freq7' => substr($line,572,44),
						'freq_use7' => substr($line,616,50),
						'freq8' => substr($line,666,44),
						'freq_use8' => substr($line,710,50),
						'freq9' => substr($line,760,44),
						'freq_use9' => substr($line,804,50),

						'freqn1' => substr($line,854,60),
						'freqn2' => substr($line,914,60),
						'freqn3' => substr($line,974,60),
						'freqn4' => substr($line,1034,60),
						'freqn5' => substr($line,1094,60),
						'freqn6' => substr($line,1154,60),
						'freqn7' => substr($line,1214,60),
						'freqn8' => substr($line,1274,60),
						'freqn9' => substr($line,1334,60),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$twr3[] = $data;
		}elseif($record_type == 'TWR4')
		{
			$data = array(
						'recordtype' => $record_type,
						'terminal_ident' => substr($line,4,4),
						'airport_services' => substr($line,8,100),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$twr4[] = $data;
		}elseif($record_type == 'TWR5')
		{
			$data = array(
						'recordtype' => $record_type,
						'terminal_ident' => substr($line,4,4),
						'approach_primary' => substr($line,8,9),
						'approach_secondary' => substr($line,17,9),
						'departure_primary' => substr($line,26,9),
						'departure_secondary' => substr($line,35,9),
						'radar1_type' => substr($line,44,10),
						'radar1_hours' => substr($line,54,200),
						'radar2_type' => substr($line,254,10),
						'radar2_hours' => substr($line,264,200),
						'radar3_type' => substr($line,464,10),
						'radar3_hours' => substr($line,474,200),
						'radar4_type' => substr($line,674,10),
						'radar4_hours' => substr($line,684,200),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$twr5[] = $data;
		}elseif($record_type == 'TWR6')
		{
			$data = array(
						'recordtype' => $record_type,
						'terminal_ident' => substr($line,4,4),
						'element_number' => substr($line,8,5),
						'remark_text' => substr($line,13,800),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$twr6[] = $data;
		}elseif($record_type == 'TWR7')
		{
			$data = array(
						'recordtype' => $record_type,
						'terminal_ident' => substr($line,4,4),
						'freq' => substr($line,8,44),
						'freq_use' => substr($line,52,50),
						'site_number' => substr($line,102,11),
						'location_ident' => substr($line,113,4),
						'faa_region' => substr($line,117,3),
						'state_name' => substr($line,120,30),
						'state_postcode' => substr($line,150,2),
						'state_city' => substr($line,152,40),
						'arpt_name' => substr($line,192,50),
						'lat_formatted' => substr($line,242,14),
						'lat_seconds' => substr($line,256,11),
						'lon_formatted' => substr($line,267,14),
						'lon_seconds' => substr($line,281,11),
						'fss_ident' => substr($line,292,4),
						'fss_name' => substr($line,296,30),

						'master_ident' => substr($line,326,11),
						'master_faa_region' => substr($line,337,3),
						'master_state_name' => substr($line,340,30),
						'master_state_postcode' => substr($line,370,2),
						'master_city' => substr($line,372,40),
						'master_name' => substr($line,412,50),
						'freq' => substr($line,462,60),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$twr7[] = $data;
		}elseif($record_type == 'TWR8')
		{
			$data = array(
						'recordtype' => $record_type,
						'terminal_ident' => substr($line,4,4),
						'class_b' => substr($line,8,1),
						'class_c' => substr($line,9,1),
						'class_d' => substr($line,10,1),
						'class_e' => substr($line,11,1),
						'hours' => substr($line,12,1),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$twr8[] = $data;
		}else
		{
			$data = array(
						'recordtype' => $record_type,
						'terminal_ident' => substr($line,4,4),
						'atis_serial' => substr($line,8,4),
						'atis_hours' => substr($line,12,200),
						'desc' => substr($line,212,100),
						'phone' => substr($line,312,18),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$twr9[] = $data;
		}
	}
	
	file_put_contents('./data/twr_basedata.json',json_encode($twr1));
	file_put_contents('./data/twr_operationalhours.json',json_encode($twr2));
	file_put_contents('./data/twr_commfreq.json',json_encode($twr3));
	file_put_contents('./data/twr_satairportservices.json',json_encode($twr4));
	file_put_contents('./data/twr_radar.json',json_encode($twr5));
	file_put_contents('./data/twr_commremarks.json',json_encode($twr6));
	file_put_contents('./data/twr_satairportdata.json',json_encode($twr7));
	file_put_contents('./data/twr_airspace.json',json_encode($twr8));
	file_put_contents('./data/twr_atis.json',json_encode($twr9));
}