<?php
  include("headers/menu_estudiante.php");
  session_start();
    
  ?>

<div class="w3-row-padding w3-padding-64 w3-container">
        <div class="w3-content">
            <div class="w3-twothird">
                <h1>Request Scholarship:</h1>
<?php
    
        $email = $_SESSION['email'];
        echo $email;
        $con= new mysqli("localhost", "root", "", "beca") OR die("Fail to query database ");
        $sql = "SELECT * FROM estudiante WHERE email='$email'";
        $result = mysqli_query($con, $sql) or die("Bad query: $sql");
                
if (isset($_GET['id']) && is_numeric($_GET['id']) ) { // Display the entry in a form: 
  
      // Define the query: 
      $query = "SELECT * FROM solicitud WHERE id={$_GET['id']}"; 
      if ($result = mysqli_query($con,$query)) { // Run the query. 
          if (mysqli_num_rows($result) == 1) { //  Confirm that the SELECT query returned a row prior to fetching it 
              $row = mysqli_fetch_array($result); // Retrieve the information. 
      
              // Make the form: 
              print '<form action="delete_solicitud.php" method="post"> 
              <p>Are you sure you want to delete this scholarship?</p> 
              <p><h3>' . $row['actividad'] . '</h3>' . 
              $row['id'] . '<br /> 
              <input type="hidden" name="id" value="' . $_GET['id'] . '" /> 
              <input type="submit" name="submit" value="Delete this Scholaship!" /> 
              <input type="submit" name="cancel" value="Cancel!" /></p> 
              </form>'; 
          } 
          else { // A SELECT query don't returned any row 
              print '<p style="color: red;">No rows were selected</p>'; 
          } 
      } else { // Couldn't get the information. 
          print '<p style="color: red;">Could not retrieve the blog entry because:<br />' . mysqli_error($con) . '.</p><p>The query being run w as: ' . $query . '</p>'; 
      } 
  
  } elseif (isset($_POST['id']) && is_numeric($_POST['id'])) { // Handle the form. 
      if (isset($_POST['cancel'])) { 
          header ('Location:view_solicitud.php'); 
          exit(); 
      } 
      // Define the query: 
      $query = "DELETE FROM solicitud WHERE id={$_POST['id']} LIMIT 1"; 
      $result = mysqli_query($con,$query); // Execute the query. 
      
      // Report on the result: 
      if (mysqli_affected_rows($con) == 1) { 
  //        print '<p>The blog entry has been deleted.</p>'; 
          header ('Location:view_solicitud.php'); 
          exit(); 
      } else { 
          print '<p style="color: red;">Could not delete the blog entry because:<br />' . mysqli_error($con) . '.</p><p>The query being run wa s: ' . $query . '</p>'; 
      } 
  
  } else { // No ID received. 
      print '<p style="color: red;">This page has been accessed in error.</p>'; 
  } // End of main IF. 
  
  mysqli_close($con); // Close the connection.
  
  ?> 