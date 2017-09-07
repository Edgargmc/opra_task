<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;


class TodoController extends REST_Controller {


    function __construct() {
        parent::__construct();
        $this->load->model('Todo');

    }

    public function index_get(){
        $banks = $this->Todo->getAll();
        return $this->response($banks, REST_Controller::HTTP_OK);
    }



    public function all_get(){
        $respo = ["a" => "naranja", "b" => "yuca", "c" => "manzana"];
        header('Content-type: application/json');
        echo $json= json_encode($respo);
    }
}
