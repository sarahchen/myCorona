<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>myCorona | Meet Us</title>

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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top">

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
                        <a href="meetUs.php">Meet The Creators</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="explore/index.php">Explore</a>
                    </li>
                    <?php
                        if($_SESSION['logged-in']) {
                            echo
                            ' <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . $_SESSION['login_user'] . '<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="profile/index.php">Profile</a></li>
            <li><a href="#">Your Store</a></li>
            <li><a href="#">Settings</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="login/message.php?type=logout">Logout</a></li>
          </ul>
        </li> ';
                        } else {
                            echo '<li>
                        <a href="login/index.php">Login</a>
                    </li>';
                        }

                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- MAIN PICTURE THING -->
    <header style="background-image: url(../img/header.jpg);">
        <div class="header-content">
            <div class="header-content-inner">
                <h1>Meet the Creators of myCorona</h1>
                <hr>
                <p>
                    We are three high school girls that planned and built myCorona from scratch.
                </p>
            </div>
        </div>
    </header>

    <section class="bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">Innovation Institute</h2>
                    <p class="text-faded">
                        Summer 2014, the New York Hall of Science in Corona, Queens opened up a program to highschool students looking to make improvements in the community. The program provded us with design, marketing, and anthropological skills we must implement to build a final project that leaves an impact.
                        <br></br>
                        The class broke into groups, each identifying a different problem in the community and assessing the best way to solve this problem.
                        We noticed the shops that were closed in the daytime and the "For Sale/Rent" signs in every other storefront and decided that this was the problem we were going to tackle.
                        <br></br>
                        After a lot of planning, we decided to build a website that combined many existing services together in one place. It is special and original because it was built for a community, tailored for small businesses to succeed.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">The Makers</h2>
                    <hr class="primary">
                </div>
            </div>
            <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <h3>Allyssa Tiara</h3>
                        <p class="text-muted">
                            Allyssa is a senior at NEST HS in Manhattan and works part time, but her passions are music and fencing. She will one day go pro with all the practice she does.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <h3>Ekta Rana</h3>
                        <p class="text-muted">
                            Ekta is a senior at Townsend Harris HS in Queens and is works at the NY Hall of Science as an Explainer. She participated in Girls Who Code and aspires to become a computer programmer in the future.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <h3>Sarah Chen</h3>
                        <p class="text-muted">
                            Sarah is a senior at Stuyvesant HS in Manhattan and is the brains of this operation. She coded the website after learning how to program and enjoys coding for her high school's First Robotics Team. She will one day become an amazing programmer.
                        </p>
                    </div>
                </div>
    </section>

    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">Let's Get In Touch!</h2>
                    <hr class="primary">
                </div>
                <div class="col-lg-4 col-lg-offset-2 text-center">
                    <i class="fa fa-phone fa-3x wow bounceIn"></i>
                    <p>123-456-6789</p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fa fa-envelope-o fa-3x wow bounceIn" data-wow-delay=".1s"></i>
                    <p><a href="mailto:your-email@your-domain.com">info@mycorona.com</a></p>
                </div>
            </div>
        </div>
    </section>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/jquery.fittext.js"></script>
    <script src="js/wow.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/creative.js"></script>

</body>

</html>
/body>

</html>
