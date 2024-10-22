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
$id = $_GET['id'];
// Process the form submission
if (isset($_POST['score']) && !empty($_POST['score']) && isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['course_id']) && !empty($_POST['course_id'])) {
    $score = $_POST['score'];
    $name = $_POST['name'];
    $course_id = $_POST['course_id'];

    // Ensure fees and teacher_id are numbers
    if (!is_numeric($name) && is_string($name) && is_numeric($score) && is_numeric($course_id) && (int) $score >= 0 && (int) $score < 101) {
        // Prepare the insert statement
        $stmt = $conn->prepare("INSERT INTO score (score, course_id, name) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $score, $course_id, $name); // Use 'i' for integer teacher_id, 'd' for fees
        if ($stmt->execute()) {
            // Redirect to course page upon success
            header('Location: score.php');
            exit;
        } else {
            $not_valide = true;
        }

    } else {
        $not_valide = true;
    }


}

// Fetch the list of teachers
$sql = "SELECT name, id FROM student";
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
            <h1 class="mb-4">Insert Score</h1>
            <form method="post">
                <!-- Name Field -->
                <h5 style='color:red'>
                    <?php if ($not_valide == true) {
                        echo "Note Validate data";
                    } ?>
                </h5>
                <div class="mb-3">
                    <label for="score" class="form-label">Score</label>
                    <input type="number" min="0" max="100" class="form-control" id="score" name="score" required>
                </div>

                <!-- Teacher Selection -->
                <div class="mb-3">
                    <label for="student_id" class="form-label">Student</label>
                    <select class="form-select rounded-3 w-80" id="student_id" name="name" required>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No student found</option>";
                        }
                        ?>
                    </select>
                </div>
                <input type="hidden" name="course_id" value=<?php echo $id; ?> />
                <!-- Submit Button -->

                <button type="submit" class="btn btn-primary my-4">Insert</button>
            </form>
        </div>
    </main>
</body>

</html>