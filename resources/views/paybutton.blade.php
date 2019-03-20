<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Package::Paypal Integration</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">

  <link rel="stylesheet" href="">

</head>

<body>
    <div class="container">
        <form method="post" action="{{ route('create-payment')}}">
        @csrf
            <input type="submit" value="20 Pay Now">
        </form>

    </div>
  <script src=""></script>
</body>
</html>