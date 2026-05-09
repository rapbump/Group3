<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "customer_db";

$conn = new mysqli($host, $user, $password, $dbname);


if($conn->connect_error){
    die("Connection Failed: ". $conn->connect_error);
}

function redirect_login(){
    header("Location: ../frontend/login.php");
    exit();
}
function redirect_home(){
    header("Location: ../frontend/glowtrack.php");
    exit();
}
function flash(string $type, string $text): void    
{
    $_SESSION['flash'] = [ 
        'type' => $type,  
        'text' => $text
    ];
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    exit("Invalid access. Open <a href='../index.php'>Home</a>.");
}

$action = $_POST['action'] ?? '';

if ($action === ''){
    flash('err', 'No action provided.');
    redirect_home();
}

if ($action === 'book'){
    if (!isset($_SESSION['user'])){
        flash('err', 'You must be logged in to book an appointment.');
        redirect_login();
    }
    else {
        if ($action === 'book'){
            $fname = trim($_POST['fname']);
            $date = $_POST['date'];
            $phone = $_POST['phone'];
            $time = $_POST['time'];
            $services = $_POST['services'];
            $email = $_POST['email'];
            $text = $_POST['comment'];
            if ($fname === '' || $date === '' || $phone === '' || $time === '' || $services === '' || $email === ''){
                flash('err', 'Booking failed: all fields except comment are required.');
                redirect_home();
            }
            $stmt = $conn->prepare("INSERT INTO booking (fname, date, phone, time, service_id, email, comment) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if (!$stmt){
                flash('err', 'Booking failed: database error.');
                redirect_home();
            }
            $stmt->bind_param("ssssiss", $fname, $date, $phone, $time, $services, $email, $text);
            if (!$stmt->execute()){
                flash('err', 'Booking failed: database error.');
                redirect_home();
            }
        }
        flash('ok', 'Booking successful!');
        redirect_home();
    }
}
?>