<?php
class EmailController {
    private $conn;
    private $messages;

    public function __construct($db_conn, $messages) {
        $this->conn = $db_conn;
        $this->messages = $messages;
    }

    // Validate form input
    public function validate($data) {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = "Name is required.";
        }
        if (empty($data['subject'])) {
            $errors['subject'] = "Subject is required.";
        }
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "A valid email is required.";
        }
        if (empty($data['message'])) {
            $errors['message'] = "Message is required.";
        } elseif (strlen($data['message']) > 150) {
            $errors['message'] = "Message cannot exceed 150 characters.";
        }

        return $errors;
    }

    // Save message to database
    public function saveMessage($data) {
        $stmt = $this->conn->prepare(
            "INSERT INTO email (name, subject, recipient_email, messages) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $data['name'], $data['subject'], $data['email'], $data['message']);
        return $stmt->execute();
    }

    // Fetch all messages
    public function getAllMessages() {
        $result = $this->conn->query("SELECT * FROM email ORDER BY created_at DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Delete a message by ID
    public function deleteMessage($id) {
        $stmt = $this->conn->prepare("DELETE FROM email WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
