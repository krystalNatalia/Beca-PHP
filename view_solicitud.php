<?php
  include("headers/menu_estudiante.php");
  session_start();
    
  ?>

<div class="w3-row-padding w3-padding-64 w3-container">
        <div class="w3-content">
            <div class="w3-twothird">
                <h1>View My Scholarships:</h1>
<?php
    
        $email = $_SESSION['email'];
        echo $email;
        $con= new mysqli("localhost", "root", "", "beca") OR die("Fail to query database ");
        $sql = "SELECT * FROM estudiante WHERE email='$email'";
        $result1 = mysqli_query($con, $sql) or die("Bad query: $sql");
                
         if (mysqli_num_rows($result1) > 0)
              {
                while($row1 = mysqli_fetch_assoc($result1))
                  {        
                
                
                
                
//Definir query
        $num_est= $row1['num_id'];
                
        $query = "SELECT * FROM solicitud WHERE status='pendiente' AND solicitud.num_id='$num_est'";
        
        if($result = mysqli_query($con, $query)){
         
            //Muestra el número de resultados
            $num_rows = mysqli_num_rows($result);
            print "<h3>Results: <strong>$num_rows</strong></h3>";
        
            
            //Enlace para añadir nueva beca
            print "<a href=add_solicitud.php>Apply for new scholarship!</a>";
            
            //Muestra tabla para presentar los resultados del query
            print "<table class='w3-table w3-striped w3-border' border=\"1\" cellpadding=\"3\" cellspacing=\"0\">
                    <tr>
                        <th>ID</th>
                        <th>ID Student</th>
                        <th>ID Scholarshio</th>
                        <th>Activity</th>
                        <th>Cost</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>";
            
            
            while($row = mysqli_fetch_array($result)){
                
                //Por cada resultado imprimimos toda la información
                //Al final añadimos una opción de Editar o Borrar la beca correspondiente
                print "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['num_id']}</td>
                        <td>{$row['id_beca']}</td>
                        <td>{$row['actividad']}</td>
                        <td>{$row['costo']}</td>
                        <td>{$row['cantidad_otorgada']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['fecha']}</td>
                        <td><a href=\"edit_solicitud.php?id={$row['id']}\">Edit/Delete</a></td> 
                    </tr>";
//                print "<tr>
//                        <td>
//                            <a href=\"edit_beca.php?id={$row['id']}\">Edit/Delete</a>";
                }
        
        
            print "</table>";
        }
        

        //Muestra error si el query no pudo ejecutarse 
        else {
            
            print '<p style="color:red;">Could not retrieve the data because:<br/>'.mysqli_error($con).'.</p><p>The query being run was: '.$query.'</p>';
        }
                    
                }
         }
        mysqli_close($con);
        
print "</div></div></div>"; 

                
?>