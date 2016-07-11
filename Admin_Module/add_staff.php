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
        <title>School Portal :: Admin Module :: Staff Log</title>

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
		
		<script type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="../js/jquery.form.min.js"></script>
		<link href="../css/style2.css" rel="stylesheet" type="text/css">

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
		
		<!-- Datepicker -->
        <link rel="stylesheet" href="../jquery-box/development-bundle/themes/base/jquery.ui.all.css">
	
		<script src="../jquery-box/development-bundle/ui/jquery.ui.core.js"></script>
		<script src="../jquery-box/development-bundle/ui/jquery.ui.widget.js"></script>
		<script src="../jquery-box/development-bundle/ui/jquery.ui.datepicker.js"></script>
        
    <script type="text/javascript">
       $(document).ready(function(){
       $("#show").load("../bin_admin/addsta.php",hideLoader());
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
           $('input#addstaff').val('Loading...');
        var postData = $(this).serializeArray();
        //var formURL = $(this).attr("action");
        $.ajax(
        {
            url : "../bin_admin/register_staff.php",
            type: "POST",
            data : postData,
            dataType: 'json',
            success:function(d)
            {
                var name = $.trim(d.mn);
                var user = $.trim(d.us);
				var id = $.trim(d.id);
                //data: return data from server
                   $("#content").load("../bin/uploadpic.php?name=" + name +"&user=" + user +"&id="+ id);
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                //if fails  
                alert(textStatus);
            }
        });
        e.preventDefault(); //STOP default action
    });
        
        
        
        $("#paging_button ul li").click(function(){
		
		showLoader();
		
		$("#paging_button ul li").css({'background-color' : ''});
		$(this).css({'background-color' : '#FFA500'});

		$("#content").load("../bin_admin/staff_list.php?page=" + this.id, hideLoader);
		
		return false;
	});
	
	$("#1").css({'background-color' : '#FFA500'});
	//showLoader();
	//$("#content").load("../bin_admin/staff_list.php?page=1", hideLoader);
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
                    Staff Log
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
                        
                     
                        <div id="content">
							<h4>Enroll New Staff</h4><hr>
							<form id="mai" action="" method="post" enctype="multipart/form-data">
								<fieldset>
										<p>
												<select name="title">
													<option value="">Select Title</option>
													<option value="Dr.">Dr.</option>
													<option value="Mr.">Mr.</option>
													<option value="Mrs.">Mrs.</option>
													<option value="Miss">Miss</option>
												</select>
												<input type="hidden" value="Staff" name="pr" id="pr" />
										</p>
										<p>
											<input type="text" value="" name="surname" id="surname" placeholder="Surname"/>
										</p>
										<p>
											<input type="text" value="" name="firstname" id="firstname" placeholder="First Name"/>
										</p>
										<p>
											<input type="text" value="" name="othername" id="othername" placeholder="Last Name"/>
										</p>
										<p>
											<select name="gender">
												<option value="">Select Gender</option>
												<option value="1">Male</option>
												<option value="2">Female</option>
											</select>
											<input type="date" value="" name="dob" id="dob" placeholder="Date of Birth"/>
										</p>
										<p>
												<input type="text" value="" name="phone" id="phone" placeholder="Phone Number"/>
										</p>
										<p>
												<input type="text" value="" name="aphone" id="aphone" placeholder="Alt Phone Number"/>
										</p>
										<p>
												<input type="text" value="" name="email" id="email" placeholder="Email"/>
										</p>
										<p>
												<textarea  name="address"  id="address" rows="5" cols="10" placeholder="Address"></textarea>
										</p>
										<p>
												<input type="text" value="" name="bgroup" id="bgroup" placeholder="Blood Group"/>
										</p>
									   
										<p>
												<input type="text" value="" name="height" id="height" placeholder="Height"/>
										</p>
									   <p>
												<select name="religion" id="religion">
													<option>Select Religion</option>
													<option value="1">Christian</option>
													<option value="2">Muslim</option>
												</select>
												<select name="position" id="position">
													<option>Select Position</option>
													<?php 
													$log->set_sqlstr("SELECT * FROM position"); 
													$log->querydata();                        
													for($i=0; $i < $log->no_rec; $i++){
													   echo "<option value=\"".$log->data[0]."\">".$log->data[1]."</option>"; 
													   $log->fetchdata();
													}
													?>
												</select>
												<select name="class" id="class">
													<option>Select Class</option>
													<?php 
													$log->set_sqlstr("SELECT * FROM class"); 
													$log->querydata();                        
													for($i=0; $i < $log->no_rec; $i++){
													   echo "<option value=\"".$log->data[0]."\">".$log->data[1]."</option>"; 
													   $log->fetchdata();
													}
													?>
												</select>
												
										</p>

										<p><input type="submit" value="Add Staff" name="addstaff" id="addstaff" /></p>
								</fieldset>					
							</form>
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

  
 <script>
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
	
	 $('#dob').datepicker({
              changeMonth: true,
              changeYear: true,
              dateFormat: 'd-m-yy'
      });
        
    //callback handler for select change of option for state
       $('#si').submit(function(e) {
      showLoader();
      var c = $("#sid").val();
      var d = c.replace(" ", "%20");
     //alert(d);
       $("#content").load("../bin_admin/staff_list.php?page=1&sid="+ d, hideLoader()); 
      
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