<?php

namespace App\Controllers\MerchantApp;
use App\Controllers\BaseController;

class DashboardController extends BaseController
{
	private $apiUrl;

	public function __construct(){
		helper(['restclient', 'restclientfile']);
		$this->apiUrl = env('API_BASE_URL').'/api';
	}

	public function index() {
		$data = [
			'title' => 'Dashboard'
		];
		return view('MerchantApp/dashboard', $data);
	}

	public function getProfile() {
		$token = $this->request->getHeaderLine('Authorization');
		$resp = api('GET', $this->apiUrl.'/merchant', $token);
		echo $resp;
	}

	public function getCategory() {
		$token = $this->request->getHeaderLine('Authorization');
		$resp = api('GET', $this->apiUrl.'/category', $token);
		echo $resp;
	}

	public function getMenu() {
		$token = $this->request->getHeaderLine('Authorization');

		$searchFilter = $this->request->getGet('search');
		$categoryFilter = $this->request->getGet('category');

		if($categoryFilter != 'all'){
			$resp = api('GET', $this->apiUrl.'/menu?search='.$searchFilter.'&category='.$categoryFilter, $token);
		}else{
			$resp = api('GET', $this->apiUrl.'/menu?search='.$searchFilter, $token);
		}

		echo $resp;
	}

	public function addMenu() {
		$token = $this->request->getHeaderLine('Authorization');

		$multipart = [
			'name' => $this->request->getPost('name'),
			'detail' => $this->request->getPost('detail'),
			'id_category' => $this->request->getPost('id_category'),
			'price' => $this->request->getPost('price'),
			'is_ready' => $this->request->getPost('is_ready')
		];

		$image = $this->request->getFile('image');
		if ($image) {
			if ($image->isValid() && !$image->hasMoved()) {
				$allowedType = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
				if(!in_array($image->getMimeType(), $allowedType)){
					return $this->response->setJSON(['errors' => 'File harus berupa gambar']);
				}else{
					$multipart['file'] = new \CURLFile($image->getTempName(), $image->getMimeType(), $image->getName());
				}
			}
		}else{
			return $this->response->setStatusCode(400)->setJSON(['errors' => 'Gambar tidak boleh kosong']);
		}

		$response = apiWithFile('POST', $this->apiUrl.'/menu', $token, $multipart);

		// return $this->response->setJSON($response);
		// echo json_encode($response['body'], JSON_PRETTY_PRINT);
		return $this->response->setStatusCode($response['status'])->setJSON($response['body']);
	}

	public function updateMenu() {
		$token = $this->request->getHeaderLine('Authorization');

		$multipart = [
			'name' => $this->request->getPost('name'),
			'detail' => $this->request->getPost('detail'),
			'id_category' => $this->request->getPost('id_category'),
			'price' => $this->request->getPost('price'),
			'is_ready' => $this->request->getPost('is_ready')
		];

		$image = $this->request->getFile('image');
		if ($image = $this->request->getFile('image')) {
			if ($image->isValid() && !$image->hasMoved()) {
				$allowedType = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
				if(!in_array($image->getMimeType(), $allowedType)){
					return $this->response->setJSON(['errors' => 'File harus berupa gambar']);
				}else{
					$multipart['file'] = new \CURLFile($image->getTempName(), $image->getMimeType(), $image->getName());
				}
			}
		}

		$response = apiWithFile('PUT', $this->apiUrl.'/menu/'.$this->request->getGet('id'), $token, $multipart);

		// echo $response;
		// return $this->response->setJSON($response);
		return $this->response->setStatusCode($response['status'])->setJSON($response['body']);
	}

	public function deleteMenu() {
		$token = $this->request->getHeaderLine('Authorization');

		$response = api('DELETE', $this->apiUrl.'/menu/'.$this->request->getGet('id'), $token);

		// echo $response;
		return $this->response->setJSON($response);
	}

	public function addMenuFIX() {
		$client = \Config\Services::curlrequest();
		$token = $this->request->getHeaderLine('Authorization');

		// Prepare the form data
		$formData = [
			'name' => $this->request->getPost('name'),
			'detail' => $this->request->getPost('detail'),
			'id_category' => $this->request->getPost('id_category'), // Ensure numeric
			'price' => $this->request->getPost('price'), // Ensure numeric
			'is_ready' => $this->request->getPost('is_ready'), // Ensure numeric
			'variants' => $this->request->getPost('variants') // Encode as JSON if array
		];

		// For file upload (if needed)
		if ($image = $this->request->getFile('image')) {
			if ($image->isValid() && !$image->hasMoved()) {
				$formData['image'] = new \CURLFile($image->getTempName(), $image->getMimeType(), $image->getName());
			}
		}

		$options = [
			'headers' => [
				'Authorization' => 'Bearer '.$token
			],
			'multipart' => $formData,
			'http_errors' => false
		];

		$response = $client->post($this->apiUrl.'/menu', $options);

		// Handle response
		echo $response->getBody();
		// return $this->response->setJSON(json_decode($response->getBody(), true));
	}
}
