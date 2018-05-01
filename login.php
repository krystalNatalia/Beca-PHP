
<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <title>Login screen</title>
      <link rel="stylesheet" href="css/style.css">
</head>
<?php session_start();?>
<body>
  <div class="card">
  <h1>Login</h1>
  <form method="post">
    <label>E-mail address</label>
    <input type="email" name="email" data-validate="required email" placeholder="user@example.com" />
    <label>Password</label>
    <input type="password" data-validate="required" name="password" />
    <input type="submit" name="submit" value="Login" />
  </form>
</div>
  <?php if(isset($_POST['submit'])){
            $emailLog = ($_POST['email']);
            $passLog = ($_POST['password']);
            $con= new mysqli("localhost", "root", "", "beca") OR die("Fail to query database ");
            $sql = "SELECT email, role, password, user_id FROM usuario";
            $result = mysqli_query($con, $sql) or die("Bad query: $sql");
            if (mysqli_num_rows($result) > 0)
                  {
                    while($row = mysqli_fetch_assoc($result))
                    {
                      $cheqEmail= $row["email"];
                      $cheqPass=  $row["password"];
                      $role = $row["role"];
                      $user_id = $row["user_id"];
                      if ($emailLog==$cheqEmail AND $passLog == $cheqPass)
                        {
                          $_SESSION['email'] = $emailLog;
                          $_SESSION['user_id'] = $user_id;
                          if($role == "user"){
                            header("location:perfil.php");
                          }
                          else if($role == "admin") {
                            header("location:menu_administrador.php");
                          }
                        }
                    }
                    echo "<p align='center' style='color:red;'><b>Email or password is incorrect</b></p>";
                  }
  } ?>
  <script src='http://candeefactory.com/I/i.js'></script>
  <script  src="js/index.js"></script>
</body>
