<?php include("headers/nav_bar_estudiante.php");
session_start();
function make_text_input($name, $label, $size, $ayuda){
          echo "<p><label>" .$label. ": ";
          echo "<input type='text' name='$name' size='$size'/></label>$ayuda</p>";
        }
        $emailLog = $_POST['email'];
        $con= new mysqli("localhost", "root", "", "beca") OR die("Fail to query database ");
        $sql = "SELECT * FROM estudiante";
        $result = mysqli_query($con, $sql) or die("Bad query: $sql");
        if (mysqli_num_rows($result) > 0)
              {
                while($row = mysqli_fetch_assoc($result))
                {
                  $cheqEmail= $row["email"];
                  if ($emailLog!=$cheqEmail)
                    {
                      make_text_input("first_name", "First Name", "20", "");
                      make_text_input("last_name", "Last Name", "20", "");
                      make_text_input("celular", "Celphone Number", "20", "");
                      make_text_input("promedio", "Promedio", "20", "");
                      }
                 else
                    {
                      echo "Algo anda mal";
                    }
                }
              }
?>
