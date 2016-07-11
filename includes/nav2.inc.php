<?php
$lnk = basename($_SERVER['REQUEST_URI']);
//$k = substr($lnk, 0, 13);
?>
<ul id="nav" class="sf-menu">
    <li <?php if ($lnk !='blog.php' 
            && $lnk !='qow.php' && $lnk !='postPub.php' && $lnk !='news.php'
            && $lnk !='articles.php' && $lnk !='jokes.php' && $lnk !='quote.php'
            && $lnk!='p_quote.php') {echo 'class="current-menu-item"'; } ?>>
        <a href="index.php"><span>ACCOUNT HOME</span></a></li>
    <!--<li <?php if ($lnk=='blog.php' || $lnk=='single.php') {echo 'class="current-menu-item"'; } ?> ><a href="blog.php">BLOG</a>
        <ul>
            <li><a href="ublog.php">New Blog</a></li>
        </ul>
    </li>-->
    <li <?php if ($lnk=='postPub.php' || $lnk=='news.php' || $lnk=='articles.php' || $lnk=='jokes.php' || $lnk=='quote.php') {echo 'class="current-menu-item"'; } ?> ><a href="postPub.php">ADD NEWS</a>
        <ul>
            <li><a href="news.php">View News</a></li>
            <li><a href="articles.php">View Articles</a></li>
            <li><a href="jokes.php">View Jokes</a></li>
            <li><a href="quote.php">View Quotes</a></li>
        </ul>
    </li>
    <li <?php if ($lnk=='result.php' || $lnk=='gresult.php' || $lnk=='eresult.php') {echo 'class="current-menu-item"'; } ?>><a href="result.php">RESULT LOG</a>
        <ul>
            <li><a href="result.php">View Result</a></li>
            <li><a href="eresult.php">Edit Result</a></li>
            <li><a href="sresult.php">Send Result</a></li>
            <li><a href="gresult.php">Generate Result</a></li>
        </ul>
    </li>
    <li><a target="_blank" href="setStatus">SET STATUS</a></li>
    <li><a href="../Admin_Module?action=out">LOGOUT</a></li>
</ul>
<div id="combo-holder"></div>