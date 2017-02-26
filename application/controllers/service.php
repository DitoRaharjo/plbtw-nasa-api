<?php

//require APPPATH.'/libraries/REST_Controller.php';
//class Engine extends REST_Controller
class Service extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		// Load the rest client spark
		$this->load->spark('restclient/2.1.0');

		// Load the library
		$this->load->library('rest');

		// Run some setup
		$this->rest->initialize(array('server' => 'https://api.nasa.gov/mars-photos/api/v1/'));
		$this->load->helper('url');

	}

	// function generateRandomString($length = 11) {
  //   $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  //   $charactersLength = strlen($characters);
  //   $randomString = '';
  //   for ($i = 0; $i < $length; $i++) {
  //       $randomString .= $characters[rand(0, $charactersLength - 1)];
  //   }
  //   return $randomString;
	// }
	//
	// public function generate_signature()
	// {
	//
	//     $base = $this->_method.'&'.rawurlencode($this->_url.QBO_SANDBOX_URL.'v3/company/'.$this->_realm_id).'&'
	//         .rawurlencode("oauth_consumer_key=".rawurlencode($this->_consumer_key).'&'
	//         .'&oauth_nonce='.rawurlencode('34604g54654y456546')
	//         .'&oauth_signature_method='.rawurlencode('HMAC-SHA1')
	//         .'&oauth_timestamp='.rawurlencode(time())
	//         .'&oauth_token='.rawurlencode($this->_auth_token)
	//         .'&oauth_version='.rawurlencode('1.0')
	//         .'&'.rawurlencode($this->_query));
	//
	//     $key = rawurlencode($this->_consumer_secret).'&'.rawurlencode($this->_token_secret);
	//
	//     $this->_signature = base64_encode(hash_hmac("sha1", $base, $key, true));
	// }

	function get_rover_data()
	{

	    // deklarasi variabel untuk menampung data array hasil akses REST API
		$rovers = array();

     	// deklarasi variabel untuk menampung data field array
		$rover_data['name'] = "";
		$rover_data['launch_date'] = "";
		$rover_data['landing_date'] = "";
		$rover_data['status'] = "";
		$rover_data['recent_photo_taken'] = "";
		$rover_data['total_photo'] = "";
		$rover_data['days'] = 0;
		$rover_data['active_days'] = 0;
		$rover_data['cameras'] = array();
		// $rover_data['cameras']['cameras_name'] = "";
		// $rover_data['cameras']['cameras_code'] = "";

		// akses REST API
		//$result = $this->rest->get('countries/?format=json');

		$api_key = "Ws8vS2QzPsP7thehBCd1Vrv66ZCuAXoC3uNwf6aD";

		$result = $this->rest->get('rovers?api_key='.$api_key.'');

		// kode program pada bagian ini sangat tergantung keluaran JSON dari API yang kita gunakan
		// jika keluaran JSO dari API-nya ternyata string maka harus di decode terlebih dahulu dengan perintah json_decode()
		// pemrosesan data-nya juga sangat tergantung dari struktur JSON-nya, Anda bisa mengecek melalui http://jsonviewer.stack.hu/
		// Anda harus banyak bereksperimen pada bagian ini, silahkan gunakan echo atau var_dump() untuk memastikan isi dari setiap variabel

			foreach ($result as $key => $value)
			{
				if($key == "rovers") {
					foreach ($value as $object) {
						foreach ($object as $key1 => $value1) {
							if($key1 == "name") {
								$rover_data['name'] = $value1;
							}
							if($key1 == "launch_date") {
								$rover_data['launch_date'] = $value1;
							}
							if($key1 == "landing_date") {
								$rover_data['landing_date'] = $value1;
							}
							if($key1 == "status") {
								$rover_data['status'] = $value1;
							}
							if($key1 == "max_date") {
								$rover_data['recent_photo_taken'] = $value1;
							}
							if($key1 == "total_photos") {
								$rover_data['total_photo'] = $value1;
							}
							if($key1 == "cameras") {
								foreach ($value1 as $object2) {
									foreach ($object2 as $key2 => $value2) {
										// if($key2 == "name") {
										// 	$rover_data['cameras']['cameras_code'] = $value2;
										// }
										// if($key2 == "full_name") {
										// 	$rover_data['cameras']['cameras_name'] = $value2;
										// }
										array_push($rover_data['cameras'], $value2);
									}

								}
							}
						}

						$dateStart = new DateTime($rover_data['launch_date']);
						$dateFinish = new DateTime($rover_data['landing_date']);
						$dateNow = new DateTime($rover_data['recent_photo_taken']);

						$diffJourney = $dateFinish->diff($dateStart)->format("%a");
						$diffActive = $dateNow->diff($dateStart)->format("%a");

						$rover_data['days'] = $diffJourney;
						$rover_data['active_days'] = $diffActive;

						array_push($rovers,$rover_data);
						unset($rover_data['cameras']);
						$rover_data['cameras'] = array();
					}
				}

			}
		return $rovers;
	}

	function index()
	{
		// $hasil = json_encode($this->get_rover_data(), true);
		//
		// echo $hasil;

		// $hasil = $this->get_rover_data();
		//
		// foreach ($hasil as $object) {
		// 	foreach ($object as $key => $value) {
		// 		if($key == "name") {
		// 			echo "</br></br>".$value."</br></br>";
		// 		}
		// 		if($key == "cameras") {
		// 			$max = count($value);
		// 			for ($index=0;$index<$max;$index++) {
		// 				if($index<$max-1) {
		// 					echo $value[$index]." : ".$value[$index+1]."</br>";
		// 					$index++;
		// 				}
		// 			}
		// 		}
		// 	}
		// }


		// echo json_encode($this->get_rover_data(), true);
		$data['rovers'] = $this->get_rover_data();
		$this->load->view('result_viewer',$data);
	}

	function get_photo_data($rover, $camera)
	{

	    // deklarasi variabel untuk menampung data array hasil akses REST API
		$photos = array();

     	// deklarasi variabel untuk menampung data field array
		$photo_data['error'] = NULL;
		$photo_data['img_src'] = "";
		$photo_data['date'] = "";


		// akses REST API
		//$result = $this->rest->get('countries/?format=json');

		$api_key = "Ws8vS2QzPsP7thehBCd1Vrv66ZCuAXoC3uNwf6aD";

		$result = $this->rest->get('rovers/'.$rover.'/photos?sol=121&camera='.$camera.'&api_key='.$api_key.'');

		// kode program pada bagian ini sangat tergantung keluaran JSON dari API yang kita gunakan
		// jika keluaran JSO dari API-nya ternyata string maka harus di decode terlebih dahulu dengan perintah json_decode()
		// pemrosesan data-nya juga sangat tergantung dari struktur JSON-nya, Anda bisa mengecek melalui http://jsonviewer.stack.hu/
		// Anda harus banyak bereksperimen pada bagian ini, silahkan gunakan echo atau var_dump() untuk memastikan isi dari setiap variabel

			foreach ($result as $key => $value)
			{
				if($key == "errors") {
					$photo_data['error'] = "No Photos Yet";
					array_push($photos,$photo_data);
				} else if($key == "photos") {
					foreach ($value as $object) {
						foreach ($object as $key1 => $value1) {
							if($key1 == "img_src") {
								$photo_data['img_src'] = $value1;
							}
							if($key1 == "earth_date") {
								$photo_data['date'] = $value1;
							}
						}
						array_push($photos,$photo_data);
					}
				}
			}
		return $photos;
	}

	function photoindex($rover, $camera)
	{
		// echo json_encode($this->get_photo_data($rover, $camera), true);
		$data['photos'] = $this->get_photo_data($rover, $camera);
		$this->load->view('photo_viewer',$data);
	}
}
