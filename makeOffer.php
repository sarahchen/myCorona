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
    // USER INFO
    $id = $useless->id;
    $haveStore = $useless->haveStore;

    // GET STORE INFO
    $query2 = 'select * from stores where owner_id="' . $id . '";';
    $beepboop2 = mysqli_query($conn, $query2);
    $useless2 = mysqli_fetch_object($beepboop2);
    // STORE INFO
    $store_id = $useless2->id;
    $storeName = $useless2->name;
    $offers = $useless2->offers;

    $issue;

    // MAKE OFFER
    if(isset($_POST['offer_title']) and isset($_POST['cost'])) {
    	if($_POST['offer_title'] != "" and $_POST['cost'] != "") {
    		$q_offer_title = 'insert into offers (store_id, offer, cost) values("' .$store_id.'", "'.$_POST['offer_title'].'", "'.$_POST['cost'].'")';
    		$magic_offer_title = mysqli_query($conn, $q_offer_title);
    		if($magic_offer_title) {
    			// GET OFFER ID
    			$q_getID = 'select id from offers where offer="'.$_POST['offer_title'].'";';
    			$theweirdreturnval = mysqli_query($conn, $q_getID);
    			$thenicereturnval = mysqli_fetch_object($theweirdreturnval);

    			$offer_id = $thenicereturnval->id;

    			// PUT INTO STORE INFO
    			if($offers == null) {
    			    $new_offers = strval($offer_id);
    			} else {
    			    $new_offers = $offers . ',' . strval($offer_id);
    			}
    			$q_update = 'update stores set offers="'.$new_offers.'" where id="'.$store_id.'";';

    			if(mysqli_query($conn, $q_update)) {
    			    $issue = $issue . '<div class="alert alert-success" role="alert">Offer Made!</div>';
    			} else {
    			    $issue = $issue . '<div class="alert alert-danger" role="alert">Offer failed to be made!</div>';
    			}
    		} else {
    			$issue = $issue . '<div class="alert alert-danger" role="alert">Offer failed to be made!</div>';
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

    <title>myCorona | Make Offer!</title>

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
    <h1>Create Offer</h1>
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
			    <div class="col-xs-12">
				    <a href="#" class="active" id="login-form-link">Enter All Info!</a>
			    </div>
			</div>
			<hr>
		    </div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
					<form id="login-form" action="makeOffer.php" method="post" role="form" style="display: block;">
						<div class="form-group">
	                        <input type="text" name="offer_title" id="offer_title" tabindex="1" class="form-control" placeholder="Offer" value="">
	                    </div>
                        <div class="form-group">
	                        <input type="text" name="cost" id="cost" tabindex="1" class="form-control" placeholder="Cost of Offer" value="">
	                    </div>
	                    <div class="form-group">
							<div class="row">
							<div class="col-sm-6 col-sm-offset-3">
								<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Make">
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