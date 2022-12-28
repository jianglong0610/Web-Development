<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>

  <meta charset="utf-8">
  <title>Send Email</title>
  <title>Order</title>
  <!-- Latest compiled and minified Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



</head>

<body>
  <div class="container">
  <?php
  include 'top_nav.php'
  ?>
  </div>
  <div class="container d-flex justify-content-center mt-5" style="background-image:url('image/background.jpg')">


    <form class="" action="contact.php" method="post">
      <div>Email <br><input type="email" name="email" value=""></div> <br>
      <div>Subject <br><input type="text" name="subject" value=""></div> <br>
      <div>Message <br><input type="text" name="message" value=""></div> <br>
      <button class="w-50 ms-5" type="submit" name="send">Send</button>

      <?php

      use PHPMailer\PHPMailer\PHPMailer;
      use PHPMailer\PHPMailer\Exception;

      require 'phpmailer/src/Exception.php';
      require 'phpmailer/src/PHPMailer.php';
      require 'phpmailer/src/SMTP.php';

      if (isset($_POST["send"])) {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ahbhx0610@gmail.com';
        $mail->Password = 'mrjaxmcobczwhvcx';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = '465';

        $mail->setFrom('ahbhx0610@gmail.com');

        $mail->addAddress('ahbhx0610@gmail.com');

        $mail->isHTML(true);

        $mail->Subject = $_POST["subject"];
        $mail->Body = $_POST["message"] . " " . $_POST['email'];

        $mail->send();

        echo
        "
    <script>
    alert('Send Sucessfully');
    document.location.herf = 'contact.php'
    </script>
    ";
      }
      ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>