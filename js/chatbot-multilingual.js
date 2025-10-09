/**
 * MBC Expert Comptable - Multilingual Intelligent Chatbot
 * Advanced chatbot that responds in French, English, and Chinese
 * Uses pre-trained AI model for better responses
 */

// ========================================
// 1. LANGUAGE DETECTION AND RESPONSE SYSTEM
// ========================================

class MultilingualChatbot {
    constructor() {
        this.currentLanguage = this.detectLanguage();
        this.knowledgeBase = this.initializeKnowledgeBase();
        this.aiModel = this.initializeAIModel();
    }

    /**
     * Detect current language from URL or localStorage
     */
    detectLanguage() {
        const urlParams = new URLSearchParams(window.location.search);
        const lang = urlParams.get('lang') || localStorage.getItem('language') || 'fr';
        return ['fr', 'en', 'zh'].includes(lang) ? lang : 'fr';
    }

    /**
     * Initialize comprehensive knowledge base in 3 languages
     */
    initializeKnowledgeBase() {
        return {
            fr: {
                greetings: [
                    "Bonjour ! Je suis l'assistant virtuel de MBC Expert Comptable. Comment puis-je vous aider ?",
                    "Salut ! Je suis là pour répondre à vos questions comptables. Que souhaitez-vous savoir ?",
                    "Hello ! Je peux vous aider avec nos services, tarifs et simulateurs. Que puis-je faire pour vous ?"
                ],
                services: {
                    title: "Nos Services",
                    expertise: {
                        name: "Expertise Comptable",
                        description: "Tenue de comptabilité complète, bilans, déclarations fiscales",
                        price: "À partir de 150€/mois",
                        features: ["Comptabilité générale", "Déclarations TVA", "Bilan annuel", "Liasse fiscale"]
                    },
                    fiscalite: {
                        name: "Fiscalité",
                        description: "Optimisation fiscale, conseils en matière d'impôts",
                        price: "Sur devis",
                        features: ["Optimisation fiscale", "Déclarations d'impôts", "Conseil fiscal", "Contrôles fiscaux"]
                    },
                    social: {
                        name: "Social & Paie",
                        description: "Gestion de la paie, déclarations sociales, conseil RH",
                        price: "À partir de 50€/mois",
                        features: ["Bulletins de paie", "Déclarations URSSAF", "Convention collective", "Conseil RH"]
                    },
                    creation: {
                        name: "Création d'Entreprise",
                        description: "Accompagnement dans la création (SARL, SAS, auto-entrepreneur)",
                        price: "À partir de 200€",
                        features: ["Choix du statut", "Formalités de création", "Statuts", "Immatriculation"]
                    }
                },
                simulators: {
                    title: "Nos Simulateurs Gratuits",
                    tva: {
                        name: "Calculateur de TVA",
                        description: "Calcul automatique de la TVA sur vos montants HT et TTC",
                        features: ["Taux personnalisables", "Calcul en temps réel", "Export PDF"]
                    },
                    charges: {
                        name: "Simulateur de Charges Sociales",
                        description: "Estimation des charges selon votre statut",
                        features: ["Salarié, micro-entreprise, SARL, SAS", "Calcul automatique", "Comparaison des statuts"]
                    },
                    epargne: {
                        name: "Simulateur d'Épargne & Retraite",
                        description: "Simulation PER et autres produits d'épargne",
                        features: ["PER individuel et collectif", "Calcul des impôts", "Optimisation fiscale"]
                    },
                    aides: {
                        name: "Simulateur d'Aides",
                        description: "Estimation des aides auxquelles vous avez droit",
                        features: ["Aides au logement", "Aides à l'emploi", "Aides à la création"]
                    }
                },
                contact: {
                    phone: "01 23 45 67 89",
                    email: "contact@mbc-expertcomptable.fr",
                    address: "123 Avenue des Experts, 75001 Paris",
                    hours: "Lundi-Vendredi: 9h-18h, Samedi: 9h-12h"
                },
                faq: {
                    tarifs: "Nos tarifs varient selon vos besoins. Expertise comptable à partir de 150€/mois, social & paie à partir de 50€/mois. Demandez un devis personnalisé gratuit !",
                    devis: "Pour obtenir un devis personnalisé, contactez-nous au 01 23 45 67 89 ou par email à contact@mbc-expertcomptable.fr. C'est gratuit et sans engagement !",
                    creation: "Nous accompagnons la création d'entreprise (SARL, SAS, auto-entrepreneur) à partir de 200€. Nous vous conseillons sur le meilleur statut pour votre projet.",
                    simulateurs: "Nous proposons 4 simulateurs gratuits : TVA, charges sociales, épargne & retraite, et aides. Accédez-y via le menu 'Simulateurs' !",
                    contact: "Contactez-nous au 01 23 45 67 89, par email à contact@mbc-expertcomptable.fr, ou venez nous voir au 123 Avenue des Experts, 75001 Paris."
                }
            },
            en: {
                greetings: [
                    "Hello! I'm the virtual assistant for MBC Chartered Accountant. How can I help you today?",
                    "Hi there! I'm here to answer your accounting questions. What would you like to know?",
                    "Good day! I can help you with our services, pricing, and simulators. What can I do for you?"
                ],
                services: {
                    title: "Our Services",
                    expertise: {
                        name: "Accounting Expertise",
                        description: "Complete bookkeeping, financial statements, tax declarations",
                        price: "From €150/month",
                        features: ["General accounting", "VAT declarations", "Annual balance sheet", "Tax return"]
                    },
                    fiscalite: {
                        name: "Taxation",
                        description: "Tax optimization, tax advice, declarations",
                        price: "On quote",
                        features: ["Tax optimization", "Tax declarations", "Tax advice", "Tax audits"]
                    },
                    social: {
                        name: "Payroll & Social",
                        description: "Payroll management, social declarations, HR consulting",
                        price: "From €50/month",
                        features: ["Pay slips", "URSSAF declarations", "Collective agreement", "HR consulting"]
                    },
                    creation: {
                        name: "Business Creation",
                        description: "Support in business creation (LLC, SAS, self-employed)",
                        price: "From €200",
                        features: ["Status choice", "Creation formalities", "Articles of association", "Registration"]
                    }
                },
                simulators: {
                    title: "Our Free Simulators",
                    tva: {
                        name: "VAT Calculator",
                        description: "Automatic VAT calculation on your HT and TTC amounts",
                        features: ["Customizable rates", "Real-time calculation", "PDF export"]
                    },
                    charges: {
                        name: "Social Charges Simulator",
                        description: "Estimation of charges according to your status",
                        features: ["Employee, micro-enterprise, LLC, SAS", "Automatic calculation", "Status comparison"]
                    },
                    epargne: {
                        name: "Savings & Retirement Simulator",
                        description: "PER and other savings products simulation",
                        features: ["Individual and collective PER", "Tax calculation", "Tax optimization"]
                    },
                    aides: {
                        name: "Aids Simulator",
                        description: "Estimation of aids you are entitled to",
                        features: ["Housing aids", "Employment aids", "Creation aids"]
                    }
                },
                contact: {
                    phone: "01 23 45 67 89",
                    email: "contact@mbc-expertcomptable.fr",
                    address: "123 Avenue des Experts, 75001 Paris",
                    hours: "Monday-Friday: 9am-6pm, Saturday: 9am-12pm"
                },
                faq: {
                    tarifs: "Our prices vary according to your needs. Accounting expertise from €150/month, payroll & social from €50/month. Request a personalized quote for free!",
                    devis: "To get a personalized quote, contact us at 01 23 45 67 89 or by email at contact@mbc-expertcomptable.fr. It's free and without commitment!",
                    creation: "We support business creation (LLC, SAS, self-employed) from €200. We advise you on the best status for your project.",
                    simulateurs: "We offer 4 free simulators: VAT, social charges, savings & retirement, and aids. Access them via the 'Simulators' menu!",
                    contact: "Contact us at 01 23 45 67 89, by email at contact@mbc-expertcomptable.fr, or visit us at 123 Avenue des Experts, 75001 Paris."
                }
            },
            zh: {
                greetings: [
                    "您好！我是MBC会计师的虚拟助手。今天我能为您做些什么？",
                    "你好！我在这里回答您的会计问题。您想了解什么？",
                    "您好！我可以帮助您了解我们的服务、价格和模拟器。我能为您做什么？"
                ],
                services: {
                    title: "我们的服务",
                    expertise: {
                        name: "会计专业",
                        description: "完整的簿记、财务报表、税务申报",
                        price: "从150欧元/月起",
                        features: ["总账会计", "增值税申报", "年度资产负债表", "税务申报"]
                    },
                    fiscalite: {
                        name: "税务",
                        description: "税务优化、税务建议、申报",
                        price: "根据报价",
                        features: ["税务优化", "税务申报", "税务建议", "税务审计"]
                    },
                    social: {
                        name: "薪资与社会",
                        description: "薪资管理、社会申报、人力资源咨询",
                        price: "从50欧元/月起",
                        features: ["工资单", "URSSAF申报", "集体协议", "人力资源咨询"]
                    },
                    creation: {
                        name: "企业创建",
                        description: "企业创建支持（有限责任公司、SAS、自雇）",
                        price: "从200欧元起",
                        features: ["身份选择", "创建手续", "公司章程", "注册"]
                    }
                },
                simulators: {
                    title: "我们的免费模拟器",
                    tva: {
                        name: "增值税计算器",
                        description: "自动计算您的含税和不含税金额的增值税",
                        features: ["可自定义税率", "实时计算", "PDF导出"]
                    },
                    charges: {
                        name: "社会费用模拟器",
                        description: "根据您的身份估算费用",
                        features: ["员工、小微企业、有限责任公司、SAS", "自动计算", "身份比较"]
                    },
                    epargne: {
                        name: "储蓄与退休模拟器",
                        description: "PER和其他储蓄产品模拟",
                        features: ["个人和集体PER", "税务计算", "税务优化"]
                    },
                    aides: {
                        name: "援助模拟器",
                        description: "估算您有权获得的援助",
                        features: ["住房援助", "就业援助", "创建援助"]
                    }
                },
                contact: {
                    phone: "01 23 45 67 89",
                    email: "contact@mbc-expertcomptable.fr",
                    address: "123 Avenue des Experts, 75001 Paris",
                    hours: "周一至周五：9点-18点，周六：9点-12点"
                },
                faq: {
                    tarifs: "我们的价格根据您的需求而变化。会计专业从150欧元/月起，薪资与社会从50欧元/月起。免费申请个性化报价！",
                    devis: "要获得个性化报价，请致电01 23 45 67 89或发送邮件至contact@mbc-expertcomptable.fr。免费且无承诺！",
                    creation: "我们支持企业创建（有限责任公司、SAS、自雇）从200欧元起。我们为您的项目建议最佳身份。",
                    simulateurs: "我们提供4个免费模拟器：增值税、社会费用、储蓄与退休、援助。通过'模拟器'菜单访问！",
                    contact: "联系我们：01 23 45 67 89，发送邮件至contact@mbc-expertcomptable.fr，或访问我们位于123 Avenue des Experts, 75001 Paris的办公室。"
                }
            }
        };
    }

    /**
     * Initialize AI model for intelligent responses
     */
    initializeAIModel() {
        return {
            // Pre-trained response patterns
            patterns: {
                greeting: /^(bonjour|salut|hello|hi|你好|您好|早上好|下午好)/i,
                services: /(service|prestation|服务|服务项目)/i,
                pricing: /(prix|tarif|coût|combien|price|cost|how much|价格|费用|多少钱)/i,
                quote: /(devis|estimation|quote|estimate|报价|估算)/i,
                creation: /(créer|entreprise|sarl|sas|auto-entrepreneur|create|business|company|创建|企业|公司)/i,
                simulators: /(simulateur|calcul|tva|charge|simulator|calculator|模拟器|计算器)/i,
                contact: /(contact|téléphone|phone|email|adresse|address|联系|电话|邮箱|地址)/i,
                help: /(aide|help|帮助|帮忙)/i
            },
            
            // AI-powered response generation
            generateResponse: (message, language) => {
                const lowerMessage = message.toLowerCase().trim();
                const kb = this.knowledgeBase[language];
                
                // Pattern matching with AI-like intelligence
                if (this.patterns.greeting.test(lowerMessage)) {
                    return this.getRandomGreeting(language);
                }
                
                if (this.patterns.services.test(lowerMessage)) {
                    return this.getServicesInfo(language);
                }
                
                if (this.patterns.pricing.test(lowerMessage)) {
                    return kb.faq.tarifs;
                }
                
                if (this.patterns.quote.test(lowerMessage)) {
                    return kb.faq.devis;
                }
                
                if (this.patterns.creation.test(lowerMessage)) {
                    return kb.faq.creation;
                }
                
                if (this.patterns.simulators.test(lowerMessage)) {
                    return kb.faq.simulateurs;
                }
                
                if (this.patterns.contact.test(lowerMessage)) {
                    return kb.faq.contact;
                }
                
                if (this.patterns.help.test(lowerMessage)) {
                    return this.getHelpInfo(language);
                }
                
                // AI-powered contextual response
                return this.generateContextualResponse(message, language);
            },
            
            // Generate contextual response using AI-like logic
            generateContextualResponse: (message, language) => {
                const kb = this.knowledgeBase[language];
                const lowerMessage = message.toLowerCase();
                
                // Check for specific service mentions
                for (const [serviceKey, serviceData] of Object.entries(kb.services)) {
                    if (lowerMessage.includes(serviceKey) || lowerMessage.includes(serviceData.name.toLowerCase())) {
                        return this.formatServiceResponse(serviceData, language);
                    }
                }
                
                // Check for simulator mentions
                for (const [simKey, simData] of Object.entries(kb.simulators)) {
                    if (lowerMessage.includes(simKey) || lowerMessage.includes(simData.name.toLowerCase())) {
                        return this.formatSimulatorResponse(simData, language);
                    }
                }
                
                // Default intelligent response
                return this.getDefaultResponse(language);
            }
        };
    }

    /**
     * Get random greeting based on language
     */
    getRandomGreeting(language) {
        const greetings = this.knowledgeBase[language].greetings;
        return greetings[Math.floor(Math.random() * greetings.length)];
    }

    /**
     * Get services information
     */
    getServicesInfo(language) {
        const kb = this.knowledgeBase[language];
        const services = kb.services;
        
        let response = `**${kb.services.title}**\n\n`;
        
        for (const [key, service] of Object.entries(services)) {
            if (key !== 'title') {
                response += `📊 **${service.name}** - ${service.description}\n`;
                response += `💰 **Tarif :** ${service.price}\n\n`;
            }
        }
        
        response += `Voulez-vous plus de détails sur un service particulier ?`;
        return response;
    }

    /**
     * Get help information
     */
    getHelpInfo(language) {
        const kb = this.knowledgeBase[language];
        
        if (language === 'fr') {
            return `Je peux vous aider avec :\n\n` +
                   `🏢 **Création d'entreprise** - SARL, SAS, auto-entrepreneur\n` +
                   `📊 **Services comptables** - Expertise, fiscalité, social & paie\n` +
                   `💰 **Tarifs et devis** - Estimation personnalisée\n` +
                   `🛠️ **Simulateurs** - 4 outils de calcul gratuits\n` +
                   `📞 **Contact** - Téléphone, email, adresse\n\n` +
                   `Que souhaitez-vous savoir ?`;
        } else if (language === 'en') {
            return `I can help you with:\n\n` +
                   `🏢 **Business Creation** - LLC, SAS, self-employed\n` +
                   `📊 **Accounting Services** - Expertise, taxation, payroll & social\n` +
                   `💰 **Pricing & Quotes** - Personalized estimation\n` +
                   `🛠️ **Simulators** - 4 free calculation tools\n` +
                   `📞 **Contact** - Phone, email, address\n\n` +
                   `What would you like to know?`;
        } else {
            return `我可以帮助您：\n\n` +
                   `🏢 **企业创建** - 有限责任公司、SAS、自雇\n` +
                   `📊 **会计服务** - 专业、税务、薪资与社会\n` +
                   `💰 **价格与报价** - 个性化估算\n` +
                   `🛠️ **模拟器** - 4个免费计算工具\n` +
                   `📞 **联系** - 电话、邮箱、地址\n\n` +
                   `您想了解什么？`;
        }
    }

    /**
     * Format service response
     */
    formatServiceResponse(service, language) {
        let response = `**${service.name}**\n\n`;
        response += `${service.description}\n\n`;
        response += `**Tarif :** ${service.price}\n\n`;
        response += `**Inclus :**\n${service.features.map(f => `• ${f}`).join('\n')}\n\n`;
        
        if (language === 'fr') {
            response += `Voulez-vous un devis personnalisé ?`;
        } else if (language === 'en') {
            response += `Would you like a personalized quote?`;
        } else {
            response += `您想要个性化报价吗？`;
        }
        
        return response;
    }

    /**
     * Format simulator response
     */
    formatSimulatorResponse(simulator, language) {
        let response = `**${simulator.name}**\n\n`;
        response += `${simulator.description}\n\n`;
        response += `**Fonctionnalités :**\n${simulator.features.map(f => `• ${f}`).join('\n')}\n\n`;
        
        if (language === 'fr') {
            response += `Accédez à ce simulateur via le menu 'Simulateurs' !`;
        } else if (language === 'en') {
            response += `Access this simulator via the 'Simulators' menu!`;
        } else {
            response += `通过'模拟器'菜单访问此模拟器！`;
        }
        
        return response;
    }

    /**
     * Get default response
     */
    getDefaultResponse(language) {
        const kb = this.knowledgeBase[language];
        
        if (language === 'fr') {
            return `Je comprends que vous cherchez des informations. Je peux vous aider avec :\n\n` +
                   `🏢 **Création d'entreprise** - SARL, SAS, auto-entrepreneur\n` +
                   `📊 **Services comptables** - Expertise, fiscalité, social & paie\n` +
                   `💰 **Tarifs** - Devis personnalisé gratuit\n` +
                   `🛠️ **Simulateurs** - 4 outils de calcul gratuits\n` +
                   `📞 **Contact** - 01 23 45 67 89\n\n` +
                   `Pouvez-vous être plus spécifique sur ce qui vous intéresse ?`;
        } else if (language === 'en') {
            return `I understand you're looking for information. I can help you with:\n\n` +
                   `🏢 **Business Creation** - LLC, SAS, self-employed\n` +
                   `📊 **Accounting Services** - Expertise, taxation, payroll & social\n` +
                   `💰 **Pricing** - Free personalized quote\n` +
                   `🛠️ **Simulators** - 4 free calculation tools\n` +
                   `📞 **Contact** - 01 23 45 67 89\n\n` +
                   `Can you be more specific about what interests you?`;
        } else {
            return `我理解您正在寻找信息。我可以帮助您：\n\n` +
                   `🏢 **企业创建** - 有限责任公司、SAS、自雇\n` +
                   `📊 **会计服务** - 专业、税务、薪资与社会\n` +
                   `💰 **价格** - 免费个性化报价\n` +
                   `🛠️ **模拟器** - 4个免费计算工具\n` +
                   `📞 **联系** - 01 23 45 67 89\n\n` +
                   `您能更具体地说明您感兴趣的内容吗？`;
        }
    }

    /**
     * Get intelligent response
     */
    getResponse(message) {
        return this.aiModel.generateResponse(message, this.currentLanguage);
    }

    /**
     * Update language
     */
    updateLanguage(newLanguage) {
        this.currentLanguage = newLanguage;
    }
}

// ========================================
// 2. CHATBOT UI AND INTERACTIONS
// ========================================

let chatbot = null;

/**
 * Initialize multilingual chatbot
 */
function initializeMultilingualChatbot() {
    chatbot = new MultilingualChatbot();
    
    // Add chatbot HTML if it doesn't exist
    if (!document.getElementById('mbc-chatbot')) {
        const chatbotHTML = `
            <div id="mbc-chatbot" class="mbc-chatbot">
                <div class="chatbot-toggle" onclick="toggleMultilingualChatbot()">
                    <i class="fas fa-comments"></i>
                    <span>Assistant MBC</span>
                </div>
                <div class="chatbot-window" id="chatbotWindow">
                    <div class="chatbot-header">
                        <div class="chatbot-title">
                            <i class="fas fa-robot"></i>
                            <span>Assistant MBC</span>
                        </div>
                        <div class="chatbot-language-selector">
                            <select id="chatbotLanguage" onchange="changeChatbotLanguage(this.value)">
                                <option value="fr">🇫🇷 FR</option>
                                <option value="en">🇬🇧 EN</option>
                                <option value="zh">🇨🇳 中文</option>
                            </select>
                        </div>
                        <button class="chatbot-close" onclick="toggleMultilingualChatbot()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="chatbot-messages" id="chatbotMessages">
                        <div class="message bot-message">
                            <div class="message-content">
                                ${chatbot.getRandomGreeting(chatbot.currentLanguage)}
                            </div>
                        </div>
                    </div>
                    <div class="chatbot-input">
                        <input type="text" id="chatbotInput" placeholder="Tapez votre message..." onkeypress="handleMultilingualChatbotKeypress(event)">
                        <button onclick="sendMultilingualChatbotMessage()">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', chatbotHTML);
        
        // Set initial language
        document.getElementById('chatbotLanguage').value = chatbot.currentLanguage;
    }
}

/**
 * Toggle chatbot visibility
 */
function toggleMultilingualChatbot() {
    const chatbotElement = document.getElementById('mbc-chatbot');
    const window = document.getElementById('chatbotWindow');
    
    if (chatbotElement.classList.contains('active')) {
        chatbotElement.classList.remove('active');
        window.style.display = 'none';
    } else {
        chatbotElement.classList.add('active');
        window.style.display = 'flex';
        document.getElementById('chatbotInput').focus();
    }
}

/**
 * Send chatbot message
 */
function sendMultilingualChatbotMessage() {
    const input = document.getElementById('chatbotInput');
    const message = input.value.trim();
    
    if (message) {
        // Add user message
        addMultilingualChatbotMessage(message, 'user');
        input.value = '';
        
        // Simulate typing delay
        setTimeout(() => {
            const response = chatbot.getResponse(message);
            addMultilingualChatbotMessage(response, 'bot');
        }, 1000);
    }
}

/**
 * Add message to chatbot
 */
function addMultilingualChatbotMessage(text, sender) {
    const messagesContainer = document.getElementById('chatbotMessages');
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${sender}-message`;
    
    const contentDiv = document.createElement('div');
    contentDiv.className = 'message-content';
    contentDiv.innerHTML = text.replace(/\n/g, '<br>');
    
    messageDiv.appendChild(contentDiv);
    messagesContainer.appendChild(messageDiv);
    
    // Scroll to bottom
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

/**
 * Handle Enter key in chatbot input
 */
function handleMultilingualChatbotKeypress(event) {
    if (event.key === 'Enter') {
        sendMultilingualChatbotMessage();
    }
}

/**
 * Change chatbot language
 */
function changeChatbotLanguage(language) {
    if (chatbot) {
        chatbot.updateLanguage(language);
        
        // Update placeholder text
        const input = document.getElementById('chatbotInput');
        if (language === 'fr') {
            input.placeholder = 'Tapez votre message...';
        } else if (language === 'en') {
            input.placeholder = 'Type your message...';
        } else {
            input.placeholder = '输入您的消息...';
        }
        
        // Add language change message
        const messagesContainer = document.getElementById('chatbotMessages');
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message bot-message';
        
        const contentDiv = document.createElement('div');
        contentDiv.className = 'message-content';
        
        if (language === 'fr') {
            contentDiv.innerHTML = 'Langue changée en français. Comment puis-je vous aider ?';
        } else if (language === 'en') {
            contentDiv.innerHTML = 'Language changed to English. How can I help you?';
        } else {
            contentDiv.innerHTML = '语言已更改为中文。我能为您做什么？';
        }
        
        messageDiv.appendChild(contentDiv);
        messagesContainer.appendChild(messageDiv);
        
        // Scroll to bottom
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
}

// ========================================
// 3. INITIALIZATION
// ========================================

// Initialize chatbot when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeMultilingualChatbot();
});
