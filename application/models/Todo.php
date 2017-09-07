<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Todo extends CI_Model{

    public function __construct(){
        parent::__construct();
    }


    public function getAll(){

        $result = [];
        $query = $this->db->get_where('tasks', array('	date_delete' => NULL));

        foreach ($query->result_array('Tasks') as $row){
            array_push($result,$row);
        }

        return $result;
    }

}
