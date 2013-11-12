<?php

set_time_limit(0);
ini_set('memory_limit','2048M');

function process($date)
{	
	// get data
	$data = get_data('https://nfdc.faa.gov/webContent/56DaySub/'.$date.'/APT.zip','APT.txt');
	
	// process data
	$cycle = strtotime($date);
	echo 'cycle:'.$cycle;
	
	$apt = array();
	$att = array();
	$rwy = array();
	$ars = array();
	$rmk = array();

	$lines = explode("\n",$data);
	$data = NULL;
	foreach($lines as $line)
	{
		$record_type = substr($line,0,3);
		if($record_type == 'APT')
		{
			$data = array(
						'recordtype' => $record_type,
						'landing_site_number' => substr($line,3,11),
						'landing_facility_type' => substr($line,14,13),
						'location_identifier' => substr($line,27,4),
						'information_effective' => substr($line,31,10),
						'faa_region' => substr($line,41,3),
						'faa_district' => substr($line,44,4),
						'associated_state_post' => substr($line,48,2),
						'associated_state' => substr($line,50,20),
						'associated_county' => substr($line,70,21),
						'associated_county_state' => substr($line,91,2),
						'associated_city_name' => substr($line,93,40),
						'facility_name' => substr($line,133,50),
						'airport_ownership_type' => substr($line,183,2),
						'facility_use' => substr($line,185,2),
						'owner_name' => substr($line,187,35),
						'owner_address' => substr($line,222,72),
						'owner_csz' => substr($line,294,45),
						'owner_phone' => substr($line,339,16),
						'manager_name' => substr($line,355,35),
						'manager_address' => substr($line,390,72),
						'manager_csz' => substr($line,462,45),
						'manager_phone' => substr($line,507,16),
						'apt_ref_latitude_formatted' => substr($line,523,15),
						'apt_ref_latitude_seconds' => substr($line,538,12),
						'apt_ref_longitude_formatted' => substr($line,550,15),
						'apt_ref_longitude_seconds' => substr($line,565,12),
						'airport_ref_determination' => substr($line,577,1),
						'elevation' => substr($line,578,7),
						'elevation_determination' => substr($line,585,1),
						'magnetic_variation_direction' => substr($line,586,3),
						'magnetic_variation_epoch' => substr($line,589,4),
						'tpa' => substr($line,593,4),
						'sectional_chart' => substr($line,597,30),
						'distance_central_biz_district' => substr($line,627,2),
						'direction_central_biz_district' => substr($line,629,5),
						'landarea_covered' => substr($line,632,5),
						'boundary_artcc_id' => substr($line,637,4),
						'boundary_artcc_comp_id' => substr($line,641,3),
						'boundary_artcc_name' => substr($line,644,30),
						'responsible_artcc_id' => substr($line,674,4),
						'responsible_artcc_comp_id' => substr($line,678,3),
						'responsible_artcc_name' => substr($line,681,30),
						'tiein_fss' => substr($line,711,1),
						'tiein_fss_id' => substr($line,712,4),
						'tiein_fss_name' => substr($line,716,30),
						'local_phone' => substr($line,746,16),
						'tollfree_phone' => substr($line,762,16),
						'alternate_fss_id' => substr($line,778,4),
						'alternate_fss_name' => substr($line,782,30),
						'tollfree_phone_alt' => substr($line,812,16),
						'facility_notam_id' => substr($line,828,4),
						'notamd_availability' => substr($line,832,1),
						'airport_activation_date' => substr($line,834,7),
						'airport_status_code' => substr($line,840,2),
						'airport_arff_certification' => substr($line,842,15),
						'npias_federal_code' => substr($line,857,7),
						'airport_airspace' => substr($line,865,13),
						'facility_customs_entry' => substr($line,877,1),
						'facility_customs_landingrights' => substr($line,878,1),
						'facility_military_civiljoint' => substr($line,879,1),
						'facility_military_landingrights' => substr($line,880,1),
						'airport_inspection_method' => substr($line,881,2),
						'agencygroup_inspection' => substr($line,883,1),
						'last_physical_inspection' => substr($line,884,8),
						'last_date_information_request' => substr($line,892,8),
						'fuel_types_available' => substr($line,900,40),
						'airframe_repair' => substr($line,940,5),
						'powerplant_repair' => substr($line,945,5),
						'bottled_oxygen' => substr($line,950,8),
						'bulk_oxygen' => substr($line,958,9),
						'airport_lighting' => substr($line,966,7),
						'beacon_lighting_schedule' => substr($line,973,7),
						'atc_tower_onairport' => substr($line,980,1),
						'unicom_frequency' => substr($line,981,7),
						'ctaf_frequency' => substr($line,988,7),
						'segmented_circle' => substr($line,995,4),
						'beacon_color' => substr($line,999,3),
						'landing_free' => substr($line,1002,1),
						'medical_field' => substr($line,1003,1),
						'single_engine_aircraft' => substr($line,1004,3),
						'multi_engine_aircraft' => substr($line,1007,3),
						'jet_engine_aircraft' => substr($line,1010,3),
						'ga_helicopter' => substr($line,1013,3),
						'operational_gliders' => substr($line,1016,3),
						'operational_military' => substr($line,1019,3),
						'ultralight_aircraft' => substr($line,1022,3),
						'commercial_services' => substr($line,1025,6),
						'commuter_services' => substr($line,1031,6),
						'air_taxi' => substr($line,1037,6),
						'general_aviation_local' => substr($line,1043,6),
						'general_aviation_itinerant' => substr($line,1049,6),
						'military_aircraft' => substr($line,1055,6),
						'12month_ending' => substr($line,1061,10),
						'airport_position_source' => substr($line,1071,16),
						'airport_position_source_date' => substr($line,1087,10),
						'airport_elevation_source' => substr($line,1097,16),
						'airport_elevation_source_date' => substr($line,1113,10),
						'contract_fuel' => substr($line,1123,1),
						'transient_storage' => substr($line,1124,12),
						'other_services' => substr($line,1136,71),
						'wind_indicator' => substr($line,1207,3),
						'icao_identifier' => substr($line,1210,7),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}

			$apt[] = $data;
		}elseif($record_type == 'ATT')
		{
			$data = array(
						'recordtype' => $record_type,
						'site_number' => substr($line,3,11),
						'facility_state_post' => substr($line,14,2),
						'attendance_schedule_number' => substr($line,16,2),
						'attendance_schedule' => substr($line,18,108),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}

			$att[] = $data;
		}elseif($record_type == 'RWY')
		{
			$data = array(
						'recordtype' => $record_type,
						'site_number' => substr($line,3,11),
						'runway_state_post' => substr($line,14,2),
						'runway_identification' => substr($line,16,7),
						'runway_length' => substr($line,23,5),
						'runway_width' => substr($line,28,4),
						'runway_surface_typecondition' => substr($line,32,12),
						'runway_surface_treatment' => substr($line,44,5),
						'pavement_classification_number' => substr($line,49,11),
						'runway_lights_intensity' => substr($line,60,5),
						'baseend_identifier' => substr($line,65,3),
						'baseend_truealignment' => substr($line,68,3),
						'baseend_ilstype' => substr($line,71,10),
						'baseend_righthandpattern' => substr($line,81,1),
						'baseend_runwaymarkings_type' => substr($line,82,5),
						'baseend_runwaymarkings_condition' => substr($line,87,1),
						'baseend_latitude_formatted' => substr($line,88,15),
						'baseend_latitude_seconds' => substr($line,103,12),
						'baseend_longitude_formatted' => substr($line,115,15),
						'baseend_longitude_seconds' => substr($line,130,12),
						'baseend_elevation' => substr($line,142,7),
						'baseend_thresholdcrossingheight' => substr($line,149,3),
						'baseend_visualglidepathangle' => substr($line,152,4),
						'baseend_latitudedisplacedthreshold_formatted' => substr($line,156,15),
						'baseend_latitudedisplacedthreshold_seconds' => substr($line,171,15),
						'baseend_longitudedisplacedthreshold_formatted' => substr($line,183,12),
						'baseend_longitudedisplacedthreshold_seconds' => substr($line,198,12),
						'baseend_elevationdisplacedthreshold' => substr($line,210,7),
						'baseend_displacedthresholdlengthfromend' => substr($line,217,4),
						'baseend_elevationattouchdown' => substr($line,221,7),
						'baseend_visualglideslopeindicators' => substr($line,228,5),
						'baseend_rvrequipment' => substr($line,233,3),
						'baseend_rvvequipment' => substr($line,237,1),
						'baseend_approachlightsystem' => substr($line,237,8),
						'baseend_reilavailability' => substr($line,245,1),
						'baseend_centerlinelightsavailability' => substr($line,246,1),
						'baseend_touchdownlightsavailability' => substr($line,247,1),
						'baseend_controllingobjectdescription' => substr($line,248,11),
						'baseend_controllingobjectmarking' => substr($line,259,4),
						'baseend_faacfrpart77' => substr($line,263,5),
						'baseend_controllingobjectclearanceslope' => substr($line,270,2),
						'baseend_controllingobjectheight' => substr($line,270,5),
						'baseend_controllingobjectdistancefromend' => substr($line,275,5),
						'baseend_controllingobjectcenterlineoffset' => substr($line,281,7),
						'reciprocal_identifier' => substr($line,287,3),
						'reciprocal_truealignment' => substr($line,290,3),
						'reciprocal_ilstype' => substr($line,293,10),
						'reciprocal_righthandpattern' => substr($line,303,1),
						'reciprocal_runwaymarkings_type' => substr($line,304,5),
						'reciprocal_runwaymarkings_condition' => substr($line,309,1),
						'reciprocal_latitude_formatted' => substr($line,310,15),
						'reciprocal_latitude_seconds' => substr($line,325,12),
						'reciprocal_longitude_formatted' => substr($line,337,15),
						'reciprocal_longitude_seconds' => substr($line,352,12),
						'reciprocal_elevation' => substr($line,364,7),
						'reciprocal_thresholdcrossingheight' => substr($line,371,3),
						'reciprocal_visualglidepathangle' => substr($line,374,4),
						'reciprocal_latitudedisplacedthreshold_formatted' => substr($line,378,15),
						'reciprocal_latitudedisplacedthreshold_seconds' => substr($line,393,15),
						'reciprocal_longitudedisplacedthreshold_formatted' => substr($line,405,12),
						'reciprocal_longitudedisplacedthreshold_seconds' => substr($line,420,12),
						'reciprocal_elevationdisplacedthreshold' => substr($line,432,7),
						'reciprocal_displacedthresholdlengthfromend' => substr($line,439,4),
						'reciprocal_elevationattouchdown' => substr($line,443,7),
						'reciprocal_visualglideslopeindicators' => substr($line,450,5),
						'reciprocal_rvrequipment' => substr($line,455,3),
						'reciprocal_rvvequipment' => substr($line,458,1),
						'reciprocal_approachlightsystem' => substr($line,459,8),
						'reciprocal_reilavailability' => substr($line,467,1),
						'reciprocal_centerlinelightsavailability' => substr($line,468,1),
						'reciprocal_touchdownlightsavailability' => substr($line,469,1),
						'reciprocal_controllingobjectdescription' => substr($line,470,11),
						'reciprocal_controllingobjectmarking' => substr($line,481,4),
						'reciprocal_faacfrpart77' => substr($line,485,5),
						'reciprocal_controllingobjectclearanceslope' => substr($line,490,2),
						'reciprocal_controllingobjectheight' => substr($line,492,5),
						'reciprocal_controllingobjectdistancefromend' => substr($line,497,5),
						'reciprocal_controllingobjectcenterlineoffset' => substr($line,502,7),
						'runwaylength_source' => substr($line,509,16),
						'runwaylength_sourcedate' => substr($line,525,10),
						'runwaylength_weightbearingcapacity_single' => substr($line,535,6),
						'runwaylength_weightbearingcapacity_dual' => substr($line,541,6),
						'runwaylength_weightbearingcapacity_2dual' => substr($line,547,6),
						'runwaylength_weightbearingcapacity_2dualtandem' => substr($line,553,6),
						'baseend_gradient' => substr($line,559,5),
						'baseend_gradientdirection' => substr($line,564,4),
						'baseend_positionsource' => substr($line,568,16),
						'baseend_positionsourcedate' => substr($line,584,10),
						'baseend_elevationsource' => substr($line,594,16),
						'baseend_elevationsourcedate' => substr($line,610,10),
						'baseend_displacedthreshold_positionsource' => substr($line,620,16),
						'baseend_displacedthreshold_positionsourcedate' => substr($line,636,10),
						'baseend_displacedthreshold_elevationsource' => substr($line,646,16),
						'baseend_displacedthreshold_elevationsourcedate' => substr($line,662,10),
						'baseend_touchdown_elevationsource' => substr($line,672,16),
						'baseend_touchdown_elevationsourcedate' => substr($line,688,10),
						'baseend_tora' => substr($line,698,5),
						'baseend_toda' => substr($line,703,5),
						'baseend_asda' => substr($line,708,5),
						'baseend_lda' => substr($line,713,5),
						'baseend_lahso' => substr($line,718,5),
						'baseend_lahso_intersectionrunway' => substr($line,723,7),
						'baseend_lahso_intersectiondescription' => substr($line,730,40),
						'baseend_lahso_latitude_formatted' => substr($line,770,15),
						'baseend_lahso_latitude_seconds' => substr($line,785,12),
						'baseend_lahso_longitude_formatted' => substr($line,797,15),
						'baseend_lahso_longitude_seconds' => substr($line,812,12),
						'baseend_lahso_latlon_source' => substr($line,824,16),
						'baseend_lahso_latlon_sourcedate' => substr($line,840,10),
						'reciprocal_gradient' => substr($line,850,5),
						'reciprocal_gradientdirection' => substr($line,855,4),
						'reciprocal_positionsource' => substr($line,859,16),
						'reciprocal_positionsourcedate' => substr($line,875,10),
						'reciprocal_elevationsource' => substr($line,885,16),
						'reciprocal_elevationsourcedate' => substr($line,901,10),
						'reciprocal_displacedthreshold_positionsource' => substr($line,911,16),
						'reciprocal_displacedthreshold_positionsourcedate' => substr($line,927,10),
						'reciprocal_displacedthreshold_elevationsource' => substr($line,937,16),
						'reciprocal_displacedthreshold_elevationsourcedate' => substr($line,953,10),
						'reciprocal_touchdown_elevationsource' => substr($line,963,16),
						'reciprocal_touchdown_elevationsourcedate' => substr($line,979,10),
						'reciprocal_tora' => substr($line,989,5),
						'reciprocal_toda' => substr($line,994,5),
						'reciprocal_asda' => substr($line,708,5),
						'reciprocal_lda' => substr($line,999,5),
						'reciprocal_lahso' => substr($line,1009,5),
						'reciprocal_lahso_intersectionrunway' => substr($line,1014,7),
						'reciprocal_lahso_intersectiondescription' => substr($line,1021,40),
						'reciprocal_lahso_latitude_formatted' => substr($line,1061,15),
						'reciprocal_lahso_latitude_seconds' => substr($line,1076,12),
						'reciprocal_lahso_longitude_formatted' => substr($line,1088,15),
						'reciprocal_lahso_longitude_seconds' => substr($line,1103,12),
						'reciprocal_lahso_latlon_source' => substr($line,1115,16),
						'reciprocal_lahso_latlon_sourcedate' => substr($line,1141,10),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}

			$rwy[] = $data;
		}elseif($record_type == 'ARS')
		{
			$data = array(
						'recordtype' => $record_type,
						'site_number' => substr($line,3,11),
						'facility_state_post' => substr($line,14,2),
						'runway_identification' => substr($line,16,7),
						'runway_end_identification' => substr($line,23,3),
						'arresting_device' => substr($line,26,9),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}

			$ars[] = $data;
		}else
		{
			$data = array(
						'recordtype' => $record_type,
						'site_number' => substr($line,3,11),
						'facility_state_post' => substr($line,14,2),
						'remark_element' => substr($line,16,11),
						'remark' => substr($line,27,1500),
						'cycle' => $cycle,
						);
			foreach($data as $key => $value)
			{
				$data[$key] = trim($value);
			}

			$rmk[] = $data;
		}
	}
	
	$data = NULL;
	
	file_put_contents('./data/apt_landingfacility.json',json_encode($apt));
	file_put_contents('./data/apt_attendance.json',json_encode($att));
	file_put_contents('./data/apt_runways.json',json_encode($rwy));
	file_put_contents('./data/apt_arresting.json',json_encode($ars));
	file_put_contents('./data/apt_remarks.json',json_encode($rmk));
}
