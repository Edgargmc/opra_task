<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todo extends CI_Model{

    private $table  = "tasks";

    public function __construct(){
        parent::__construct();
    }

    public function getAll(){

        $result = [];
        $query = $this->db->get_where($this->table, ['date_delete' => NULL]);

        foreach ($query->result_array('Tasks') as $row){
            array_push($result,$row);
        }

        return $result;
    }

    public function getTaskById($taskId){

        $query = $this->db->get_where($this->table, ["id" => $taskId]);
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

    public function update($id, $id_status, $description, $author){

        $query = $this->db->get_where($this->table, ['id' => $id]);

        if(!$query->num_rows()){ return false; }

        $dataTaks = [
            'id_status'    => $id_status,
            'description'  => $description,
            'author'       => $author
        ];

        $this->db->where('id', $id);
        $this->db->update($this->table, $dataTaks);
        $afftectedRows = $this->db->affected_rows();

        return $afftectedRows;
    }

    public function delete($taskId){

        $query = $this->db->get_where($this->table, ["id" => $taskId]);

        if($query->num_rows()){
            $this->db->where('id', $taskId);
            $this->db->delete($this->table);
            $result = $this->db->error();
            
            if($result['code'] !== 0){
                print_r($result);
                return $result;
            }
            return true;
        }else{
            return false;
        }
    }
}
