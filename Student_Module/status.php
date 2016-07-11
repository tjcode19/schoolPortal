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
        
         $log->set_sqlstr("SELECT * FROM student_data WHERE id='". $_SESSION['s_portal_id'] ."'"); 
        $log->querydata();
        $name = $log->data['last_name']." ".$log->data['first_name']." ".$log->data['other_name'];
             
        
        $log->set_sqlstr("SELECT * FROM behaviouralattitude WHERE student_id ='". $_SESSION['s_portal_id'] ."'"); 
        $log->querydata();
        
        function Grade($e){
            return (($e == "A")?"Excellent":
                (($e == "B")?"Very Good":
                    (($e == "C")?"Good":
                        (($e == "D")?"Fair":
                            (($e == "E")?"Poor":"Very Poor")))));
        }
        
?>
<!doctype html> 
<html class="no-js">

    <head>
        <meta charset="utf-8"/>
        <title>School Portal :: Student Module :: Status & Eligibility</title>

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
                    Status and Eligibility
                </div>
                <!-- ENDS masthead -->
                
                <!-- page content-->
                <div id="page-content-sb" class="cf">        	

                    <!-- entry-content -->	
                    <div class="entry-content cf">

                        <table width="100%" cellpadding="10" cellspacing="0" id="det">
                        
                        <tr>
                            <th colspan="2">Status & Eligibility for <?php echo $name; ?></th>
                        </tr>
                        <tr>
                            <td align="right">Student Name:</td><td><?php echo $name; ?></td>
                        </tr>
                        <tr>
                            <td align="right">Admission Status:</td><td> Active </td>
                        </tr>
                         <tr>
                            <td align="right">Punctuality:</td><td><?php echo Grade($log->data[2]); ?></td>
                        </tr>
                        <tr>
                            <td align="right">Class Attendance:</td><td><?php echo Grade($log->data[3]); ?></td>
                        </tr>
                        <tr>
                            <td align="right">Carry Out Of Assignment:</td><td><?php echo Grade($log->data[4]); ?></td>
                        </tr>
                        <tr>
                            <td align="right">Neatness:</td><td><?php echo Grade($log->data[6]); ?></td>
                        </tr>
                        <tr>
                            <td align="right">Politeness:</td><td> <?php echo Grade($log->data[5]); ?> </td>
                        </tr>
                        <tr>
                            <td align="right">Relationship With Staff:</td><td> <?php echo Grade($log->data[7]); ?> </td>
                        </tr>
                        <tr>
                            <td align="right">Relationship With Student:</td><td> <?php echo Grade($log->data[8]); ?> </td>
                        </tr>
                        <tr>
                            <td align="right">Attentiveness In Class:</td><td><?php echo Grade($log->data[1]); ?></td>
                        </tr>
                        <tr>
                            <td align="right">Initiative:</td><td><?php echo Grade($log->data[9]); ?></td>
                        </tr>
                        <tr>
                            <td align="right">Emotional Stability:</td><td> <?php echo Grade($log->data[10]); ?> </td>
                        </tr>
                        <tr>
                            <td align="right">Attitude to Study:</td><td><?php echo Grade($log->data[11]); ?></td>
                        </tr>
                        <tr>
                            <td align="right">Attitude to School:</td><td><?php echo Grade($log->data[12]); ?></td>
                        </tr>
                        <tr>
                            <td align="right">Manual Skill:</td><td> <?php echo Grade($log->data[13]); ?> </td>
                        </tr>
                        <tr>
                            <td align="right">Club & Societies:</td><td><?php echo Grade($log->data[14]); ?></td>
                        </tr>
                        <tr>
                            <td align="right">Class Teacher's remark:</td><td><?php echo $log->data[15]; ?></td>
                        </tr>
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