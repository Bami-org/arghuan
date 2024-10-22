<?php
// Ensure cookie is set, otherwise redirect to login page
if (!isset($_COOKIE['arghona'])) {
    header("Location: login.php");
    exit; // Prevent further script execution if not logged in
}

require_once('config.php');
$not_valide = false;
// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the form submission
if (isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['fees']) && !empty($_POST['fees']) && isset($_POST['teacher_id']) && !empty($_POST['teacher_id'])) {
    $name = $_POST['name'];
    $fees = $_POST['fees'];
    $teacher_id = $_POST['teacher_id'];

    // Ensure fees and teacher_id are numbers
    if (is_numeric($fees) && is_numeric($teacher_id) && is_string($name) && !is_numeric($name)) {
        // Prepare the insert statement
        $stmt = $conn->prepare("INSERT INTO course (name, fees, teacher_id) VALUES (?, ?, ?)");
        $stmt->bind_param("sdi", $name, $fees, $teacher_id); // Use 'i' for integer teacher_id, 'd' for fees

        if ($stmt->execute()) {
            // Redirect to course page upon success
            header('Location: course.php');
            exit;
        } else {
            $not_valide = true;
        }

    } else {
        $not_valide = true;
    }


}

// Fetch the list of teachers
$sql = "SELECT name, id FROM employe WHERE type='teacher'";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo "Error preparing statement: " . $conn->error;
    exit;
}

$result = null;
if ($stmt->execute()) {
    $result = $stmt->get_result();
} else {
    echo "Error executing statement: " . $stmt->error;
    exit;
}

$stmt->close();
$conn->close();
?>

<!-- HTML code remains the same -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="package/all.css">
    <link rel="stylesheet" href="package/fontawesome.min.css">
    <link rel="stylesheet" href="package/bootstrap.min.css">
    <link rel="stylesheet" href="css/student.css">
    <title>New Course</title>
    <script src="package/bootstrap.min.js" defer></script>
    <script src="script.js" defer></script>
</head>

<body class="bg-gray">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Arghuan</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" id="home-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="about-link" href="student.php">Student</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-link" href="employe.php">Employe</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-link" href="salary.php">Salary</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="services-link" href="course.php">Course</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-link" href="score.php">Score</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" id="services-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="d-flex justify-content-center align-items-center">
        <div class="container w-50 shadow-lg rounded-3 py-4 px-4 my-5">
            <h1 class="mb-4">Insert Course</h1>
            <form method="post">
                <!-- Name Field -->
                <h5 style='color:red'>
                    <?php if ($not_valide == true) {
                        echo "Note Validate data";
                    } ?>
                </h5>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <!-- Fees Field -->
                <div class="mb-3">
                    <label for="fees" class="form-label">Fees</label>
                    <input type="number" class="form-control" id="fees" name="fees" step="0.01" required>
                </div>

                <!-- Teacher Selection -->
                <div class="mb-3">
                    <label for="teacher_id" class="form-label">Teacher</label>
                    <select class="form-select rounded-3 w-80" id="teacher_id" name="teacher_id" required>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No teachers found</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary my-4">Insert</button>
            </form>
        </div>
    </main>
</body>

</html>