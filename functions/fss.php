<?php 

set_time_limit(0);
ini_set('memory_limit','1024M');

function process($date)
{
	// get data
	$data = get_data('https://nfdc.faa.gov/webContent/56DaySub/'.$date.'/FSS.zip','FSS.txt');

	$cycle = strtotime($date);
	echo 'cycle:'.$cycle;
	
	$fss = array();
	
	$lines = explode("\n",$data);
	foreach($lines as $line)
	{
		$remarks = substr($line,4657,40);
		$remarks = explode('5F',$remarks);

		$com_remarks = substr($line,16499,1050);
		$com_remarks = explode('5F',$com_remarks);

		$data = array(
					'record_ident' => substr($line,0,4),
					'name' => substr($line,4,25),
					'site_number' => substr($line,30,11),
					'airport_name' => substr($line,51,11),
					'airport_city' => substr($line,102,26),
					'airport_state' => substr($line,128,20),
					'airport_lat' => substr($line,148,14),
					'airport_lon' => substr($line,162,14),
					'types' => substr($line,176,8),
					'ident' => substr($line,184,26),
					'fss_owner_code' => substr($line,210,1),
					'fss_owner_name' => substr($line,211,69),
					'fss_operator_code' => substr($line,280,1),
					'fss_operator_name' => substr($line,281,69),
					'primary_fss_freq' => str_split(substr($line,350,2400),40),
					'fss_hours' => substr($line,2750,100),
					'status' => substr($line,2850,20),
					'fss_name' => substr($line,2870,3),
					'com_outlet_ident' => str_split(substr($line,2873,560),14),
					'navaid_ident' => str_split(substr($line,3433,525),7),
					'weather_radar' => substr($line,3978,1),
					'efas' => substr($line,3979,10),
					'flight_watch_hours' => substr($line,3989,50),
					'city' => substr($line,4039,26),
					'state' => substr($line,4065,20),
					'lat' => substr($line,4085,14),
					'lon' => substr($line,4199,14),
					'region' => substr($line,4113,3),
					'advisory_freq' => str_split(substr($line,4119,120),6),
					'freq_broadcasts' => str_split(substr($line,4239,120),6),
					'volmet_schedule' => str_split(substr($line,4359,240),12),
					'df_type' => substr($line,4599,30),
					'df_lat' => substr($line,4629,14),
					'df_lon' => substr($line,4643,14),
					'lowalt_enroutechart' => str_split(substr($line,4657,40),2),
					'telephone' => substr($line,4657,40),
					'station_remarks' => $remarks,
					'facility_city' => str_split(substr($line,5809,780),26),
					'facility_state' => str_split(substr($line,6589,600),20),
					'geo_lat' => str_split(substr($line,7189,420),14),
					'geo_lon' => str_split(substr($line,7609,420),14),
					'facility_owner_code' => str_split(substr($line,8029,40),1),
					'facility_owner_name' => str_split(substr($line,8069,2760),69),
					'facility_operator_code' => str_split(substr($line,10829,40),1),
					'facility_operator_name' => str_split(substr($line,10869,2760),69),
					'fss_com' => str_split(substr($line,13629,160),4),
					'freq_coms' => str_split(substr($line,13789,540),9),
					'op_hours' => str_split(substr($line,14329,800),20),
					'com_status' => str_split(substr($line,15129,800),20),
					'com_facility_date' => str_split(substr($line,15929,330),11),
					'navaid_ident' => str_split(substr($line,16259,140),7),
					'lowalt_enroutechart_com' => str_split(substr($line,16399,60),2),
					'std_timezone' => str_split(substr($line,16459,40),2),
					'com_remarks' => $com_remarks,
					'date' => substr($line,17549,11),
					'cycle' => $cycle,
					);
		foreach($data as $key => $value)
		{
			if(!is_array($value))
			{
				$data[$key] = @trim($value);
			}
		}
		$fss[] = $data;
	}
	
	file_put_contents('./data/fss.json',json_encode($fss));
}