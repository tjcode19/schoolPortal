<?php 

    require_once ('../includes/linker.php');
    require_once ('../includes/login.inc.php');
     $log = new login;
     
    $log->verify_login();
    if ($log->logsuccess !=3){
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
        <title>Demo School :: Admin Module :: Scheme Of Work</title>

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
           //$("#show").load("../bin/addstu.php",hideLoader());
	$('.search-background').hide();
        $('#error').hide();
        $('#mwindow').hide();
        
	function showLoader(){
	
		$('.search-background').fadeIn(200);
	}
	
	function hideLoader(){
	
		$('.search-background').fadeOut(200);
	};
        hideLoader;
	
      //callback handler for select change of option for state
      $('#sea').submit(function(e) {
      showLoader();
      var c = $("select#cl").val();
      var c1 = c.replace(" ", "%20");
      var s = $("select#sub").val();
      var s1 = s.replace(" ", "%20");
      var t = $("select#term").val();
      var t1 = t.replace(" ", "%20");
      //alert(c1+s1+t1);
       $("#content").load("../bin/scheme_edit.php?page=1&c="+ c1 +"&s="+ s1 +"&t="+ t1, hideLoader()); 
      /*
        var postData = $(this).serializeArray();
        //var formURL = $(this).attr("action");
        $.ajax(
        {
            url : "../bin/search.php",
            type: "POST",
            data : postData,
            dataType: 'json',
            success:function(d)
            {
                //data: return data from server
                alert("hey");
                $("#content").load("../bin/scheme_list.php?page=1&c="+ d.cl +"&s="+ d.sub +"&t="+ d.te, hideLoader()); 
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                //if fails  
                alert(textStatus);
            }
        });*/
        e.preventDefault(); //STOP default action
    });
    
       //callback handler for select change of option for state
       $('#m').submit(function(e) {
      showLoader();
      
        var postData = $(this).serializeArray();
        //var formURL = $(this).attr("action");
        $.ajax(
        {
            url : "../bin/update_sc.php",
            type: "POST",
            data : postData,
            dataType: 'json',
            success:function(d)
            {
                //data: return data from server
                //alert(d)
                var c = d.c;
                var c1 = c.replace(" ", "%20");
                var s = d.s;
                var s1 = s.replace(" ", "%20");
                var t = d.t;
                var t1 = t.replace(" ", "%20");
                alert("Data Updated");
                $("#content").load("../bin/scheme_edit.php?page=1&c="+ c1 +"&s="+ s1 +"&t="+ t1, hideLoader()); 
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                //if fails  
                alert(textStatus);
            }
        });
        e.preventDefault(); //STOP default action
    });
	
	$("#content").load("../bin/scheme_edit.php?page=1", hideLoader);
});

        </script>
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
                    Scheme Of Work
                </div>
                <!-- ENDS masthead -->
                
                <!-- page content-->
                <div id="page-content-sb" class="cf">        	

                    <!-- entry-content -->	
                    <div class="entry-content cf">
                       <div class="search-background">
                                <label><img src="../img/loader.gif" alt="" /></label>
                                <p>Please Wait</p>
                        </div>
                        <div id="mai" style="margin-bottom: 10px;">
                             <form action="" method="post" id="sea">
                                    <select name="cl" id="cl">
                                        <option value="">Select Class</option>
                                        <?php 
                                        $log->set_sqlstr("SELECT Name FROM class"); 
                                        $log->querydata();                        
                                        for($i=0; $i < $log->no_rec; $i++){
                                           echo "<option value=\"".$log->data[0]."\">".$log->data[0]."</option>"; 
                                           $log->fetchdata();
                                        }
                                        ?>
                                    </select>
                                    <select name="sub" id="sub">
                                        <option value="">Select Subject</option>
                                        <?php 
                                        $log->set_sqlstr("SELECT Name FROM subject"); 
                                        $log->querydata();                        
                                        for($i=0; $i < $log->no_rec; $i++){
                                           echo "<option value=\"".$log->data[0]."\">".$log->data[0]."</option>"; 
                                           $log->fetchdata();
                                        }
                                        ?>
                                    </select>
                                    <select name="term" id="term">
                                        <option value="">Select Term</option>
                                        <?php 
                                        $log->set_sqlstr("SELECT Name FROM term"); 
                                        $log->querydata();                        
                                        for($i=0; $i < $log->no_rec; $i++){
                                           echo "<option value=\"".$log->data[0]."\">".$log->data[0]."</option>"; 
                                           $log->fetchdata();
                                        }
                                        ?>
                                    </select>
                                 <input type="submit" value="Search" />
                            </form>
                        </div><form action="" method="post" id="m">
                         <div id="content">
                             
                                 
                             
                       </div></form>

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