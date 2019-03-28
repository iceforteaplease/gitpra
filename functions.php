<?php
session_start();
require_once "pdo.php";

class error_check {

  function access_denied() {   // if not logged in
    if ( ! isset($_SESSION['name']) || ! isset($_SESSION['user_id']) ) {
      die("ACCESS DENIED");
    }
  }

  function cancel() {
    if ( isset($_POST['cancel']) ) {// redirects to index.php
      header("Location: index.php");
      exit;
    }
  }

  function fields_not_blank() {
    if ( isset($_POST['first_name']) && isset( $_POST['last_name']) && isset($_POST['email'])
          && isset($_POST['headline']) && isset($_POST['summary']) ) {
      if ( strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1
          || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1
            || strlen($_POST['summary']) < 1 ) {
        $_SESSION['error'] = "All fields are required";
        header("Location: add.php");
        exit;
      }
    }
  }

  function email_format() {
    if ( isset($_POST['email']) ) {
      if ( ! strpos($_POST['email'], '@') ) {
        $_SESSION['error'] = "Email address must contain @";
        header("Location: add.php");
        exit;
      }
    }
  }

  function insert_profile() {
    global $pdo;
    if ( isset($_POST['add']) ) {
      $sql = "INSERT INTO profile (user_id, first_name, last_name, email, headline, summary)
                VALUES (:us, :fn, :sn, :em, :hd, :sm)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':us' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':sn' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':hd' => $_POST['headline'],
        ':sm' => $_POST['summary']));
      $_SESSION['success'] = "Profile added";
      header("Location: index.php");
      exit();
    }
  }

  function error_flash() {
    if ( isset($_SESSION['error']) ) {
      echo "<p style='color:red'>" . $_SESSION['error'] . "</p>\n";
      unset($_SESSION['error']);
    }
  }
  function success_flash() {
    if ( isset($_SESSION['success']) ) {
      echo "<p style='color:green'>" . $_SESSION['success'] . "</p>\n";
      unset($_SESSION['success']);
    }
  }

  function set_error($message, $page) {
    $_SESSION['error'] = $message;
    header("Location: $page");
    exit;
}
}

class db_items {

  function table_profiles_in() { // displays when logged in
    global $pdo;                  // function probably too long
    if ( isset($_SESSION['name']) && isset($_SESSION['user_id']) ) {
      echo "<p><a style='text-decoration:none' href='logout.php'>Logout</a></p>";
      echo "<table border='1'>\n";
      echo "<tr><td>";
      echo "<b>Name</b>";
      echo "</td><td>";
      echo "<b>Headline</b>";
      echo "</td><td>";
      echo "<b>Action</b>";
      echo "</td></tr>";
      $sql = "SELECT profile_id, user_id, first_name, last_name, headline FROM profile";
      $stmt = $pdo->query($sql);
      while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        echo "<tr><td>";
        echo "<a style='text-decoration:none' href='view.php?profile_id=";
        echo $row['profile_id'] . "'>" . $row['first_name'] . " ";
        echo $row['last_name'] . "</a>";
        echo "</td><td>";
        echo $row['headline'];
        echo "</td><td>";
        echo "<a style='text-decoration:none' href='edit.php?profile_id=";
        echo $row['profile_id'] . "'>Edit </a>";
        echo "<a style='text-decoration:none' href='delete.php?profile_id=";
        echo $row['profile_id'] . "'>Delete</a>";
        echo "</td></tr>";
      }
      echo "</table>\n";
      echo "<p><a style='text-decoration:none' href='add.php'>Add New Entry</a></p>";
    }
  }
  function table_profiles_out() { // displays when logged out
    global $pdo;                  // function probably too long
    if ( ! isset($_SESSION['name']) || ! isset($_SESSION['user_id']) ) {
      echo "<p><a style='text-decoration:none' href='login.php'>Please Log In</a></p>";
      echo "<table border='1'>\n";
      echo "<tr><td>";
      echo "<b>Name</b>";
      echo "</td><td>";
      echo "<b>Headline</b>";
      echo "</td></tr>";
      $stmt = $pdo->query("SELECT profile_id, first_name, last_name, headline FROM profile");
      while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        echo "<tr><td>";
        echo "<a style='text-decoration:none' href='view.php?profile_id=";
        echo $row['profile_id'] . "'>" . $row['first_name'] . " ";
        echo $row['last_name'] . "</a>";
        echo "</td><td>";
        echo $row['headline'];
        echo "</td></tr>";
      }
      echo "</table>";
    }
  }
}
?>
