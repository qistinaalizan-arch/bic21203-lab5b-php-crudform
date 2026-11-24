
<?php
include 'authenticate.php';
include 'db.php';

$matric = $_GET['matric'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $matric = $_POST['matric'];
    $name = trim($_POST['name']);
    $role = $_POST['role'];

    $sql = "UPDATE users SET name = ?, role = ? WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $role, $matric);

    if ($stmt->execute()) {
        header("Location: display.php");
        exit();
    } else {
        echo "Update failed.";
    }

    $stmt->close();
}

$sql = "SELECT * FROM users WHERE matric = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $matric);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();

if (!$user) {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
</head>
<body>

<h2>Update User</h2>

<form method="POST" action="">

    Matric:
    <input type="text" name="matric"
           value="<?php echo htmlspecialchars($user['matric']); ?>"
           readonly>
    <br><br>

    Name:
    <input type="text" name="name"
           value="<?php echo htmlspecialchars($user['name']); ?>"
           required>
    <br><br>

    Role:
    <select name="role" required>
        <option value="student"
            <?php if ($user['role'] == 'student') echo 'selected'; ?>>
            Student
        </option>

        <option value="lecturer"
            <?php if ($user['role'] == 'lecturer') echo 'selected'; ?>>
            Lecturer
        </option>
    </select>
    <br><br>

    <input type="submit" value="Update">

</form>

</body>
</html>
