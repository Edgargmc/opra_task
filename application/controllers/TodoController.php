<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class TodoController extends REST_Controller {


    public function __construct() {
        parent::__construct();
        $this->load->model('Todo');
    }

    public function index_get(){
    }

    public function taskById_get(){

        $id = $this->get('id');
        if(empty($id)) return $this->response(['msg'=>'Empty id task'], REST_Controller::HTTP_BAD_REQUEST);

        $task = $this->Todo->getTaskById($id);

        return empty($task)
            ? $this->response(['msg' => 'Id task not found'], REST_Controller::HTTP_BAD_REQUEST)
            : $this->response($task, REST_Controller::HTTP_OK);
    }

    public function task_get(){

        $tasks = $this->Todo->getAll();

        if($tasks){
            return $this->response($tasks, REST_Controller::HTTP_OK);
    }

        return $this->response(['msg' => 'No tasks'], REST_Controller::HTTP_OK);
    }

    public function task_post(){

        $dataTaks = json_decode(file_get_contents('php://input'));

        $id_status  = $dataTaks->id_status        ??  "";
        $description = $dataTaks->description        ??  "";
        $author = $dataTaks->author        ??  "";

        if(empty($author))   return $this->response(['error'=>'empty author'], REST_Controller::HTTP_BAD_REQUEST);
        if(empty($description))        return $this->response(['error'=>'empty task'], REST_Controller::HTTP_BAD_REQUEST);

        $result  = $this->Todo->save($id_status, $description, $author);


        return !$result['code']
            ? $this->response(['msg' => 'Task create'], REST_Controller::HTTP_OK)
            : $this->response(['msg' => 'MYSQL ' . $result['code']], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);

    }

    public function updateTask_put(){

        $dataTaks = json_decode(file_get_contents('php://input'));

        $id = (int) $this->get('id');
        $id_status  = $dataTaks->id_status        ??  "";
        $description = $dataTaks->description        ??  "";
        $author = $dataTaks->author        ??  "";

        if(empty($id))          return $this->response(['msg'=>'empty author'], REST_Controller::HTTP_BAD_REQUEST);
        if(empty($id_status))   return $this->response(['msg'=>'empty id status'], REST_Controller::HTTP_BAD_REQUEST);
        if(empty($description)) return $this->response(['msg'=>'empty description'], REST_Controller::HTTP_BAD_REQUEST);
        if(empty($author))      return $this->response(['msg'=>'empty author'], REST_Controller::HTTP_BAD_REQUEST);

        $result  = $this->Todo->update($id, $id_status, $description, $author);

        if(is_numeric($result)){
            return $this->response(['msg'=> 'Success' .  $result['code']], REST_Controller::HTTP_OK);
        }
        return $this->response(['msg'=> 'Not found id'], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function deleteTask_delete(){
        $id = $this->get('id');

        $result = $this->Todo->delete($id);

        if(is_bool($result)){
            if($result)   return $this->response(['msg'=> 'Success' .  $result['code']], REST_Controller::HTTP_OK);
            return $this->response(['msg'=> 'Not found id'], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }else{
            return $this->response(['msg'=> 'MYSQL ' .  $result['code']], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function filter_post(){
        $filter = json_decode(file_get_contents('php://input'));
  
       if($filter){
           $author  = $filter->author        ??  "";
           $statusFilter  = $filter->statusFilter        ??  "";
           $dateFilter  = $filter->dateFilter        ??  "";

           $result  = $this->Todo->filter($author, $statusFilter, $dateFilter);

           if($result){
               return $this->response($result, REST_Controller::HTTP_OK);
           }

       }
    }

}
