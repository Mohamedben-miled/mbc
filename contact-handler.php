<?php
/**
 * Contact Form Handler
 */

require_once __DIR__ . '/includes/contact.php';

header('Content-Type: application/json');

if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get form data
$firstName = sanitizeInput($_POST['firstName'] ?? '');
$lastName = sanitizeInput($_POST['lastName'] ?? '');
$name = trim($firstName . ' ' . $lastName);
$email = sanitizeInput($_POST['email'] ?? '');
$phone = sanitizeInput($_POST['phone'] ?? '');
$company = sanitizeInput($_POST['company'] ?? '');
$subject = sanitizeInput($_POST['subject'] ?? '');
$message = sanitizeInput($_POST['message'] ?? '');

// Validate data
$validationErrors = [];

// Validate individual fields
if (empty($firstName)) {
    $validationErrors['firstName'] = 'Le prénom est requis.';
}

if (empty($lastName)) {
    $validationErrors['lastName'] = 'Le nom est requis.';
}

if (empty($email)) {
    $validationErrors['email'] = 'L\'email est requis.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $validationErrors['email'] = 'L\'email n\'est pas valide.';
}

if (empty($subject)) {
    $validationErrors['subject'] = 'Le sujet est requis.';
}

if (empty($message)) {
    $validationErrors['message'] = 'Le message est requis.';
}

if (!empty($validationErrors)) {
    echo json_encode([
        'success' => false,
        'message' => 'Veuillez corriger les erreurs suivantes :',
        'errors' => $validationErrors
    ]);
    exit;
}

// Submit contact form
$submissionData = [
    'name' => $name,
    'email' => $email,
    'phone' => $phone,
    'company' => $company,
    'subject' => $subject,
    'message' => $message
];

if ($contact->submitContact($submissionData)) {
    // Send email notification
    $db = Database::getInstance();
    $submission = $contact->getSubmission($db->lastInsertId());
    $contact->sendEmailNotification($submission);
    
    echo json_encode([
        'success' => true,
        'message' => 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Une erreur est survenue lors de l\'envoi de votre message. Veuillez réessayer.'
    ]);
}
?>
