<?php 

    require_once ('../includes/linker.php');
    require_once ('../includes/login.inc.php');
     $log = new login;
     
    $log->verify_login();
    if ($log->logsuccess !=4){
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
		<title>Demo School :: Control Panel :: Publications</title>
		
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
		<script type="text/javascript">
                    $(document).ready(function(){
                        //$("#show").load("../bin/addstu.php",hideLoader());
                        $('.search-background').hide();
                        //$('.success').hide();
                        $('#mwindow').hide();

                        function showLoader(){

                                $('.search-background').fadeIn(200);
                        }

                        function hideLoader(){

                                $('.search-background').fadeOut(200);
                        };
                        hideLoader;
                   
                     $("#paging_button ul li").click(function(){
		
                            showLoader();

                            $("#paging_button ul li").css({'background-color' : ''});
                            $(this).css({'background-color' : '#FFA500'});

                            $("#content").load("../bin_cpanel/student_s_list.php?page=" + this.id, hideLoader);

                            return false;
                    });
                    
                        $('#close').click(function(e){
                            $('#mwindow').hide();               
                              e.preventDefault();
                       });
                    $("#1").css({'background-color' : '#FFA500'});
                    showLoader();
                    //$("#content").load("../bin/scheme_list.php?page=1", hideLoader);
                    $("#article").load("../bin_cpanel/article.php?page=1");
                    $("#jokes").load("../bin_cpanel/jokes.php?page=1");
                    $("#quote").load("../bin_cpanel/quote.php?page=1");
                    $("#news").load("../bin_cpanel/news.php?page=1",hideLoader());
                   
                     });
                     
                </script>
	</head>
	
	
	<body class="blog">
	 <?php

        $per_page = 20;  
        $log->set_sqlstr("select * from publications ");
        $log->querydata(); 
        $count = $log->no_rec;
        $pages = ceil($count/$per_page);
        ?>
            <div id="mwindow">
                <div id="mwindow_in">
                    <a href="#" id="close"><img class="alignright" alt="View" title="Close" src="../img/mono-icons/stop32.png" /></a>
                    <div id="show">
                    </div>
                </div>
            </div>
		<!-- HEADER -->
		<header>
			<div class="wrapper cf">
				
				<div id="logo">
					<a href="index.php"><img  src="../img/logo.png" alt="Simpler"></a>
				</div>
				
				<!-- nav -->
				<?php require_once '../includes/nav4.inc.php';?>
				<!-- ends nav -->

			</div>
		</header>
		<!-- ENDS HEADER -->
		
		<!-- MAIN -->
		<div id="main">
                    
			<div class="wrapper cf">
                            <div class="search-background">
                                <label><img src="../img/loader.gif" alt="" /></label>
                                <p>Please Wait</p>
                        </div>
                        <!-- masthead -->
                        <div class="masthead cf">
                           Publications
                        </div>
                        <!-- ENDS masthead -->	
                        <!-- posts list -->
	        	<div id="posts-list" class="cf">        	
	        		
                         <!-- Tabs -->
                        <ul class="tabs">
                                <li><a href="#"><span>Articles</span></a></li>
                                <li><a href="#"><span>Jokes</span></a></li>
                                <li><a href="#"><span>Quote</span></a></li>
                                <li><a href="#"><span>News Log</span></a></li>
                        </ul>

                        <div class="panes">
                                <div id="article">

                                </div>
                                <div id="jokes">

                                </div>

                                <div id="quote">
                                    
                                </div>
                                <div id="news">
                                    
                                </div>
                        </div>
                          <div id="paging_button" align="center">
                            <ul>
                            <?php
                            //Show page links
                            for($i=1; $i<=$pages; $i++)
                            {
                                    echo '<li id="'.$i.'">'.$i.'</li>';
                            } ?>
                            </ul>
                        </div>
                        <!-- ENDS TABS -->
        		</div>
        		<!-- ENDS posts list -->
			
				<!-- sidebar -->
        	<aside id="sidebar">
                     <?php require_once '../includes/sidebar3.inc.php';?>
        		
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