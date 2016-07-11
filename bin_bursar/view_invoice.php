<?php
include '../includes/login.inc.php';
$log = new login;
$log->database();
?> 

<table width="100%" cellpadding="10" cellspacing="0" id="det">
    <tr>
        <th align="right">Item</th><th>Amount</th>
    </tr>
    <?php

    /** function toWhere($condition){ }
     *  $codition is array of conditions
     *  return where clause as string
     */
    function toWhere($conditions){
        $cond = ""; $first =true;
        foreach ($conditions as $value) {
            if($value !== ""){
                $cond .= ($first ===true) ?$value:" AND ".$value;
                $first = false;
            }
        }
        $conds = $cond !== "" ?"where ".$cond:"";
        return $conds;
    }
    
    function addcomma($amt) {
        $l = strlen($amt);
        //$g = $l/3;
        $nstr = "";
        for ($i = 0; $i < $l; $i++) {
            $nstr .= substr($amt, $i, 1);
            if (((($l - ($i + 1)) % 3) == 0) && (($i + 1) != $l)) {
                $nstr .= ", ";
            }
        }
        return $nstr;
    }

    function getTyp($cl) {
        $log = new login;
        $log->database();
        $log->set_sqlstr("SELECT name FROM schoolfeetype WHERE id='" . $cl . "'");
        $log->querydata();
        return $log->data[0];
    }

    function getClass($cl) {
        $log = new login;
        $log->database();
        $log->set_sqlstr("SELECT name FROM class WHERE id='" . $cl . "'");
        $log->querydata();
        return $log->data[0];
    }

    function getTerm($cl) {
        $log = new login;
        $log->database();
        $log->set_sqlstr("SELECT name FROM term WHERE id='" . $cl . "'");
        $log->querydata();
        return $log->data[0];
    }

    function getSe($cl) {
        $log = new login;
        $log->database();
        $log->set_sqlstr("SELECT name FROM session WHERE id='" . $cl . "'");
        $log->querydata();
        return $log->data[0];
    }

    function getSt($cl) {
        $log = new login;
        $log->database();
        $log->set_sqlstr("SELECT name FROM invoice_status WHERE id='" . $cl . "'");
        $log->querydata();
        return $log->data[0];
    }
  
    $conditions = array();
    $conditions[] = isset($_REQUEST['n'])?(($_REQUEST['n']!=="")?"feepayment.id = ".intval($_REQUEST['n']):""):""; 
    
    //gets where conditions
    $where = toWhere($conditions); 
    $sql = "Select schoolfeetype.name, schoolfees.amount  "
          ."From feepayment Inner Join  "
          ."feepaymentitem On feepayment.id = feepaymentitem.fee_payment Inner Join  "
          ."schoolfees On feepaymentitem.school_fee_id = schoolfees.id Inner Join  "
          ."schoolfeetype On schoolfees.type = schoolfeetype.id "
          . $where; 
     
    $log->set_sqlstr($sql);
    $log->querydata();

    if ($log->no_rec > 0) {
        for ($i = 0; $i < $log->no_rec; $i++) {
            ?>
            <tr >
                <td align="right"><?php echo $log->data[0]; ?> </td>
                <td><?php echo $log->data[1]; ?></td>  
            </tr>
        <?php $log->fetchdata();
    }
?>
    <tr >
        <td align="right"> <a href="#"  class="link-button">Pay</a> </td>
        <td><a href="#"  class="link-button">Cancel</a></td>  
     </tr>
<?php } else { ?>
        <tr >
            <td colspan="2" align="center">No record found </td>
        </tr> 
<?php } ?>
</table>
<script type="text/javascript">
    $(document).ready(function () {



    });
</script>
