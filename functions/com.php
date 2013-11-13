<?php 

set_time_limit(0);
ini_set('memory_limit','1024M');

function process($date)
{
	// get data
	$data = get_data('https://nfdc.faa.gov/webContent/56DaySub/'.$date.'/COM.zip','COM.txt');

	$cycle = strtotime($date);
	echo 'cycle:'.$cycle;
	
	$com = array();
	
	$lines = explode("\n",$data);
	foreach($lines as $line)
	{
		$data = array(
					'outlet_ident' => substr($line,0,4),
					'outlet_type' => substr($line,4,7),
					'assoc_navaid_ident' => substr($line,11,4),
					'assoc_navaid_type' => substr($line,15,2),
					'assoc_navaid_city' => substr($line,17,26),
					'assoc_navaid_state' => substr($line,43,20),
					'assoc_navaid_name' => substr($line,63,26),
					'assoc_navaid_lat' => substr($line,89,14),
					'assoc_navaid_lon' => substr($line,103,14),

					'com_navaid_city' => substr($line,117,26),
					'com_navaid_state' => substr($line,143,20),
					'com_navaid_region_name' => substr($line,163,20),
					'com_navaid_region_code' => substr($line,183,3),
					'com_navaid_lat' => substr($line,186,14),
					'com_navaid_lon' => substr($line,200,14),
					'com_navaid_call' => substr($line,214,26),
					'com_navaid_freq' => str_split(substr($line,240,144),9),

					'fss_ident' => substr($line,384,4),
					'fss_ident_name' => substr($line,388,30),
					'alt_fss_ident' => substr($line,418,4),
					'alt_fss_ident_name' => substr($line,422,30),
					'op_hours' => str_split(substr($line,452,60),20),
					'owner_code' => substr($line,512,1),
					'owner_name' => substr($line,513,69),
					'operator_code' => substr($line,582,1),
					'operator_name' => substr($line,583,69),
					'charts' => substr($line,652,8),
					'timezone' => substr($line,660,2),
					'status' => substr($line,662,20),
					'status_date' => substr($line,682,11),
					'cycle' => $cycle,
					);
		foreach($data as $key => $value)
		{
			if(!is_array($value))
			{
				$data[$key] = @trim($value);
			}
		}
		$com[] = $data;
	}
	
	file_put_contents('./data/com.json',json_encode($com));
}