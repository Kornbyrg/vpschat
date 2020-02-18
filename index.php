<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/php/db.php";
    if( !R::testConnection())
    {
        exit('Not connection to database');
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,
    initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" >
    <title>Chat program</title>
    <style>
      body{
        background: #fcfcfc;
      }
    </style>
  </head>
  <body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal">Company name</h5>
    <nav class="my-2 my-md-0 mr-md-3">
      <a class="p-2 text-dark" href="#">Features</a>
      <a class="p-2 text-dark" href="#">Enterprise</a>
      <a class="p-2 text-dark" href="#">Support</a>
      <a class="p-2 text-dark" href="#">Pricing</a>
    </nav>
    <a class="btn btn-outline-primary" href="#">Sign up</a>
  </div>
    <div class="container">
      <div class="py-5 text-center">
        <h2>Chat program</h2>
        <p class="lead">Take your name and write!</p>
      </div>
      <div class="row">
        <div class="col-6">
          <h3>Form message</h3>
          <form id="messForm">
            <input type="hidden" name="name" id="name" placeholder="Write name" class="form-control" value="<?php echo $_SESSION['logged_user']->login; ?>">
            <br>
            <label for="message">Message</label>
            <textarea name="message" id="message" class="form-control"
            placeholder="Write message"></textarea>
            <br>
            <input type="submit" value="Send" class="btn btn-danger">
          </form>
        </div>
        <div class="col-6">
          <h3>message</h3>
          <div id="all_mess">
          </div>
        </div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="/socket.io/socket.io.js"></script>
    <script>
      var min = 1;
      var max = 6;
      var random = Math.floor(Math.random() * (max - min)) + min;

      var alertClass;
      switch (random) {
        case 1:
          alertClass = "secondary";
          break;
        case 2:
          alertClass = "danger";
          break;
        case 3:
          alertClass = "success";
          break;
        case 4:
          alertClass = "warning";
          break;
        case 5:
          alertClass = "info";
          break;
        case 6:
          alertClass = "light";
          break;
      }

      $(function(){
        var socket = io.connect();
        var $form = $("#messForm");
        var $name = $("#name");
        var $textarea = $("#message");
        var $all_messages = $("#all_mess");

        $form.submit(function(event){
          event.preventDefault();
          socket.emit('send mess', {mess: $textarea.val(), name: $name.val(), className: alertClass});
          $textarea.val('');
        });

        socket.on('add mess', function(data){
          $all_messages.append("<div class='alert alert-" + data.className + "'><b>" + data.name + "</b>: " + data.mess + "</div>")
        });
      });
    </script>
  </body>
</html>
