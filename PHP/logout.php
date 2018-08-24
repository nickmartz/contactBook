<?php
// did the user's browser send a cookie for the session?
if( isset( $_COOKIE[ session_name() ] ) ) {

    // empty the cookie
    // lasts about a day accross the entire site
    setcookie( session_name(), '', time()-86400, '/' );
}

// clear all session variables
session_unset();

session_destroy();

include('header.php');
?>

<h1>Logged out</h1>

<p class="lead">You've been logged out. Thanks for using ContactBook!</p>

<?php 
include('footer.php');
?>