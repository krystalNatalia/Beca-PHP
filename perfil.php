<?php
  include("headers/menu_estudiante.php");
  session_start();
  function make_text_input($name, $label, $size, $ayuda, $tipo)
    {
      echo "<p><label>" .$label. " </label>";
      echo "<input class='w3-input' type='$tipo' step='any' name='$name' placeholder='$ayuda' size='$size' required/></p>";
    }
  ?>
<div class="w3-row-padding w3-padding-64 w3-container">
  <div class="w3-content">
        <?php
          if(isset($_POST['registrar']))
            {
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
              else
                {
                  $not_registered=TRUE;
                }
              if($not_registered)
                {?>
                  <h1>It seems you haven't register yet!</h1>
                  <div class="w3-panel w3-border-top w3-border-bottom w3-border-red">
                    <h2>Please, fill out the form below</h2>
                    <form method="post">
                      <?php
                        make_text_input("first_name", "First Name", "20", "", "text");
                        make_text_input("last_name", "Last Name", "20", "", "text");
                        make_text_input("cell_number", "Cell-Phone #", "18","(___-___-____)", "number");
                        make_text_input("gpa", "GPA", "8", "0.00-4.00", "number");
                        ?>
                        </div>
                      <button class="w3-button w3-black w3-padding-large w3-large" type="submit" name="registrar">Sumbit</button>
                    </form>
                <?php
                }
              else
                {
                  echo "ya registrado";//Aqui va eseñar su perfil si es que esta registrado
                }

                ?>
  </div>
</div>
