<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="http://v4.pingendo.com/assets/bootstrap/themes/default.css" rel="stylesheet" type="text/css">
  <style>
    body {
      background-color: #eee;
    }
    .hidden{
      display: none !important;
  visibility: hidden !important;

    }
  </style>
</head>

<body>
  <div class="bg-inverse section">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="text-xs-center" draggable="true">Blogger To Wordpress Bot</h1>
          <hr>
        </div>
      </div>
    </div>
  </div>
  <div class="section">
    <hr>
    <div class="container">
      <div class="row" draggable="true">
      <form action="details.php" method="POST">
        <div class="col-xs-9">
          <input type="text" name="url" class="form-control" placeholder="Blogger Url">
          <input type="text" name="page" class="form-control hidden" placeholder="Blogger Url" value="1">
        </div>
        <div class="col-xs-3">
          <button type="submit" class="btn btn-block btn-primary">Get Contents</button>
        </div>
        </form>
      </div>
    </div>
    <hr>
  </div>
  

  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/js/bootstrap.js"></script>
</body>

</html>