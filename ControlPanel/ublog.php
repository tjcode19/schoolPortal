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
		<title>Demo School :: Staff Module :: Add New Blog</title>
		
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
		
	</head>
	
	
	<body class="blog">
	
		<!-- HEADER -->
		<header>
			<div class="wrapper cf">
				
				<div id="logo">
					<a href="index.php"><img  src="../img/logo.png" alt="Simpler"></a>
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
                            Our Blog &#8594; Add New Blog
                        </div>
                        <!-- ENDS masthead -->	
                        <!-- posts list -->
	        	<div id="posts-list" class="cf">     
	        			
				<!-- Respond -->				
				<div id="respond">
					<h3 id="reply-title">Upload New Blog <small>
                                                <a rel="nofollow" id="cancel-comment-reply-link" href="/themes/wp-simpler/archives/34#respond" style="display:none;">Cancel reply</a></small></h3>
					
					
					<form action="single.php" method="post" id="commentform">
						
					<p class="comment-form-comment"><label for="comment">Content</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>						
					
					
					<p class="form-submit">
                                                <input name="add Image" type="submit" id="Addimage" value="Upload Picture">
						<input name="submit" type="submit" id="submit" value="Upload New Blog">
						<input type="hidden" name="comment_post_ID" value="34" id="comment_post_ID">
						<input type="hidden" name="comment_parent" id="comment_parent" value="0">
					</p>
					
					</form>
				</div>
				<!-- ENDS Respond -->
        		</div>
        		<!-- ENDS posts list -->
			
				<!-- side bar -->
        	<aside id="sidebar">
                     <?php require_once '../includes/sidebar2.inc.php';?>
        		
        	</aside>
			<!-- ENDS side bar -->
			
			
			</div><!-- ENDS WRAPPER -->
		</div>
		<!-- ENDS MAIN -->
		
		
		<!-- FOOTER -->
		<?php require_once '../includes/footer.inc.php';?>
		<!-- ENDS FOOTER -->
		
	</body>
	
	
	
</html>