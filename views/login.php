<html>
    <head>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <title>Books Store</title>
        <script type="text/javascript">
            function validateEntries(){                
                var username = document.getElementsByName("username")[0].value;
                var password = document.getElementsByName("password")[0].value;
                if(username != "" && password != ""){
                    return true;
                }                
                document.getElementById("p_confirmation").innerHTML = "Please fill all the mandatory fields.";
                document.getElementById("p_confirmation").style.visibility = "visible";
                return false;
            }
            function userNotFound(){
                <?php if($attempted == true){
                    echo 'document.getElementById("p_confirmation").innerHTML = "User not found! Please try again.";';
                    echo 'document.getElementById("p_confirmation").style.visibility = "visible";';
                }?>
            }
        </script>    
    </head>
    <body onload = "userNotFound();">	
        <div style="margin-top: 5%;">
            <div style = "border-radius: 50px; border: 3px solid #73AD21; padding: 20px; text-align: center; width: 30%; margin: 0 auto;">
                <h2>Login</h2>
                <form action="login"  method="post" onsubmit = "return validateEntries();">	
                    Username <input type ="text" name ="username" /><span style="color:red;"> *</span><br><br> 
                    Password <input type ="password" name ="password"/> <span style="color:red;"> *</span><br><br>
                    <p id ="p_confirmation" style="color:red; visibility: hidden;"></p>
                    <div style="text-align:right;">
                        <input type="submit" value = "Login"/>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>