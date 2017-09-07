<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;


class Welcome extends REST_Controller {


	public function index(){
		$this->load->view('welcome_message');
	}
}
