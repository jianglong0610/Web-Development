<html>
    <head>
        <title>exercise2</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    </head>

    <body>

    <div class="container text-center">
    <?php
            $first = (rand(100,200));
            $second = (rand(100,200));
            
            
             

            if ($first > $second) {
                echo "<p class=fs-1 ><strong>$first</strong></p>" . "<br>";
                echo "<p class=fs-3 >$second</p>";

            }
              
            else {
                echo "<p class=fs-3 >$first</p>" . "<br>";
                echo "<p class=fs-1 ><strong>$second</strong></p>";
            }
            
        ?>
    </div>
    </body>

</html>