<?php 

set_time_limit(0);
ini_set('memory_limit','1024M');


function process($date)
{
	// get data
	$data = get_data('https://nfdc.faa.gov/webContent/56DaySub/'.$date.'/NAV.zip','NAV.txt');

	$cycle = strtotime($date);
	echo 'cycle:'.$cycle;
	
	$nav1 = array();
	$nav2 = array();
	$nav3 = array();
	$nav4 = array();
	$nav5 = array();
	$nav6 = array();
	
	$lines = explode("\n",$data);
	foreach($lines as $line)
	{
		$record_type = substr($line,0,4);
		if($record_type == 'NAV1')
		{
			$data = array(
						'recordtype' => $record_type,
						'ident' => substr($line,4,4),
						'type' => substr($line,8,20),
						'official_ident' => substr($line,28,4),

						'admin_effective_date' => substr($line,32,10),
						'admin_name' => substr($line,42,30),
						'admin_city' => substr($line,72,40),
						'admin_state' => substr($line,112,30),
						'admin_state_post' => substr($line,142,2),
						'admin_faa_region' => substr($line,144,3),
						'admin_country' => substr($line,147,30),
						'admin_country_code' => substr($line,177,2),
						'admin_owner' => substr($line,179,50),
						'admin_operator' => substr($line,229,50),
						'admin_systemuse' => substr($line,279,1),
						'admin_publicuse' => substr($line,280,1),
						'admin_class' => substr($line,281,11),
						'admin_hours' => substr($line,292,11),
						'admin_artcc_high_ident' => substr($line,303,4),
						'admin_artcc_high_name' => substr($line,307,30),
						'admin_artcc_low_ident' => substr($line,337,4),
						'admin_artcc_low_name' => substr($line,341,30),

						'geo_lat_formatted' => substr($line,371,14),
						'geo_lat_seconds' => substr($line,385,11),
						'geo_lon_formatted' => substr($line,396,14),
						'geo_lon_seconds' => substr($line,410,11),
						'geo_coord_code' => substr($line,421,1),
						'geo_lat_tacan_formatted' => substr($line,422,14),
						'geo_lat_tacan_seconds' => substr($line,436,11),
						'geo_lon_tacan_formatted' => substr($line,447,14),
						'geo_lon_tacan_seconds' => substr($line,461,11),
						'geo_elevation' => substr($line,472,7),
						'geo_variation_deg' => substr($line,479,5),
						'geo_variation_epoch' => substr($line,484,4),

						'asdf' => substr($line,341,30),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$nav1[] = $data;
		}elseif($record_type == 'NAV2')
		{
			$data = array(
						'recordtype' => $record_type,
						'ident' => substr($line,4,4),
						'type' => substr($line,8,20),
						'remarks' => substr($line,28,600),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$nav2[] = $data;
		}elseif($record_type == 'NAV3')
		{
			$data = array(
						'recordtype' => $record_type,
						'ident' => substr($line,4,4),
						'type' => substr($line,8,20),
						'names' => substr($line,28,36),
						'space_fixes' => substr($line,64,720),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$nav3[] = $data;
		}elseif($record_type == 'NAV4')
		{
			$data = array(
						'recordtype' => $record_type,
						'ident' => substr($line,4,4),
						'type' => substr($line,8,20),
						'names' => substr($line,28,80),
						'pattern_number' => substr($line,108,3),
						'space_hp' => split(substr($line,111,664),83),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				if(!is_array($value))
				{
					$data[$key] = @trim($value);
				}
			}
			
			$nav4[] = $data;
		}elseif($record_type == 'NAV5')
		{
			$data = array(
						'recordtype' => $record_type,
						'ident' => substr($line,4,4),
						'type' => substr($line,8,20),
						'names' => substr($line,28,30),
						'space' => substr($line,69,690),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$nav5[] = $data;
		}else // RMK
		{
			$data = array(
						'recordtype' => $record_type,
						'ident' => substr($line,4,4),
						'type' => substr($line,8,20),
						'code' => substr($line,39,3),
						'bearing' => substr($line,30,2),
						'altitude' => substr($line,33,5),
						'airport_id' => substr($line,38,4),
						'state' => substr($line,42,2),
						'desc_inair' => substr($line,44,75),
						'desc_ground' => substr($line,119,75),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$nav6[] = $data;
		}
	}
	
	file_put_contents('./data/nav_basedata.json',json_encode($nav1));
	file_put_contents('./data/nav_remarks.json',json_encode($nav2));
	file_put_contents('./data/nav_fixes.json',json_encode($nav3));
	file_put_contents('./data/nav_hpf.json',json_encode($nav4));
	file_put_contents('./data/nav_fanmarkers.json',json_encode($nav5));
	file_put_contents('./data/nav_vorreceiver.json',json_encode($nav6));
}
