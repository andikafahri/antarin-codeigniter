<?php

namespace App\Controllers\MerchantApp;
use App\Controllers\BaseController;

class LoginController extends BaseController
{
	public function index() {
		return view('MerchantApp/login');
	}

	public function reqLogin() {
		$client = \Config\Services::curlrequest();
		$request = $this->request->getPost();

		$url = env('API_BASE_URL').'/api/merchant/login';
		$data = [
			'username' => $request['username'],
			'password' => $request['password']
		];

		$result = $client->request('POST', $url, ['json' => $data, 'http_errors' => false]);

		$response = json_decode($result->getBody(), true);

		// return $this->response->setJSON([
		// 	'status' => $result->getStatusCode(),
		// 	'data' => $result
		// ]);
		echo $result->getBody();
	}
}
