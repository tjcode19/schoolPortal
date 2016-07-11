<!doctype html> 
<?php
    include("../../includes/login.inc.php");
    $log = new login;	
    $log->database();
    
    function getCla($po){
        $log = new login;	
        $log->database();
        $log->set_sqlstr("SELECT name FROM class WHERE id ='". $po."'"); 
        $log->querydata();
        return $log->data[0];
    }
?>
<html>
    <head>
        <title>Result Page</title>
        <link rel="stylesheet" media="all" href="css/style1.css"/>
        <link rel="stylesheet" media="all" href="css/bootstrap.css"/>
        <link rel="stylesheet" media="all" href="css/bootstrap-theme.css"/>
        <link rel="stylesheet" media="all" href="css/bootstrap-theme.min.css"/>
        <link rel="stylesheet" media="all" href="css/bootstrap.min.css"/>
        <script src="js/jquery.1.9.1.js"></script>
		<style>
			#logo_res{
				background-image:url('../img/cms.jpg');
			}
                        th, td{
                            padding:10px;
                        }
		</style>
    </head>
    <body id="resultload"> 
        <div id="mainp">
            <header>
                <div id="logo_res">
                    <a href="index.html"><img  src="../../img/banner.png" alt="Simpler"></a>
                </div>
                <div id="row1">
                    <div>Please select subjects for <?php echo getCla($_REQUEST['c']); ?></div>
                </div>
            </header>
            
            <form action="enter.php?c=<?php echo $_REQUEST['c']; ?>" method="post" role="form" id="formR">
            <div class="row">
                <div class="col-md-6 form-group">
                    <table width="100%" cellpadding="10" cellspacing="10" border="1">
                        <tr align="left">
                            <th width="5%"></th>
                            <th>Subject</th>
                        </tr>
                        <?php 

                            $log->set_sqlstr("SELECT * FROM subject"); 
                            $log->querydata();
                            for($a=0; $a< $log->no_rec; $a++){

                        ?>
                        <tr align="left">
                            <td><input type="checkbox" id="sub[]" name="subject[]" value="<?php echo $log->data[0]; ?>"></td>
                             <td><?php echo $log->data[1]; ?></td>
                        </tr>
                        <?php 
                            $log->fetchdata();
                            }
                        ?>
                    </table>
                </div>
                <div class="col-md-6">
                     <div class="row">
                        <div class="col-md-6 form-group">
                            <select name="term" class="form-control" id="term">
                                <option value="">Select Term</option>
                                 <option value="1">First Term</option>
                                 <option value="2">Second Term</option>
                                 <option value="3">Third Term</option>
                             </select>                           
                        </div>
                         <div class="col-md-6">
                            <select name="session" class="form-control" id="sess">
                                <option value="">Select Session</option>
                                <?php 

                                    $log->set_sqlstr("SELECT * FROM session"); 
                                    $log->querydata();
                                    for($a=0; $a< $log->no_rec; $a++){
                                ?> 

                                     <option value="<?php echo $log->data[0]; ?>"><?php echo $log->data[1]; ?></option>

                                <?php $log->fetchdata(); } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" id="class" value="1">
                            <input class="btn btn-primary" type="submit" value="Insert/Edit Result">
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <div></div>
           
        </div> 
        
        <footer>
           SMS Version 2.0 &copy; <?php echo date("Y"); ?>
        </footer>  
        
        
<script type="text/javascript">
$(document).ready(function(){
   /* $('#formR').submit(function(e) {
        var cl = $("input#class").val();
        var sub = $("input#sub").val();
        var t = $("input#term").val();
        var s = $("input#sess").val();
        window.location.href = 'enter.php?class='+cl+'&subject='+sub+'&term='+t+'&session='+s;
         
        e.preventDefault();
    }); */   
});
</script>
    </body> 
</html>

