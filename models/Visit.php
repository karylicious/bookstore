<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Description of Visit
 *
 * @author w1570462
 */
class Visit extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }    
    
    public function addVisit($book_id, $uniq_user_id, $visit_date){
        if(!$this->alreadyExists($book_id, $uniq_user_id)){
            $data = array("book_id" => $book_id,
                          "uniq_user_id" => $uniq_user_id,
                          "visit_date" => $visit_date);
            $this->db->insert("Visits", $data);
            
            $this->load->model("book");
            $this->book->updateViews($book_id);
        }
    }       
    
    private function alreadyExists($book_id, $uniq_user_id){
        $this->db->select("visit_id");
        $this->db->where("book_id", $book_id);
        $this->db->where("uniq_user_id =", $uniq_user_id);
        $result = $this->db->get("Visits");
        return ($result->num_rows() == 1);
    }
}