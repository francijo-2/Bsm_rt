
@include('Layouts.app')

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>The Bangalore School of Music</title>

    <!-- Bootstrap -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cssstyle.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 
 
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="{{ asset('js/jquery-ui.js') }}"></script>
   <script src="{{ asset('js/bootstrap-datetimepicker.js') }}"></script>
  </head>
  <body>
  
  <div class="hero-unit customDiv container-fluid">

<img src="{{ asset('BSM Logo.png') }}" width="130"; height="157"/></div>

  </div>
   
   <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">The BSM Admin Center</a>
      
       <form class="navbar-form navbar-right" role="search" method ="post" action = "{{ route('search') }}">
        {{ csrf_field() }}
      	<div class="form-group">
        <input type="text" name= "search_stu" class="form-control" placeholder="Search for a student">
        <input type="submit" name="search" class="btn btn-primary" value="Search">
        </form>
        
    </div>
    <ul class="nav navbar-nav pull-right">
       <li class="active"><a href="/">Home</a></li>
      <li><a href="/Accounts/Accounts/Info">Accounts</a></li>
      <li><a href="/Exams/Info">Exams</a></li>
    </ul>
   
  </div>
</nav>
  
<div class="container-fluid customDiv2">

