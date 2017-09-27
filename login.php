<?php

    session_start();
    include('connect.php');

    // LOG OUT
    if($_GET['info'] == out) {
        session_destroy();
        header('Location: ../index.php');
    }

    $issue; // STRING THAT DISPLAYS ISSUES

    // LOG IN INFO
    if(isset($_POST['userName']) and isset($_POST['userPassword'])) {
        $match = 'select password from users where username ="' . $_POST['userName'] . '";';
        $result = mysqli_query($conn, $match);
        $obj = mysqli_fetch_object($result);
        $ans = $obj->password;
        if($ans == $_POST['userPassword']) {
            $_SESSION['logged-in'] = true;
            $_SESSION['login_user'] = $_POST['userName'];

            header("Location: homepage.php");
        } else {
            $issue = $issue . '<div class="alert alert-danger" role="alert">Login Failed.</div>';
        }
    }
    // REGISTER INFO
    if(isset($_POST['regUser']) and isset($_POST['regPass']) and isset($_POST['fullName']) and isset($_POST['email'])) {
        $u = $_POST['regUser'];
        $p = $_POST['regPass'];
        $f = $_POST['fullName'];
        $e = $_POST['email'];

        $add = "INSERT INTO users (username, password, fullName, email) VALUES ('"
                . $u . "', '" . $p . "', '" . $f . "', '" . $e . "');";
        if(mysqli_query($conn, $add)) {
            $issue = $issue . '<div class="alert alert-success" role="alert">Registration Successful!</div>';
        } else {
            $issue = $issue . '<div class="alert alert-danger" role="alert">Registration Failed.</div>';
        }

    }

    if($_SESSION['logged-in']) {
        $issue =  $issue . 'You are already logged in. <br> <a href="login.php/?info=out">Log Out?</a>';
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>myCorona | Login & Register</title>

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">

    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 50px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    </style>

</head>

<body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">

	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" rel="home" href="homepage.php">myCorona</a>
	</div>

	<div class="collapse navbar-collapse">

		<ul class="nav navbar-nav">
		    <li><a href="profile.php">Profile</a></li>
            <li><a href="store.php">Your Store</a></li>
		    <li><a href="#">Explore</a></li>

<?php
    if(isset($_SESSION['logged-in'])) {
        $drop = '<li><a href="login.php?info=out">Logout</a></li>';
        echo $drop;
    } else {
        $noDrop = '<li><a href="login.php">Login</a></li>';
        echo $noDrop;
    }
?>

		</ul>

		<div class="col-sm-3 col-md-3 pull-right">
		<form class="navbar-form" role="search">
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
			<div class="input-group-btn">
				<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
			</div>
		</div>
		</form>
		</div>

	</div>
	</div>

<div class="container">

  <div class="text-center">
    <h1>Welcome to myCorona!</h1>
    <p class="lead">
<?php

    if(isset($issue)) {
        echo $issue;
    }

?>
    </p>



    <div class="container">
    <div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-login">
			<div class="panel-heading">
			<div class="row">
			    <div class="col-xs-6">
				    <a href="#" class="active" id="login-form-link">Login</a>
			    </div>
			    <div class="col-xs-6">
				    <a href="#" id="register-form-link">Register</a>
				</div>
			</div>
			<hr>
		    </div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
					<form id="login-form" action="login.php" method="post" role="form" style="display: block;">
						<div class="form-group">
							<input type="text" name="userName" tabindex="1" class="form-control" placeholder="Username" value="">
						</div>
						<div class="form-group">
							<input type="password" name="userPassword" tabindex="2" class="form-control" placeholder="Password">
						</div>
						<!-- REMEMBER ME BOX
						<div class="form-group text-center">
							<input type="checkbox" tabindex="3" class="" name="remember" id="remember">
							<label for="remember"> Remember Me</label>
						</div> -->
						<div class="form-group">
							<div class="row">
							<div class="col-sm-6 col-sm-offset-3">
								<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
							</div>
							</div>
						</div>
					</form>
					<form id="register-form" action="login.php" method="post" role="form" style="display: none;">
						<div class="form-group">
						    <input type="text" name="regUser" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
						</div>
						<div class="form-group">
							<input type="password" name="regPass" id="password" tabindex="1" class="form-control" placeholder="Password">
						</div>
						<div class="form-group">
							<input type="text" name="fullName" id="fullName" tabindex="1" class="form-control" placeholder="Full Name" value="">
						</div>
						<div class="form-group">
							<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-sm-6 col-sm-offset-3">
									<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
    </div>
	</div>
	</div>

	</div>
</div><!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/login.js"></script>


</body>

</html>