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
    }

    public function TaskByID_get(){
        $id = $this->get('id');
        if(empty($id)) return $this->response(['error'=>'Empty id task'], REST_Controller::HTTP_BAD_REQUEST);

        $task = $this->Todo->getTaskById($id);

        if(empty($task)){
            return $this->response(['error'=>'Id task not found'], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            return $this->response($task, REST_Controller::HTTP_OK);
        }
    }

    public function Task_get(){
        $tasks = $this->Todo->getAll();
        return $this->response($tasks, REST_Controller::HTTP_OK);
    }

    public function Task_post(){

        $dataTaks = json_decode(file_get_contents('php://input'));

        $id_status  = $dataTaks->id_status        ??  "";
        $description = $dataTaks->description        ??  "";
        $author = $dataTaks->author        ??  "";

        if(empty($author))   return $this->response(['error'=>'empty author'], REST_Controller::HTTP_BAD_REQUEST);
        if(empty($description))        return $this->response(['error'=>'empty task'], REST_Controller::HTTP_BAD_REQUEST);

        $result  = $this->Todo->save($id_status, $description, $author);


        if(!$result['code']){
            return $this->response(['msg'=>'Task create'], REST_Controller::HTTP_OK);
        }else{
            return $this->response(['error'=> 'MYSQL ' .  $result['code']], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
