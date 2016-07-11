<div id="upload-wrapper">
<div align="center">
<h3>Upload Image <?php echo $_REQUEST['name']; ?></h3>
<form action="../bin_admin/processupload_stu.php" method="post" enctype="multipart/form-data" id="MyUploadForm">
<input name="ImageFile" id="imageInput" type="file" />
<input name="user" id="user" type="hidden" value="<?php echo $_REQUEST['user']; ?>"/>
<input type="submit"  id="submit-btn" value="Upload" />
<img src="../img/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
</form>
<div id="output"></div>
<a href="#" id="ad" style="display: none;">Add Another Student</a>
</div>
</div>