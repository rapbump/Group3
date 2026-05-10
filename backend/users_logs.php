<?php 
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "glowtrack_db";

$conn = new mysqli($host, $user, $password, $dbname);

if($conn->connect_error){
    die("Connection Failed: ". $conn->connect_error);
}

function flash(string $type, string $text): void    
{
    $_SESSION['flash'] = [ 
        'type' => $type,  
        'text' => $text
    ];
}

function redirect_home(){
    header("Location: ../index.php");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    exit("Invalid access. Open <a href='../index.php'>Home</a>.");
}

$action = $_POST['action'] ?? '';

if ($action === ''){
    flash('err', 'No action provided.');
    redirect_home();
}

if ($action === 'signup'){
    $username = trim($_POST['name']);
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $role = $_POST['role'] ?? 'user';

    if ($username === '' || $email === '' || $pass === ''){
        flash('err', 'Registration failed: username, email and password are required.');
        redirect_home();
    }

    if (strlen($username) < 3){
        flash('err', 'Registration failed: username must be at least 3 characters.');
        redirect_home();
    }
    if (strlen($pass) < 8){
        flash('err', 'Registration failed: password must be at least 8 characters.');
        redirect_home();
    }
    $hashed = password_hash($pass , PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username , email , password, role) VALUES (?,?,?,?)");

    if (!$stmt){
        flash('err', 'Registration failed: database error.'); 
        redirect_home();
    }
    $stmt->bind_param("ssss", $username, $email, $hashed, $role);

    if ($stmt->execute()){
        flash('ok', 'Registration successful! You can now log in.');
    }
    else{
        flash('err', 'Registration failed: username may already exist.');
        redirect_home();
    }
    $stmt->close();
    redirect_home();

}

if ($action === 'login'){
    $username = trim($_POST['name']);
    $pass = $_POST['pass'];

    if ($username === '' || $pass === ''){
        flash('err', 'Login failed: username and password are required.');
        redirect_home();
        exit();
    }

    $stmt = $conn->prepare("SELECT user_id , username, password, role FROM users WHERE username =  ? LIMIT 1");

    if(!$stmt){
        flash('err', 'Login failed: database error.');
        redirect_home();
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()){
        if (password_verify($pass, $row['password'])){
            session_regenerate_id(true);

            $_SESSION ['user_id'] = (int)$row['user_id'];
            
            $_SESSION['user'] = [
                'id' => (int)$row['user_id'],
                'username' => $row['username'],
                'role' => $row['role']
            ];
            flash('ok', 'Login successful!');

            if ($row['role'] === 'admin'){
                header("Location: ../frontend/admin_page.php");
                exit();
            }
            else{
                header("Location: ../frontend/users_page.php");
                exit();
            }
        }
        else{
            flash('err', 'Login failed: invalid username or password.');
            redirect_home();
        }
    }
    else{
        flash('err', 'Login failed: invalid username or password.');
        redirect_home();
    }
    $stmt->close();
}

if ($action === 'logout'){
    unset($_SESSION['user']);

    session_regenerate_id(true);

    flash('ok', 'Logged out successfully.');
    redirect_home();
}


?>