<?php
if (!isset($_COOKIE['arghona'])) {
    header("Location: login.php");
}

require_once('config.php');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$id = $_GET['id'];
if (isset($_POST['course_id']) && !empty($_POST['course_id']) && isset($_POST['student_id']) && !empty($_POST['student_id']) && !empty($_POST['student_id'])) {
    $course_id = $_POST['course_id'];
    $student_id = $_POST['student_id'];

    $stmt = $conn->prepare("INSERT INTO student_course (std_id, course_id) VALUES (?,?)");
    $stmt->bind_param("ii", $student_id, $course_id);

    if ($stmt->execute()) {
        header('Location:course.php');
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
$sql = "select name,id from student";
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
?>
<!-- HTML code remains the same -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta lang="en" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="package/all.css" />
    <link rel="stylesheet" href="package/fontawesome.min.css" />
    <link rel="stylesheet" href="package/bootstrap.min.css" />
    <link rel="stylesheet" href="css/student.css" />
    <title>Student Course</title>
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
    <main class="d-flex  justify-content-center align-item-center">
        <div class="container w-50 shadow-lg rounded-3 py-4 px-4 my-5 ">
            <h4>Insert student</h4>
            <form method="post">
                <div class="mb-3">
                    <select class="form-select rounded-3 w-80" name="student_id">
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo " <option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No teachers found</option>";
                        }
                        ?>
                    </select>
                </div>
                <input type="hidden" name="course_id" value=<?php echo $id; ?> />
                <button type="submit" class="btn btn-primary my-4">Insert</button>
            </form>
        </div>
    </main>
</body>

</html>