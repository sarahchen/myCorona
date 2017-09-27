<?php

    session_start();
    include('connect.php');

    if(!$_SESSION['logged-in']) {
        header('Location: ../index.php');
    }

    $viewMode = 0; // SET TO 0 IS SELF, SET TO 1 IS SOMEONE ELSE
    if(isset($_GET['id'])) {
        $viewMode = 1;
        $prof_id = $_GET['id'];
    }

    if($viewMode == 0) {
        $query = 'select * from users where username ="' . $_SESSION['login_user'] . '";';
        $result = mysqli_query($conn, $query);
    }
    elseif($viewMode == 1) {
        $query = 'select * from users where id ="' . $prof_id . '";';
        $result = mysqli_query($conn, $query);
    }
    else {
        echo '<div class="alert alert-danger" role="alert">Could Not Load Profile</div>';
    }

    $data_array = mysqli_fetch_object($result);

    $id = $data_array->id;
    $username = $data_array->username;
    $full_name = $data_array->fullName;
    $email = $data_array->email;
    $points = $data_array->points;
    $description = $data_array->description;
    $likes = $data_array->likes;
    $prizes = $data_array->prizes;
    $store_id = $data_array->store_id;
    $img = $data_array->img;
    $haveStore = $data_array->haveStore;

    // FUNCTIONS

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

    // ADD OFFER
    if(isset($_GET['offer_id'])) {
        $new_offers = $prizes . ',' . $_GET['offer_id'];
        $q = 'update users set prizes="'.$new_offers.'" where id="' .$id. '";';
        if(mysqli_query($conn, $q)) {
            $issue = $issue . 'Offer Claimed!';
        } else {
            $issue = $issue . 'Offer failed to claim';
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

    <title>myCorona | Profile</title>

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">

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
		    <li><a href="#">Profile</a></li>
            <li><a href="store.php">Your Store</a></li>
		    <li><a href="explore.php">Explore</a></li>

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

<!-- PROFILE START -->
<section id="prof">

        <div class="container">
        	<div class="row">
        		<div class="col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
            	 <div class="well profile">
                    <div class="col-sm-12">
                        <div class="col-xs-12 col-sm-8">
                            <center>
                            <h2><?php echo $full_name; ?></h2>
                            <p><strong>About: </strong>
                            <?php
                                if($description != null) {
                                    echo $description;
                                } else {
                                    echo 'No Description.';
                                }
                            ?></p>
                            <p><strong>Points:</strong> <?php  echo $points; ?></p>
                            </center>
                        </div>
                        <div class="col-xs-12 col-sm-4 text-center">
                            <figure> <!-- THE SIDE THING -->
                                <img src="<?php echo $img;?>" alt="" class="img-circle img-responsive"> <!-- PROFILE PIC -->

                            </figure>
                        </div>
                    </div>
                    <div class="col-xs-12 divider text-center">
                        <div class="col-xs-12 col-sm-4 emphasis">
                            <h2><strong><?php echo countArray($likes); ?></strong></h2>
                            <p><small>Followed Stores</small></p>
                            <button class="btn btn-success btn-block"><span class="fa fa-home"></span> View Stores </button>
                        </div>
                        <div class="col-xs-12 col-sm-4 emphasis">
                            <h2><strong><?php echo countArray($prizes);?></strong></h2>
                            <p><small>Offers Claimed</small></p>
                            <button class="btn btn-info btn-block"><span class="fa fa-usd"></span> View Offers </button>
                        </div>
                        <div class="col-xs-12 col-sm-4 emphasis">
                            <h2><strong>
                            <?php
                                if($haveStore == 0) {
                                    echo '0';
                                } else {
                                    $query_store = 'select followers from stores where id="'.$store_id.'";';
                                    $stuffs = mysqli_query($conn, $query_store);
                                    $potato = mysqli_fetch_object($stuffs);
                                    $tomato = countArray($potato->followers);
                                    echo $tomato;
                                }
                            ?>
                            </strong></h2>
                            <p><small>Store Followers</small></p>
                            <div class="btn-group dropup btn-block">
                              <button type="button" class="btn btn-primary"><span class="fa fa-gear"></span> Options </button>
                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <ul class="dropdown-menu text-left" role="menu">
                                <li><a href="<?php echo $email; ?>"><span class="fa fa-envelope pull-right"></span> Send an email </a></li>
                                <li><a href="<?php
                                        if($viewMode == 0) {
                                            echo 'store.php';
                                        } else {
                                            if($haveStore == 0) {
                                                echo '#';
                                            } else {
                                                echo 'store.php?store_id='.$store_id;
                                            }
                                        }
                                    ?>"><span class="fa fa-home pull-right"></span>The Store</a></li>
                                <li class="divider"></li>
                                <li><a href="#"><span class="fa fa-warning pull-right"></span>Report this user for spam</a></li>
                                <li class="divider"></li>
                                <?php
                                    if($viewMode == 0) {
                                        echo '<li><a href="editProfile.php" class="btn" role="button"> Edit Profile </a></li>';
                                    } else {
                                        echo '<li><a href="#" class="btn disabled" role="button">Hello</a></li>';
                                    }
                                ?>

                              </ul>
                            </div>
                        </div>
                    </div>
            	 </div>
        		</div>
        	</div>
        </div>
</section>

<!-- FOLLOWED STORES SECTION -->
<!-- SHUT OFF UNTIL AFTER MAKER FAIRE
<section id="likes">
    <div id="myCarousel" class="carousel slide">

        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>


        <div class="carousel-inner">
            <div class="item active">

                <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide One');"></div>
                <div class="carousel-caption">
                    <h2>Caption 1</h2>
                </div>
            </div>
            <div class="item">

                <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide Two');"></div>
                <div class="carousel-caption">
                    <h2>Caption 2</h2>
                </div>
            </div>
            <div class="item">

                <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide Three');"></div>
                <div class="carousel-caption">
                    <h2>Caption 3</h2>
                </div>
            </div>
        </div>


        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>

    </div>
</section>
-->

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/login.js"></script>
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>


</body>

</html>