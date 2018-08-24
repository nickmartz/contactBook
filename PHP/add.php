<?php
session_start();

// if user is not logged in, send them to login page
if( !$_SESSION['loggedInUser'] ) {
    header("Location: index.php");
}

include('connection.php');
include('functions.php');

// if add button was submitted
if( isset( $_POST['add'] ) ) {
    $contactName = $contactEmail = $contactPhone = $contactAddress = $contactCompany =  "";
    
    // check to see if inputs are empty
    // create variables with form data
    // wrap the data with our function
    
    if( !$_POST["contactName"] ) {
        $nameError = "Please enter a name <br>";
    } else {
        $contactName = validateFormData( $_POST["contactName"] );
    }

    if( !$_POST["contactEmail"] ) {
        $emailError = "Please enter an email <br>";
    } else {
        $contactEmail = validateFormData( $_POST["contactEmail"] );
    }
    
    // these inputs are not required
    // so we'll just store whatever has been entered
    $contactPhone    = validateFormData( $_POST["contactPhone"] );
    $contactAddress  = validateFormData( $_POST["contactAddress"] );
    $contactCompany  = validateFormData( $_POST["contactCompany"] );
    
    // if required fields have data
    if( $contactName && $contactEmail ) {
        $query = "INSERT INTO contacts (id, name, email, phone_number, address, company, date_added) VALUES (NULL, '$contactName', '$contactEmail', '$contactPhone', '$contactAddress', '$contactCompany', CURRENT_TIMESTAMP)";
        
        $result = mysqli_query( $conn, $query );
        
        // if query was successful, refresh with query string
        if( $result ) {
            header( "Location: contacts.php?alert=success" );
        } else {
            echo "Error: ". $query ."<br>" . mysqli_error($conn);
        }
        
    }
    
}

mysqli_close($conn);
include('header.php');
?>

<h1>Add Contact</h1>

<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="contact-name">Name *</label>
        <input type="text" class="form-control input-lg" id="contact-name" name="contactName" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="contact-email">Email *</label>
        <input type="text" class="form-control input-lg" id="contact-email" name="contactEmail" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="contact-phone">Phone</label>
        <input type="text" class="form-control input-lg" id="contact-phone" name="contactPhone" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="contact-address">Address</label>
        <input type="text" class="form-control input-lg" id="contact-address" name="contactAddress" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="contact-company">Company</label>
        <input type="text" class="form-control input-lg" id="contact-company" name="contactCompany" value="">
    </div>
    <div class="col-sm-12">
            <a href="contacts.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success pull-right" name="add">Add contact</button>
    </div>
</form>

<?php
include('footer.php');
?>