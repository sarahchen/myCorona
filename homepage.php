<?php
    session_start();
    include('connect.php');

    if(($_SESSION['logged-in']) == false) {
        header('Location: index.php');
    }

    $username = $_SESSION['login_user'];

    function getOffer(mysqli $con, $SOMEVARIABLE, $viewMode) {
        $qqq = 'select * from offers where id="'.$SOMEVARIABLE.'";';
        $themagic = mysqli_query($con, $qqq);
        $themeat = mysqli_fetch_object($themagic);

        $offer = $themeat->offer;
        $cost = $themeat->cost;

        $thehtml = '
<div class="offer-box">
    <h3>' .$offer. '</h3>
    <p>Cost: '.$cost.'</p>
    <a href="profile.php?offer_id='.$SOMEVARIABLE.'" class="btn btn-default btn-xl wow tada">Claim Offer!</a>';

        if($viewMode == 0) {
            $thehtml = $thehtml . '<a href="store.php?delete='.$id.'" class="btn btn-danger btn-xl wow tada">Delete Offer</a> </div>';
        } else {
            $thehtml = $thehtml . '</div>';
        }
        return $thehtml;

    }

    function getStore(mysqli $con, $store_id) {
        $query = 'select * from stores where id="'.$store_id.'";';
        $result = mysqli_query($con, $query);
        $get = mysqli_fetch_object($result);

        $store_name = $get->name;
        $img = $get->img;

        $html = '
        <div class="col-lg-4 col-sm-6">
            <a href="store.php?store_id='.$store_id.'" class="portfolio-box">
                <img src="'.$img.'" class="img-responsive" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-name">
                                '.$name.'
                            </div>
                        </div>
                    </div>
            </a>
        </div>
        ';

        if($store_name == null) {
            return false;
        }

        return $html;
    }

    $isNull;

// GET ALL LIKED STORES
    $query_store = 'select likes from users where username ="'.$username.'";';
    $send_store = mysqli_query($conn, $query_store);
    $get_store = mysqli_fetch_object($send_store);

    $likes = $get_store->likes;
    if ($likes == null) {
        $isNull = true;
    } else {
        $isNull = false;
    }

    $arrayLikes = explode(",",$likes);



?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>myCorona | Home</title>

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/creative.css">
    <link rel="stylesheet" type="text/css" href="css/store.css">

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
        <p class="lead"></p>

<section>
    <h3>Recent Offers</h3>
<?php

    if($isNull == true) {
        echo "<p> You don't have any liked stores! </p>";
    } else {

    // GET ALL OFFERS FROM STORES
    $query = 'select * from offers where store_id in ("' .$likes. '");';
    $result = mysqli_query($conn, $query);
    $get = mysqli_fetch_array($result, MYSQLI_BOTH);

    $item=end($get);
    do {
        $offer_id = $item->id;
        echo getOffer($conn, $offer_id, $viewMode);
    } while ($item=prev($get));

    }

?>
</section>
    </div>
</div><!-- /.container -->

<!-- GOING TO BE SHUT OFF UNTIL AFTER MAKER FAIRE
<center><h3>New Stores</h3></center>
<section class="no-padding" id="portfolio">
        <div class="container-fluid">
            <div class="row no-gutter">
<?php
/*
    // Get Stores
    $qq = 'select id from stores;';
    $rr = mysqli_query($conn, $qq);
    $gg = mysqli_fetch_object($rr);

    echo $gg->id;

    $i = 0;
    $item = end($gg);
    do {
        echo $item;
        $hi = getStore($conn, $item);
        if($hi != false) {
            echo $hi;
            $i = $i + 1;
        }
    } while ($item=prev($gg) and $i<6);

*/

?>
            </div>
        </div>
    </section>
-->


    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/login.js"></script>


</body>

</html>