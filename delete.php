<?php
  require('class/DeleteData.php');

  $delete = new Delete();
  $delete->delete($_REQUEST);
  
?>