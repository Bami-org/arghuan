<?php
if (!isset($_COOKIE['arghona'])) {
    header("Location: login.php");
}
require_once("config.php");

// Check if a search term is set
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Modify the SQL query to include the search condition
$sql = "SELECT course.id, course.name, course.fees, employe.name AS teacherName 
       FROM course
       INNER JOIN employe ON course.teacher_id = employe.id
       WHERE course.name LIKE ? OR employe.name LIKE ?";
$stmt = $conn->prepare($sql);
$searchParam = '%' . $search . '%';
$stmt->bind_param('ss', $searchParam, $searchParam);
$result = null;
if ($stmt->execute()) {
    $result = $stmt->get_result();
}
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
    <link rel="stylesheet" href="css/student.css" />
    <title>Management Course</title>
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
    <main class="d-flex justify-content-center align-item-center">
        <div class="container w-80 shadow-lg rounded-3 py-4 px-2 my-5">
            <div class="title">
                <h4>Course Management</h4>
                <a href="addCourse.php" class="btn btn-primary btn-md my-2 mx-2"><span class="fa fa-plus"></span></a>
            </div>

            <!-- Search Form -->
            <form method="GET" action="course.php" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search by course or teacher"
                        value="<?php echo htmlspecialchars($search); ?>">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Fees</th>
                        <th>Teacher Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["fees"] . "</td>";
                            echo "<td>" . $row["teacherName"] . "</td>";
                            echo "<td>
                                    <a href='updateCourse.php?id=" . $row["id"] . "' class='btn btn-primary btn-sm'><span class='fa fa-edit'></span></a>
                                    <a href='deleteCourse.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm'><span class='fa fa-trash'></span></a>
                                    <a href='addStudentToCourse.php?id=" . $row["id"] . "' class='btn btn-primary btn-sm'><span class='fa fa-user-plus'></span></a>
                                    <a href='courseDetial.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm'><span class='fa fa-circle-info'></span></a>
                                    <a href='addScore.php?id=" . $row["id"] . "' class='btn btn-primary btn-md my-2 mx-2'><span class='fa fa-plus'></span></a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No data available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer class="bg-dark text-white py-3">
        <div class="container">
            <p class="mb-0">&copy; 2023 Your Site. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>