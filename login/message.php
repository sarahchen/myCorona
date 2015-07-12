    <?php
        session_start();

        function getUser($csv) {
            $file = fopen($csv, "r");
            $txt = fgetcsv($file);
            $data = array();
            for($counter = 0; $counter < sizeof($txt); $counter++) {
                $data[$counter] = $txt[$counter][0];
            }
            fclose($file);
            return $data;
        }

        function userExist($name) {
            $data = getUser("../userData.csv");
            for($counter = 0; $counter < sizeof($data); $counter++) {
                if($name == $data[$counter]) {
                    return $counter;
                    break;
                }
            }
            return -1;
        }

        function passMatch($user, $pass) {
            $index = userExist($user);
            $file = fopen("../userData.csv", "r");
            $txt = fgetcsv($file);
            fclose($file);
            $nPass = md5($pass);
            if($nPass == $txt[$index][1]) {
                return true;
            }
            else {
                return false;
            }
        }

        function validReg($u, $p) {
            if(userExist($u) > 0) {
                return false;
            }
            return true;
        }

        function validLog($u, $p) {
            if(userExist($u) > 0 and passMatch($u, $p)) {
                return true;
            } else {
                return false;
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

    <title>myCorona</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">

    <!-- Custom Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css" type="text/css">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="../css/animate.min.css" type="text/css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/creative.css" type="text/css">
    <!-- All the files that are required -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/login.css">
    <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <script src="../js/login.js"></script>
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
                <a class="navbar-brand page-scroll" href="../index.php">myCorona</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="../index.php#about">About</a>
                    </li>
                    <li>
                        <a href="../meetUs.php">Meet The Creators</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="../index.php#contact">Contact</a>
                    </li>
                    <li>
                        <a href="index.php">Login</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <div class="text-center" style="padding:50px 0">
        <div class="etc-login-form">
			<p>
			    <?php
			        if (!empty($_POST) and isset($_POST["reg_user"]) and isset($_POST["reg_pass"]) and isset($_POST["reg_email"]) and isset($_POST["reg_fullname"])) {
                        $user = $_POST["reg_user"];
                        $pass = $_POST["reg_pass"];
                        $email = $_POST["reg_email"];
                        $fullName = $_POST["reg_fullname"];

                        if(validReg($user, $pass)) {
                            $userData = fopen("../userData.csv", "a");
                            $txt = $user . "," . md5($pass) . "," . $email . "," . $fullName . "\n";
                            fwrite($userData, $txt);
                            fclose($userData);

                            echo "Success! You have registered.";
                        } else {
                            echo "Username is already taken. Try again.";
                        }

                    }

                    if (!empty($_POST) and isset($_POST["lg_user"])) {
                        $user = $_POST["lg_user"];
                        $pass = ($_POST["lg_pass"]);

                        if(validLog($user, $pass)) {
                            $_SESSION["User"] = $user;

                            echo "You have logged in.";
                        } else {
                            echo "Your username and password do not match.";
                        }
                    }
			    ?>
			</p>
	    </div>
    </div>

</body>
</html>