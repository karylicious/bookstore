<html>
    <head>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <title>Books Store</title>
    </head>
    <body style="padding: 20px;">	
        <div>
            <a href='index'>Home</a> > <a href='editbooks'>Edit Books</a> > Search
        </div>
        <div style="float:right; background-color: black; color:orange; padding: 15px; border-style: dashed;">
            <strong><a href="logout" style="color:orange;">Logout</a></strong>
        </div>
        
        <div>
            <h2><center>Search Results</center></h2>
            <div style="text-align:center; margin-top: 50px; height: 20px;" id="div_form_parent">
                <p style="text-align:right;">
                    <a href="newbook"><button>New Book</button></a>
                    <button onclick="   if(document.getElementById('search_form').style.visibility == 'visible'){
                                                                        document.getElementById('div_form_parent').style.height = '20px';
                                                                        document.getElementById('search_form').style.visibility = 'hidden';
                                                                    }
                                                                    else{
                                                                        document.getElementById('div_form_parent').style.height = '120px';
                                                                        document.getElementById('search_form').style.visibility = 'visible';
                                                                    }
                    ">Search</button>
                </p>
                <form method="post" action="search" style="text-align: right; visibility: hidden;" id="search_form" onsubmit="return true;">
                    <p>Title <input type="text" name="title" style="width:300px"/></p> 
                    <p>Author <input type="text" name="author" style="width:300px"/></p> 
                    <input type="submit" value="Search books" style="background-color: orange; color:white;"/>
                </form>
            </div>
        </div>               
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3">
                    <p><strong>Categories</strong></p>
                    <?php
                        foreach($allCategories as $category){                     
                            echo "<a href='editbooksbycategory?category=".$category->category_id."'>" .$category->category_name. "</a><br><br>";
                        }
                    ?>             
                </div>
                <div class="col-sm-9">
                        <div class="row">
                        <?php
                        if($listOfBooks != false){
                            for($index = 0; $index < count($listOfBooks); $index++){
                                if($listOfBooks[$index]["book_author"] == null){
                                    continue;
                                }
                                echo "<div class='col-sm-6'>";
                                echo"<br><br><a href='editbookdetails?id=".$listOfBooks[$index]["book_id"]."'><img src='https://www.freeiconspng.com/uploads/no-image-icon-15.png' width=150></a>";
                                echo"<br><br><p><a href='editbookdetails?id=".$listOfBooks[$index]["book_id"]."'><strong>".$listOfBooks[$index]["book_title"]."</strong></a></p>";
                                echo"<p><strong>by</strong> ".$listOfBooks[$index]["book_author"]."</p>";
                                echo"<p><strong>published on</strong> ".$listOfBooks[$index]["book_release_date"]."</p>";
                                echo"<p><strong>category</strong> ".$listOfBooks[$index]["category_name"]."</p>";
                                echo"<p><strong>&pound;".$listOfBooks[$index]["book_price"]."</strong></p>";
                                echo"</div>";
                            }
                        }
                        else{
                            echo "<p style='margin-top:100px;'>Your search did not match any book.</p>";
                        }
                        ?>
                        </div>

                </div>
            </div>
        </div>
    </body>
</html>