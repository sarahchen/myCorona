<?php
    session_start();
    include('connect.php');

    if(($_SESSION['logged-in']) == false) {
        header('Location: explore.php');
    }

    $viewMode = 0; // 0 is owners store, 1 is someone else's store

    $issue;
    // ALL GET DATA FUNCTIONS
    if(isset($_GET['delete'])) {
        $offerID = $_GET['delete'];

        $q_delete = 'delete from users where id="'.$offerID.'";';
        if(mysqli_query($conn, $q_delete)) {
            $issue = $issue . 'Offer Deleted Successfully';
        }
    }

    // GET USER ID
    $q_userID = 'select id, haveStore, store_id from users where username ="' . $_SESSION['login_user'] . '";';
    $thebads = mysqli_query($conn, $q_userID);
    $thegoods = mysqli_fetch_object($thebads);
    $user_id = $thegoods->id;
    $haveStore = $thegoods->haveStore;
    $store_id = $thegoods->store_id;

    if(isset($_GET['store_id'])) {
        if($_GET['store_id'] != $store_id) {
            $viewMode = 1;
        }
    }
    if($viewMode == 0 and $haveStore == 0) {
        header('Location: editStore.php');
    }


    // STORE VARIABLES
    $store_id;
    $store_name;
    $owner_id;
    $website;
    $description;
    $offers;
    $followers;
    $img;

    // IF OWN STORE, GET STORE INFO
    if($viewMode == 0) {
        $q_MYstore = 'select * from stores where owner_id="' . $user_id . '";';
        $poopoo = mysqli_query($conn, $q_MYstore);
        $peepee = mysqli_fetch_object($poopoo);

    } elseif($viewMode == 1) {
        $q_store = 'select * from stores where id="' . $_GET['store_id'] . '";';
        $rock = mysqli_query($conn, $q_store);
        $peepee = mysqli_fetch_object($rock);

    } else {
        $issue = $issue . 'Could not load store';
    }

    $store_id = $peepee->id;
    $store_name = $peepee->name;
    $owner_id = $peepee->owner_id;
    $website = $peepee->website;
    $description = $peepee->description;
    $offers = $peepee->offers;
    $followers = $peepee->followers;
    $img = $peepee->img;

    function countArray($array) {
        $count = 0;
        if ($array != null) {
            $a = explode(",",$array);
            foreach($a as $value) {
                $count = $count + 1;
            }
        }
        return $count;
    }

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

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>myCorona | <?php echo $store_name;?></title>

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

<nav>
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
</nav>

<header style="background-image: url(<?php echo $img;?>);">
    <div class="header-content">
        <div class="header-content-inner">
            <h1><?php echo $store_name; ?></h1>
            <hr>
            <p><?php echo $description; ?></p>
            <hr>
            <a href="http://<?php echo $website;?>" class="btn btn-primary btn-xl">Visit Website</a>
            <?php
                if($viewMode == 0) {
                    echo '<a href="editStore.php" class="btn btn-primary btn-xl">Edit Store</a>';
                    echo '<a href="addPurchase.php" class="btn btn-primary btn-xl">Add Purchase</a>';
                } else {
                    // NEED TO WRITE SO THAT YOU CAN ONLY FOLLOW A STORE ONCE
                    // echo '<a href="follow.php?id='.$store_id.'" class="btn btn-primary btn-xl">Follow!</a>';
                }
            ?>
        </div>
    </div>
</header>

<section id="offers">
    <div class="container">
        <center>
        <h1>Offers!</h1>
<?php
    echo $issue;

    if($viewMode == 0) {
        echo '<a href="makeOffer.php" class="btn btn-default btn-xl wow tada">Make Offer!</a><br>';
    }

    if(countArray($offers) == 0) {
        echo '<div class="offer-box"> <h3>No Offers Here!</h3> </div>';
    } else {
        $a_offers = explode(",",$offers);
        foreach($a_offers as $v) {
            echo getOffer($conn, $v, $viewMode);
        }
    }

?>
    </center>
    </div>
</section>

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>


</body>

</html>