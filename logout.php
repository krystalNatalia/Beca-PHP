<?php
session_start();
$_SESSION = array();
session_destroy();
?>

<?php include('headers/heading.php');
      include('headers/nav_bar.php');?>
<div class="w3-row-padding w3-padding-64 w3-container">
  <div class="w3-content">
      <h1 align="center">You have been logged out</h1>
  </div>
</div>

<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Quote of the day: live life</h1>
</div>

<?php include('headers/footer.php'); ?>
