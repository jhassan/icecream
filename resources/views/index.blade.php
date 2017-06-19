<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cappellos</title>

    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('../../bootstrap/css/bootstrap.min.css')}}">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('../../bootstrap/css/4-col-portfolio.css')}}">
    <!-- STYLE -->
    <link rel="stylesheet" href="{{asset('../../bootstrap/css/style.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body  style="background-image: url('img/bg202.jpg'); background-repeat: no-repeat;">

    <!-- Navigation -->
    	
    <!--  @if($errors->has())
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    @endif -->
        @if (Session::has('message'))
           <div class="alert alert-danger container" style="width:400px;">{{ Session::get('message') }}</div>
        @endif
    <!-- Page Content -->
        <div class="container" style="width:400px; background-color: #fff; height: 228px; border-radius: 20px;">

        <!-- Page Heading -->
        <form class="form-signin" method="post" action="{{ URL::to('login') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <h2 class="form-signin-heading text-center bld"><strong>POS Cappellos</strong></h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control m-t-10" placeholder="Password" required>
        <div class="checkbox hide">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-success btn-block m-t-10" type="submit">Sign in</button>
      </form>
        <!-- /.row -->
     </div>   
</body>
</html>