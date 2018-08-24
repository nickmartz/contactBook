<?php
session_start();

include('connection.php');
include('functions.php');

// if add button was submitted
if( isset( $_POST['sign_up'] ) ) {
    $newUserName = $newUserEmail = $newUserPassword =  "";
    
    // check to see if inputs are empty
    // create variables with form data
    // wrap the data with our function
    
    if( !$_POST["newUserName"] ) {
        $nameError = "Please enter a name <br>";
    } else {
        $newUserName = validateFormData( $_POST["newUserName"] );
    }

    if( !$_POST["newUserEmail"] ) {
        $emailError = "Please enter an email <br>";
    } else {
        $newUserEmail = validateFormData( $_POST["newUserEmail"] );
    }
    
    if( !$_POST["newUserPassword"] ) {
        $passwordError = "Please enter a password <br>";
    } else {
        $newUserPassword = validateFormData( $_POST["newUserPassword"] );
        $newUserHashedPassword = password_hash($newUserPassword, PASSWORD_DEFAULT);
    }
    
    $query = "SELECT name, password FROM users WHERE email='$newUserEmail'";
    
    // store the result
    $result = mysqli_query( $conn, $query );
    
    //if there is data then account already exists
    if( mysqli_num_rows($result) > 0 ) {
        header( "Location: newUser.php?alert=newUserExists" );
    }else {
        // if required fields have data
        if( $newUserName && $newUserEmail && newUserPassword ) {
            $query2 = "INSERT INTO users (id, email, name, password) VALUES (NULL, '$newUserEmail', '$newUserName', '$newUserHashedPassword')";
            
            $result = mysqli_query( $conn, $query2 );
            
            // if query was successful, refresh with query string
            if( $result ) {
                header( "Location: index.php?alert=newUserSuccess" );
            } else {
                echo "Error: ". $query ."<br>" . mysqli_error($conn);
            }
        } else {
            $fieldMessage = "<div class='alert alert-danger'>Please enter in all fields.<a class='close' data-dismiss='alert'>&times;</a></div>";
        }
    }
    
}

if( isset( $_GET['alert'] ) ) {
    // if user exists
    if( $_GET['alert'] == 'newUserExists' ) {
        $userError = "<div class='alert alert-danger'>Account already exists! Please try again. <a class='close' data-dismiss='alert'>&times;</a></div>";
    }
}

mysqli_close($conn);
include('header.php');
?>

<h1>New User Form</h1>

<?php echo $userError ?>
<?php echo $fieldMessage ?>

<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="newUser-name">Name</label>
        <input type="text" class="form-control input-lg" id="newUser-name" name="newUserName" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="newUser-email">Email</label>
        <input type="text" class="form-control input-lg" id="newUser-email" name="newUserEmail" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="newUser-password">Password</label>
        <input type="text" class="form-control input-lg" id="newUser-password" name="newUserPassword" value="">
    </div>
    <div class="col-sm-12">
            <a href="index.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success pull-right" name="sign_up">Sign Up</button>
    </div>
</form>

<?php
include('footer.php');
?>