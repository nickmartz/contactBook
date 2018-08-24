<?php
session_start();

// if user is not logged in send to login page
if( !$_SESSION['loggedInUser'] ) {
    header("Location: index.php");
}

// get ID sent by GET collection
$contactID = $_GET['id'];

include('connection.php');
include('functions.php');

// query the database with contact ID
$query = "SELECT * FROM contacts WHERE id='$contactID'";
$result = mysqli_query( $conn, $query );

// if result is returned
if( mysqli_num_rows($result) > 0 ) {
    
    while( $row = mysqli_fetch_assoc($result) ) {
        $contactName     = $row['name'];
        $contactEmail    = $row['email'];
        $contactPhone    = $row['phone_number'];
        $contactAddress  = $row['address'];
        $contactCompany  = $row['company'];
    }
} else { 
    
    $alertMessage = "<div class='alert alert-warning'>Nothing to see here. <a href='contacts.php'>Head back</a>.</div>";
}

// if update button was submitted
if( isset($_POST['update']) ) {
    
    // set variables
    $contactName     = validateFormData( $_POST["contactName"] );
    $contactEmail    = validateFormData( $_POST["contactEmail"] );
    $contactPhone    = validateFormData( $_POST["contactPhone"] );
    $contactAddress  = validateFormData( $_POST["contactAddress"] );
    $contactCompany  = validateFormData( $_POST["contactCompany"] );
    
    // update database query & result
    $query = "UPDATE contacts
            SET name='$contactName',
            email='$contactEmail',
            phone_number='$contactPhone',
            address='$contactAddress',
            company='$contactCompany'
            WHERE id='$contactID'";
    
    $result = mysqli_query( $conn, $query );
    
    // if the entry was updated successfully go back to contact page 
    if( $result ) {
        header("Location: contacts.php?alert=updatesuccess");
    } else {
        echo "Error updating record: " . mysqli_error($conn); 
    }
}

// if delete button was submitted
if( isset($_POST['delete']) ) {
    
    $alertMessage = "<div class='alert alert-danger'>
                        <p>Are you sure you want to delete this contact?</p><br>
                        <form action='". htmlspecialchars( $_SERVER["PHP_SELF"] ) ."?id=$contactID' method='post'>
                            <input type='submit' class='btn btn-danger btn-sm' name='confirm-delete' value='Yes, I want to delete this contact.'>
                            <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel, no thanks.</a>
                        </form>
                    </div>";
    
}

// if confirm delete button was submitted
if( isset($_POST['confirm-delete']) ) {
    
    // delete database query & result
    $query = "DELETE FROM contacts WHERE id='$contactID'";
    $result = mysqli_query( $conn, $query );
    
    // if the entry was deleted successfully go back to contact page 
    if( $result ) {
        header("Location: contacts.php?alert=deleted");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
    
}

mysqli_close($conn);
include('header.php');
?>

<h1>Edit Contact</h1>

<?php echo $alertMessage; ?>

<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>?id=<?php echo $contactID; ?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="contact-name">Name</label>
        <input type="text" class="form-control input-lg" id="contact-name" name="contactName" value="<?php echo $contactName; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="contact-email">Email</label>
        <input type="text" class="form-control input-lg" id="contact-email" name="contactEmail" value="<?php echo $contactEmail; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="contact-phone">Phone</label>
        <input type="text" class="form-control input-lg" id="contact-phone" name="contactPhone" value="<?php echo $contactPhone; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="contact-address">Address</label>
        <input type="text" class="form-control input-lg" id="contact-address" name="contactAddress" value="<?php echo $contactAddress; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="contact-company">Company</label>
        <input type="text" class="form-control input-lg" id="contact-company" name="contactCompany" value="<?php echo $contactCompany; ?>">
    </div>
    <div class="col-sm-12">
        <hr>
        <button type="submit" class="btn btn-lg btn-danger pull-left" name="delete">Delete</button>
        <div class="pull-right">
            <a href="contacts.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success" name="update">Update</button>
        </div>
    </div>
</form>

<?php
include('includes/footer.php');
?>