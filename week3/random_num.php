<html>
    <head>
        <title>exercise1</title>
        <style>
            
            .green{
                color: green;
                font-style: italic;
            }

            .blue{
                color: blue;
                font-style: italic;
            }

            .red{
                color: red;
                font-weight: bold;
            }

            .black{
                font-weight: bold;
                font-style: italic;
            }

        </style>
    </head>

    <body>
        <?php
            $first = (rand(100,200));
            $second = (rand(100,200));
            $sum = $first + $second;
            $mutiply = $first * $second;
            
            echo "<p class=\"blue\">$first</p>" . "<br>";
            echo "<p class=\"green\">$second</p>" . "<br>";
            echo "<p class=red>$sum</p>" . "<br>";
            echo "<p class=black>$mutiply</p>"; 
        ?>

        

    </body>

</html>