<?php
function apiWithFile($method, $url, $token, $multipart) {
	$client = \Config\Services::curlrequest();

	$header = [
		'Authorization' => 'Bearer '. $token
	];

	// $options = [
	// 	'headers' => $header,
	// 	'http_errors' => false
	// ];

	// $multipart = [];
	// foreach ($data as $key => $value) {
	// 	$multipart[] = [
	// 		'name' => $key,
	// 		'contents' => is_array($value) ? json_encode($value) : $value
	// 	];
	// }

	// if($image && $image->isValid()){
	// 	$multipart[] = [
	// 		'name' => 'image',
	// 		'contents' => fopen($image->getTempName(), 'r'),
	// 		'filename' => $image->getClientName(),
	// 		'headers' => [
	// 			'Content-Type' => $image->getMimeType()
	// 		]
	// 	];	
	// }

	// dd($multipart);
	// echo $multipart;
	// $options['multipart'] = $multipart;

	// $response = $client->request($method, $url, $options);
	// print_r($multipart);
	$response = $client->request($method, $url, ['headers' => $header, 'multipart' => $multipart, 'http_errors' => false]);

	// echo $response->getBody();
	// print_r($response);
	$status = $response->getStatusCode();
	$body = $response->getBody();

	// if($status === 200){
	// 	return $response->getBody();
	// }else if($status === 500){
	// 	return json_encode(['errors' => 'Maaf, ada kendala pada erver']);
	// }else if($status === 401){
	// 	return redirect()->to('');
	// }else{
	// 	return $response->getBody();
	// }

	if($status === 401){
		return redirect()->to('');
	}else{
		return [
			'status' => $status,
			'body' => json_decode($body, true)
		];
	}

	// return json_decode($response->getBody(), true);
}
?>