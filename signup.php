<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>myCorona | Sign Up</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">

    <!-- Custom Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" type="text/css">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="css/animate.min.css" type="text/css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/creative.css" type="text/css">
    <!-- All the files that are required -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/login.css">
    <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <script src="js/login.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- NAVIGATION -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="index.php">myCorona</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="index.php#about">About</a>
                    </li>
                    <li>
                        <a href="#">Meet The Creators</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="index.php#contact">Contact</a>
                    </li>
                    <li>
                        <a href="login.php">Login</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <div class="text-center" style="padding:50px 0">
    	<div class="logo">register</div>
	    <!-- Main Form -->
	    <div class="login-form-1">
		    <form id="register-form" class="text-left" method="POST">
			    <div class="login-form-main-message"></div>
			    <div class="main-login-form">
				    <div class="login-group">
					    <div class="form-group">
						    <label for="reg_user" class="sr-only">Username</label>
						    <input type="text" class="form-control" id="reg_user" name="reg_user" placeholder="username">
					    </div>
					    <div class="form-group">
						    <label for="reg_pass" class="sr-only">Password</label>
						    <input type="password" class="form-control" id="reg_pass" name="reg_pass" placeholder="password">
					    </div>
					    <div class="form-group">
						    <label for="reg_pass_confirm" class="sr-only">Password Confirm</label>
						    <input type="password" class="form-control" id="reg_pass_confirm" name="reg_pass_confirm" placeholder="confirm password">
					    </div>

					    <div class="form-group">
						    <label for="reg_email" class="sr-only">Email</label>
						    <input type="text" class="form-control" id="reg_email" name="reg_email" placeholder="email">
					    </div>
					    <div class="form-group">
						    <label for="reg_fullname" class="sr-only">Full Name</label>
						    <input type="text" class="form-control" id="reg_fullname" name="reg_fullname" placeholder="full name">
					    </div>

				    </div>
				    <button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
			    </div>
			    <div class="etc-login-form">
				    <p>already have an account? <a href="login.php">login here</a></p>
			    </div>
		    </form>
	    </div>
	    <!-- end:Main Form -->
    </div>

    <?php
        function validPass() {
            if(($pass == $passConfirm)) {
                return true;
            }
            else {
                echo "Passwords do not match";
                return false;
            }
        }

        if (!empty($_POST)) {
            $user = $_POST["reg_user"];
            $pass = md5($_POST["reg_pass"]);
            $passConfirm = md5($_POST["reg_pass_confirm"]);
            $email = $_POST["reg_email"];
            $fullName = $_POST["reg_fullname"];

            if(validPass()) {
                $userData = fopen("userData.csv", "w");
                $txt = $user . "," . $pass . "," . $email . "," . $fullName . "\n";
                fwrite($userData, $txt);
                fclose($userData);
            }
        }

    ?>

</body>