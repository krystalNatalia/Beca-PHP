<?php
  include("headers/menu_estudiante.php");
  session_start();
  function make_text_input($name, $label, $ayuda, $tipo, $valor)
    {
      echo "<p><label>" .$label. " </label>";
      echo "<input class='w3-input' type='$tipo' value='$valor' step='any' name='$name' placeholder='$ayuda' required/></p>";
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
                mysqli_close($con);
            }
          elseif (isset($_POST['actualizar']))
            {
              $email = $_SESSION['email'];
              $first_name_db = $_POST['first_name_db'];
              $last_name_db = $_POST['last_name_db'];
              $cell_db = $_POST['cell_number_db'];
              $gpa_db = $_POST['gpa_db'];
              $con= new mysqli("localhost", "root", "", "beca") OR die("Fail to query database ");
              $sql_new = "UPDATE estudiante SET `first_name`='$first_name_db', `last_name`='$last_name_db', `celular`='$cell_db', `promedio`='$gpa_db' WHERE email='$email'";
              mysqli_query($con, $sql_new) or die("Bad query: $sql_new");
              mysqli_close($con);
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
          mysqli_close($con);
          if($not_registered)
            {?>
              <h1>It seems you haven't register yet!</h1>
              <div class="w3-panel w3-border-top w3-border-bottom w3-border-red">
                <h2>Please, fill out the form below</h2>
                <form method="post">
                  <?php
                    make_text_input("first_name", "First Name", "", "text", "");
                    make_text_input("last_name", "Last Name", "", "text", "");
                    make_text_input("cell_number", "Cell-Phone #","(___-___-____)", "number", "");
                    make_text_input("gpa", "GPA", "0.00-4.00", "number", "");
                    ?>
                    </div>
                  <button class="w3-button w3-black w3-padding-large w3-large" type="submit" name="registrar">Sumbit</button>
                </form>
            <?php
            }
          else
          {
            $email=$_SESSION['email'];
            $con= new mysqli("localhost", "root", "", "beca") OR die("Fail to query database ");
            $sql = "SELECT first_name, last_name, celular, promedio FROM estudiante WHERE email='$email'";
            $result = mysqli_query($con, $sql) or die("Bad query: $sql");
            if (mysqli_num_rows($result) > 0)
              {
                while($row = mysqli_fetch_assoc($result))
                  {
                    echo "<h1>Welcome back ".$row["first_name"]."!</h1>";
                    echo "<div class='w3-panel w3-border-top w3-border-bottom w3-border-red'>";
                    echo "<form method='post'>";
                    make_text_input("first_name_db", "First Name", "", "text", $row['first_name']);
                    make_text_input("last_name_db", "Last Name", "", "text", $row['last_name']);
                    make_text_input("cell_number_db", "Cell-Phone #", "number", "text", $row['celular']);
                    make_text_input("gpa_db", "GPA", "", "number", $row['promedio']);
                    echo "</div>";
                    echo "<button class='w3-button w3-black w3-padding-large w3-large' type='submit' name='actualizar'>Update</button>";
                    echo "</form>";
                  }
              }
              mysqli_close($con);
          }
          ?>
  </div>
</div>
