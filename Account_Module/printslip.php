
     <?php
        include("../bin/getpos.php");
        function Grade($g){
                        return (($g >= 70)?"A":
                                (($g < 70 && $g >= 60)?"B":
                                (($g < 60 && $g >= 50)?"C":
                                (($g < 50 && $g >= 45)?"D":
                                (($g < 45 && $g >= 40?"E":"<span style=\"color:red\">F</span>"))))));
                    }
                    
        $log = new login();
        
        $log1 = new login();
        
        $rs = new login();        
      
    ?>
	
    <!doctype html> 
    <html>
    <head>
        <title>Result Page</title>
        <link rel="stylesheet" media="all" href="../css/style2.css"/>
        <link rel="stylesheet" media="all" href="../css/style.css"/>
        <link rel="stylesheet" media="all" href="../css/widgets.css"/>
		<style>
			#logo_res{
				background-image:url('../img/cms.jpg');
			}
		</style>
    </head>
    <body id="resultpage">
        <div id="mainp">
        <header>
            <div id="logo_res">
                <a href="index.html"><img  src="../img/banner.png" alt="Simpler"></a>
            </div>
            <div id="row1">
                <div><h3>Result Slip For <?php echo $_REQUEST['c'] ; ?></h3></div>
            </div>
        </header>		
            <table width="100%" cellpadding="5" cellspacing="0" id="s">
                <tr>
					<th>N/S</th>
                    <th>Name</th>
                    <th>CA1</th>
                    <th>CA2</th>
					<th>Exam</th>
                </tr>
        
            <?php   
                
                 $log->database();
					$log->set_sqlstr("SELECT * FROM student_data WHERE Class='".$_REQUEST['c']."'");
					$log->querydata();
					for($stv = 0; $stv < $log->no_rec; $stv++){ 
            ?>
			
                <tr align="center">
					<td><?php echo ($stv + 1); ?> </td>
                   <td><?php echo $log->data[1].", ".$log->data[2]." ".$log->data[3]; ?></td>
                    <td></td>
                    <td></td>
					<td></td>
                </tr>
				   <?php 
                    $log->fetchdata();
                    }
                ?>
				
            </table>
       
        
        <footer>
            SMS Version 2.0 &copy; <?php echo date("Y"); ?>
        </footer> </div>
    </body></html>
