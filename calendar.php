<?php
include 'connection.php';

$successMsg = '';
$errorMsg = '';
$eventsFromDB = [];

// Handle ADD Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add') {
    $course = trim($_POST['course_name'] ?? '');
    $instructor = trim($_POST['instructor_name'] ?? '');
    $start = $_POST['start_date'] ?? '';
    $end = $_POST['end_date'] ?? '';
    $startTime = $_POST['start_time'] ?? '';
    $endTime = $_POST['end_time'] ?? '';

    if ($course && $instructor && $start && $end) {
        $stmt = $conn->prepare("INSERT INTO courses (course_name, instructor_name, start_date, end_date, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $course, $instructor, $start, $end, $startTime, $endTime);

        if ($stmt->execute()) {
            $successMsg = "Event added successfully!";
            $stmt->close();
            header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
            exit;
        } else {
            $errorMsg = "Error adding event: " . $stmt->error;
        }
        $stmt->close();
    } else {
        header("Location: " . $_SERVER['PHP_SELF'] . "?error=1");
        exit;
    }
}

// Handle EDIT Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'edit') {
    $id = $_POST['event_id'] ?? null;
    $course = trim($_POST['course_name'] ?? '');
    $instructor = trim($_POST['instructor_name'] ?? '');
    $start = $_POST['start_date'] ?? '';
    $end = $_POST['end_date'] ?? '';
    $startTime = $_POST['start_time'] ?? '';
    $endTime = $_POST['end_time'] ?? '';

    if ($id && $course && $instructor && $start && $end) {
        $stmt = $conn->prepare("UPDATE courses SET course_name=?, instructor_name=?, start_date=?, end_date=?, start_time=?, end_time=? WHERE id=?");
        $stmt->bind_param("ssssssi", $course, $instructor, $start, $end, $startTime, $endTime, $id);

        if ($stmt->execute()) {
            $successMsg = "Event updated successfully!";
            $stmt->close();
            header("Location: " . $_SERVER['PHP_SELF'] . "?success=2");
            exit;
        } else {
            $errorMsg = "Error updating event: " . $stmt->error;
        }
        $stmt->close();
    } else {
        header("Location: " . $_SERVER['PHP_SELF'] . "?error=1");
        exit;
    }
}

// Handle DELETE Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    $id = $_POST['event_id'] ?? null;

    if ($id) {
        $stmt = $conn->prepare("DELETE FROM courses WHERE id=?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $successMsg = "Event deleted successfully!";
            $stmt->close();
            header("Location: " . $_SERVER['PHP_SELF'] . "?success=3");
            exit;
        } else {
            $errorMsg = "Error deleting event: " . $stmt->error;
        }
        $stmt->close();
    } else {
        header("Location: " . $_SERVER['PHP_SELF'] . "?error=1");
        exit;
    }
}

// Show Messages Based on Query Param
if (isset($_GET['success'])) {
    $successMsg = match ($_GET['success']) {
        1 => "Event added successfully!",
        2 => "Event updated successfully!",
        3 => "Event deleted successfully!",
        default => "Action completed successfully!",
    };
} elseif (isset($_GET['error'])) {
    $errorMsg = "An error occurred. Please try again.";
}

// Fetch Events from DB
$result = $conn->query("SELECT * FROM courses");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $start = new DateTime($row['start_date']);
        $end = new DateTime($row['end_date']);

        while ($start <= $end) {
            $eventsFromDB[] = [
                'id' => $row['id'],
                'title' => "{$row['course_name']} - {$row['instructor_name']}",
                'date' => $start->format('Y-m-d'),
                'startDate' => $row['start_date'],
                'endDate' => $row['end_date'],
                'start_time' => $row['start_time'],
                'end_time' => $row['end_time']
            ];
            $start->modify('+1 day');
        }
    }
} elseif (!$result) {
    $errorMsg = "Failed to load events: " . $conn->error;
}

$conn->close();
?>
