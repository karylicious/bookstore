<html>
    <head>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <title>Books Store</title>
    </head>
    <body style="padding: 20px;">	
        <a href="index">Home</a> > Edit Categories         
        <div style="float:right; background-color: black; color:orange; padding: 15px; border-style: dashed;">
            <strong><a href="logout" style="color:orange;">Logout</a></strong>
        </div>        
        <h2 style="text-align:center;">Edit Categories</h2>
        <form method="post" action="addcategory" style="text-align: right; margin-top: 50px;">
            <p>Category Name <input type="text" name="categoryname" style="width:300px"/> <input type="submit" value="Add new category"/></p> 
            <p style="color:red;"><?php if(!$added){echo"Category already exists! Please try again.";} ?> </p>
        </form>        
        <h3>Categories</h3><br>    
        <div style="column-count:4;">
          <?php
            if($allCategories != false){
                foreach($allCategories as $cat){                     
                    echo $cat->category_name. "<br><br>";
                }
            }
          ?>   
        </div>
    </body>
</html>