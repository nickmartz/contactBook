<?php
session_start();

include('functions.php');

// check if the form is submitted
if( isset( $_POST['login'] ) ) {
    
    // grab variables from log in form
    // wrap data with validate function
    $formEmail = validateFormData( $_POST['email'] );
    $formPass = validateFormData( $_POST['password'] );
    
    // connect to the database
    include('connection.php');
    
    $query = "SELECT name, password FROM users WHERE email='$formEmail'";
    
    $result = mysqli_query( $conn, $query );
    
    // verify if result is returned 
    if( mysqli_num_rows($result) > 0 ) {
        
        // store user data in variables
        while( $row = mysqli_fetch_assoc($result)) {
            $name       = $row['name'];
            $hashedPass = $row['password'];
        }
        
        // if correct password, redirect user to contacts
        if( password_verify( $formPass, $hashedPass ) ) {
            
            $_SESSION['loggedInUser'] = $name;
            
            header( "Location: contacts.php" );
        }else {
            $loginError = "<div class='alert alert-danger'>Wrong username / password combination. Try again.</div>";
        }
    } else {
            // data is not in the database, error message
            $loginError = "<div class='alert alert-danger'>No such user in database. Please try again. <a class='close' data-dismiss='alert'>&times;</a></div>";
        }
}

if( isset( $_GET['alert'] ) ) {
    
    // new conact added
    if( $_GET['alert'] == 'newUserSuccess' ) {
        $signupError = "<div class='alert alert-success'>New User added! <a class='close' data-dismiss='alert'>&times;</a></div>";
        
    } elseif( $_GET['alert'] == 'newUserExist' ) {
        $signupError = "<div class='alert alert-success'>Account already exists! Please try again. <a class='close' data-dismiss='alert'>&times;</a></div>";
    }
}

mysqli_close($conn);

include('header.php');
?>

<h1 class="text-center" style="padding-top: 60px;">Hi, Welcome to ContactBook!</h1>
<p class="lead text-center">Please Log Into Your Account Or Create a New One.</p>

<?php echo $loginError ?>
<?php echo $signupError ?>

<form class="form-inline text-center" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">
    <div class="form-group">
        <label for="login-email" class="sr-only">Email</label>
        <input type="text" class="form-control" id="login-email" placeholder="email" name="email" value="<?php echo $formEmail; ?>">
    </div>
    <div class="form-group">
        <label for="login-password" class="sr-only">Password</label>
        <input type="password" class="form-control" id="login-password" placeholder="password" name="password">
    </div>
    <button type="submit" class="btn btn-primary" name="login">Login</button>
    <button type="button" class="btn btn-success" name="sign_up" onclick="location.href = 'newUser.php';">Create a new account</button>
</form>

<?php
include('footer.php');
?>