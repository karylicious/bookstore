<html>
    <head>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <title>Books Store</title>
        <style>
            .not-active {
                pointer-events: none;
                cursor: default;
                text-decoration: none;
                color: black;
            }
        </style>
    </head>
    <body>	
        <div style="float:right; background-color: black; color:orange; padding: 15px; border-style: dashed;">
            <strong><a href="logout" style="color:orange;">Logout</a></strong>
        </div>    
        <h1 style="text-align:center;">Book Store Content Management</h1>
        <div style="text-align:center; margin-top: 100px;">
            <a href="editcategories">
                <button style="margin-right: 20px; height: 200px; width:200px; font-size: large"><strong>Edit Categories</strong></button>
            </a>            
            <a href="editbooks" <?php  if($total == 0){echo 'class="not-active"';} ?> >
                <button style="height: 200px; width:200px; font-size:large; <?php  if($total == 0){echo 'color:gray';} ?>"><strong>Edit Books</strong></button>
            </a>
        </div>
    </body>
</html>