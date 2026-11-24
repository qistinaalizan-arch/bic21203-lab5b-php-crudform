
<?php
include 'authenticate.php';
include 'db.php';

$sql = "SELECT matric, name, role FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Display Users</title>
</head>
<body>

<h2>User List</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Matric</th>
        <th>Name</th>
        <th>Level</th>
        <th>Action</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
    ?>

    <tr>
        <td><?php echo htmlspecialchars($row['matric']); ?></td>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['role']); ?></td>

        <td>
            <a href="update.php?matric=<?php echo urlencode($row['matric']); ?>">
                Update
            </a>

            |

            <form method="POST" action="delete.php" style="display:inline;">
                <input type="hidden" name="matric"
                       value="<?php echo htmlspecialchars($row['matric']); ?>">
                <input type="submit" value="Delete"
                       onclick="return confirm('Are you sure you want to delete this user?');">
            </form>
        </td>
    </tr>

    <?php
        }
    } else {
        echo "<tr><td colspan='4'>No records found</td></tr>";
    }
    ?>

</table>

</body>
</html>
