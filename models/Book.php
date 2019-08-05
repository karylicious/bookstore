<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Description of Book
 *
 * @author w1570462
 */
class Book extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }    
    
    public function addBook($book_title, $book_author, $book_publisher, $book_description, $category_id, $book_release_date,
        $book_price, $book_stock_level, $book_edition){
        $data = array("book_title" => $book_title,
                      "book_author" => $book_author,
                      "book_publisher" => $book_publisher,
                      "book_description" => $book_description,
                      "category_id" => $category_id,
                      "book_release_date" => $book_release_date,
                      "book_price" => $book_price,
                      "book_stock_level" => $book_stock_level,
                      "book_edition" => $book_edition);
        
        $result = $this->db->insert("Books", $data);
        return $result;
    }    
    
    public function getBookById($book_id){
        $this->db->where("book_id", $book_id);
        $result = $this->db->get("Books"); 
        
        if($result->num_rows() != 1){
            return false;
        }        
        return $result->row();
    }    
    
    public function alreadyExists($book_title, $category_id){
        $this->db->where("book_title", $book_title);
        $this->db->where("category_id", $category_id);
        $result = $this->db->get("Books");        
        return ($result->num_rows() == 1);
    }
    
    public function getAllBooksOrderedByCategory(){
        $this->db->select("book_title, book_author, book_release_date, book_price, category_name, book_id");
        $this->db->join("Categories", "Categories.category_id = Books.category_id");        
        $this->db->order_by("category_name", "ASC");
        $result = $this->db->get("Books");
        
        if($result->num_rows() == 0){
            return false;
        }
        return $this->getBookDataFromQueryResult($result);
    }    
    
    public function getBooksByCategory($category_id){
        $this->db->select("book_title, book_author, book_release_date, book_price, category_name, book_id");
        $this->db->join("Categories", "Categories.category_id = Books.category_id");
        $this->db->where("Books.category_id", $category_id);  
        $this->db->order_by("book_title", "ASC");
        $result = $this->db->get("Books");     
        
        if($result->num_rows() == 0){
            return false;
        }
        return $this->getBookDataFromQueryResult($result);
    }
           
    public function searchBooks($book_title, $book_author){
        if($book_title== "" && $book_author== ""){
            return false;
        }
        $this->db->select("book_title, book_author, book_release_date, book_price, category_name, book_id");
        $this->db->join("Categories", "Categories.category_id = Books.category_id");
        
        if($book_title!= "" && $book_author!= ""){
            $this->db->like("book_title", $book_title);
            $this->db->like("book_author", $book_author);
        }
        else if($book_title!= "" && $book_author== ""){
            $this->db->like("book_title", $book_title);
        }
        else if($book_title== "" && $book_author!= ""){
            $this->db->like("book_author", $book_author);
        }
        $result = $this->db->get("Books"); 
        
        if($result->num_rows() == 0){
            return false;
        }
        return $this->getBookDataFromQueryResult($result);
    }
    
    private function getWhoViewThisBook($book_id, $uniq_user_id){	
        $this->db->select("uniq_user_id");
        $this->db->where("book_id", $book_id);
        $this->db->where("uniq_user_id !=", $uniq_user_id);
        $result = $this->db->get("Visits");
        
        if($result->num_rows() == 0){
            return false;
        }        
        $list = array();

        foreach($result->result() as $row){
            $list[] = $row->uniq_user_id;
        }
        return $list;
    }

    public function getBooksViewedByUsersWhoViewThisBook($book_id, $uniq_user_id){
        $users = $this->getWhoViewThisBook($book_id, $uniq_user_id);
        
        $this->db->select("book_title, book_author, book_release_date, book_price, category_name, Books.book_id");
        $this->db->join("Visits", "Visits.book_id = Books.book_id");
        $this->db->join("Categories", "Categories.category_id = Books.category_id");
        $this->db->where("Books.book_id !=", $book_id);
        $this->db->where_in("uniq_user_id", $users);
        $this->db->group_by('Books.book_id');//without this there will be duplicate books
        $this->db->order_by("book_total_views", "DESC");
        
        $this->db->limit(5); 
        $result = $this->db->get("Books");
        //echo $this->db->last_query();
        if($result->num_rows() == 0){
            return false;
        }
        return $this->getBookDataFromQueryResult($result);
    }
        
    private function getBookDataFromQueryResult($result){
        $books = array();
        $index = 0;
        
        foreach($result->result() as $row){
            $books[$index]["book_title"] = $row->book_title;
            $books[$index]["book_author"] = $row->book_author;
            $books[$index]["book_release_date"] = $row->book_release_date;
            $books[$index]["book_price"] = $row->book_price; 
            $books[$index]["category_name"] = $row->category_name; 
            $books[$index]["book_id"] = $row->book_id;
            $index++;
        }
        return $books;
    }
        
    public function updateViews($book_id){
        $this->db->set("book_total_views", "book_total_views + 1", false);
        $this->db->where("book_id", $book_id);
        $this->db->update("Books");        
    }
        
    public function updateStockLevel($book_id, $user_quantity){
        $this->db->set("book_stock_level", "book_stock_level - $user_quantity", false);
        $this->db->where("book_id", $book_id);
        $this->db->update("Books");
    }
}