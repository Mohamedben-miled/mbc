<?php
/**
 * Email Management System with SMTP Support
 */

require_once __DIR__ . '/../config/database.php';

class EmailManager {
    private $db;
    private $config;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->loadConfig();
    }

    /**
     * Load SMTP configuration from database
     */
    private function loadConfig() {
        try {
            // Check if table exists first
            $checkTable = $this->db->query("SHOW TABLES LIKE 'smtp_config'");
            if ($checkTable->rowCount() == 0) {
                // Table doesn't exist, use defaults
                $this->config = [
                    'enabled' => 0,
                    'host' => 'smtp.gmail.com',
                    'port' => 587,
                    'encryption' => 'tls',
                    'username' => '',
                    'password' => '',
                    'from_email' => '',
                    'from_name' => 'MBC Expert Comptable',
                    'notification_email' => ''
                ];
                return;
            }
            
            $stmt = $this->db->query("SELECT * FROM smtp_config ORDER BY id DESC LIMIT 1");
            $this->config = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$this->config) {
                // Default configuration
                $this->config = [
                    'enabled' => 0,
                    'host' => 'smtp.gmail.com',
                    'port' => 587,
                    'encryption' => 'tls',
                    'username' => '',
                    'password' => '',
                    'from_email' => '',
                    'from_name' => 'MBC Expert Comptable',
                    'notification_email' => ''
                ];
            }
        } catch (PDOException $e) {
            // Silently use default config if table doesn't exist
            $this->config = [
                'enabled' => 0,
                'host' => 'smtp.gmail.com',
                'port' => 587,
                'encryption' => 'tls',
                'username' => '',
                'password' => '',
                'from_email' => '',
                'from_name' => 'MBC Expert Comptable',
                'notification_email' => ''
            ];
        }
    }

    /**
     * Check if email notifications are enabled
     */
    public function isEnabled() {
        return isset($this->config['enabled']) && $this->config['enabled'] == 1;
    }

    /**
     * Send email using PHPMailer or native mail function
     */
    public function sendEmail($to, $subject, $message, $html = true) {
        if (!$this->isEnabled()) {
            error_log("Email sending is disabled");
            return false;
        }

        // Check if PHPMailer is available
        if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            return $this->sendWithPHPMailer($to, $subject, $message, $html);
        } else {
            return $this->sendWithNativeMail($to, $subject, $message, $html);
        }
    }

    /**
     * Send email using PHPMailer
     */
    private function sendWithPHPMailer($to, $subject, $message, $html) {
        try {
            require_once __DIR__ . '/../vendor/autoload.php';
            
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = $this->config['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $this->config['username'];
            $mail->Password = $this->config['password'];
            $mail->SMTPSecure = $this->config['encryption'] === 'ssl' ? PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS : 
                                ($this->config['encryption'] === 'tls' ? PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS : '');
            $mail->Port = $this->config['port'];
            $mail->CharSet = 'UTF-8';

            // Sender
            $mail->setFrom($this->config['from_email'], $this->config['from_name']);
            
            // Recipient
            $mail->addAddress($to);

            // Content
            $mail->isHTML($html);
            $mail->Subject = $subject;
            $mail->Body = $message;
            
            if (!$html) {
                $mail->AltBody = strip_tags($message);
            }

            return $mail->send();
        } catch (Exception $e) {
            error_log("PHPMailer Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send email using native PHP mail function
     */
    private function sendWithNativeMail($to, $subject, $message, $html) {
        $headers = [];
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-Type: " . ($html ? "text/html" : "text/plain") . "; charset=UTF-8";
        $headers[] = "From: " . $this->config['from_name'] . " <" . $this->config['from_email'] . ">";
        $headers[] = "Reply-To: " . $this->config['from_email'];
        $headers[] = "X-Mailer: PHP/" . phpversion();

        return mail($to, $subject, $message, implode("\r\n", $headers));
    }

    /**
     * Send contact form notification
     */
    public function sendContactNotification($submission) {
        if (!$this->isEnabled() || empty($this->config['notification_email'])) {
            return false;
        }

        $subject = "Nouveau message de contact - " . htmlspecialchars($submission['subject']);
        
        $message = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #296871; color: white; padding: 20px; border-radius: 8px 8px 0 0; }
                .content { background: #f9fafb; padding: 20px; border: 1px solid #e5e7eb; }
                .field { margin-bottom: 15px; }
                .field-label { font-weight: bold; color: #296871; }
                .field-value { margin-top: 5px; padding: 10px; background: white; border-radius: 4px; }
                .footer { background: #f3f4f6; padding: 15px; text-align: center; font-size: 12px; color: #6b7280; border-radius: 0 0 8px 8px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Nouveau message de contact</h2>
                </div>
                <div class='content'>
                    <div class='field'>
                        <div class='field-label'>Nom:</div>
                        <div class='field-value'>" . htmlspecialchars($submission['name']) . "</div>
                    </div>
                    <div class='field'>
                        <div class='field-label'>Email:</div>
                        <div class='field-value'>" . htmlspecialchars($submission['email']) . "</div>
                    </div>
                    " . (!empty($submission['phone']) ? "
                    <div class='field'>
                        <div class='field-label'>Téléphone:</div>
                        <div class='field-value'>" . htmlspecialchars($submission['phone']) . "</div>
                    </div>
                    " : "") . "
                    <div class='field'>
                        <div class='field-label'>Sujet:</div>
                        <div class='field-value'>" . htmlspecialchars($submission['subject']) . "</div>
                    </div>
                    <div class='field'>
                        <div class='field-label'>Message:</div>
                        <div class='field-value'>" . nl2br(htmlspecialchars($submission['message'])) . "</div>
                    </div>
                </div>
                <div class='footer'>
                    <p>Ce message a été reçu depuis le formulaire de contact du site MBC Expert Comptable.</p>
                    <p>Date: " . date('d/m/Y H:i') . "</p>
                </div>
            </div>
        </body>
        </html>
        ";

        return $this->sendEmail($this->config['notification_email'], $subject, $message, true);
    }

    /**
     * Get SMTP configuration
     */
    public function getConfig() {
        return $this->config;
    }

    /**
     * Save SMTP configuration
     */
    public function saveConfig($data) {
        try {
            // Check if config exists
            $stmt = $this->db->query("SELECT COUNT(*) as count FROM smtp_config");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $exists = $result['count'] > 0;

            if ($exists) {
                // Update existing config
                $stmt = $this->db->prepare("
                    UPDATE smtp_config SET
                        enabled = ?,
                        host = ?,
                        port = ?,
                        encryption = ?,
                        username = ?,
                        password = ?,
                        from_email = ?,
                        from_name = ?,
                        notification_email = ?
                    WHERE id = 1
                ");
            } else {
                // Insert new config
                $stmt = $this->db->prepare("
                    INSERT INTO smtp_config (
                        enabled, host, port, encryption, username, password,
                        from_email, from_name, notification_email
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
            }

            return $stmt->execute([
                isset($data['enabled']) ? 1 : 0,
                $data['host'],
                $data['port'],
                $data['encryption'],
                $data['username'],
                $data['password'],
                $data['from_email'],
                $data['from_name'],
                $data['notification_email']
            ]);
        } catch (PDOException $e) {
            error_log("Save SMTP config error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Test email configuration
     */
    public function testConnection($config) {
        try {
            // Simple test - just check if we can connect to SMTP server
            $connection = @fsockopen(
                $config['host'],
                $config['port'],
                $errno,
                $errstr,
                5
            );
            
            if ($connection) {
                fclose($connection);
                return ['success' => true, 'message' => 'Connexion SMTP réussie'];
            } else {
                return ['success' => false, 'message' => "Erreur de connexion: $errstr ($errno)"];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}

