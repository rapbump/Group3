<?php
session_start();
include 'connection.php';

function redirect_login(){
    header("Location: ../frontend/login.php");
    exit();
}
function redirect_home(){
    header("Location: ../frontend/users_page.php");
    exit();
}
function flash(string $type, string $text): void {
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

if ($action === 'book') {
    if (!isset($_SESSION['user_id'])) {
        flash('err', 'You must be logged in to book an appointment.');
        redirect_login();
    }

    $user_id = (int)$_SESSION['user_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $phone = $_POST['phone'];
    $services = (int)$_POST['services'];
    $notes = $_POST['comment'];

    if ($date === '' || $time === '' || $phone === '' || $services === 0) {
        flash('err', 'Booking failed: all required fields must be filled.');
        redirect_home();
    }

    $stmt = $conn->prepare("INSERT INTO booking (user_id, service_id, appointment_date, phone, appointment_time, notes) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        flash('err', 'Booking failed: database error.');
        redirect_home();
    }

    $stmt->bind_param("iissss", $user_id, $services, $date, $phone, $time, $notes);

    if ($stmt->execute()) {
        flash('ok', 'Booking successful!');
    } else {
        flash('err', 'Booking failed: ' . $stmt->error);
    }
    $stmt->close();

    redirect_home();
}
?>
