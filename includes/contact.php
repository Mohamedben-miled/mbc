<?php
/**
 * Contact Form Handler for MBC Website
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/encoding.php';

class Contact {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
        // Ensure UTF-8 encoding for database connection
        ensureUtf8Encoding($this->db->getConnection());
    }

    /**
     * Submit contact form
     */
    public function submitContact($data) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO contact_submissions (name, email, phone, subject, message) 
                VALUES (?, ?, ?, ?, ?)
            ");
            
            return $stmt->execute([
                $data['name'],
                $data['email'],
                $data['phone'] ?? '',
                $data['subject'],
                $data['message']
            ]);
        } catch (PDOException $e) {
            error_log("Contact submission error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all contact submissions
     */
    public function getSubmissions($page = 1, $limit = 20, $status = null) {
        try {
            $offset = ($page - 1) * $limit;
            $whereClause = $status ? "WHERE status = ?" : "";
            $params = $status ? [$status] : [];
            
            $sql = "SELECT * FROM contact_submissions $whereClause ORDER BY created_at DESC LIMIT ? OFFSET ?";
            $params[] = $limit;
            $params[] = $offset;
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get submissions error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get single submission
     */
    public function getSubmission($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM contact_submissions WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Get submission error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Update submission status
     */
    public function updateStatus($id, $status) {
        try {
            $stmt = $this->db->prepare("UPDATE contact_submissions SET status = ? WHERE id = ?");
            return $stmt->execute([$status, $id]);
        } catch (PDOException $e) {
            error_log("Update status error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete submission
     */
    public function deleteSubmission($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM contact_submissions WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Delete submission error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get submissions count
     */
    public function getSubmissionsCount($status = null) {
        try {
            $whereClause = $status ? "WHERE status = ?" : "";
            $params = $status ? [$status] : [];
            
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM contact_submissions $whereClause");
            $stmt->execute($params);
            $result = $stmt->fetch();
            return $result['count'];
        } catch (PDOException $e) {
            error_log("Get submissions count error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get new submissions count
     */
    public function getNewSubmissionsCount() {
        return $this->getSubmissionsCount('new');
    }

    /**
     * Subscribe to newsletter
     */
    public function subscribeNewsletter($email) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO newsletter_subscriptions (email) 
                VALUES (?) 
                ON DUPLICATE KEY UPDATE status = 'active', subscribed_at = CURRENT_TIMESTAMP
            ");
            
            return $stmt->execute([$email]);
        } catch (PDOException $e) {
            error_log("Newsletter subscription error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Unsubscribe from newsletter
     */
    public function unsubscribeNewsletter($email) {
        try {
            $stmt = $this->db->prepare("UPDATE newsletter_subscriptions SET status = 'unsubscribed' WHERE email = ?");
            return $stmt->execute([$email]);
        } catch (PDOException $e) {
            error_log("Newsletter unsubscription error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get newsletter subscribers
     */
    public function getNewsletterSubscribers($page = 1, $limit = 50) {
        try {
            $offset = ($page - 1) * $limit;
            $stmt = $this->db->prepare("
                SELECT * FROM newsletter_subscriptions 
                WHERE status = 'active' 
                ORDER BY subscribed_at DESC 
                LIMIT ? OFFSET ?
            ");
            $stmt->execute([$limit, $offset]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get newsletter subscribers error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Validate contact form data
     */
    public function validateContactData($data) {
        $errors = [];

        if (empty($data['name'])) {
            $errors[] = 'Le nom est requis.';
        }

        if (empty($data['email'])) {
            $errors[] = 'L\'email est requis.';
        } elseif (!validateEmail($data['email'])) {
            $errors[] = 'L\'email n\'est pas valide.';
        }

        if (empty($data['subject'])) {
            $errors[] = 'Le sujet est requis.';
        }

        if (empty($data['message'])) {
            $errors[] = 'Le message est requis.';
        }

        return $errors;
    }

    /**
     * Send email notification (placeholder - implement with your email service)
     */
    public function sendEmailNotification($submission) {
        // This is a placeholder function
        // Implement with your preferred email service (PHPMailer, SendGrid, etc.)
        
        $to = 'contact@mbc-expertcomptable.fr';
        $subject = 'Nouveau message de contact - ' . $submission['subject'];
        $message = "
        Nouveau message de contact reçu :
        
        Nom: {$submission['name']}
        Email: {$submission['email']}
        Téléphone: {$submission['phone']}
        Sujet: {$submission['subject']}
        
        Message:
        {$submission['message']}
        
        Date: " . formatDateTime($submission['created_at']);
        
        $headers = "From: {$submission['email']}\r\n";
        $headers .= "Reply-To: {$submission['email']}\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        return mail($to, $subject, $message, $headers);
    }
}

// Initialize contact instance
$contact = new Contact();
?>
