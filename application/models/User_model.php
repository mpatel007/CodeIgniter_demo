<?php
class User_model extends CI_Model{
       public function insert($data){
            $this->db->insert('user',$data);
            // return $this->db->insert_id();
        }
        public function update($data,$update_id){
            $this->db->where('id', $update_id);
            $this->db->update('user', $data);
        }

}
