<?php 

    require_once ('../includes/linker.php');
    require_once ('../includes/login.inc.php');
     $log = new login;
     
    $log->verify_login();
    if ($log->logsuccess !=1){
        header("Location:".Homepage);
    }
    if(isset($_REQUEST['action'])){
	    if($_REQUEST['action']=='out' && $log->logsuccess != 0) 
		   {$log->logout(); header("Location:".Homepage);}
	}  
 $log->set_sqlstr("SELECT Term, Session FROM school_profile"); 
 $log->querydata();
 $term = $log->data[0];
 $sess = $log->data[1];
 
 $log->set_sqlstr("SELECT Amount FROM paymentlog WHERE student_id='".$_SESSION['s_portal_id']."'"); 
 $log->querydata();
 $deposit = "";
 for ($i = 0; $i < $log->no_rec; $i++) {
   $deposit +=  $log->data[0];
   $log->fetchdata();
}
 
 $log->set_sqlstr("SELECT * FROM publications WHERE Type=1 AND Status=1 ORDER BY id DESC"); 
 $log->querydata(); 
 $news = $log->data[2];
 $newt = $log->data[1];
 
 $log->set_sqlstr("SELECT Class FROM student_data WHERE id='".$_SESSION['s_portal_id']."'"); 
 $log->querydata(); 
 $class = $log->data[0];
 
/* 
 $log->set_sqlstr("SELECT Amount FROM school_fees WHERE Name='".$class."'"); 
 $log->querydata();
 $amt = $log->data[0];
 */
 
   function addcomma($amt){
       $l = strlen($amt);
       //$g = $l/3;
       $nstr = "";
       for($i = 0; $i < $l; $i++){
           $nstr .=  substr( $amt,$i, 1);
        if( ((($l-($i+1))%3) == 0) 
             && (($i+ 1) != $l) ){
            $nstr .= ", ";
        }
       }
       return $nstr; 
   }
   
    function getTyp($po){
		$log = new login;	
		$log->database();
		$log->set_sqlstr("SELECT name FROM schoolfeetype WHERE id ='". $po."'"); 
		$log->querydata();
		return $log->data[0];
	}
	function getUser($po){
		$log = new login;	
		$log->database();
		$log->set_sqlstr("SELECT username FROM authentication WHERE id ='". $po."'"); 
		$log->querydata();
		return $log->data[0];
	}
   
   //$bal = $amt - $deposit;
?>
<!doctype html> 
<html class="no-js">

    <head>
        <meta charset="utf-8"/>
        <title>School Portal :: Student Module :: Payment Record</title>

        <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link rel="stylesheet" media="all" href="../css/style.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->		

        <!-- JS -->
        <script src="../js/jquery-1.7.1.min.js"></script>
        <script src="../js/custom.js"></script>
        <script src="../js/tabs.js"></script>
        <script src="../js/css3-mediaqueries.js"></script>
        <script src="../js/jquery.columnizer.min.js"></script>

        <!-- Isotope -->
        <script src="../js/jquery.isotope.min.js"></script>

        <!-- Lof slider -->
        <script src="../js/jquery.easing.js"></script>
        <script src="../js/lof-slider.js"></script>
        <link rel="stylesheet" href="../css/lof-slider.css" media="all"  /> 
        <!-- ENDS slider -->

        <!-- Tweet -->
        <link rel="stylesheet" href="../css/jquery.tweet.css" media="all"  /> 
        <script src="../js/tweet/jquery.tweet.js" ></script> 
        <!-- ENDS Tweet -->

        <!-- superfish -->
        <link rel="stylesheet" media="screen" href="../css/superfish.css" /> 
        <script  src="../js/superfish-1.4.8/js/hoverIntent.js"></script>
        <script  src="../js/superfish-1.4.8/js/superfish.js"></script>
        <script  src="../js/superfish-1.4.8/js/supersubs.js"></script>
        <!-- ENDS superfish -->

        <!-- prettyPhoto -->
        <script  src="../js/prettyPhoto/js/jquery.prettyPhoto.js"></script>
        <link rel="stylesheet" href="../js/prettyPhoto/css/prettyPhoto.css"  media="screen" />
        <!-- ENDS prettyPhoto -->

        <!-- poshytip -->
        <link rel="stylesheet" href="../js/poshytip-1.1/src/tip-twitter/tip-twitter.css"  />
        <link rel="stylesheet" href="../js/poshytip-1.1/src/tip-yellowsimple/tip-yellowsimple.css"  />
        <script  src="../js/poshytip-1.1/src/jquery.poshytip.min.js"></script>
        <!-- ENDS poshytip -->

        <!-- JCarousel -->
        <script type="text/javascript" src="../js/jquery.jcarousel.min.js"></script>
        <link rel="stylesheet" media="screen" href="../css/carousel.css" /> 
        <!-- ENDS JCarousel -->

        <!-- GOOGLE FONTS -->
        <link href='http://fonts.googleapis.com/css?family=Voltaire' rel='stylesheet' type='text/css'>

        <!-- modernizr -->
        <script src="../js/modernizr.js"></script>

        <!-- SKIN -->
        <link rel="stylesheet" media="all" href="../css/skin.css"/>

        <!-- Less framework -->
        <link rel="stylesheet" media="all" href="../css/lessframework.css"/>

        <!-- jplayer -->
        <link href="../player-skin/jplayer-black-and-yellow.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="../js/jquery.jplayer.min.js"></script>

        <!-- flexslider -->
        <link rel="stylesheet" href="../css/flexslider.css" >
        <script src="../js/jquery.flexslider.js"></script>

        <!-- reply move form -->
        <script src="../js/moveform.js"></script>

    </head>


    <body class="page">

        <!-- HEADER -->
        <header>
            <div class="wrapper cf">

                <div id="logo">
                    <a href="index.php"><img  src="../img/logo.png" alt="Simpler"></a>
                </div>

                <!-- nav -->
                    <?php require_once '../includes/nav.inc.php';?>
                <!-- ends nav -->

            </div>
        </header>
        <!-- ENDS HEADER -->

        <!-- MAIN -->
        <div id="main">
            <div class="wrapper cf">


                <!-- masthead -->
                <div class="masthead cf">
                    Payment Record
                </div>
                <!-- ENDS masthead -->
                
                <!-- page content-->
                <div id="page-content-sb" class="cf">        	

                    <!-- entry-content -->	
                    <div class="entry-content cf">
                        <div id="col1">
                            <table width="100%" cellpadding="10" cellspacing="0">
                                <tr>
                                    <td rowspan="4" width="30%">
                                       <h4><?php echo $newt; ?></h4><br/>
                                        <p><?php echo $news; ?></p>
                                    </td>
                                    <td align="right">Student ID:</td><td><?php echo strtoupper($_SESSION['user_id']); ?></td>
                                </tr>
								<?php 
									$log->set_sqlstr("SELECT * FROM schoolfees WHERE class='".$class."'"); 
									$log->querydata();
								
									for($i=0; $i < $log->no_rec; $i++){  
								?>
                                <tr>
                                    <td align="right"><?php echo getTyp($log->data[0]); ?>:</td><td>NGN <?php echo addcomma($log->data[2]); ?></td>
                                </tr>
									<?php $log->fetchdata(); } ?>
                            </table>
                        </div>
                        <h3 class="payrec">Payment History</h3>
                         <table width="100%" cellpadding="10" cellspacing="0" id="payrec">
                            <tr>
                                <th>S/N</th><th>Amount</th><th>Description</th><th>Date</th><th>Time</th>
                            </tr>
                            <?php 
                            $log->database();
                            $log->set_sqlstr("SELECT * FROM paymentlog WHERE student_id='".strtoupper($_SESSION['s_portal_id'])."'");
                            $log->querydata();
                            for($i = 0; $i < $log->no_rec; $i++){
                            ?>
                             <tr align="center">
                                <td><?php echo ($i+1); ?>.</td><td>NGN<?php echo addcomma($log->data[1]); ?></td><td><?php echo $log->data[7]; ?></td>
                                <td><?php echo $log->data[5]; ?></td><td><?php echo $log->data[6]; ?></td>
                            </tr>
                             <?php 
                                $log->fetchdata();
                                }
                            ?>
                        </table>
                    </div>
                    <!-- ENDS entry content -->

                </div>
                <!-- ENDS page content-->

                <!-- sidebar -->
                <aside id="sidebar">
                     <?php require_once '../includes/sidebar.inc.php';?>
                </aside>
                <!-- ENDS sidebar -->


            </div><!-- ENDS WRAPPER -->
        </div>
        <!-- ENDS MAIN -->


        <!-- FOOTER -->
            <?php require_once '../includes/footer.inc.php';?>
        <!-- ENDS FOOTER -->

    </body>



</html>