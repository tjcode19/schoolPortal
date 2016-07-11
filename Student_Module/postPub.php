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
		<title>School Portal :: Staff Module :: Post Article</title>
		
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
        $('.success').hide();
        
	function showLoader(){
	
		$('.search-background').fadeIn(200);
	}
	
	function hideLoader(){
	
		$('.search-background').fadeOut(200);
	};
        hideLoader;

    
     //callback handler for select change of option for state
       $('#mai').submit(function(e) {
      showLoader();
        var postData = $(this).serializeArray();
        //var formURL = $(this).attr("action");
        $.ajax(
        {
            url : "../bin_student/postPub.php",
            type: "POST",
            data : postData,
            dataType: 'html',
            success:function(d)
            {
                //data: return data from server
                if(d==0){
                    alert("The Content cannot be empty"); 
                    $('.success').html("The Content cannot be empty").show();
                }
                else if(d==2){
                    alert("Please Select Type");
                    $('.success').html("Please Select Type").show();
                }
                else{
                    alert("Data Posted"); 
                    $('.success').html("Data Posted").show();
                    $( '#mai' ).each(function(){
                        this.reset();
                    });
                }               
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                //if fails  
                alert(textStatus);
            }
        });
       //$("#sid").hide();
        e.preventDefault(); //STOP default action
    }); 
});

        </script>
	</head>
	
	
	<body class="blog">
	
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
                            Add New Publication
                        </div>
                        <!-- ENDS masthead -->	
                        <!-- posts list -->
	        	<div id="posts-list" class="cf">        	
	        		
                           <!-- form -->
                           
				<p id="sent-form-msg" class="success" style="font-size: 20px;"></p>
				<form id="mai" action="" method="post">
					<fieldset>
						
                                                <p>
                                                        <select name="type"  id="type">
                                                            <option Value="">Select Type</option>
                                                            <option Value="Article">Article</option>
                                                            <option Value="Jokes">Joke</option>
                                                            <option Value="News">News</option>
                                                            <option Value="Quote">Quote</option> 
                                                        </select>
						</p>
						<p>
							<input name="title"  id="title" type="text" class="form-poshytip" placeholder="Enter the Title" title="Enter the Title" />
						</p>
                                                
                                                <p>
							<input name="author"  id="author" type="text" class="form-poshytip" placeholder="Enter the Author" title="Enter the Author" />
						</p>
						
						<p>
							<textarea  name="content"  id="content" rows="5" cols="5" class="form-poshytip" placeholder="Enter content here" title="Enter content here"></textarea>
						</p>
												
						<p><input type="submit" value="Send" name="submit" id="submit" /> 
					</fieldset>
					
				</form>
				<!-- ENDS form -->
                          
        		</div>
        		<!-- ENDS posts list -->
			
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