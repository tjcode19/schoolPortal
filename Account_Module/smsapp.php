<?php 

    require_once ('../includes/linker.php');
    require_once ('../includes/login.inc.php');
     $log = new login;
     
    $log->verify_login();
    if ($log->logsuccess !=99){
        header("Location:".Homepage);
    }
    if(isset($_REQUEST['action'])){
	    if($_REQUEST['action']=='out' && $log->logsuccess != 0) 
		   {$log->logout(); header("Location:".Homepage);}
	}
        
    $log->set_sqlstr("SELECT sms_units FROM school_calendar"); 
    $log->querydata(); 
    $sms_unit = $log->data[0]; 
?>
<!doctype html> 
<html class="no-js">

	<head>
		<meta charset="utf-8"/>
		<title>School portal :: Admin Module :: SMS APP</title>
		
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
       $('#mai').submit(function(e) {
        showLoader();
        
        var postData = $(this).serializeArray();
        //var formURL = $(this).attr("action");
        $.ajax(
        {
            url : "../bin_admin/send_sms.php",
            type: "POST",
            data : postData,
            dataType: 'json',
            //dataType: 'html',
            success:function(d)
            {
                //data: return data from server
				alert(d.r);
                var r = d.r;
                var n = d.n;
                var u = d.u;
                //alert(r);
                if(r == 1){                    
                    $(".bal").html(n, hideLoader()); 
                    $(".used").html(u, hideLoader());
                    alert("Message Sent");
                     $( '#mai' ).each(function(){
                        this.reset();
                    });
                    $("#sent-form-msg").html("Message Sent").show(); 
                }
                else if(r == 2){                    
                    alert("Please Select Target");
                    $("#sent-form-msg").html("Please Select Target").show();
                    hideLoader();
                    //$("#sent-form-msg").show(); 
                }
                else if(r == 3){                    
                    alert("Message Field can not be empty");
                    $("#sent-form-msg").html("Message Field can not be empty").show(); 
                    hideLoader();
                    //$("#sent-form-msg").show(); 
                }
                else{
                    alert("Message Sending Failed \n SMS Unit is low");
                    $("#sent-form-msg").html("Message Sending Failed </br> SMS Unit is low").show(); 
                    hideLoader();
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                //if fails  
                alert(textStatus);
            }
        });
        e.preventDefault(); //STOP default action
    });
    $('#msg').keyup(function() {
        var len = $.trim($("#msg").val()).length;
        var page;
        if(len <= 160) page = 1;
        else if(len > 160 && len < 320) page = 2;
        $('#lent').text('You typed ' + len + ' Letters, Page: ' + page);
        //alert(len);
        
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
				<?php require_once '../includes/nav_acct.php';?>
				<!-- ends nav -->

			</div>
		</header>
		<!-- ENDS HEADER -->
		
		<!-- MAIN -->
		<div id="main">
			<div class="wrapper cf">
                        <!-- masthead -->
                        <div class="masthead cf">
                            SMS APP
                        </div>
                        <!-- ENDS masthead -->	
                        <!-- posts list -->
	        	<div id="posts-list" class="cf">        	
	        		  <div class="search-background">
                                <label><img src="../img/loader.gif" alt="" /></label>
                                <p>Please Wait</p>
                        </div>
                           <!-- form -->
				<script type="text/javascript" src="../js/form-validation.js"></script>
				<p id="sent-form-msg" class="success" style="color:#cb5432; font-size: 18px">Message Sent</p>
				<form id="mai" action="" method="post">
                                    <fieldset>
                                            <p>
                                                <span style="font-size: 17px;" >SMS Balance: 
                                                    <span style="font-size: 17px;" class="bal"><?php echo $sms_unit; ?></span>
                                                </span>
                                                <span style="font-size: 17px; float: right;">SMS Units Charged: 
                                                    <span style="font-size: 17px;" class="used">0</span>
                                                </span>
                                            </p>
                                            <p>
                                                    <select name="target" id="target">
                                                        <option value="">Select Your Target Here</option>
                                                        <option value="none">None</option>
                                                        <option value="staff">All Staff</option>
                                                        <option value="parent">All Parents</option>
                                                    </select>
                                            </p>
                                            <p>
                                                    <input required type="text" value="" name="s_id" id="s_id" placeholder="Sender ID (11 Characters Only)"/>
                                            </p>
                                            <p>
                                                    <textarea  name="rec"  id="rec" rows="5" cols="10" placeholder="Enter Receivers seperated by comma(,)"></textarea>
                                            </p>

                                            <p>
                                                    <textarea  required name="msg"  id="msg" rows="5" cols="10" placeholder="Message Here"></textarea>
                                            </p>

                                            <p><input type="submit" value="Send" name="submit" id="submit" /> 
                                                <span id="error" class="warning">Message</span></p>
                                            <p id="lent" style="color:#cb5432; font-size: 18px"></p>
                                    </fieldset>					
				</form>
				<!-- ENDS form -->
                          
        		</div>
        		<!-- ENDS posts list -->
			
				<!-- sidebar -->
        	<aside id="sidebar">
                     <?php require_once '../includes/sidebar_acct.inc.php';?>
        		
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