<?php    require_once ('includes/linker.php');
    require_once ('includes/login.inc.php');
	require_once ('includes/database.php');
    
     $log = new login;
	 $db = new dbase;
    $log->database();
    $db->database();
    
    	if(isset($_POST['userid']) && isset($_POST['pass'])){
		$logname = strtoupper($_POST['userid']);
		$logpass = md5($_POST['pass']);
		//$logpas = $_POST['pname'];
		$log->do_login($logname,$logpass);
		
		if (isset($_POST['rem']) and $_POST['rem'] == "on") {
			setcookie('userid', $logname, time() + 60 * 60 * 24 * 30);
			setcookie('pass', $logpass, time() + 60 * 60 * 24 * 30);
			// * sets cookie for 30 days *
		}
		
		if ($log->logsuccess==1){
                    header("Location:".Student_Module);
		}
		elseif ($log->logsuccess==2){
                    header("Location:".Staff_Module);
		}
                elseif ($log->logsuccess==3){
                    header("Location:".Admin_Module);
		}
		elseif($log->logsuccess==4){
                    header("Location:".ControlPanel);
		}
		elseif($log->logsuccess==99){
                    header("Location:".Bursar_Module);
		}
		elseif($log->logsuccess==5){
                    header("Location:".Homepage."?err=raw&userid=".$logname);
		}
                elseif($log->logsuccess==6){
                    header("Location:".Homepage."?err=deactivated&userid=".$logname);
		}
                elseif($log->logsuccess==0){
                    header("Location:".Homepage."?err=notexist");
		}
		else
                    //header("Location:".Homepage);
				echo $log->logsuccess;
	}
        else if(isset($_POST['action']) && isset($_POST['pin'])){
            $db->set_sqlstr("SELECT Status FROM pin_log WHERE PIN = '" . $_POST['pin'] . "'");
            $db->querydata();
            $d = date('Y-n-d');
            $t = date('H:i:s');
            if($db->data[0] == "Raw"){
				$log->set_sqlstr("SELECT Class FROM student_data WHERE Username='" . $_POST['user'] . "'");
				$log->querydata();
				$log->set_sqlstr("SELECT Id FROM class WHERE Name='" . $log->data[0] . "'");
				$log->querydata();
				$class = ($log->data[0] + 1);
				$log->set_sqlstr("SELECT Name FROM class WHERE Id='" . $log->data[0] . "'");
				$log->querydata();
				$log->set_sqlstr("UPDATE student_data SET Class='".$log->data[0]."' WHERE Username='" . $_POST['user'] . "'"); 	
                $log->ex_scalar();
                $log->set_sqlstr("UPDATE auth_tab SET Status='Active' WHERE Username='" . $_POST['user'] . "'"); 	
                $log->ex_scalar();
				$log->set_sqlstr("UPDATE admission_details SET AdmissionStatus='Active', PresentClass='".$log->data[0]."' WHERE Username = '" . $_POST['user'] . "'");
				$log->ex_scalar();
				$log->set_sqlstr("UPDATE status SET Status='Active' WHERE Username = '" . $_POST['user'] . "'");
				$log->ex_scalar();
				
                $db->set_sqlstr("UPDATE pin_log SET Status='Used', User='" . $_POST['user'] . "', Date_Used='" . $d . "', Time_Used='" . $t . "'" .
                    " WHERE PIN = '".$_POST['pin']."'");
                $db->ex_scalar();
                header("Location:".Homepage."?err=activated&userid=".$_POST['user']);
            }
        }
?>
<!doctype html> 
<html class="no-js">

	<head>
		<meta charset="utf-8"/>
		<title>School Portal:: Authentication Page</title>
		
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link rel="stylesheet" media="all" href="css/style.css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->		
				
		<!-- JS -->
		<script src="js/jquery-1.7.1.min.js"></script>
		<script src="js/custom.js"></script>
		<script src="js/tabs.js"></script>
		<script src="js/css3-mediaqueries.js"></script>
		<script src="js/jquery.columnizer.min.js"></script>
		
		<!-- Isotope -->
		<script src="js/jquery.isotope.min.js"></script>
		
		<!-- Lof slider -->
		<script src="js/jquery.easing.js"></script>
		<script src="js/lof-slider.js"></script>
		<link rel="stylesheet" href="css/lof-slider.css" media="all"  /> 
		<!-- ENDS slider -->
		
		<!-- Tweet -->
		<link rel="stylesheet" href="css/jquery.tweet.css" media="all"  /> 
		<script src="js/tweet/jquery.tweet.js" ></script> 
		<!-- ENDS Tweet -->
		
		<!-- superfish -->
		<link rel="stylesheet" media="screen" href="css/superfish.css" /> 
		<script  src="js/superfish-1.4.8/js/hoverIntent.js"></script>
		<script  src="js/superfish-1.4.8/js/superfish.js"></script>
		<script  src="js/superfish-1.4.8/js/supersubs.js"></script>
		<!-- ENDS superfish -->
		
		<!-- prettyPhoto -->
		<script  src="js/prettyPhoto/js/jquery.prettyPhoto.js"></script>
		<link rel="stylesheet" href="js/prettyPhoto/css/prettyPhoto.css"  media="screen" />
		<!-- ENDS prettyPhoto -->
		
		<!-- poshytip -->
		<link rel="stylesheet" href="js/poshytip-1.1/src/tip-twitter/tip-twitter.css"  />
		<link rel="stylesheet" href="js/poshytip-1.1/src/tip-yellowsimple/tip-yellowsimple.css"  />
		<script  src="js/poshytip-1.1/src/jquery.poshytip.min.js"></script>
		<!-- ENDS poshytip -->
		
		<!-- JCarousel -->
		<script type="text/javascript" src="js/jquery.jcarousel.min.js"></script>
		<link rel="stylesheet" media="screen" href="css/carousel.css" /> 
		<!-- ENDS JCarousel -->
		
		<!-- GOOGLE FONTS -->
		<link href='http://fonts.googleapis.com/css?family=Voltaire' rel='stylesheet' type='text/css'>

		<!-- modernizr -->
		<script src="js/modernizr.js"></script>
		
		<!-- SKIN -->
		<link rel="stylesheet" media="all" href="css/skin.css"/>
		
		<!-- Less framework -->
		<link rel="stylesheet" media="all" href="css/lessframework.css"/>
		
		<!-- jplayer -->
		<link href="player-skin/jplayer-black-and-yellow.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/jquery.jplayer.min.js"></script>
		
		<!-- flexslider -->
		<link rel="stylesheet" href="css/flexslider.css" >
		<script src="js/jquery.flexslider.js"></script>
		
		<!-- reply move form -->
		<script src="js/moveform.js"></script>
		
	</head>
	
	
	<body class="page">
	
		<!-- HEADER -->
		<header>
			<div class="wrapper cf">
				
				<div id="logo">
					<a href="../index.php"><img  src="img/logo.png" alt="Simpler"></a>
				</div>
				
				<!-- nav -->
                                    <?php require_once 'includes/nav3.inc.php';?>
				<!-- ends nav -->

			</div>
		</header>
		<!-- ENDS HEADER -->
		
		<!-- MAIN -->
		<div id="main">
			<div class="wrapper cf">
			
			
				
			<!-- page content-->
        	<div id="page-content" class="cf">
                    <div id="mwindow_in">
                    
                        <?php 
                        if(isset($_REQUEST['err']) && $_REQUEST['err']=="raw"){
                        ?>
                        <form id="m" action="" method="post">
                        <fieldset style="text-align: center">
                                <h3>Enter Your Activation Pin</h3><hr>
                                <p>
                                        User ID: <?php echo $_REQUEST['userid']; ?>
                                </p>
                                <p>
                                        <input type="password" value="" name="pin" id="pin" size="35" placeholder="Enter Your Activation PIN"/>
                                        <input type="hidden" value="activate" name="action"/>
                                        <input type="hidden" value="<?php echo $_REQUEST['userid']; ?>" name="user" />
                                </p>
                                <p><input type="submit" value="Activate" /></p>
                        </fieldset></form>
                        <?php 
                        } else if(isset($_REQUEST['err']) && $_REQUEST['err']=="activated"){
                        ?>
                         <form id="mai" action="" method="post">
                        <fieldset style="text-align: center">
							<h3>Activation Successful</h3>
                                <h3>Enter your password again to login</h3><hr>
                                <p>
                                        User ID: <?php echo $_REQUEST['userid']; ?>
                                        <input type="hidden" value="<?php echo $_REQUEST['userid']; ?>" name="userid"/>
                                </p>
                                <p>
                                        <input type="password" value="" name="pass" size="35" placeholder="Password"/>
                                </p>
                                <p><input type="submit" value="Login" name="submit"/></p>
                        </fieldset> </form>
                         <?php 
                        } else if(isset($_REQUEST['err']) && $_REQUEST['err']=="deactivated"){
                        ?>
                         <form id="mai" action="" method="post">
                        <fieldset style="text-align: center">
                                <h3 style="color:red">Account Deactivated</h3><hr>
                                <p>
                                        Your Account has been locked by the school administrator, please visit your IT center to complain.
                                </p>
                        </fieldset> </form>
                        <?php }else{?>
                        <form id="mai" action="" method="post">
                        <fieldset style="text-align: center">
                                <h3>User Login</h3><hr>
                                <p style="color:#cb5432;">You want to access the part of this web that requires authentication, please provide your username and password to gain access.</p>
                                <p>
                                        <input type="text" value="" name="userid" id="userid" size="35" placeholder="User ID:"/>
                                </p>
                                <p>
                                        <input type="password" value="" name="pass" size="35" placeholder="Password"/>
                                </p>
                                <p><input type="submit" value="Login" name="submit" /></p>
                        </fieldset> </form>
                        <?php }?>
                   
                    </div>
    		</div>
    		<!-- ENDS page content-->
			</div><!-- ENDS WRAPPER -->
		</div>
		<!-- ENDS MAIN -->
		
		
		<!-- FOOTER -->
		<?php require_once 'includes/footer.inc.php';?>
		<!-- ENDS FOOTER -->
		
	</body>
	
	
	
</html>