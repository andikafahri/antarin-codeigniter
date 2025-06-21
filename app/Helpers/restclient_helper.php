<?php
function api($method, $url, $token, $data = null) {
	$client = \Config\Services::curlrequest();

	$header = [
		'Authorization' => 'Bearer '.$token
	];

	if($data){
		$response = $client->request($method, $url, ['headers' => $header, 'json' => $data, 'http_errors' => false]);
	}else{
		$response = $client->request($method, $url, ['headers' => $header, 'http_errors' => false]);
	}

	// print_r($response->getStatusCode());
	$status = $response->getStatusCode();

	if($status === 200){
		return $response->getBody();
	}else if($status === 500){
		return json_encode(['errors' => 'Maaf, ada kendala pada erver']);
	}else if($status === 401){
		return redirect()->to('');
	}else{
		return $response->getBody();
	}
}
?>