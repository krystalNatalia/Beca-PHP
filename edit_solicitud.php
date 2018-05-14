<?php
  include("headers/menu_estudiante.php");
  session_start();
    
  ?>

<div class="w3-row-padding w3-padding-64 w3-container">
        <div class="w3-content">
            <div class="w3-twothird">
                <h1>Edit Scholarship:</h1>
<?php
    
        $email = $_SESSION['email'];
        echo $email;
        $con= new mysqli("localhost", "root", "", "beca") OR die("Fail to query database ");
        $sql = "SELECT * FROM estudiante WHERE email='$email'";
        $result = mysqli_query($con, $sql) or die("Bad query: $sql");
                

   if (isset($_GET['id']) && is_numeric($_GET['id']) ) { // Display the entry in a form: 
   
       // Define the query. 
       $query = "SELECT * FROM solicitud WHERE id={$_GET['id']}"; 
       if ($result = mysqli_query($con,$query)) { // Run the query. 
           if (mysqli_num_rows($result) == 1) { // Confirm that the SELECT query returned a row prior to fetching it 
               $row = mysqli_fetch_array($result); // Retrieve the information. 
               
               // Make the form: 
               print '<form action="edit_solicitud.php" method="post"> 
                       <p>Activity: <input type="text" name="actividad" size="40" maxsize="100" value="' . htmlentities($row['actividad']) . '" /></p> 
                       <p>Cost: <input type="text" name="costo" size="40" value="' . htmlentities($row['costo']) . '" /></p>
                       <p>Total Given: <input type="text" name="total" size="10" value="' . htmlentities($row['cantidad_otorgada']) . '" /></p> 
                       <p>Date: <input type="date" name="date" size="10" value="' . htmlentities($row['fecha']) . '" /></p> 
                       <input type="hidden" name="id" value="' . $_GET['id'] . '" /> 
                       <input type="submit" name="submit" value="Update!" /> 
                       <input type="submit" name="delete" value="Delete!" /> 
                       <input type="submit" name="cancel" value="Cancel!" /> 
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
       if (isset($_POST['delete'])) { 
           // Delete the entry 
            header ('Location:delete_solicitud.php?id='.$_POST['id']); 
            exit(); 
       } 
       // Validate and secure the form data: 
       $problem = FALSE; 
       if (!empty($_POST['actividad']) && !empty($_POST['costo']) && !empty($_POST['total']) && !empty($_POST['date'])) { 
           $actividad = mysqli_real_escape_string($con,trim(strip_tags($_POST['actividad']))); 
           $costo = mysqli_real_escape_string($con,trim(strip_tags($_POST['costo']))); 
           $total = mysqli_real_escape_string($con,trim(strip_tags($_POST['total']))); 
           $date = mysqli_real_escape_string($con,trim(strip_tags($_POST['date'])));  
       } else { 
           print '<p style="color: red;">Please submit all.</p>'; 
           $problem = TRUE; 
       } 
       
       if (!$problem) { 
       
           // Define the query. 
           $query = "UPDATE solicitud SET actividad='$actividad', costo='$costo', cantidad_otorgada='$total', fecha='$date' WHERE id={$_POST['id']}";
           $result = mysqli_query($con,$query); // Execute the query. 
               
           // Report on the result: 
           if (mysqli_affected_rows($con) == 1 OR mysqli_affected_rows($con) == 0) { // se añadió, OR mysqli_affected_rows($dbc) == 0, p or si el usuario no cambia nada y aun así da Update 
           //    print '<p>The blog entry has been updated.</p>'; 
               header ('Location:view_solicitud.php'); 
               exit(); 
           } else { 
               print '<p style="color: red;">Could not update the entry because:<br />' . mysqli_error($con) . '.</p><p>The query being run was: ' . $query . '</p>'; 
           } 
           
       } // No problem! 
   } else { // No ID set. 
       print '<p style="color: red;">This page has been accessed in error.</p>'; 
   } // End of main IF. 
   
   mysqli_close($con); // Close the connection. 
   
   ?> 