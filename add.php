<?php // first page with object oriented!!!
require_once "pdo.php"; // is it better to have this here or in functions.php
include "functions.php"; // session started in functions.php

$check = new error_check;
$check->access_denied();
$check->cancel();
$check->fields_not_blank();
$check->email_format();
$check->insert_profile();

?><!DOCTYPE html>
<html>
<head><title>Patrick Thrasher</title></head>
<body>
<h1>Adding Profile for <?= $_SESSION['name']; ?></h1>

<?php $check->error_flash(); ?>

<form method="post">
<p><label for="first_name">First Name: </label><input type="text" name="first_name"></p>
<p><label for="last_name">Last Name: </label><input type="text" name="last_name"></p>
<p><label for="email">Email: </label><input type="text" name="email"></p>
<p><label for="headline">Headline:</label><br><input type="text" name="headline" size="60"></p>
<p><label for="summary">Summary:</label><br><textarea name="summary"rows="8" cols="60"></textarea></p>
<input type="submit" name="add" value="Add"><input type="submit" name="cancel" value="Cancel">
</form>
</body>
</html>
