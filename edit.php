<?php
require_once 'config/database.php';
include 'includes/header.php';

$error = '';
$success = '';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $course = trim($_POST['course']);

    if (empty($first_name) || empty($last_name) || empty($email) || empty($course)) {
        $error = "Please fill all required fields";
    } else {
        $sql = "UPDATE students SET first_name=?, last_name=?, email=?, phone=?, course=? WHERE id=?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $first_name, $last_name, $email, $phone, $course, $id);
        
        if ($stmt->execute()) {
            header("Location: index.php?msg=Student updated successfully");
            exit();
        } else {
            $error = "Error: " . $conn->error;
        }
        $stmt->close();
    }
}

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

<h2>Edit Student</h2>

<?php if ($error) : ?>
    <div class="error-msg"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST" action="">
    <div class="form-group">
        <label for="first_name">First Name *</label>
        <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>" required>
    </div>

    <div class="form-group">
        <label for="last_name">Last Name *</label>
        <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>" required>
    </div>

    <div class="form-group">
        <label for="email">Email *</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="tel" name="phone" id="phone" value="<?php echo htmlspecialchars($student['phone']); ?>">
    </div>

    <div class="form-group">
        <label for="course">Course *</label>
        <input type="text" name="course" id="course" value="<?php echo htmlspecialchars($student['course']); ?>" required>
    </div>

    <button type="submit" class="btn">Update Student</button>
</form>

<?php
include 'includes/footer.php';
$conn->close();
?> 