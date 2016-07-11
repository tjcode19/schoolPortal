<?php
$lnk = basename($_SERVER['REQUEST_URI']);
//$k = substr($lnk, 0, 13);
?>
<ul id="nav" class="sf-menu">
    <li <?php if ($lnk !='blog.php' 
            && $lnk !='qow.php' && $lnk !='postPub.php' && $lnk !='publications.php' 
            && $lnk !='submit_a.php' && $lnk!='single.php' && $lnk!='p_news.php'
            && $lnk!='p_quote.php') {echo 'class="current-menu-item"'; } ?>>
        <a href="index.php"><span>ACCOUNT HOME</span></a></li>
    <li <?php if ($lnk=='allpin.php') 
        {echo 'class="current-menu-item"'; } ?> ><a href="allpin.php">PIN LOG</a>
    </li>
	<li <?php if ($lnk=='allpin.php') 
        {echo 'class="current-menu-item"'; } ?> ><a target="_blank" href="invoice">Invoice</a>
    </li>
    <li <?php if ($lnk=='postPub.php' || $lnk=='publications.php') {echo 'class="current-menu-item"'; } ?> ><a href="publications.php">PUBLICATIONS</a>
        <ul>
            <li><a href="postPub.php">Add New</a></li>
        </ul>
    </li>
    <li <?php if ($lnk=='result.php' || $lnk=='gresult.php' || $lnk=='eresult.php') {echo 'class="current-menu-item"'; } ?>><a href="result.php">RESULT LOG</a>
        <ul>
            <li><a href="result.php">View Result</a></li>
            <li><a href="eresult.php">Edit Result</a></li>
        </ul>
    </li>
    <li><a href="?action=out">LOGOUT</a></li>
</ul>
<div id="combo-holder"></div>