<?php include("headers/nav_bar_estudiante.php");
session_start();?>
<div class="w3-row-padding w3-padding-64 w3-container">
  <div class="w3-content">
    <div class="w3-twothird">
      <h1>Registrarse</h1>
<?php
if(isset($_POST['registrar'])){
$email = $_SESSION['email'];
$user_id = $_SESSION['user_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$cell = $_POST['cell_number'];
$gpa = $_POST['gpa'];
$con= new mysqli("localhost", "root", "", "beca") OR die("Fail to query database ");
$sql_new = "INSERT INTO estudiante (num_id, email, first_name, last_name, celular, departamento_id, promedio) Values ('$user_id', '$email', '$first_name', '$last_name', '$cell', '2', '$gpa')";
mysqli_query($con, $sql_new) or die("Bad query: $sql_new");
}
function make_text_input($name, $label, $size, $ayuda){
          echo "<p><label>" .$label. ": ";
          echo "<input type='text' name='$name' size='$size'/></label>$ayuda</p>";
        }
        $con= new mysqli("localhost", "root", "", "beca") OR die("Fail to query database ");
        $sql = "SELECT * FROM estudiante";
        $result = mysqli_query($con, $sql) or die("Bad query: $sql");
        if (mysqli_num_rows($result) > 0)
              {
                while($row = mysqli_fetch_assoc($result))
                {
                  $cheqEmail= $row["email"];
                  if ($_SESSION['email']!=$cheqEmail)
                    {
                        $not_registered=TRUE;
                      }
                 else
                    {
                      $not_registered=FALSE;
                    }
                }

              }
              else {
                $not_registered=TRUE;
              }
              if($not_registered){?>
                <form method="post">
                  <?php
                    make_text_input("first_name", "First Name", "20", "");
                    make_text_input("last_name", "Last Name", "20", "");
                    make_text_input("cell_number", "Cell-Phone #", "18","");
                    make_text_input("gpa", "GPA", "8", "");
                  ?>
                  <button class="w3-button w3-black w3-padding-large w3-large w3-margin-top" type="submit" name="registrar">Sumbit</button>
                </form>
                <?php
            }
            else {
              echo "ya registrado";
            }

?>
</div>
</div>
</div>
