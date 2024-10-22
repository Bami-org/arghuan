<?php // Database connection details
require_once('config.php');
// Connection successful
$found = true;
if (isset($_COOKIE['arghona'])) {
    header("Location: index.php");
}
if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($result->num_rows == 1 && password_verify($password, $row['password'])) {
            $cookie_name = "arghona";
            $cookie_value = $row['id'];
            setcookie($cookie_name, $cookie_value, time() + (86400 * 60), "/");
            header("Location: index.php");
            exit; // Ensure the script stops executing after the redirect
        } else {
            $found = false;
        }
    } else {
        echo "Error executing query: " . $stmt->error;
    }
} ?>
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
    <title>Login</title>
    <script src="package/bootstrap.min.js" defer></script>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="container ">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-header bg-success">
                            <h4 class="text-center">Login</h4>
                        </div>
                        <div class="card-body">

                            <form method="post" action="">
                                <?php if ($found == false) {
                                    echo ' <div class="mt-2 text-danger">
    User not found
</div>';
                                }
                                ?>
                                <div class="form-group mb-2">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block mt-2">Login</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>