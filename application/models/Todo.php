<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Todo extends CI_Model{
    
    private $table  = "tasks";

    public function __construct(){
        parent::__construct();
    }
    
    public function getAll(){
        $result = [];
       
        $query = $this->db->get_where($this->table, array('date_delete' => NULL));

        foreach ($query->result_array('Tasks') as $row){
            array_push($result,$row);
        }

        return $result;
    }

    public function getTaskById($Taskid){

        $query = $this->db->get_where($this->table, ["id" => $Taskid]);

        return $query->row();
    }
    
    public function save($id_status, $description, $author){

        $dataTaks = [
            'id_status'    => $id_status,
            'description'  => $description,
            'author'       => $author
        ];

        $this->db->insert($this->table, $dataTaks);
        return $result = $this->db->error();
    }
    
}
