<?php
include 'includes/db.php'; // adjust path if inside admin folder

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // sanitize the input

    $stmt = $conn->prepare("DELETE FROM email WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: admin/dashboard.php?success=deleted");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid request: No valid ID provided.";
}
?>
