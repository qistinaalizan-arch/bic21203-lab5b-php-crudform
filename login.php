<?php
session_start();
include 'db.php';
$error="";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $matric=trim($_POST['matric']);
    $password=$_POST['password'];

    $sql="SELECT * FROM users WHERE matric = ?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("s",$matric);
    $stmt->execute();

    $result=$stmt->get_result();

    if($result->num_rows == 1){
        $user=$result->fetch_assoc();

        if(password_verify($password, $user['password'])) {
            $_SESSION['matric']=$user['matric'];
            $_SESSION['name']=$user['name'];
            $_SESSION['role']=$user['role'];

            header("Location: display.php");
            exit();
        } else {
            $error="Invalid username or password, try login again.";
        }
    }else {
        $error="Invalid username or password, try login again.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form method="POST" action="">
        <fieldset style="width: 300px;">
            Matric:
            <input type="text" name="matric" required>
            <br><br>

            Password:
            <input type="password" name="password" required>
            <br><br>
            <input type="submit" value="Login">

            <p>
                <a href="register.php">Register</a>
                here if you have not.
            </p>

            <p style="color:red;">
                <?php echo htmlspecialchars($error); ?>
            </p>

        </fieldset>
    </form>
</body>
</html>




