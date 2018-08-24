<!DOCTYPE html>

<html>

    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ContactBook</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    </head>
    
    <body style="padding-top: 60px;">            
    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">

        <div class="container-fluid">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="contacts.php">CONTACT<strong>BOOK</strong></a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                
                <?php
                if( $_SESSION['loggedInUser'] ) { 
                    // if user is logged in
                ?>
                
                <ul class="nav navbar-nav">
                    <li><a href="contacts.php">My Contacts</a></li>
                    <li><a href="add.php">Add Contact</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout.php">Log out</a></li>
                </ul>
                
                <?php
                } else {
                    // if the user is not logged in
                ?>
                
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="newUser.php">Sign Up</a></li>
                    <li><a href="index.php">Log in</a></li>
                </ul>
                
                <?php
                }
                ?>

            </div>

        </div>

    </nav>
        
    <div class="container">