<!doctype html> 
<html class="no-js">

    <head>
        <meta charset="utf-8"/>
        <title>Demo School :: Admin Module :: Result Log</title>

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
                    <a href="index.html"><img  src="../img/logo.png" alt="Simpler"></a>
                </div>

                <!-- nav -->
                    <?php require_once '../includes/nav2.inc.php';?>
                <!-- ends nav -->

            </div>
        </header>
        <!-- ENDS HEADER -->

        <!-- MAIN -->
        <div id="main">
            <div class="wrapper cf">


                <!-- masthead -->
                <div class="masthead cf">
                    Result Log for <?php echo $_REQUEST['n']?>
                </div>
                <!-- ENDS masthead -->
                
                <!-- page content-->
                <div id="page-content-sb" class="cf">        	

                    <!-- entry-content -->	
                    <div class="entry-content cf">
                        
                        <table width="100%" cellpadding="10" cellspacing="0" id="mai">
                            
                            <tr>
                                <td><a href="result.php" class="link-button">Back</a></td>
                                <td>
                                    <select name="term">
                                        <option>Select Term</option>
                                    </select>
                                    <select name="session">
                                        <option>Select Session</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="submit" value="Edit Result" />
                                </td>
                            </tr>
                            
                        </table>
                        
                        <div id="show">
                            <table width="100%" cellpadding="10" cellspacing="0" id="payrec">
                            
                            <tr>
                                <th>Course</th><th>CA1</th><th>CA2</th><th>CA</th><th>EXAM</th><th>TOTAL</th><th>GRADE</th>
                            </tr>
                            <tr align="center">
                                <td>Mathematics</td>
                                <td>10</td>
                                <td>10</td>
                                <td><span style="color: #cb5432">20</span></td>
                                <td>40</td>
                                <td><span style="color: #cb5432">60</span></td>
                                <td>B</td>
                            </tr>
                            
                        </table>
                        </div>

                    </div>
                    <!-- ENDS entry content -->

                </div>
                <!-- ENDS page content-->

                <!-- sidebar -->
                <aside id="sidebar">
                     <?php require_once '../includes/sidebar2.inc.php';?>
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