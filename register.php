<?php
include 'db.php';
$message="";
if(isset($_POST['submit'])){

    $matric=$_POST['matric'];
    $name=$_POST['name'];
    $password=$_POST['password'];
    $role=$_POST['role'];

    if(empty($matric) || empty($name) ||
    empty($password) || empty($role)) {

    $message="Please fill in all fields.";
    
    }else{

        $hashed_password=password_hash($password, PASSWORD_DEFAULT);
        $sql="INSERT INTO users(matric, name, password, role)
        VALUES (?, ?, ?, ?)";

        $stmt=mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt, "ssss",
            $matric, $name, $hashed_password, $role
        );

        if(mysqli_stmt_execute($stmt)) {
            $message="Registration successful!";
        } else{
            $message="Error: ". mysql_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
</head>
<body>
    <h2>Registration Form</h2>
    <form method="POST" action="">

    Matric:
    <input type="text" name="matric" maxlength="10" required>
    <br><br>

    Name:
    <input type="text" name="name" maxlength="100" required>
    <br><br>

    Password:
    <input type="password" name="password" required>
    <br><br>

    Role:
    <select name="role" required>
        <option value="">Please select </option>
        <option value="student">Student</option>
        <option value="lecturer">Lecturer</option>
    </select>
    <br><br>

    <input type="submit" name="submit" value="submit">
</form>
<p><?php echo htmlspecialchars($message); ?></p>
</body>
</html>


