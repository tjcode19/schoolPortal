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
    
?>
<!doctype html> 
<html class="no-js">

    <head>
        <meta charset="utf-8"/>
        <title>School Portal :: Student Module :: Question Of The Week</title>

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
               
    <script type="text/javascript">
       $(document).ready(function(){
       //$("#show").load("../bin/addadm.php",hideLoader());
       $('.search-background').hide();
       $('#showc').hide();
        
	function showLoader(){
	
		$('.search-background').fadeIn(200);
	}
	
	function hideLoader(){
	
		$('.search-background').fadeOut(200);
	};
        hideLoader;
        
     //callback handler for select change of option for state
        $('#show p a').click(function(e){
        showLoader();
        var link = this.href;
         var r=confirm("Is this your final answer?");
            if (r==true)
              {
                $.ajax(
                {
                    url : link,
                    success:function()
                    {
                        //data: return data from server
                            $("#show").fadeOut(500);
                            $("#showc").delay(600).fadeIn(1000).show(1000);
                    }
                });
                hideLoader();
              }
              hideLoader();
        e.preventDefault(); //STOP default action
    });
    

	$("#content").load("../bin_student/ans_q.php?opt=Option1", hideLoader);
        });

        </script>
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
                    Question Of The Week
                </div>
                <!-- ENDS masthead -->
                
                <!-- page content-->
                <div id="page-content-sb" class="cf">        	
                      <div class="search-background">
                                <label><img src="../img/loader.gif" alt="" /></label>
                                <p>Please Wait</p>
                        </div>
                    <!-- entry-content -->
                    
                     <?php
                            $log->database();
                            
                            $log->set_sqlstr("SELECT Week FROM quiz_tab WHERE Status='Active'");
                            $log->querydata();
                            $wk = $log->data[0];
                            
                           // $wk1 = $wk-1;
                            $log->set_sqlstr("SELECT Question_ID FROM quiz_tab WHERE Week='".$wk."'");
                            $log->querydata();
							$qid = $log->data[0];
                            
                            $log->set_sqlstr("SELECT Question, Answer FROM question_tab WHERE ID='".$qid."'");
                            $log->querydata();
							$question=$log->data[0]; 
							$answer = $log->data[1];
                            
                            $log->set_sqlstr("SELECT ".$answer." FROM option_tab WHERE Question_ID='".$qid."'");
                            $log->querydata(); 
							$ans=$log->data[0];
                            
                            $log->set_sqlstr("SELECT Username FROM answer_tab WHERE Question_ID='".$qid."' AND Answer='".$answer.
                                    "' ORDER BY Date, Time ASC");
                            $log->querydata();                            
							$user = $log->data[0];
                            
                            $log->set_sqlstr("SELECT * FROM student_data WHERE Username='".$user."'");
                            $log->querydata(); 
                        ?>
                    <div class="entry-content cf">
                        <h4 style="color:green; text-decoration: blink;">Last Week Winner!</h4>
                         <table width="100%" cellpadding="10" cellspacing="0" >
                            <tr>
                                <td rowspan="4" width="30%">
                                    <a href="#" class="thumb">
                                        <img id="id" src="<?php echo $log->data[9]; ?>" alt="Post" />
                                    </a>
                                </td>
                                <td align="right">Name:</td>
                                <td><span style="color: #cb5432"><?php echo $log->data[1]." ".$log->data[2]." ".$log->data[3]; ?></span></td>
                            </tr>
                            <tr>
                                <td align="right">Class:</td>
                                <td><span style="color: #cb5432"><?php echo $log->data[12]; ?></span></td>
                            </tr>
                            <tr>
                                <td align="right">Question:</td>
                                <td><span style="color: #cb5432"><?php echo $question; ?></span></td>
                            </tr>
                             <tr>
                                <td align="right">Correct Answer:</td>
                                <td><span style="color: #cb5432"><?php echo $ans; ?></span></td>
                            </tr>
                            
                         </table><hr>
                         
                         <?php
                            $log->database();
                            
                            $log->set_sqlstr("SELECT Question_ID, Week FROM quiz_tab WHERE Status='Active'");
                            $log->querydata();
                            $id = $log->data[0];
                            $week = $log->data[1];
                            
                            $log->set_sqlstr("SELECT Session FROM school_calendar");
                            $log->querydata();
                            $sess = $log->data[0];
                            
                            $str = "SELECT * FROM answer_tab WHERE Username='".$_SESSION['s_portal_id']."' AND Week = '".$week.
                                    "' AND Session='".$sess."'";
                            $log->set_sqlstr($str);
                            $log->querydata();
                            $no = $log->no_rec;
							

                            $log->set_sqlstr("SELECT * FROM question_tab INNER JOIN option_tab ON question_tab.ID=option_tab.Question_ID WHERE question_tab.ID='".$id."'");
                            $log->querydata(); 
                            
                            if($no < 1){
                        ?>
                           <div id="show">
                        <h4>Question</h4>
                        <p><?php echo $log->data['Question']; ?></p>
                        <p><a href="../bin_student/ans_q.php?opt=Option1&user=<?php echo $_SESSION['s_portal_id']; ?>&id=<?php echo $id; ?>" class="link-button">A. <?php echo $log->data['Option1']; ?></a></p>
                        <p><a href="../bin_student/ans_q.php?opt=Option2&user=<?php echo $_SESSION['s_portal_id']; ?>&id=<?php echo $id; ?>" class="link-button">B. <?php echo $log->data['Option2']; ?></a></p>
                        <p><a href="../bin_student/ans_q.php?opt=Option3&user=<?php echo $_SESSION['s_portal_id']; ?>&id=<?php echo $id; ?>" class="link-button">C. <?php echo $log->data['Option3']; ?></a></p>
                        <p><a href="../bin_student/ans_q.php?opt=Option4&user=<?php echo $_SESSION['s_portal_id']; ?>&id=<?php echo $id; ?>" class="link-button">A. <?php echo $log->data['Option4']; ?></a></p>
                         
                        </div>
                            <?php }else{ ?>
                         <div id="show1">
                        <h5>You've attempted this week's quiz. Please join Us next week. Thank You!</h5>
                        
                        </div>
                         <?php } ?>
                         <div id="showc">
                        <h4>Thank You!!! Make sure you are here next week.</h4>
                        
                        </div>
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