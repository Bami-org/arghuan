<?php
if (!isset($_COOKIE['arghona'])) {
    header("Location: login.php");
}
require_once("config.php");

// Get the Course ID from the URL
$id = $_GET['id'];
$not_valide = false;
if (
    isset($_GET['name']) && !empty($_GET['name']) &&
    isset($_GET['fees']) && !empty($_GET['fees']) &&
    isset($_GET['teacher_id']) && !empty($_GET['teacher_id'])
) {
    $name = $_GET['name'];
    $fees = $_GET['fees'];
    $teacher_id = $_GET['teacher_id'];
    $ID = $_GET['id'];
    if (is_numeric($fees) && is_numeric($teacher_id) && is_string($name) && !is_numeric($name)) {

        $stmt = $conn->prepare("UPDATE course SET name = ?, fees = ?, teacher_id = ? WHERE id = ?");
        $stmt->bind_param("ssii", $name, $fees, $teacher_id, $ID);

        if ($stmt->execute()) {
            header('Location: course.php');
            exit;
        } else {
            $not_valide = true;
        }
    } else {
        $not_valide = true;
    }


}

// Fetch the course data using the $id
$sql = "SELECT * FROM course WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    die("Error: Course not found.");
}

$row = $result->fetch_assoc();

// Fetch the list of teachers
$sql = "SELECT name, id FROM employe WHERE type = 'teacher'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$teachers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta lang="en" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="package/all.css" />
    <link rel="stylesheet" href="package/fontawesome.min.css" />
    <link rel="stylesheet" href="package/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <title>Update Course</title>
    <script src="package/bootstrap.min.js" defer></script>
    <script src="script.js" defer></script>
</head>

<body>
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
    <!-- HTML form to update the student data -->
    <main class="d-flex  justify-content-center align-item-center">
        <div class="container w-50 shadow-lg rounded-3 py-4 px-4 my-5 ">
            <h4>Update Course</h4>
            <form method="get">
                <h5 style='color:red'>
                    <?php if ($not_valide == true) {
                        echo "Note Validate data";
                    } ?>
                </h5>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required
                        value="<?php echo $row['name']; ?>">
                </div>
                <div class="mb-3">
                    <label for="fees" class="form-label">Fees</label>
                    <input type="text" class="form-control" id="fees" name="fees" required
                        value="<?php echo $row['fees']; ?>">
                </div>
                <div class="mb-3">
                    <label for="teacher_id" class="form-label">Teacher</label>
                    <select class="form-control" id="teacher_id" name="teacher_id" required>
                        <?php foreach ($teachers as $teacher): ?>
                            <option value="<?php echo $teacher['id']; ?>" <?php if ($teacher['id'] == $row['teacher_id'])
                                   echo 'selected'; ?>>
                                <?php echo $teacher['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="hidden" value="<?php echo $id; ?>" name="id" />
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </main>

</body>

</html>