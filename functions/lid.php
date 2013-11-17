<?php

set_time_limit(0);
ini_set('memory_limit','1024M');

function process($date)
{
	// get data
	$data = get_data('https://nfdc.faa.gov/webContent/56DaySub/'.$date.'/LID.zip','LID.txt');
	
	// process data
	$cycle = strtotime($date);
	echo 'cycle:'.$cycle;
	
	$usa = array();
	$dod = array();
	$can = array();
	
	$lines = explode("\n",$data);
	foreach($lines as $line)
	{
		$record_type = substr($line,1,3);
		if($record_type == 'USA')
		{
			$data = array(
						'sort_code' => substr($line,0,1),
						'group_code' => $record_type,
						'loc_ident' => substr($line,4,5),

						'faa_region' => substr($line,9,3),
						'state' => substr($line,12,2),
						'city' => substr($line,14,40),
						'artcc' => substr($line,54,4),
						'artcc_id' => substr($line,58,3),

						'lf_name' => substr($line,61,50),
						'lf_type' => substr($line,111,13),
						'lf_fss_ident' => substr($line,124,4),

						'navaid_name1' => substr($line,128,30),
						'navaid_type1' => substr($line,158,20),
						'navaid_name2' => substr($line,178,30),
						'navaid_type2' => substr($line,208,20),
						'navaid_name3' => substr($line,228,30),
						'navaid_type3' => substr($line,258,20),
						'navaid_name4' => substr($line,278,30),
						'navaid_type4' => substr($line,308,20),
						'navaid_fss_ident' => substr($line,328,4),

						'ils_rwyend' => substr($line,332,3),
						'ils_type' => substr($line,335,20),
						'ils_locid' => substr($line,355,5),
						'ils_airport' => substr($line,360,50),
						'ils_fss_ident' => substr($line,410,4),

						'fss_name' => substr($line,414,30),

						'artcc_name' => substr($line,444,30),
						'artcc_type' => substr($line,474,17),

						'fltwo_id' => substr($line,491,1),
						'ofac_name' => substr($line,492,75),
						'ofac_type' => substr($line,567,15),
						'effective_date' => substr($line,582,10),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$usa[] = $data;
		}elseif($record_type == 'DOD')
		{
			$data = array(
						'sort_code' => substr($line,0,1),
						'group_code' => $record_type,
						'loc_ident' => substr($line,4,5),
						'loc_country' => substr($line,9,30),
						'loc_slq' => substr($line,39,20),
						'loc_city' => substr($line,59,50),

						'lf_name' => substr($line,109,50),
						'lf_type' => substr($line,159,20),

						'navaid_name1' => substr($line,179,50),
						'navaid_type1' => substr($line,229,20),
						'navaid_name2' => substr($line,249,50),
						'navaid_type2' => substr($line,299,20),

						'ofac_name1' => substr($line,319,50),
						'ofac_type1' => substr($line,369,20),
						'ofac_name2' => substr($line,389,50),
						'ofac_type2' => substr($line,439,20),
						'effective_date' => substr($line,459,10),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$dod[] = $data;
		}else
		{
			$data = array(
						'sort_code' => substr($line,0,1),
						'group_code' => $record_type,
						'loc_ident' => substr($line,4,5),

						'province' => substr($line,9,10),
						'city' => substr($line,19,50),

						'lf_name' => substr($line,61,50),
						'lf_type' => substr($line,111,13),
						'lf_fss_ident' => substr($line,124,4),

						'navaid_name1' => substr($line,69,50),
						'navaid_desc1' => substr($line,119,50),
						'navaid_type1' => substr($line,169,20),
						'navaid_name2' => substr($line,189,50),
						'navaid_desc2' => substr($line,239,50),
						'navaid_type2' => substr($line,289,20),
						'navaid_name3' => substr($line,309,50),
						'navaid_desc3' => substr($line,359,50),
						'navaid_type3' => substr($line,409,20),

						'navaid_name1' => substr($line,429,30),
						'navaid_desc1' => substr($line,459,50),
						'navaid_type1' => substr($line,509,20),
						'navaid_name2' => substr($line,529,30),
						'navaid_desc2' => substr($line,559,50),
						'navaid_type2' => substr($line,609,20),

						'ils_name1' => substr($line,629,30),
						'ils_desc1' => substr($line,659,50),
						'ils_type1' => substr($line,709,20),
						'ils_name2' => substr($line,729,30),
						'ils_desc2' => substr($line,759,50),
						'ils_type2' => substr($line,809,20),

						'of_name1' => substr($line,829,30),
						'of_desc1' => substr($line,859,50),
						'of_type1' => substr($line,909,20),
						'of_name2' => substr($line,929,30),
						'of_desc2' => substr($line,959,50),
						'of_type2' => substr($line,1009,20),

						'effective_date' => substr($line,1029,10),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}
			
			$can[] = $data;
		}
	}
	
	file_put_contents('./data/lid_usa.json',json_encode($usa));
	file_put_contents('./data/lid_dod.json',json_encode($dod));
	file_put_contents('./data/lid_can.json',json_encode($can));
}
