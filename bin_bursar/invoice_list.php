<?php
include '../includes/login.inc.php';
$log = new login;
$log->database();
?> 

<table width="100%" cellpadding="10" cellspacing="0" id="det">
    <tr>
        <th align="right">ID</th><th align="left">Name</th><th align="left">Class</th><th align="left">Term</th><th align="left">Session</th>
        <th>Amount</th><th align="left">Status</th><th></th>
    </tr>
    <?php

    /** function toWhere($condition){ }
     *  $codition is array of conditions
     *  return where clause as string
     */
    function toWhere($conditions) {
        $cond = "";
        $first = true;
        foreach ($conditions as $value) {
            if ($value !== "") {
                $cond .= ($first === true) ? $value : " AND " . $value;
                $first = false;
            }
        }
        $conds = $cond !== "" ? "where " . $cond : "";
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
    $conditions[] = isset($_REQUEST['cl']) ? (($_REQUEST['cl'] !== "") ? "feepayment.class = " . intval($_REQUEST['cl']) : "") : "";
    $conditions[] = isset($_REQUEST['tr']) ? (($_REQUEST['tr'] !== "") ? "feepayment.term = " . intval($_REQUEST['tr']) : "") : "";
    $conditions[] = isset($_REQUEST['se']) ? (($_REQUEST['se'] !== "") ? "feepayment.session = " . intval($_REQUEST['se']) : "") : "";
    $conditions[] = isset($_REQUEST['st']) ? (($_REQUEST['st'] !== "") ? "feepayment.status = " . intval($_REQUEST['st']) : "") : "";

    //gets where conditions
    $where = toWhere($conditions);
    $sql = "Select feepayment.student_id, Concat(student_data.first_name, \" \", "
            . "student_data.last_name) As name, feepayment.class, feepayment.term, "
            . "feepayment.session, feepayment.amount, feepayment.status, feepayment.id "
            . "From feepayment Inner Join student_data On feepayment.student_id = student_data.id "
            . $where;

    $log->set_sqlstr($sql);
    $log->querydata();

    if ($log->no_rec > 0) {
        for ($i = 0; $i < $log->no_rec; $i++) {
            ?>
            <tr >
                <td align="right"><?php echo $log->data[0]; ?> </td>
                <td><?php echo $log->data[1]; ?></td>
                <td ><?php echo getClass($log->data[2]); ?> </td>
                <td ><?php echo getTerm($log->data[3]); ?> </td>
                <td ><?php echo getSe($log->data[4]); ?> </td>
                <td ><?php echo $log->data[5]; ?> </td>
                <td ><?php echo getSt($log->data[6]); ?> </td>
                <td><a href="../bin_bursar/view_invoice.php?n=<?php echo $log->data[7]; ?>"  class="link-button">view</a></td> 
            </tr>
            <?php
            $log->fetchdata();
        }
    } else {
        ?>
        <tr >
            <td colspan="3" align="center">No record found for this class</td>
        </tr>
<?php } ?>
</table>
<script type="text/javascript">
    $(document).ready(function () {
        function showLoader() {

                    $('.search-background').fadeIn(200);
                }

                function hideLoader() {

                    $('.search-background').fadeOut(200);
                }
                ;
       $('#det tr td a').click(function(e){
           e.preventDefault(); 
           showLoader();
           var link = this.href;  
           $("#content").load(link, hideLoader());             
	});
    });
</script>
