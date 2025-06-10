<?php
require_once 'config/database.php';
include 'includes/header.php';

// Fetch all students
$sql = "SELECT * FROM students ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<?php if (isset($_GET['msg'])) : ?>
    <div class="success-msg"><?php echo $_GET['msg']; ?></div>
<?php endif; ?>

<h2>Student List</h2>

<?php if ($result->num_rows > 0) : ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Course</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['course']); ?></td>
                    <td>
                        <a href="view.php?id=<?php echo $row['id']; ?>" class="btn">View</a>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>No students found.</p>
<?php endif; ?>

<?php
include 'includes/footer.php';
$conn->close();
?> 