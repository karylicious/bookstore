<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Description of Books
 *
 * @author w1570462
 */
class Store extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model("book");
        $this->load->model("category");
        
        $uniq_user_id = $this->session->userdata('uniqid');
        //$this->session->unset_userdata('basket');
        //$this->session->set_userdata("basket", array("subtotal" => 0, "books" => array(), "totalitems" => 0));
        if($uniq_user_id == NULL){
            $this->session->set_userdata("uniqid", uniqid());
            $this->session->set_userdata("basket", array("subtotal" => 0, "books" => array(), "totalitems" => 0));
        }        
    }
    
    function index(){
        $listOfBooks = $this->book->getAllBooksOrderedByCategory();        
        $allCategories = $this->category->getAllCategories();
        $this->load->view("index", array("listOfBooks" => $listOfBooks, "allCategories" => $allCategories));
    }
        
    function bookdetails(){        
        $this->load->model("visit");
        $book_id = $this->input->get("id", FALSE); // returns all GET items without XSS filtering
        
        $book = $this->book->getBookById($book_id);
        $category = $this->category->getCategoryNameById($book->category_id);      
              
        $uniq_user_id = $this->session->userdata('uniqid');
        $top_five_books = $this->book->getBooksViewedByUsersWhoViewThisBook($book_id, $uniq_user_id);
        $visit_date = date('d-m-Y H:i:s');
        $this->visit->addVisit($book_id, $uniq_user_id, $visit_date);
        $this->load->view("bookdetails", array("current_book" => $book, "top_five_books" => $top_five_books, "category" => $category->category_name));
        
    }
        
    function booksbycategory(){
        $category_id = $this->input->get("category", FALSE); // returns all GET items without XSS filtering        
        $listOfBooks = $this->book->getBooksByCategory($category_id);
        $allCategories = $this->category->getAllCategories();
        $category = $this->category->getCategoryNameById($category_id);        
        $this->load->view("booksbycategory", array("listOfBooks" => $listOfBooks, "category" => $category->category_name, "allCategories" => $allCategories));
    }
    
    function search(){        
        $book_title = $this->input->get("title", TRUE); // returns all GET items with XSS filtering
        $book_author = $this->input->get("author", TRUE); // returns all GET items with XSS filtering
        
        $list = array();
        
        if($book_title != NULL && $book_author != NULL){
            $list = $this->book->getBooksByTitleAndAuthor($book_title, $book_author);
        }
        elseif ($book_title != NULL && $book_author == NULL){
            $list = $this->book->getBooksByAuthor($book_author);
        }
        elseif($book_title == NULL && $book_author != NULL){
            $list = $this->book->getBooksByTitle($book_title);
        }        
        $this->load->view("search", array("list" => $list));        
    }    
    
    
    function additem(){
        $user_quantity = $this->input->post("quantity");
        $book_id = $this->input->post("id");     
        $current_basket = $this->session->basket;
        
        if (array_key_exists($book_id,$current_basket["books"])){
            $this->updatequantity();
        }
        else{
            //Indirect modification of overloaded property CI_Session::$basket has no effect
            $book_details = $this->book->getBookById($book_id);
            $current_basket["books"][$book_id]['title'] = $book_details->book_title;
            $current_basket["books"][$book_id]['author'] = $book_details->book_author;
            $current_basket["books"][$book_id]['price'] = $book_details->book_price;
            $current_basket["books"][$book_id]['stock_level'] = $book_details->book_stock_level;
            $current_basket["books"][$book_id]['id'] = $book_id;
            $current_basket["books"][$book_id]['user_quantity'] = $user_quantity;
            $this->updateBasket($user_quantity, $book_details, $current_basket);
            return $this->load->view("basket", array("basket" => $this->session->basket));
        }        
    }
    
    function basket(){
        $this->load->view("basket", array("basket" => $this->session->basket));
    }
            
    function updatequantity(){
        $user_quantity = $this->input->post("quantity");
        $book_id = $this->input->post("id"); 
        $current_basket = $this->session->basket;
        $prev_quantity = $this->session->basket["books"][$book_id]['user_quantity'];
        
        if($user_quantity == $current_basket["books"][$book_id]['user_quantity']){//User is updating with the current quantity
            return $this->load->view("basket", array("basket" => $this->session->basket));
        }            
                
        unset($current_basket["books"][$book_id]);
        $this->session->set_userdata("basket",$current_basket); 
        
        $book_details = $this->book->getBookById($book_id);
        
        $this->removeItemFromBasket($prev_quantity, $book_details->book_price);
        
        if($user_quantity == 0){
            return $this->load->view("basket", array("basket" => $this->session->basket));
        }       
        $this->additem();
    }    
        
    function removeItemFromBasket($prev_quantity, $book_price){ 
        $current_basket = $this->session->basket;
        $total = $book_price * $prev_quantity;        
        $current_basket["subtotal"] -= $total;
        $current_basket["totalitems"] -= $prev_quantity;        
        $this->session->set_userdata("basket",$current_basket);       
    }
    
    function updateBasket($user_quantity, $book, $current_basket){
        $total = $book->book_price * $user_quantity;
        $current_basket["subtotal"] += $total ;
        $current_basket["totalitems"] += $user_quantity;   
        $this->session->set_userdata("basket",$current_basket);
    }
    
    function checkout(){
        foreach($this->session->basket["books"] as $book_id){
            $this->book->updateStockLevel($book_id['id'], $book_id['user_quantity']);
        }
        $this->session->set_userdata("basket", array("subtotal" => 0, "books" => array(), "totalitems" => 0));
        $this->index();
    }
}