<?php
/**
 * Description of Category
 *
 * @author w1570462
 */
class Category extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }    
    
    public function addCategory($category_name){
        if($this->categoryAlreadyExist($category_name)){
            return false;
        }
        else{
            $data = array("category_name" => $category_name);
            $this->db->insert("Categories", $data);
            return true;
        }
    }
    
    public function getCategoryNameById($id){
        $this->db->where("category_id", $id);
        $result = $this->db->get("Categories");
        
        if($result->num_rows() != 1){
            return -1;
        }
        return $result->row();    
    }
    
    private function categoryAlreadyExist($name){
        $this->db->where("category_name", $name);
        $result = $this->db->get("Categories");
        
        if($result->num_rows() == 0){
            return false;
        }
        return true;    
    }
    
    public function getAllCategories(){
        $this->db->order_by("category_name", "ASC");
        $result= $this->db->get("Categories");
        
        if($result->num_rows() == 0){
            return false;
        }
        return $result->result();
    }
    
    public function totalCategories(){
        return $this->db->count_all('Categories');
    }
}