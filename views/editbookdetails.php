<html>
    <head>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <title>Books Store</title>
    </head>
    <body style="padding: 20px;">	
        <a href="index">Home</a> > <a href="editbooksbycategory?category=<?php echo $current_book->category_id; ?>"><?php echo $category;?></a> > <?php echo $current_book->book_title; ?>  
        <div style="float:right; background-color: black; color:orange; padding: 15px; border-style: dashed;">
            <strong><a href="logout" style="color:orange;">Logout</a></strong>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2">
                    <img src='https://www.freeiconspng.com/uploads/no-image-icon-15.png' width=150>                        
                </div>
                <div class="col-sm-9">
                    <div class="row">                        
                    <?php
                        echo "<p><h2>".$current_book->book_title."</strong></h2></p>";
                        echo"<p><strong>by</strong> ".$current_book->book_author."</p>";
                        echo "<p><strong>Description</strong></p>";
                        echo "<p>".$current_book->book_description."</p>";                               

                        echo "<div style='padding-right:30px;'>";
                        echo"<div class='text-right' style='font-size:x-large; color:red;'>&pound;".$current_book->book_price."</div>";  
                        echo"<div class='text-right' style='font-size:large;'>Stock Level<strong> ".$current_book->book_stock_level."</strong></div>";
                        echo "</div>";

                        echo"<div style='margin-bottom:50px; text-align:left;'>";
                        echo"<br><strong>Category</strong> ".$category;
                        echo"<br><br><strong>Publisher</strong> ".$current_book->book_publisher;
                        echo"<br><strong>Edition</strong> ".$current_book->book_edition;
                        echo"<br><strong>Release Date</strong> ".$current_book->book_release_date;    
                        echo"<br><strong>Total Views</strong> ".$current_book->book_total_views;
                        echo"</div>";
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>