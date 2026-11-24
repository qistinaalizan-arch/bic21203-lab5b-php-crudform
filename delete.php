
<?php
include 'authenticate.php';
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $matric = $_POST['matric'];

    $sql = "DELETE FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);

    if ($stmt->execute()) {
        header("Location: display.php");
        exit();
    } else {
        echo "Delete failed.";
    }

    $stmt->close();

} else {
    echo "Invalid request.";
}
?>
