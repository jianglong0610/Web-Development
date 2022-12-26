<!DOCTYPE html>
<html>

<head>
  <title>Contact</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body>
  <div class="container">

    <?php
    include 'top_nav.php'
    ?>

    <?php
    $to = "chanjianglong0610@e.newera.edu.my";
    $subject = "My subject";
    $txt = "Hello world!";
    $headers = "From: webmaster@example.com" . "\r\n" .
      "CC: somebodyelse@example.com";

    mail($to, $subject, $txt, $headers);
    ?>

    <div class="d-flex justify-content-center mt-5">
      <h1>Contact Us</h1>
    </div>

    <div class="row m-5">
      <div class="col">
        Email:<br>
        chanjianglong@e.newera.edu.my
      </div>
      <div class="col">
        Phone:<br>
        012-6166199
      </div>
      <div class="col">
        Instagram:<br>
        ---
      </div>
    </div>

    <div class="d-flex justify-content-center mt-5">
      <h1>Suggestion</h1>
    </div>

    <form>
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name">
      </div>
      <div class="mb-3">
        <label for="suggestion" class="form-label">Suggestion</label>
        <textarea type="text" class="form-control" id="suggestion"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

  </div>
</body>

</html>