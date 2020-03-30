<?php
	$kawalcoronaProvinsi = file_get_contents("https://api.kawalcorona.com/indonesia/provinsi/");
  $kasusProvinsi = json_decode($kawalcoronaProvinsi, TRUE);

  $geojsonProvinsi = file_get_contents("data/provinsi_polygon.geojson");
  $pointProvinsi = json_decode($geojsonProvinsi, TRUE);

  
	foreach ($pointProvinsi['features'] as $key => $first_value) {
    foreach ($kasusProvinsi as $second_value) {
      if($first_value['properties']['Kode_Provi']==$second_value['attributes']['Kode_Provi']){
      	$pointProvinsi['features'][$key]['properties']['Kasus_Positif'] = $second_value['attributes']['Kasus_Posi'];
        $pointProvinsi['features'][$key]['properties']['Kasus_Sembuh'] = $second_value['attributes']['Kasus_Semb'];
        $pointProvinsi['features'][$key]['properties']['Kasus_Meninggal'] = $second_value['attributes']['Kasus_Meni'];
    	} else {}
		}
	}
	$combined_output = json_encode($pointProvinsi); 

	header("Access-Control-Allow-Origin: *");
	header('Content-Type: application/json');
	echo $combined_output;
?>