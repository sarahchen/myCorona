<?php

    session_start();
    include('connect.php');

    if(!$_SESSION['logged-in']){
        header("Location: index.php");
    }

    $query = 'select * from users where username ="' .$_SESSION["login_user"].'";';
    $beepboop = mysqli_query($conn, $query);
    $useless = mysqli_fetch_object($beepboop);

	$id = $useless->id;
    $Cfull_name = $useless->fullName;
    $Cemail = $useless->email;
    $Cdescription = $useless->description;
        if($Cdescription == null) {
            $Cdescription = "Description";
        }
    $Cpassword = $useless->password;

    $issue;

    // CHANGE BASIC INFO
    if(isset($_POST['fullName']) or isset($_POST['email']) or isset($_POST['descrip'])) {

    	// UPDATE FULL NAME
    	if($_POST['fullName'] != "") {
    		$q_fullname = 'update users set fullName ="'.$_POST['fullName'].'" where id="'.$id.'";';
    		$magic_fullname = mysqli_query($conn, $q_fullname);
    		if($magic_fullname) {
    			$issue = $issue . '<div class="alert alert-success" role="alert">Name Updated!</div>';
    		} else {
    			$issue = $issue . '<div class="alert alert-danger" role="alert">Name Failed to Update!</div>';
    		}
    	}

    	// UPDATE EMAIL
    	if($_POST['email'] != "") {
    		$q_email = 'update users set email ="'.$_POST['email'].'" where id="'.$id.'";';
    		$magic_email = mysqli_query($conn, $q_email);
    		if($magic_email) {
    			$issue = $issue . '<div class="alert alert-success" role="alert">Email Updated!</div>';
    		} else {
    			$issue = $issue . '<div class="alert alert-danger" role="alert">Email Failed to Update!</div>';
    		}
    	}

    	// UPDATE DESCRIPTION
    	if($_POST['descrip'] != "") {
    		$q_descrip = 'update users set description ="'.$_POST['descrip'].'" where id="'.$id.'";';
    		$magic_descrip = mysqli_query($conn, $q_descrip);
    		if($magic_descrip) {
    			$issue = $issue . '<div class="alert alert-success" role="alert">Description Updated!</div>';
    		} else {
    			$issue = $issue . '<div class="alert alert-danger" role="alert">Description Failed to Update!</div>';
    		}
    	}
    }

    // CHANGE PROFILE PICTURE
if(isset($_POST["submit"]) and $_POST['submit'] == "Upload Image") {
    $target_dir = "img/profile/";
    $file = $target_dir . basename($_FILES['userfile']['name']);

    if(move_uploaded_file($_FILES['userfile']['tmp_name'], $file)) {
    	$issue = $issue . '<div class="alert alert-success" role="alert">Picture uploaded! </div>';
    	$q_img = 'update users set img="'.$file.'" where id="'.$id.'";';
    	if(mysqli_query($conn, $q_img)) {
    		$issue = $issue . '<div class="alert alert-success" role="alert">Picture updated!</div>';
    	}
    } else {
    	$issue = $issue . '<div class="alert alert-danger" role="alert">Picture not uploaded</div>';
    }
}

    // CHANGE PASSWORD
    if(isset($_POST['oldPass']) or isset($_POST['newPass']) or isset($_POST['confirmPass'])) {
    	if(!isset($_POST['oldPass']) or !isset($_POST['newPass']) or !isset($_POST['confirmPass'])) {
    		$issue = $issue . '<div class="alert alert-danger" role="alert">Password failed to update. Fill in all the fields!!</div>';
    	} else {
    		if($_POST['oldPass'] == $Cpassword) {
    			if($_POST['newPass'] == $_POST['confirmPass']) {
    				$q_pass = 'update users set password="'.$_POST['newPass'].'" where id="'.$id.'";';
    				$magic_pass = mysqli_query($conn, $q_pass);
    				if($magic_pass) {
    					$issue = $issue . '<div class="alert alert-success" role="alert">Password Updated!</div>';
    				} else {
    					$issue = $issue . '<div class="alert alert-danger" role="alert">Password failed to update!</div>';
    				}
    			} else {
    				$issue = $issue . '<div class="alert alert-danger" role="alert">Password failed to update. Confirmed password does not match!!</div>';
    			}
    		} else {
    			$issue = $issue . '<div class="alert alert-danger" role="alert">Password failed to update. Old Password incorrect!!</div>';
    		}
    	}
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

    <title>myCorona | Edit Profile</title>

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

<!-- CONTENT -->
<div class="container">

  <div class="text-center">
    <h1>Edit Profile</h1>
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
				    <a href="#" class="active" id="login-form-link">Basic Info</a>
			    </div>
			    <div class="col-xs-6">
				    <a href="#" id="register-form-link">Password</a>
				</div>
			</div>
			<hr>
		    </div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
					<form id="login-form" action="editProfile.php" method="post" role="form" style="display: block;">
						<div class="form-group">
	                        <input type="text" name="fullName" id="fullName" tabindex="1" class="form-control" placeholder="<?php echo $Cfull_name;?>" value="">
	                    </div>
                        <div class="form-group">
	                        <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="<?php echo $Cemail;?>" value="">
	                    </div>
	                    <div class="form-group">
	                        <textarea name="descrip" id="descrip" tabindex="1" rows="4" columns="100" placeholder="" value="<?php echo $Cdescription;?>"></textarea>
	                    </div>
	                    <div class="form-group">
							<div class="row">
							<div class="col-sm-6 col-sm-offset-3">
								<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Change Info">
							</div>
							</div>
						</div>
					</form>
					<hr>
					<form action="editProfile.php" method="post" enctype="multipart/form-data">
						<div class="form-group">
							Change Profile Picture
							<input type="file" name="userfile" id="userfile">
						</div>
						<input type="submit" name="submit" id="submit" class="form-control btn btn-login" value="Upload Image">
					</form>
					<form id="register-form" action="editProfile.php" method="post" role="form" style="display: none;">
						<div class="form-group">
            	           <input type="password" name="oldPass" id="oldPass" tabindex="1" class="form-control" placeholder="Old Password" value="">
            	       </div>
            	       <div class="form-group">
            	           <input type="password" name="newPass" id="newPass" tabindex="1" class="form-control" placeholder="New Password" value="">
            	       </div>
            	       <div class="form-group">
            	           <input type="password" name="confirmPass" id="confirmPass" tabindex="1" class="form-control" placeholder="Confirm New Password" value="">
            	       </div>
            	       <div class="form-group">
							<div class="row">
								<div class="col-sm-6 col-sm-offset-3">
									<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Change Password">
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