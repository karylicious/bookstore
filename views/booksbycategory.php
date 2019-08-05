<html>
    <head>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <title>Books Store</title>
    </head>
    <body style="padding: 20px;">      
        <a href="index">Home</a> > <?php echo $category; ?>    
        <div style="float:right; background-color: black; color:orange; padding: 15px; border-style: dashed;">
            <strong><a href="basket" style="color:orange;">View Basket</a></strong>
        </div>
        <h2><center><?php echo $category?></center></h2>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3">
                    <p><strong>Categories</strong></p>
                    <?php
                        if($allCategories != false){
                            foreach($allCategories as $cat){                     
                                echo "<a href = 'booksbycategory?category=".$cat->category_id."'>" .$cat->category_name. "</a><br><br>";
                            }
                        }
                    ?>             
                </div>
                <div class="col-sm-9">
                    <div class="row">
                        <?php
                        if($listOfBooks != false){
                            for($index = 0; $index < count($listOfBooks); $index++){
                                echo "<div class = 'col-sm-6'>";
                                echo "<br><br><a href = 'bookdetails?id=".$listOfBooks[$index]["book_id"]."'><img src='https://www.freeiconspng.com/uploads/no-image-icon-15.png' width=150></a>";
                                echo "<br><br><p><a href = 'bookdetails?id=".$listOfBooks[$index]["book_id"]."'><strong>".$listOfBooks[$index]["book_title"]."</strong></a></p>";
                                echo "<p><strong>by</strong> ".$listOfBooks[$index]["book_author"]."</p>";
                                echo "<p><strong>published on</strong> ".$listOfBooks[$index]["book_release_date"]."</p>";
                                echo "<p><strong>category</strong> ".$listOfBooks[$index]["category_name"]."</p>";
                                echo "<p style = 'color:red;'><strong>&pound;".$listOfBooks[$index]["book_price"]."</strong></p>";
                                echo "</div>";
                            }
                        }
                        else{
                            echo "<p style = 'margin-top:100px;'>There is no book in this category.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>