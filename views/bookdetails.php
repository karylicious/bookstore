<html>
    <head>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <title>Books Store</title>
    </head>
    <body style="padding: 20px;">	
        <a href="index">Home</a> > <a href="booksbycategory?category=<?php echo $current_book->category_id; ?>"><?php echo $category;?></a> > <?php echo $current_book->book_title; ?>  
        <div style="float:right; background-color: black; color:orange; padding: 15px; border-style: dashed;">
            <strong><a href="basket" style="color:orange;">View Basket</a></strong>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2">
                    <img src='https://www.freeiconspng.com/uploads/no-image-icon-15.png' width=150>                        
                </div>
                <div class="col-sm-9">
                    <div class="row">  
                        <p><h2><?php echo $current_book->book_title; ?></strong></h2>
                        <p><strong>by</strong> <?php echo $current_book->book_author; ?></p>
                        <p><strong>Description</strong></p>
                        <p><?php echo $current_book->book_description; ?></p>  
                        <div style='padding-right:30px;'>
                            <form action='additem' method='post'>
                                <div class='text-right' style='font-size:x-large; color:red;'>&pound;<?php echo $current_book->book_price; ?></div>
                            <?php    
                            if($current_book->book_stock_level == 0){
                                echo "<div class='text-right' style='font-size:large; color:orange;'>Out of Stock</div>";
                            }
                            else{
                                echo "<div class='text-right'>Quantity";   
                                    echo " <select name='quantity'>";
                                    for($index = 1; $index <= $current_book->book_stock_level; $index++){
                                        echo '<option value="'.$index.'">'.$index.'</option>';
                                    }
                                    echo "</select>";
                                    echo "<input type='hidden' value='".$current_book->book_id."' name='id'>";
                                echo "</div><br>";                
                                echo "<div class='text-right'><input type='submit' value='Add to Basket'/></div>";
                            }?>
                            </form>
                        </div>
                        <hr>
                        <p><strong>Customers who bought this item also bought</strong></p>
                        <div class="row">
                            <?php 
                            if($top_five_books  != false){
                                for($index = 0; $index < count($top_five_books); $index++){
                                    echo "<div class='col-sm-2'>";
                                        echo "<br><br><a href='bookdetails?id=".$top_five_books[$index]["book_id"]."'><img src='https://www.freeiconspng.com/uploads/no-image-icon-15.png' width=150></a>";
                                        echo "<br><br><p><a href='bookdetails?id=".$top_five_books[$index]["book_id"]."'><strong>".$top_five_books[$index]["book_title"]."</strong></a></p>";
                                        echo "<p><strong>by</strong> ".$top_five_books[$index]["book_author"]."</p>";
                                        echo "<p><strong>published on</strong> ".$top_five_books[$index]["book_release_date"]."</p>";
                                        echo "<p><strong>category</strong> ".$top_five_books[$index]["category_name"]."</p>";
                                        echo "<p style='color:red;'><strong>&pound;".$top_five_books[$index]["book_price"]."</strong></p>";
                                    echo "</div>";
                                }
                            }?>
                        </div>
                        <hr>
                        <div style='margin-bottom:50px;'>
                            <strong>Product Details</strong>
                            <br><br><strong>Publisher</strong> <?php echo $current_book->book_publisher; ?>
                            <br><strong>Edition</strong> <?php echo $current_book->book_edition; ?>
                            <br><strong>Release Date</strong> <?php echo $current_book->book_release_date; ?>                  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>