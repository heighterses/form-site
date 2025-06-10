<?php
require_once 'config/database.php';
include 'includes/header.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $course = trim($_POST['course']);

    if (empty($first_name) || empty($last_name) || empty($email) || empty($course)) {
        $error = "Please fill all required fields";
    } else {
        $sql = "INSERT INTO students (first_name, last_name, email, phone, course) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $phone, $course);
        
        if ($stmt->execute()) {
            header("Location: index.php?msg=Student added successfully");
            exit();
        } else {
            $error = "Error: " . $conn->error;
        }
        $stmt->close();
    }
}
?>

<h2>Add New Student</h2>

<?php if ($error) : ?>
    <div class="error-msg"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST" action="">
    <div class="form-group">
        <label for="first_name">First Name *</label>
        <input type="text" name="first_name" id="first_name" required>
    </div>

    <div class="form-group">
        <label for="last_name">Last Name *</label>
        <input type="text" name="last_name" id="last_name" required>
    </div>

    <div class="form-group">
        <label for="email">Email *</label>
        <input type="email" name="email" id="email" required>
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="tel" name="phone" id="phone">
    </div>

    <div class="form-group">
        <label for="course">Course *</label>
        <input type="text" name="course" id="course" required>
    </div>

    <button type="submit" class="btn">Add Student</button>
</form>

<?php
include 'includes/footer.php';
$conn->close();
?> 