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
        
        if (mysqli_num_rows($result) > 0)
              {
                while($row = mysqli_fetch_assoc($result))
                  {
                    echo "<h1>Departamento ".$row["departamento_id"]."!</h1>";
                    $departamento = $row["departamento_id"];
                    $query = "SELECT * FROM beca WHERE departamento_id='$departamento'";
                    
                    if($result2 = mysqli_query($con, $query)){
    
                    
                    echo "Becas disponibles: ";
                    echo "<table class='w3-table w3-striped w3-border' border=\"1\" cellpadding=\"3\" cellspacing=\"0\">
                    <tr>
                        <th>ID Student</th>
                        <th>ID Scholarship</th>
                        <th>Title</th>
                        <th>Department ID</th>
                        <th>Total</th>
                        <th>Maximum</th>
                        <th>GPA</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>";
                        
                while($row2 = mysqli_fetch_array($result2)){
                echo "<form action=add_solicitud.php method=post>";                
                echo "<tr>";
                echo "<td>" . $row['num_id'] . "</td>";
                echo "<td>" . $row2['id'] . "</td>";
                echo "<td>" . $row2['nombre_beca'] . "</td>"; 
                echo "<td>" . $row2['departamento_id'] . "</td>";     
                echo "<td>" . $row2['total_beca'] . "</td>";     
                echo "<td>" . $row2['tope'] . "</td>";     
                echo "<td>" . $row2['promedio'] . "</td>";     
                echo "<td>" . $row2['disponible'] . "</td>";     
                echo "<td>" . "<input type=submit name=apply value=apply>" . "</td>";
                    
                echo "</tr>";
                echo "</form>";
                }
                echo "</table>";
                
                }
                    
                $displayform=FALSE;    
                if(isset($_POST['apply'])){
                $displayform=TRUE;
                    
                if ($displayform){
                    
                print '<form action=add_solicitud.php method=post>
                    <p>ID Student: <input type="text" name="num_id" size="40" maxsize="100" value="' . $row['num_id'] . '" /></p> 
                    <p>ID Scholarship: <input type="text" name="id" size="40" maxsize="100" value="' . $row2['id'] . '" /></p>
                    <p>Activity:
                        <input type="text" name="actividad" size="20"/>
                    </p>
                    <p>Cost:
                        <input type="text" name="costo" size="10"/>
                    </p>
                    <p>Total Given:
                        <input type="text" name="otorgada" size="10"/>
                    </p>
                    <p>Status: <input type="text" name="status" value=pendiente><br/>
                    </p>
                    
                    <p>Date:
                        <input type="date" name="date"/>
                    </p>
                   <button type=submit name=applying>Applying</button>
                    
        </form>';
               
                }
                
                }
                    if(isset($_POST['applying'])){
                        
                        
                       $num_id=$_POST['num_id'];
                       $beca_id=$_POST['id'];
                       $actividad=$_POST['actividad'];
                       $costo=$_POST['costo'];
                       $otorgada=$_POST['otorgada'];
                       $status=$_POST['status'];
                       $date=$_POST['date'];
                   
                  
                          $add_query="INSERT INTO solicitud (num_id, id_beca, actividad, costo, cantidad_otorgada, status, fecha) VALUES ('" . $num_id. "', '" . $beca_id. "', '" . $actividad. "','" . $costo. "','" . $otorgada. "','" . $status. "', '" . $date. "')";
                           $result3 = mysqli_query($con,$add_query);
                           if($result3){
                                header('Location:view_solicitud.php');
                                exit();
                            }

                    }
                    
                }
        }
      
?>
                
                
