<?php
require_once 'config/database.php';
include 'includes/header.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Fetch student data
$sql = "SELECT * FROM students WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    header("Location: index.php");
    exit();
}

$student = $result->fetch_assoc();
?>

<h2>Student Details</h2>

<div class="student-details">
    <p><strong>ID:</strong> <?php echo $student['id']; ?></p>
    <p><strong>First Name:</strong> <?php echo htmlspecialchars($student['first_name']); ?></p>
    <p><strong>Last Name:</strong> <?php echo htmlspecialchars($student['last_name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($student['phone']); ?></p>
    <p><strong>Course:</strong> <?php echo htmlspecialchars($student['course']); ?></p>
    <p><strong>Created At:</strong> <?php echo date('F j, Y, g:i a', strtotime($student['created_at'])); ?></p>
</div>

<div class="actions">
    <a href="edit.php?id=<?php echo $student['id']; ?>" class="btn">Edit</a>
    <a href="delete.php?id=<?php echo $student['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
    <a href="index.php" class="btn">Back to List</a>
</div>

<?php
include 'includes/footer.php';
$conn->close();
?> 