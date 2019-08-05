<html>
    <head>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <title>Books Store</title>
        <style>td{padding-bottom: 20px;}</style>
        <script type="text/javascript">
            function validateEntries(){                
                var title = document.getElementsByName("title")[0].value;
                var author = document.getElementsByName("author")[0].value;
                var publisher = document.getElementsByName("publisher")[0].value;
                var description = document.getElementsByName("description")[0].value;
                var release = document.getElementsByName("releasedate")[0].value;
                var price = document.getElementsByName("price")[0].value;
                var stock = document.getElementsByName("stock")[0].value;
                
                title = title.trim();
                author = author.trim();
                publisher = publisher.trim(); 
                description = description.trim();
                release = release.trim();
                price = price.trim();
                stock = stock.trim();
                
                if(title != "" && author != "" && publisher != "" && description != "" && release != "" && price != "" && stock != ""){
                    return true;
                }
                document.getElementById('p_mandatory').style.visibility = 'visible';
                return false;
            }
            <?php if($creation != "not_attempted"){ echo 'alert("'.$creation.'");';}?>
        </script>
    </head>
    <body style="padding: 20px;">
        <a href="index">Home</a> > <a href="editbooks">Edit Books</a> > New Book 
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
                        <h2 style="text-align: center;">New Book</h2><br>
                        <form action="addbook" method="post" onsubmit="return validateEntries();">
                            <table>  
                                <tr>
                                    <td>Title</td>
                                    <td><input type="text" name="title" style="width:400px;"/><span style="color:red;"> *</span></td>                                       
                                </tr>
                                <tr>
                                    <td>Author</td>
                                    <td><input type="text" name="author" style="width:400px;"/><span style="color:red;"> *</span></td>
                                </tr>
                                <tr>
                                    <td>Publisher</td>
                                    <td><input type="text" name="publisher" style="width:400px;"/><span style="color:red;"> *</span></td>
                                </tr>
                                <tr>
                                    <td>Edition</td>
                                    <td><input type="text" name="edition" style="width:400px;"/></td>
                                </tr>
                                <tr>
                                    <td>Release Date</td>
                                    <td><input type="text" name="releasedate" style="width:400px;"/><span style="color:red;"> *</span></td>
                                </tr>
                                <tr>
                                    <td>Category</td>
                                    <td>
                                        <select name="category">
                                        <?php
                                            foreach($allCategories as $cat){
                                                echo '<option value="'.$cat->category_id.'">'.$cat->category_name.'</option>';
                                            }
                                        ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Stock Level</td>
                                    <td><input type="number" min="1" max="100" name="stock"/><span style="color:red;"> *</span></td>
                                </tr>
                                <tr>
                                    <td>Price</td>
                                    <td>&pound; <input type="number" min="0" step="0.01" name="price"/><span style="color:red;"> *</span></td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>
                                        <textarea rows="6" cols="50" name="description"></textarea><span style="color:red;"> *</span>
                                        <br><p id ="p_mandatory" style="color:red; visibility: hidden;">Please fill all the mandatory fields.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class='text-right'>
                                        <input type="submit" value="Add Book"/> 
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>