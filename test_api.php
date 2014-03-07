<?php 
	$service_url = 'http://localhost:8888/vodafone/api.php';
	$service_url = 'http://54.201.188.6/vodafone/api.php';
	$curl = curl_init($service_url);
	$curl_post_data = array(
			"request"	=> 'login',
	        "usuario" 	=> 'test@test.com',
			"password" 	=> 'test1',
		);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
	$curl_response = curl_exec($curl);
	curl_close($curl);
	
	echo " " . $curl_response;
?>