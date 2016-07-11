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
        <title>School Portal :: Admin Module :: Student Log</title>

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
           $("#show").load("../bin_admin/addstu.php",hideLoader());
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
        //$("#show").load("student_log.php",hideLoader());
		//$("#mwindow").show();
		
		var win = window.open('student_log.php', '_blank');
			if(win){
				//Browser has allowed it to be opened
				win.focus();
			}else{
				//Broswer has blocked it
				alert('Please allow popups for this site');
			}
		
	});

	$("#rtype").change(function(){
		var typ = $(this).val();
		if(typ == "fr"){
			$("#rpin").css('visibility','visible');	
		}
		else
			$("#rpin").css('visibility','hidden');	
	});
	
	 $('#dob').datepicker({
              changeMonth: true,
              changeYear: true,
              dateFormat: 'd-m-yy'
      });
	
	 //callback handler for select change of option for state
       $('#mai').submit(function(e) {
           //showLoader();
           $('input#addst').val('Loading...');
        var postData = $(this).serializeArray();
        //var formURL = $(this).attr("action");
        $.ajax(
        {
            url : "../bin_admin/register_student.php",
            type: "POST",
            data : postData,
            dataType: 'json',
			//dataType: 'html',
            success:function(d)
            {
                var name = $.trim(d.mn);
                var user = $.trim(d.us);
				var id = $.trim(d.id);
                //alert(name);
				  //alert(d.n);
                //data: return data from server
                  // $("#content").load("../bin_admin/student_list.php?page=1"); 
                  $("#content").load("../bin_admin/uploadpic_stu.php?name="+ name +"&user=" + user +"&id="+ id);
				  //$("#mwindow").show();
                  // $("#content").load("../bin_admin/student_list.php?page=1", hideLoader());
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

		$("#content").load("../bin_admin/student_list.php?page=" + this.id, hideLoader);
		
		return false;
	});
	
	$("#1").css({'background-color' : '#FFA500'});
	//showLoader();
	//$("#content").load("../bin_admin/student_list.php?page=1", hideLoader);
});

        </script>

    </head>


    <body class="page">
        
            <?php

$per_page = 20;  
$log->set_sqlstr("select * from authentication WHERE Priority=1 ");
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
                    Student Log
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
                        <h4>Enroll New Student</h4><hr>
                        <div id="content">
                           <form id="mai" action="" method="post" enctype="multipart/form-data">
							<fieldset>
									<p>
											<input type="text" value="" name="surname" id="surname" placeholder="Surname"/>
											<input type="hidden" value="Student" name="pr" id="pr" />
									</p>
									<p>
											<input type="text" value="" name="firstname" id="firstname" placeholder="First Name"/>
									</p>
									<p>
											<input type="text" value="" name="othername" id="othername" placeholder="Last Name"/>
									</p>
									<p>
											<input type="date" value="" name="dob" id="dob" placeholder="Date of Birth"/>
											<select name="gender">
												<option value="">Select Gender</option>
												<option value="1">Male</option>
												<option value="2">Female</option>
											</select>
											<select name="class" >
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
									<p>
											<input type="text" value="" name="bgroup" id="bgroup" placeholder="Blood Group"/>
									</p>
									<p>
											<input type="text" value="" name="height" id="height" placeholder="Height"/>
									</p>
									<p>
										<select name="ptitle" id="ptitle">
											<option value="">Parent Title</option>
											<option value="Mr">Mr.</option>
											<option value="Mrs">Mrs.</option>
											<option value="Mrs">Dr.</option>
											<option value="Mrs">Prof.</option>
											<option value="Chief">Chief</option>
										</select>
										<input type="text" value="" name="pname" id="pname" placeholder="Parent Name (O. O. Adedayo)"/>
									</p>
									<p>
											<input type="text" value="" name="pphone" id="pphone" placeholder="Contact Phone Number"/>
											<input type="text" value="" name="apphone" id="apphone" placeholder="Alt Phone Number"/>
									</p>
									<p>
											<input type="text" value="" name="pemail" id="pemail" placeholder="Contact Email"/>
									</p>
									<p>
											<input type="text" value="" name="soo" id="soo" placeholder="State of origin"/>
									</p>
									<p>
											<input type="text" value="" name="lgo" id="lgo" placeholder="Local Gov. of oringin"/>
									</p>
									<p>
											<textarea  name="paddress"  id="paddress" rows="5" cols="5" placeholder="Contact Address"></textarea>
									</p>
									<p>
										<select name="rtype" id="rtype">
											<option value="pr">Pre-Registration</option>
											<option value="fr">Full-Registration</option>
										</select>
										<input type="password" id="rpin" name="rpin" placeholder="Enter Activation PIN">
									</p>

									<p><input type="submit" value="Add Student" name="submit" id="addst" /></p>
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

    </body>
</html>