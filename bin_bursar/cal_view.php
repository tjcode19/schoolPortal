<?php 

    require_once ('../includes/linker.php');
    require_once ('../includes/login.inc.php');
     $log = new login;
     $log->database();
  
        $log->set_sqlstr("SELECT * FROM school_calendar"); 
        $log->querydata();
        $term = $log->data[0];
        $sess = $log->data[1];
        $event = $log->data[2];
        $date = $log->data[3];
        $dura = $log->data[4];
        $mid = $log->data[7];
        $ftest = $log->data[8];
        $stest = $log->data[9];
        $eday = $log->data[10];
        $ass= $log->data[11];
        $t_test= $log->data[12];
        $vday= $log->data[13];
        $nterm= $log->data[15];
        $lupdate= $log->data[16];
?>
<table width="100%" cellpadding="10" cellspacing="0" id="mai">
                            <tr>
                                <td rowspan="5" width="30%">
                                    <h4>Latest Event</h4>
                                    <p><?php echo $event; ?></p>
                                </td>
                                <td align="right">Term:</td><td><?php echo $term; ?></td>
                            </tr>
                            <tr>
                                <td align="right">Session:</td><td><?php echo $sess; ?></td>
                            </tr>
                            <tr>
                                <td align="right">Term Duration:</td><td> <?php echo $dura; ?> Weeks</td>
                            </tr>
                             <tr>
                                <td align="right">First Term Started:</td><td><?php echo $date; ?></td>
                            </tr>
                            <tr>
                                <td align="right">Submission Of Assignment:</td><td><?php echo $ass; ?></td>
                            </tr>
                            <tr>
                                <td></td><td align="right">First CA Test:</td><td><?php echo $ftest; ?></td>
                            </tr>
                            <tr>
                                <td></td><td align="right">Second CA Test:</td><td><?php echo $stest; ?></td>
                            </tr>
                            <tr>
                                <td></td><td align="right">Mid-Term Break:</td><td> <?php echo $mid; ?></td>
                            </tr>
                            <tr>
                                <td></td><td align="right">Third CA Test:</td><td> <?php echo $t_test; ?> </td>
                            </tr>
                            <tr>
                                <td></td><td align="right">Examination Starts:</td><td> <?php echo $eday; ?> </td>
                            </tr>
                            <tr>
                                <td></td><td align="right">First Term Ends:</td><td> <?php echo $vday; ?></td>
                            </tr>
                            <tr>
                                <td></td><td align="right">Next Term Begins:</td><td><?php echo $nterm; ?></td>
                            </tr>
                            <tr>
                                <td></td><td align="right">Last Update:</td><td><?php echo $lupdate; ?></td>
                            </tr>
                        </table>