<?php
$lnk = basename($_SERVER['REQUEST_URI']);
?>
<ul id="nav" class="sf-menu">
    <li <?php if ($lnk !='blog.php' && $lnk !='qow.php' && $lnk !='postJoke.php' && $lnk !='publications.php' && $lnk !='submit_a.php' && $lnk!='single.php') {echo 'class="current-menu-item"'; } ?>>
        <a href="index.php"><span>ACCOUNT HOME</span></a></li>
    <!-- <li <?php if ($lnk=='blog.php' || $lnk=='single.php') {echo 'class="current-menu-item"'; } ?> ><a href="blog.php">BLOG</a></li> -->
    <li <?php if ($lnk=='postPub.php' || $lnk=='publications.php') {echo 'class="current-menu-item"'; } ?> ><a href="publications.php">PUBLICATIONS</a>
        <ul>
            <li><a href="postPub.php">Add New</a></li>
        </ul>
    </li>
    <!--<li <?php if ($lnk=='qow.php') {echo 'class="current-menu-item"'; } ?>><a href="qow.php">Q.O.W</a></li>-->
    <li <?php if ($lnk=='result.php') {echo 'class="current-menu-item"'; } ?>><a href="result.php">CHECK RESULT</a></li>
    <li><a href="?action=out">LOGOUT</a></li>
</ul>
<div id="combo-holder"></div>