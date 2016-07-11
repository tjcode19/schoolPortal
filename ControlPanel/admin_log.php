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
        <title>School Portal :: Control Panel :: Admin Log</title>

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
       $('#error').hide();
       $('#mwindow').hide();
        
	function showLoader(){
	
		$('.search-background').fadeIn(200);
	}
	
	function hideLoader(){
	
		$('.search-background').fadeOut(200);
	};
        hideLoader;

	$("#adds").click(function(){
                $("#show").load("../bin/addadm.php",hideLoader());
                /*$('ul li').click(function(){
                    window.location=$(this).find('a').attr('href'); return false;
                    });*/

		$("#mwindow").show();
	});
        
        
        
        $("#paging_button ul li").click(function(){
		
		showLoader();
		
		$("#paging_button ul li").css({'background-color' : ''});
		$(this).css({'background-color' : '#FFA500'});

		$("#content").load("../bin/admin_list.php?page=" + this.id, hideLoader);
		
		return false;
	});
	
	$("#1").css({'background-color' : '#FFA500'});
	showLoader();
	$("#content").load("../bin/admin_list.php?page=1", hideLoader);
});

        </script>

    </head>


    <body class="page"> 
         <?php

$per_page = 20;  
$log->set_sqlstr("select * from authentication WHERE priority=3");
$log->querydata(); 
$count = $log->no_rec;
$pages = ceil($count/$per_page);
?>
              <div id="mwindow">
                            <div id="mwindow_in">
                                <div id="show">
                                </div>
                            </div>
                        </div> 
        <!-- HEADER -->
        <header>
            <div class="wrapper cf">

                <div id="logo">
                    <a href="index.html"><img  src="../img/logo.png" alt="Simpler"></a>
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
                <!-- masthead -->
                <div class="masthead cf">
                    Admin Log
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
                            
                            <form action="e_result.php" method="post">
                            <input type="button" value="Add New Administrator" id="adds"/>
                            <input type="text" name="sid" id="sid" value="" Placeholder="Search..."/>
                            </form>
                        </div>
                        <div id="content">
                           
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

                    </div>
                    <!-- ENDS entry content -->

                </div>
                <!-- ENDS page content-->

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

  
 <script>
     /*
   //callback handler for select change of option for state
   function setA(id){
    $.post( "../bin/del_n.php", { ids: id } )
    .done(function( data ) {
      $('#tabs-1').show().html(data);
      $('#succ').fadeIn(3000).html('News Deleted!');
    });
   }
    function setB(id){
    $.post( "../bin/set_news.php", { ids: id } )
    .done(function( data ) {
      $('#tabs-1').show().html(data);
      
            $("#gadget").load("../includes/news.inc.php");
      $('#succ').fadeIn(1000).html('Action Successful!').delay(2000).fadeOut(1000);
    });
  
   }
  */ 
$(document).ready(function(){
    
    function showLoader(){
	
		$('.search-background').fadeIn(200);
	}
	
	function hideLoader(){
	
		$('.search-background').fadeOut(200);
	};
        hideLoader;
	
	var Timer  = '';
	var selecter = 0;
	var Main =0;
	
	bring(selecter);
        
    //callback handler for select change of option for state
       $('#sid').keyup(function(e) {
      showLoader();
      var c = $("#sid").val();
      var d = c.replace(" ", "%20");
     //alert(d);
       $("#content").load("../bin/admin_list.php?page=1&sid="+ d, hideLoader()); 
      
        e.preventDefault(); //STOP default action
    });
});

function bring ( selecter )
{	
	$('div.shopp:eq(' + selecter + ')').stop().animate({
		opacity  : '1.0',
		height: '60px'
		
	},300,function(){
		
		if(selecter < 6)
		{
			clearTimeout(Timer); 
		}
	});
	
	selecter++;
	var Func = function(){ bring(selecter); };
	Timer = setTimeout(Func, 20);
}

    </script>
  </body>
</html>