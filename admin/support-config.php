<?php
require_once '../includes/auth.php';
require_once '../includes/translations.php';

$auth = new Auth();
$auth->requireLogin();
$auth->requireAdmin();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add_qa':
                $question_fr = $_POST['question_fr'] ?? '';
                $answer_fr = $_POST['answer_fr'] ?? '';
                $question_en = $_POST['question_en'] ?? '';
                $answer_en = $_POST['answer_en'] ?? '';
                $question_zh = $_POST['question_zh'] ?? '';
                $answer_zh = $_POST['answer_zh'] ?? '';
                $category = $_POST['category'] ?? 'general';
                $keywords = $_POST['keywords'] ?? '';
                
                if (!empty($question_fr) && !empty($answer_fr)) {
                    $stmt = $pdo->prepare("INSERT INTO chatbot_qa (question_fr, answer_fr, question_en, answer_en, question_zh, answer_zh, category, keywords, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                    $stmt->execute([$question_fr, $answer_fr, $question_en, $answer_en, $question_zh, $answer_zh, $category, $keywords]);
                    $success_message = __('admin.support.qa_added_successfully');
                }
                break;
                
            case 'edit_qa':
                $id = $_POST['id'] ?? 0;
                $question_fr = $_POST['question_fr'] ?? '';
                $answer_fr = $_POST['answer_fr'] ?? '';
                $question_en = $_POST['question_en'] ?? '';
                $answer_en = $_POST['answer_en'] ?? '';
                $question_zh = $_POST['question_zh'] ?? '';
                $answer_zh = $_POST['answer_zh'] ?? '';
                $category = $_POST['category'] ?? 'general';
                $keywords = $_POST['keywords'] ?? '';
                
                if ($id > 0 && !empty($question_fr) && !empty($answer_fr)) {
                    $stmt = $pdo->prepare("UPDATE chatbot_qa SET question_fr = ?, answer_fr = ?, question_en = ?, answer_en = ?, question_zh = ?, answer_zh = ?, category = ?, keywords = ?, updated_at = NOW() WHERE id = ?");
                    $stmt->execute([$question_fr, $answer_fr, $question_en, $answer_en, $question_zh, $answer_zh, $category, $keywords, $id]);
                    $success_message = __('admin.support.qa_updated_successfully');
                }
                break;
                
            case 'delete_qa':
                $id = $_POST['id'] ?? 0;
                if ($id > 0) {
                    $stmt = $pdo->prepare("DELETE FROM chatbot_qa WHERE id = ?");
                    $stmt->execute([$id]);
                    $success_message = __('admin.support.qa_deleted_successfully');
                }
                break;
        }
    }
}

// Get all Q&A entries
$stmt = $pdo->query("SELECT * FROM chatbot_qa ORDER BY created_at DESC");
$qa_entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get categories
$categories = [
    'general' => __('admin.support.category_general'),
    'services' => __('admin.support.category_services'),
    'pricing' => __('admin.support.category_pricing'),
    'technical' => __('admin.support.category_technical'),
    'contact' => __('admin.support.category_contact')
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo __('admin.support.title'); ?> - MBC Dashboard</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .support-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .support-header {
            background: linear-gradient(135deg, #2e6a6e, #4a9ea0);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .support-header h1 {
            margin: 0;
            font-size: 2rem;
        }
        
        .support-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }
        
        .support-actions {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .btn-add {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        
        .qa-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .qa-card {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .qa-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }
        
        .qa-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .qa-category {
            background: #f8f9fa;
            color: #495057;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .qa-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn-edit, .btn-delete {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .btn-edit {
            background: #007bff;
            color: white;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        
        .btn-edit:hover, .btn-delete:hover {
            transform: scale(1.05);
        }
        
        .qa-content {
            margin-bottom: 15px;
        }
        
        .qa-question {
            font-weight: 600;
            color: #2e6a6e;
            margin-bottom: 8px;
        }
        
        .qa-answer {
            color: #666;
            line-height: 1.5;
        }
        
        .qa-keywords {
            margin-top: 10px;
            font-size: 0.9rem;
            color: #888;
        }
        
        .qa-keywords strong {
            color: #2e6a6e;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        
        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .modal-header h2 {
            margin: 0;
            color: #2e6a6e;
        }
        
        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .form-group textarea {
            height: 100px;
            resize: vertical;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 20px;
        }
        
        .btn-save, .btn-cancel {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
        }
        
        .btn-save {
            background: #28a745;
            color: white;
        }
        
        .btn-cancel {
            background: #6c757d;
            color: white;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .language-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .language-tab {
            padding: 8px 16px;
            border: 1px solid #ddd;
            background: #f8f9fa;
            cursor: pointer;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .language-tab.active {
            background: #2e6a6e;
            color: white;
            border-color: #2e6a6e;
        }
        
        .language-content {
            display: none;
        }
        
        .language-content.active {
            display: block;
        }
        
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .qa-grid {
                grid-template-columns: 1fr;
            }
            
            .support-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/dashboard-header.php'; ?>
    
    <div class="support-container">
        <div class="support-header">
            <h1><?php echo __('admin.support.title'); ?></h1>
            <p><?php echo __('admin.support.subtitle'); ?></p>
        </div>
        
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        
        <div class="support-actions">
            <button class="btn-add" onclick="openAddModal()">
                <i class="fas fa-plus"></i> <?php echo __('admin.support.add_qa'); ?>
            </button>
        </div>
        
        <div class="qa-grid">
            <?php foreach ($qa_entries as $qa): ?>
                <div class="qa-card">
                    <div class="qa-header">
                        <span class="qa-category"><?php echo $categories[$qa['category']] ?? $qa['category']; ?></span>
                        <div class="qa-actions">
                            <button class="btn-edit" onclick="editQA(<?php echo $qa['id']; ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-delete" onclick="deleteQA(<?php echo $qa['id']; ?>)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="qa-content">
                        <div class="qa-question"><?php echo htmlspecialchars($qa['question_fr']); ?></div>
                        <div class="qa-answer"><?php echo htmlspecialchars($qa['answer_fr']); ?></div>
                        <?php if (!empty($qa['keywords'])): ?>
                            <div class="qa-keywords">
                                <strong>Mots-clés:</strong> <?php echo htmlspecialchars($qa['keywords']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Add/Edit Modal -->
    <div id="qaModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle"><?php echo __('admin.support.add_qa'); ?></h2>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            
            <form id="qaForm" method="POST">
                <input type="hidden" name="action" id="formAction" value="add_qa">
                <input type="hidden" name="id" id="qaId" value="">
                
                <div class="language-tabs">
                    <div class="language-tab active" onclick="switchLanguage('fr')">🇫🇷 Français</div>
                    <div class="language-tab" onclick="switchLanguage('en')">🇬🇧 English</div>
                    <div class="language-tab" onclick="switchLanguage('zh')">🇨🇳 中文</div>
                </div>
                
                <div class="language-content active" id="content-fr">
                    <div class="form-group">
                        <label for="question_fr"><?php echo __('admin.support.question_fr'); ?></label>
                        <input type="text" name="question_fr" id="question_fr" required>
                    </div>
                    <div class="form-group">
                        <label for="answer_fr"><?php echo __('admin.support.answer_fr'); ?></label>
                        <textarea name="answer_fr" id="answer_fr" required></textarea>
                    </div>
                </div>
                
                <div class="language-content" id="content-en">
                    <div class="form-group">
                        <label for="question_en"><?php echo __('admin.support.question_en'); ?></label>
                        <input type="text" name="question_en" id="question_en">
                    </div>
                    <div class="form-group">
                        <label for="answer_en"><?php echo __('admin.support.answer_en'); ?></label>
                        <textarea name="answer_en" id="answer_en"></textarea>
                    </div>
                </div>
                
                <div class="language-content" id="content-zh">
                    <div class="form-group">
                        <label for="question_zh"><?php echo __('admin.support.question_zh'); ?></label>
                        <input type="text" name="question_zh" id="question_zh">
                    </div>
                    <div class="form-group">
                        <label for="answer_zh"><?php echo __('admin.support.answer_zh'); ?></label>
                        <textarea name="answer_zh" id="answer_zh"></textarea>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="category"><?php echo __('admin.support.category'); ?></label>
                        <select name="category" id="category" required>
                            <?php foreach ($categories as $key => $label): ?>
                                <option value="<?php echo $key; ?>"><?php echo $label; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keywords"><?php echo __('admin.support.keywords'); ?></label>
                        <input type="text" name="keywords" id="keywords" placeholder="<?php echo __('admin.support.keywords_placeholder'); ?>">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal()"><?php echo __('admin.support.cancel'); ?></button>
                    <button type="submit" class="btn-save"><?php echo __('admin.support.save'); ?></button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function openAddModal() {
            document.getElementById('modalTitle').textContent = '<?php echo __('admin.support.add_qa'); ?>';
            document.getElementById('formAction').value = 'add_qa';
            document.getElementById('qaId').value = '';
            document.getElementById('qaForm').reset();
            document.getElementById('qaModal').style.display = 'block';
        }
        
        function editQA(id) {
            // This would need to be implemented with AJAX to fetch the QA data
            alert('Edit functionality would be implemented here');
        }
        
        function deleteQA(id) {
            if (confirm('<?php echo __('admin.support.confirm_delete'); ?>')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete_qa">
                    <input type="hidden" name="id" value="${id}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        function closeModal() {
            document.getElementById('qaModal').style.display = 'none';
        }
        
        function switchLanguage(lang) {
            // Hide all language contents
            document.querySelectorAll('.language-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.language-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Show selected language content
            document.getElementById('content-' + lang).classList.add('active');
            
            // Add active class to selected tab
            event.target.classList.add('active');
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('qaModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>
