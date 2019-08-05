<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Description of Management
 *
 * @author w1570462
 */
class Management extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model("category");
        $this->load->model("book");
    }    
    
    function index(){
        if($this->session->authenticated){
            $totalCategories = $this->category->totalCategories();
            return $this->load->view("contentmanagement", array("total" => $totalCategories));
        }
        return $this->load->view("login", array("attempted" => false));
    }
    
    function login(){
        $user_name = $this->input->post("username");
        $user_password = $this->input->post("password");
        
        if($this->db->username == $user_name && $this->db->password == $user_password){
            $this->session->set_userdata("authenticated", true);
            $totalCategories = $this->category->totalCategories();
            return $this->load->view("contentmanagement", array("total" => $totalCategories));
        }   
        return $this->load->view("login", array("attempted" => true));
    }
    
    function logout(){
        $this->session->set_userdata("authenticated", false);
        $this->load->view("login", array("attempted" => false));
    }
    
    function editcategories(){  
        if($this->session->authenticated){
            $allCategories = $this->category->getAllCategories();
            return $this->load->view("editcategories", array("allCategories" => $allCategories, "added" => true)); //The "added" => true will just hide the paragraph with the confirmation
        }
        return $this->load->view("login", array("attempted" => false));        
    }
    
    function addcategory(){
        if($this->session->authenticated){    
            $category_name = $this->input->post("categoryname");
            $result = $this->category->addCategory($category_name);
            $allCategories = $this->category->getAllCategories();
            return $this->load->view("editcategories", array("allCategories" => $allCategories, "added" => $result));
        }
        return $this->load->view("login", array("attempted" => false));
    }  
    
    function editbooks(){   
        if($this->session->authenticated){    
            $listOfBooks = $this->book->getAllBooksOrderedByCategory();        
            $allCategories = $this->category->getAllCategories();
            return $this->load->view("editbooks", array("listOfBooks" => $listOfBooks, "allCategories" => $allCategories));
        }
        return $this->load->view("login", array("attempted" => false));
    }
    
    function editbooksbycategory(){
        if($this->session->authenticated){    
            $category_id = $this->input->get("category", FALSE); // returns all GET items without XSS filtering        
            $listOfBooks = $this->book->getBooksByCategory($category_id);
            $allCategories = $this->category->getAllCategories();
            $category = $this->category->getCategoryNameById($category_id);  

            return $this->load->view("editbooksbycategory", array("listOfBooks" => $listOfBooks, "category" => $category->category_name, "allCategories" => $allCategories));
        }
        return $this->load->view("login", array("attempted" => false));
    }
    
    function search(){
        if($this->session->authenticated){    
            $title = $this->input->post("title");
            $author = $this->input->post("author");     
            $listOfBooks = $this->book->searchBooks($title, $author);        
            $allCategories = $this->category->getAllCategories();
            
            return $this->load->view("search", array("listOfBooks" => $listOfBooks, "allCategories" => $allCategories));
        }
        return $this->load->view("login", array("attempted" => false));
    }
    
    function editbookdetails(){    
        if($this->session->authenticated){    
            $book_id = $this->input->get("id", FALSE); // returns all GET items without XSS filtering        
            $book = $this->book->getBookById($book_id);
            $category = $this->category->getCategoryNameById($book->category_id);
            return $this->load->view("editbookdetails", array("current_book" => $book, "category" => $category->category_name));
        }
        return $this->load->view("login", array("attempted" => false));
    }
    
    function newbook(){   
        if($this->session->authenticated){           
            $allCategories = $this->category->getAllCategories();
            return $this->load->view("newbook", array("allCategories" => $allCategories, "creation" => "not_attempted"));
        }
        return $this->load->view("login", array("attempted" => false));
    }    
    
    function addbook(){
        if($this->session->authenticated){
            $title = $this->input->post("title");
            $author = $this->input->post("author"); 
            $publisher = $this->input->post("publisher");
            $description = $this->input->post("description");
            $category_id = $this->input->post("category");
            $release_date = $this->input->post("releasedate");
            $price = $this->input->post("price"); 
            $stock_level = $this->input->post("stock"); 
            $edition = $this->input->post("edition");            
            
            if(!$this->book->alreadyExists($title, $category_id)){            
                $this->book->addBook($title, $author, $publisher, $description, $category_id, $release_date,
                $price, $stock_level, $edition);  
                return $this->editbooks();                
            }
            $allCategories = $this->category->getAllCategories();
            return $this->load->view("newbook", array("allCategories" => $allCategories, "creation" => "Book not added! There is already a book with the same title on the selected category."));
        }
        return $this->load->view("login", array("attempted" => false));        
    }
}