<?php
session_start();

// if user is not logged in send back to login page
if( !$_SESSION['loggedInUser'] ) {
    header("Location: index.php");
}

// connect to database
include('connection.php');

// query & result
$query = "SELECT * FROM contacts";
$result = mysqli_query( $conn, $query );

// check for query string
// update, success, or deleted
if( isset( $_GET['alert'] ) ) {
    
    // new conact added
    if( $_GET['alert'] == 'success' ) {
        $alertMessage = "<div class='alert alert-success'>New contact added! <a class='close' data-dismiss='alert'>&times;</a></div>";
        
    // contact updated
    } elseif( $_GET['alert'] == 'updatesuccess' ) {
        $alertMessage = "<div class='alert alert-success'>Contact updated! <a class='close' data-dismiss='alert'>&times;</a></div>";
    
    // contact deleted
    } elseif( $_GET['alert'] == 'deleted' ) {
        $alertMessage = "<div class='alert alert-success'>Contact deleted! <a class='close' data-dismiss='alert'>&times;</a></div>";
    }
      
}
mysqli_close($conn);

include('header.php');
?>

<h1>Contact Book</h1>

<?php echo $alertMessage; ?>

<table class="table table-striped table-bordered">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Company</th>
        <th>Edit</th>
    </tr>
    
    <?php
    
    if( mysqli_num_rows($result) > 0 ) {
        while( $row = mysqli_fetch_assoc($result) ) {
            echo "<tr>";
            
            echo "<td>" . $row['name'] . "</td><td>" . $row['email'] . "</td><td>" . $row['phone_number'] . "</td><td>" . $row['address'] . "</td><td>" . $row['company'] . "</td>";
            
            echo '<td><a href="edit.php?id=' . $row['id'] . '" type="button" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-edit"></span>
                    </a></td>';
            
            echo "</tr>";
        }
    } else { 
        // if no entries
        echo "<div class='alert alert-warning'>You have no contacts!</div>";
    }

    mysqli_close($conn);

    ?>

    <tr>
        <td colspan="7"><div class="text-center"><a href="add.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Add Contact</a></div></td>
    </tr>
</table>

<?php
include('footer.php');
?>