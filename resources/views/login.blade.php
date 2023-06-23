<!DOCTYPE html>
<html>
<head>
	<title>Go Fit</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<img class="wave" src="">
	<div class="container">
		<div class="img">
			<img src="img/reg.svg">
		</div>
		<div class="login-content">
                <form action=" {{ url('/login') }}" method="post">
                    @csrf
				<img src="img/logo.jpg">
				<h2 class="title">GO FIT</h2>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<input type="email" class="input" name="EMAIL_PEGAWAI" id="EMAIL_PEGAWAI" value="{{old('EMAIL_PEGAWAI')}}" required placeholder="Email">
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<input type="password" class="input" name="password" id="password" required placeholder="Password">
            	   </div>
            	</div>
            	<a href="{{ url('/indexReset') }}">Forgot Password?</a>
				
            	<input type="submit" value="Login"class="btn">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>