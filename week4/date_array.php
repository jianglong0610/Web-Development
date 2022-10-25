<!DOCTYPE html>
<html>

<head>

    <title>exercise 1</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

</head>

<body>
 
<div class="text-center m-5">
    <h1>What Is Your Date Of Birth?</h1>
</div>
<div class="d-flex justify-content-evenly">
    
<div class="col-3">
<select class="form-select bg-info" aria-label="Default select example">
  <option selected>Day</option>

  <?php
  $day = date("d");
    for ($num = $date ; $num <= 31; $num++) {
        $date = "";
        if($num == $day)
        {
            $date = "selected";
        }

        echo "<option value=\"$num\" $date>$num</option>";
      } 
       ?>
</select>
</div>

<div class="col-3">
<select class="form-select bg-warning" aria-label="Default select example">
  <option selected>Month</option>
  <?php

   $month = array("Month","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
   $curmonth = date("n");
      
    for ($num = 1; $num <= 12; $num++) {
        if($num == $curmonth){
        echo "<option value=\"$num\" selected>$month[$num]</option>";
      } 
      else{
        
        echo "<option value=\"$num\">$month[$num]</option>";
      }
    }
       ?>
</select>
</div>

<div class="col-3">
<select class="form-select bg-danger" aria-label="Default select example">
  <option selected>Year</option>
  <?php
    $year = date("Y");

    for ($num = $year ; $num >= 1900; $num--) {
        $select ="";
        if($num == $year)
        {
            $select = "selected";
        }
        
        echo "<option value=\"$num\" $select>$num</option>";
      } 
       ?>
</select>
</div>

</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>