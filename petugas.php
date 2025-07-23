<?php
session_start();
require 'koneksi.php'; // Hubungkan ke database

?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
  <meta name="viewport" content="width=device-width" />

  <title>KenZo Store - Coming Soon</title>

  <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

  <link href="coming-ssoon-page-master/css/coming-sssoon.css" rel="stylesheet" />

  <link href='https://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
</head>

<body>
  <nav class="navbar navbar-transparent navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="#">
              <i class="fa fa-facebook-square"></i>
              Share
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-twitter"></i>
              Tweet
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-envelope-o"></i>
              Email
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="main" style="background-image: url('images/default.jpg')">
    <div class="cover black" data-color="black"></div>
    <div class="container">
      <h1 class="logo cursive">
        KenZo Store
      </h1>

      <div class="content">
        <h4 class="motto">Toko Sepatu Terbaik Akan Segera Hadir.</h4>
        <div class="subscribe">
          <?php if (!empty($message)) {
            echo $message;
          } else { ?>
            <h5 class="info-text">
              Jadilah yang pertama tahu saat kami buka. Daftarkan email Anda.
            </h5>
          <?php } ?>

          <div class="row">
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
              <form class="form-inline" role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                  <label class="sr-only" for="email">Email address</label>
                  <input type="email" name="email" class="form-control transparent" placeholder="Ketik email Anda di sini...">
                </div>
                <button type="submit" class="btn btn-danger btn-fill">Beri Tahu Saya</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer">
      <div class="container">
        Made with <i class="fa fa-heart heart"></i> by <a href="http://www.creative-tim.com">Creative Tim</a>.
      </div>
    </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</html>