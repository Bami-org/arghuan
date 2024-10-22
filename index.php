<?php
if (!isset($_COOKIE['arghona'])) {
    header("Location: login.php");
}
require_once("config.php");
// Handle form submission
$id = $_COOKIE['arghona'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$row = null;
if ($stmt->execute()) {
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
}

if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Execute a SELECT query
    $sql = "update users set name=?, email=?, password=? where id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssd", $name, $email, $password, $id);
    $result = $stmt->execute();

    // Check if the query was successful
    if ($result) {
        $expiration_time = time() - 3600;
        // Remove the cookie
        setcookie('arghona', '', $expiration_time, '/');
        header("Location: login.php");
    } else {
        echo "Place Retry!";
    }


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
    <link rel="stylesheet" href="css/style.css" />
    <title>Profile</title>
    <script src="package/bootstrap.min.js" defer></script>
    <script src="script.js" defer></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="view.php">Arghuan</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="about-link" href="student.php">Student</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="services-link" href="employe.php">Employe</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-link" href="salary.php">Salary</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-link" href="course.php">Course</a>
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

    <main class="container-fluid d-flex  justify-content-center">
        <div class="update-card w-50 p-4  border border-1 shadow-lg">
            <h2>Update Profile</h2>
            <?php if ($row == null) {
                echo "Error No user exist!";
            } ?>
            <form id="updateForm" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?php echo $row['email']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="name"
                        value="<?php echo $row['name']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">new Passowrd</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </main>

    <footer class="bg-dark text-white py-3">
        <div class="container">
            <p class="mb-0">&copy; 2023 Your Site. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>