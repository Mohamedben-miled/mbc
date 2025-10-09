<?php
require_once 'includes/db.php';

try {
    // Create the chatbot_qa table
    $sql = "CREATE TABLE IF NOT EXISTS chatbot_qa (
        id INT AUTO_INCREMENT PRIMARY KEY,
        question_fr TEXT NOT NULL,
        answer_fr TEXT NOT NULL,
        question_en TEXT,
        answer_en TEXT,
        question_zh TEXT,
        answer_zh TEXT,
        category VARCHAR(50) DEFAULT 'general',
        keywords TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    echo "Table chatbot_qa created successfully!\n";
    
    // Insert default Q&A entries
    $default_qa = [
        [
            'question_fr' => 'Quels sont vos services principaux ?',
            'answer_fr' => 'Nous proposons quatre services principaux : l\'expertise comptable (tenue de comptabilité, bilans), la fiscalité (déclarations TVA, optimisation), le social & paie (bulletins, URSSAF), et le conseil d\'entreprise (création, stratégie).',
            'question_en' => 'What are your main services?',
            'answer_en' => 'We offer four main services: accounting expertise (bookkeeping, balance sheets), taxation (VAT declarations, optimization), social & payroll (payslips, URSSAF), and business consulting (creation, strategy).',
            'question_zh' => '您的主要服务是什么？',
            'answer_zh' => '我们提供四项主要服务：会计专业知识（簿记、资产负债表）、税务（增值税申报、优化）、社保与薪资（工资单、URSSAF）和企业咨询（创建、战略）。',
            'category' => 'services',
            'keywords' => 'services, expertise, comptabilité, fiscalité, social, paie'
        ],
        [
            'question_fr' => 'Combien coûte un devis ?',
            'answer_fr' => 'Nos devis sont entièrement gratuits et sans engagement. Contactez-nous au 01 23 45 67 89 ou par email à contact@mbc-expert.fr pour obtenir votre devis personnalisé.',
            'question_en' => 'How much does a quote cost?',
            'answer_en' => 'Our quotes are completely free and without obligation. Contact us at 01 23 45 67 89 or by email at contact@mbc-expert.fr to get your personalized quote.',
            'question_zh' => '报价多少钱？',
            'answer_zh' => '我们的报价完全免费且无义务。请致电 01 23 45 67 89 或发送电子邮件至 contact@mbc-expert.fr 获取您的个性化报价。',
            'category' => 'pricing',
            'keywords' => 'devis, gratuit, prix, tarif, coût'
        ],
        [
            'question_fr' => 'Comment créer une entreprise ?',
            'answer_fr' => 'Nous vous accompagnons dans la création d\'entreprise (SARL, SAS, auto-entrepreneur) à partir de 200€. Nous vous conseillons sur le meilleur statut pour votre projet et nous nous chargeons de toutes les formalités.',
            'question_en' => 'How to create a business?',
            'answer_en' => 'We support you in business creation (SARL, SAS, sole proprietorship) from €200. We advise you on the best status for your project and we take care of all the formalities.',
            'question_zh' => '如何创建企业？',
            'answer_zh' => '我们支持企业创建（SARL、SAS、独资企业），200欧元起。我们为您提供最适合您项目的法律地位建议，并处理所有手续。',
            'category' => 'services',
            'keywords' => 'création, entreprise, SARL, SAS, auto-entrepreneur, statut'
        ],
        [
            'question_fr' => 'Où êtes-vous situés ?',
            'answer_fr' => 'Nous sommes situés au 123 Avenue des Experts, 75001 Paris. Nos horaires d\'ouverture sont du lundi au vendredi de 9h à 18h, et le samedi de 9h à 13h.',
            'question_en' => 'Where are you located?',
            'answer_en' => 'We are located at 123 Experts Avenue, 75001 Paris. Our opening hours are Monday to Friday from 9am to 6pm, and Saturday from 9am to 1pm.',
            'question_zh' => '您在哪里？',
            'answer_zh' => '我们位于巴黎专家大道123号, 75001。我们的营业时间是周一至周五上午9点至下午6点，周六上午9点至下午1点。',
            'category' => 'contact',
            'keywords' => 'adresse, localisation, horaires, bureau, Paris'
        ],
        [
            'question_fr' => 'Proposez-vous des simulateurs ?',
            'answer_fr' => 'Oui, nous proposons 4 simulateurs gratuits : calculateur de TVA, simulateur de charges sociales, simulateur d\'épargne & retraite, et simulateur d\'aides. Accédez-y via le menu "Simulateurs" !',
            'question_en' => 'Do you offer simulators?',
            'answer_en' => 'Yes, we offer 4 free simulators: VAT calculator, social charges simulator, savings & retirement simulator, and aids simulator. Access them via the "Simulators" menu!',
            'question_zh' => '您提供模拟器吗？',
            'answer_zh' => '是的，我们提供4个免费模拟器：增值税计算器、社会费用模拟器、储蓄与退休模拟器和援助模拟器。通过“模拟器”菜单访问它们！',
            'category' => 'services',
            'keywords' => 'simulateurs, calculateur, TVA, charges, épargne, aides'
        ]
    ];
    
    $stmt = $pdo->prepare("INSERT INTO chatbot_qa (question_fr, answer_fr, question_en, answer_en, question_zh, answer_zh, category, keywords) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    foreach ($default_qa as $qa) {
        $stmt->execute([
            $qa['question_fr'],
            $qa['answer_fr'],
            $qa['question_en'],
            $qa['answer_en'],
            $qa['question_zh'],
            $qa['answer_zh'],
            $qa['category'],
            $qa['keywords']
        ]);
    }
    
    echo "Default Q&A entries inserted successfully!\n";
    echo "Chatbot Q&A system setup completed!\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
