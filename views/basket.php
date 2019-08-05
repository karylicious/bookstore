<html>
    <head>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <title>Books Store</title>
    </head>
    <body style="padding: 20px;">	
        <div class="container">
            <h2>Shopping Basket</h2>
            <?php
            if(count($basket['books']) == 0){
                echo "<p>Your Shopping Basket is empty.</p>";   
                echo '<p style="text-align:right;"><a href="index"><button>Start Shopping</button></a></p>';
            }
            else {            
                echo '<br>';
                echo '<table class="table">';
                  echo '<thead>';
                    echo '<tr>';
                      echo '<th></th>';
                      echo '<th></th>';
                      echo '<th>Price</th>';
                      echo '<th width="10%">Quantity</th>';
                    echo '</tr>';
                  echo '</thead>';
                  echo '<tbody>';
                  foreach($basket['books'] as $book){
                        echo '<tr>';
                          echo '<td width="15%">';
                            echo '<img src="https://www.freeiconspng.com/uploads/no-image-icon-15.png" style="width:104px;height:142px;">';
                          echo '</td>';
                          echo '<td>';
                          echo "<a href='bookdetails?id=".$book['id']."'><strong>".$book['title']."</strong></a><br>";
                          echo "<strong>by </strong>".$book['author']."";
                          echo'</td>';
                          echo '<td style="font-size:large; color:red;"><strong>&pound;'.$book['price'].'</strong></td>';
                          echo '<td>';
                            echo '<form action="updatequantity" method="post">';          
                               echo "<select name='quantity'>";
                                for($index = 0; $index <= $book["stock_level"]; $index++){
                                    if($index == $book["user_quantity"]){
                                        echo '<option value="'.$index.'" selected="selected">'.$index.'</option>';
                                    }
                                    else {
                                        echo '<option value="'.$index.'">'.$index.'</option>';
                                    }
                                }
                                echo "</select><br>";           
                              echo '<input type="submit" value="Update"/>';
                              echo '<input type="hidden" name="id" value="'.$book['id'].'">';
                            echo '</form>';
                          echo '</td>';
                        echo '</tr>';
                        echo '<tr>';
                    }
                  echo '</tbody>';
                echo '</table>';
                echo '<hr>';
                echo '<p style="text-align:right; font-weight: bold; font-size:large;">';
                echo 'Subtotal (<span>'.$basket['totalitems'].'</span> <span>Items</span>): <span style="color:red;">&pound;'.$basket['subtotal'].'</span>';
                echo '</p>';
                echo '<br>';
                echo '<p style="text-align:right;"><a href="checkout" style="padding-right:10px;"><button onclick="alert('."'Thank you for your order!'".');">Checkout</button></a><a href="index"><button>Continue Shopping</button></a></p>';
            }
            ?>
        </div>
    </body>
</html>