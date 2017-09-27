<?php

    session_start();
    include('connect.php');

    if(!$_SESSION['logged-in']){
        header("Location: index.php");
    }

    // GET USER ID
    $query = 'select id, haveStore, password from users where username ="' .$_SESSION["login_user"].'";';
    $beepboop = mysqli_query($conn, $query);
    $useless = mysqli_fetch_object($beepboop);
    $id = $useless->id;
    $haveStore = $useless->haveStore;
    $Cpassword = $useless->password;

    // GET STORE INFO
    $query2 = 'select * from stores where owner_id="' . $id . '";';
    $beepboop2 = mysqli_query($conn, $query2);
    $useless2 = mysqli_fetch_object($beepboop2);
    $store_id = $useless2->id;
    $CstoreName = $useless2->name;
    $Cwebsite = $useless2->website;
    $Cdescrip = $useless2->description;

    $issue;

    // CHANGE BASIC INFO
    if(isset($_POST['storeName']) or isset($_POST['website']) or isset($_POST['descrip'])) {
        if($haveStore == 0) {
            $q_makingAStore = 'update users set haveStore = "1" where id="' . $id . '";';
            $magykal = mysqli_query($conn, $q_makingAStore);
            if($magykal) {
                $issue = $issue . '<div class="alert alert-success" role="alert">Store Created!</div>';
            } else {
                $issue = $issue . '<div class="alert alert-danger" role="alert">Store Failed to Create!</div>';
            }
        }


    	// UPDATE FULL NAME
    	if($_POST['storeName'] != "") {
    		$q_storeName = 'update stores set name ="'.$_POST['storeName'].'" where owner_id="' . $id . '";';
    		$magic_storeName = mysqli_query($conn, $q_storeName);
    		if($magic_storeName) {
    			$issue = $issue . '<div class="alert alert-success" role="alert">Name Updated!</div>';
    		} else {
    			$issue = $issue . '<div class="alert alert-danger" role="alert">Name Failed to Update!</div>';
    		}
    	}

    	// UPDATE WEBSITE
    	if($_POST['website'] != "") {
    		$q_website = 'update stores set website ="'.$_POST['website'].'" where owner_id="'. $id . '";';
    		$magic_website = mysqli_query($conn, $q_website);
    		if($magic_website) {
    			$issue = $issue . '<div class="alert alert-success" role="alert">Website Updated!</div>';
    		} else {
    			$issue = $issue . '<div class="alert alert-danger" role="alert">Website Failed to Update!</div>';
    		}
    	}

    	// UPDATE DESCRIPTION
    	if($_POST['descrip'] != "") {
    		$q_descrip = 'update stores set description ="'.$_POST['descrip'].'" where owner_id="'. $id .'";';
    		$magic_descrip = mysqli_query($conn, $q_descrip);
    		if($magic_descrip) {
    			$issue = $issue . '<div class="alert alert-success" role="alert">Description Updated!</div>';
    		} else {
    			$issue = $issue . '<div class="alert alert-danger" role="alert">Description Failed to Update!</div>';
    		}
    	}
    }

    // CHANGE STORE PICTURE
if(isset($_POST["submit"]) and $_POST['submit'] == "Upload Image") {
    $target_dir = "img/store/";
    $file = $target_dir . basename($_FILES['userfile']['name']);

    if(move_uploaded_file($_FILES['userfile']['tmp_name'], $file)) {
    	$issue = $issue . '<div class="alert alert-success" role="alert">Picture uploaded! </div>';
    	$q_img = 'update stores set img="'.$file.'" where owner_id="'.$id.'";';
    	if(mysqli_query($conn, $q_img)) {
    		$issue = $issue . '<div class="alert alert-success" role="alert">Picture updated!</div>';
    	}
    } else {
    	$issue = $issue . '<div class="alert alert-danger" role="alert">Picture not uploaded</div>';
    }
}

    // DELETE STORE
    if(isset($_POST['Pass']) or isset($_POST['confirmPass'])) {
    	if(!isset($_POST['Pass']) or !isset($_POST['confirmPass'])) {
    		$issue = $issue . '<div class="alert alert-danger" role="alert">Fill in all the fields!!</div>';
    	} else {
    		if($_POST['Pass'] == $Cpassword and $_POST['Pass'] == $_POST['confirmPass']) {
    				$q_pass = 'update users set haveStore="0" where id="'.$id.'";';
    				$magic_pass = mysqli_query($conn, $q_pass);
    				if($magic_pass) {
    					$issue = $issue . '<div class="alert alert-success" role="alert">Store Deleted!</div>';
    				} else {
    					$issue = $issue . '<div class="alert alert-danger" role="alert">Store failed to delete!</div>';
    				}
    		} else {
    				$issue = $issue . '<div class="alert alert-danger" role="alert">Store failed to delete! Password problems!</div>';
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

    <title>myCorona | Edit Store</title>

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
    <h1>Edit Store</h1>
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
				    <a href="#" class="active" id="login-form-link">Store Info</a>
			    </div>
			    <div class="col-xs-6">
				    <a href="#" id="register-form-link">Delete Store</a>
				</div>
			</div>
			<hr>
		    </div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
					<form id="login-form" action="editStore.php" method="post" role="form" style="display: block;">
						<div class="form-group">
	                        <input type="text" name="storeName" id="storeName" tabindex="1" class="form-control" placeholder="Store Name" value="">
	                    </div>
                        <div class="form-group">
	                        <input type="text" name="website" id="website" tabindex="1" class="form-control" placeholder="Website" value="">
	                    </div>
	                    <div class="form-group">
	                        <textarea name="descrip" id="descrip" tabindex="1" rows="4" columns="100" placeholder="Description" value=""></textarea>
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
					<form action="editStore.php" method="post" enctype="multipart/form-data">
						<div class="form-group">
							Change Store Picture
							<input type="file" name="userfile" id="userfile">
						</div>
						<input type="submit" name="submit" id="submit" class="form-control btn btn-login" value="Upload Image">
					</form>
					<hr>
					<form id="register-form" action="editStore.php" method="post" role="form" style="display: none;">
<?php

    if($haveStore == 0) {
        echo '<h1> Create Store First! </h1>';
    } else {
        echo '
                        <div class="form-group">
            	           <input type="password" name="Pass" id="Pass" tabindex="1" class="form-control" placeholder="Enter Password" value="">
            	       </div>
            	       <div class="form-group">
            	           <input type="password" name="confirmPass" id="confirmPass" tabindex="1" class="form-control" placeholder="Confirm Password" value="">
            	       </div>
            	       <div class="form-group">
							<div class="row">
								<div class="col-sm-6 col-sm-offset-3">
									<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Delete Store">
								</div>
							</div>
						</div>

        ';
    }

?>
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