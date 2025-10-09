-- Table for chatbot Q&A system
CREATE TABLE IF NOT EXISTS chatbot_qa (
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
);

-- Insert some default Q&A entries
INSERT INTO chatbot_qa (question_fr, answer_fr, question_en, answer_en, question_zh, answer_zh, category, keywords) VALUES
('Quels sont vos services principaux ?', 'Nous proposons quatre services principaux : l\'expertise comptable (tenue de comptabilité, bilans), la fiscalité (déclarations TVA, optimisation), le social & paie (bulletins, URSSAF), et le conseil d\'entreprise (création, stratégie).', 'What are your main services?', 'We offer four main services: accounting expertise (bookkeeping, balance sheets), taxation (VAT declarations, optimization), social & payroll (payslips, URSSAF), and business consulting (creation, strategy).', '您的主要服务是什么？', '我们提供四项主要服务：会计专业知识（簿记、资产负债表）、税务（增值税申报、优化）、社保与薪资（工资单、URSSAF）和企业咨询（创建、战略）。', 'services', 'services, expertise, comptabilité, fiscalité, social, paie'),

('Combien coûte un devis ?', 'Nos devis sont entièrement gratuits et sans engagement. Contactez-nous au 01 23 45 67 89 ou par email à contact@mbc-expert.fr pour obtenir votre devis personnalisé.', 'How much does a quote cost?', 'Our quotes are completely free and without obligation. Contact us at 01 23 45 67 89 or by email at contact@mbc-expert.fr to get your personalized quote.', '报价多少钱？', '我们的报价完全免费且无义务。请致电 01 23 45 67 89 或发送电子邮件至 contact@mbc-expert.fr 获取您的个性化报价。', 'pricing', 'devis, gratuit, prix, tarif, coût'),

('Comment créer une entreprise ?', 'Nous vous accompagnons dans la création d\'entreprise (SARL, SAS, auto-entrepreneur) à partir de 200€. Nous vous conseillons sur le meilleur statut pour votre projet et nous nous chargeons de toutes les formalités.', 'How to create a business?', 'We support you in business creation (SARL, SAS, sole proprietorship) from €200. We advise you on the best status for your project and we take care of all the formalities.', '如何创建企业？', '我们支持企业创建（SARL、SAS、独资企业），200欧元起。我们为您提供最适合您项目的法律地位建议，并处理所有手续。', 'services', 'création, entreprise, SARL, SAS, auto-entrepreneur, statut'),

('Où êtes-vous situés ?', 'Nous sommes situés au 123 Avenue des Experts, 75001 Paris. Nos horaires d\'ouverture sont du lundi au vendredi de 9h à 18h, et le samedi de 9h à 13h.', 'Where are you located?', 'We are located at 123 Experts Avenue, 75001 Paris. Our opening hours are Monday to Friday from 9am to 6pm, and Saturday from 9am to 1pm.', '您在哪里？', '我们位于巴黎专家大道123号, 75001。我们的营业时间是周一至周五上午9点至下午6点，周六上午9点至下午1点。', 'contact', 'adresse, localisation, horaires, bureau, Paris'),

('Proposez-vous des simulateurs ?', 'Oui, nous proposons 4 simulateurs gratuits : calculateur de TVA, simulateur de charges sociales, simulateur d\'épargne & retraite, et simulateur d\'aides. Accédez-y via le menu "Simulateurs" !', 'Do you offer simulators?', 'Yes, we offer 4 free simulators: VAT calculator, social charges simulator, savings & retirement simulator, and aids simulator. Access them via the "Simulators" menu!', '您提供模拟器吗？', '是的，我们提供4个免费模拟器：增值税计算器、社会费用模拟器、储蓄与退休模拟器和援助模拟器。通过“模拟器”菜单访问它们！', 'services', 'simulateurs, calculateur, TVA, charges, épargne, aides'),

('Quels sont vos tarifs ?', 'Nos tarifs varient selon vos besoins. Expertise comptable à partir de 150€/mois, social & paie à partir de 50€/mois. Nous proposons des formules Starter (89€/mois), Professional (149€/mois) et Enterprise (249€/mois).', 'What are your prices?', 'Our prices vary according to your needs. Accounting expertise from €150/month, social & payroll from €50/month. We offer Starter (€89/month), Professional (€149/month) and Enterprise (€249/month) packages.', '您的价格是多少？', '我们的价格根据您的需求而定。会计专业知识每月150欧元起，社保与薪资每月50欧元起。我们提供入门版（89欧元/月）、专业版（149欧元/月）和企业版（249欧元/月）套餐。', 'pricing', 'tarifs, prix, formules, Starter, Professional, Enterprise'),

('Comment vous contacter ?', 'Vous pouvez nous contacter par téléphone au 01 23 45 67 89, par email à contact@mbc-expert.fr, ou venir nous voir au 123 Avenue des Experts, 75001 Paris. Nous sommes également disponibles sur WhatsApp !', 'How to contact you?', 'You can contact us by phone at 01 23 45 67 89, by email at contact@mbc-expert.fr, or visit us at 123 Experts Avenue, 75001 Paris. We are also available on WhatsApp!', '如何联系您？', '您可以致电 01 23 45 67 89，发送电子邮件至 contact@mbc-expert.fr，或访问我们位于巴黎专家大道123号, 75001的办公室。我们也可以通过WhatsApp联系！', 'contact', 'contact, téléphone, email, WhatsApp, adresse'),

('Êtes-vous spécialisés dans les entreprises franco-maghrébines ?', 'Absolument ! Notre équipe comprend parfaitement les enjeux spécifiques des entrepreneurs franco-maghrébins, notamment en matière de fiscalité internationale et de double imposition. Nous offrons un accompagnement personnalisé adapté à cette double culture entrepreneuriale.', 'Are you specialized in Franco-Maghrebian businesses?', 'Absolutely! Our team perfectly understands the specific challenges of Franco-Maghrebian entrepreneurs, particularly in terms of international taxation and double taxation. We offer personalized support adapted to this dual entrepreneurial culture.', '您专门从事法马企业吗？', '当然！我们的团队完全理解法马企业家的具体挑战，特别是在国际税务和双重征税方面。我们提供适合这种双重创业文化的个性化支持。', 'services', 'franco-maghrébin, spécialisation, double culture, fiscalité internationale'),

('Quel est votre délai de réponse ?', 'Nous nous engageons à vous répondre dans les 24h maximum, souvent en moins de 2h sur WhatsApp. Notre réactivité exceptionnelle fait partie de nos points forts !', 'What is your response time?', 'We commit to responding to you within 24 hours maximum, often in less than 2 hours on WhatsApp. Our exceptional responsiveness is one of our strengths!', '您的回复时间是多少？', '我们承诺在最多24小时内回复您，通常在WhatsApp上不到2小时。我们卓越的响应能力是我们的优势之一！', 'contact', 'délai, réponse, réactivité, WhatsApp, 24h'),

('Proposez-vous une garantie ?', 'Oui, nous offrons une garantie de satisfaction de 30 jours. Si vous n\'êtes pas satisfait, nous vous remboursons intégralement le premier mois. De plus, nous proposons le premier mois offert sans engagement !', 'Do you offer a guarantee?', 'Yes, we offer a 30-day satisfaction guarantee. If you are not satisfied, we will refund you in full for the first month. In addition, we offer the first month free without commitment!', '您提供保证吗？', '是的，我们提供30天满意保证。如果您不满意，我们将全额退还第一个月。此外，我们提供第一个月免费且无承诺！', 'pricing', 'garantie, satisfaction, remboursement, premier mois, sans engagement');
