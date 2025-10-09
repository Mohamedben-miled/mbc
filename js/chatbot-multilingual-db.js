/**
 * Multilingual Chatbot with Database Integration
 * Advanced AI-powered chatbot for MBC Expert Comptable
 */
class MultilingualChatbotDB {
    constructor() {
        this.currentLanguage = this.detectLanguage();
        this.knowledgeBase = this.initializeKnowledgeBase();
        this.aiModel = this.initializeAIModel();
        this.initializeChatbotUI();
        this.loadChatbotMessages();
        this.addEventListeners();
    }

    /**
     * Detect user's language preference
     */
    detectLanguage() {
        // Check URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const langParam = urlParams.get('lang');
        if (langParam && ['fr', 'en', 'zh'].includes(langParam)) {
            return langParam;
        }

        // Check localStorage
        const storedLang = localStorage.getItem('mbc_chatbot_language');
        if (storedLang && ['fr', 'en', 'zh'].includes(storedLang)) {
            return storedLang;
        }

        // Check browser language
        const browserLang = navigator.language || navigator.userLanguage;
        if (browserLang.startsWith('zh')) return 'zh';
        if (browserLang.startsWith('en')) return 'en';
        
        // Default to French
        return 'fr';
    }

    /**
     * Initialize knowledge base with static data
     */
    initializeKnowledgeBase() {
        return {
            fr: {
                company: {
                    name: "MBC Expert Comptable",
                    description: "Cabinet d'expertise comptable spécialisé dans l'accompagnement des entreprises et des entrepreneurs",
                    services: ["Expertise comptable complète", "Fiscalité et optimisation fiscale", "Social & Paie", "Conseil en gestion", "Création d'entreprise", "Formalités juridiques"],
                    contact: { phone: "01 23 45 67 89", email: "contact@mbc-expert.fr", address: "123 Avenue des Experts, 75001 Paris" }
                },
                chatbot_messages: {
                    welcome: "Bonjour ! Je suis l'assistant virtuel de MBC Expert Comptable. Comment puis-je vous aider aujourd'hui ?",
                    greeting_response: (companyName) => `Bonjour ! Je suis l'assistant virtuel de ${companyName}. Je peux vous aider avec nos services, tarifs, simulateurs ou toute question comptable. Que puis-je faire pour vous ?`,
                    help_response: `Je peux vous aider avec :\n\n🏢 **Création d'entreprise** - SARL, SAS, auto-entrepreneur\n📊 **Services comptables** - Expertise, fiscalité, social & paie\n💰 **Tarifs et devis** - Estimation personnalisée\n🛠️ **Simulateurs** - 4 outils de calcul gratuits\n📞 **Contact** - Téléphone, email, adresse\n\nQue souhaitez-vous savoir ?`,
                    default_response: `Je comprends que vous cherchez des informations. Je peux vous aider avec :\n\n🏢 **Création d'entreprise** - SARL, SAS, auto-entrepreneur\n📊 **Services comptables** - Expertise, fiscalité, social & paie\n💰 **Tarifs** - Devis personnalisé gratuit\n🛠️ **Simulateurs** - 4 outils de calcul gratuits\n📞 **Contact** - 01 23 45 67 89\n\nPouvez-vous être plus spécifique sur ce qui vous intéresse ?`,
                    input_placeholder: "Tapez votre message...",
                    assistant_name: "Assistant MBC"
                }
            },
            en: {
                company: {
                    name: "MBC Chartered Accountant",
                    description: "Chartered accounting firm specializing in supporting businesses and entrepreneurs",
                    services: ["Full accounting expertise", "Taxation and tax optimization", "Social & Payroll", "Management consulting", "Business creation", "Legal formalities"],
                    contact: { phone: "01 23 45 67 89", email: "contact@mbc-expert.fr", address: "123 Experts Avenue, 75001 Paris" }
                },
                chatbot_messages: {
                    welcome: "Hello! I am the virtual assistant of MBC Chartered Accountant. How can I help you today?",
                    greeting_response: (companyName) => `Hello! I am the virtual assistant of ${companyName}. I can help you with our services, prices, simulators or any accounting question. What can I do for you?`,
                    help_response: `I can help you with:\n\n🏢 **Business Creation** - SARL, SAS, sole proprietorship\n📊 **Accounting Services** - Expertise, taxation, social & payroll\n💰 **Prices and quotes** - Personalized estimate\n🛠️ **Simulators** - 4 free calculation tools\n📞 **Contact** - Phone, email, address\n\nWhat would you like to know?`,
                    default_response: `I understand you are looking for information. I can help you with:\n\n🏢 **Business Creation** - SARL, SAS, sole proprietorship\n📊 **Accounting Services** - Expertise, taxation, social & payroll\n💰 **Prices** - Free personalized quote\n🛠️ **Simulators** - 4 free calculation tools\n📞 **Contact** - 01 23 45 67 89\n\nCan you be more specific about what interests you?`,
                    input_placeholder: "Type your message...",
                    assistant_name: "MBC Assistant"
                }
            },
            zh: {
                company: {
                    name: "MBC 会计师事务所",
                    description: "专业为企业和企业家提供支持的会计师事务所",
                    services: ["全面会计专业知识", "税务和税务优化", "社保与薪资", "管理咨询", "企业创建", "法律手续"],
                    contact: { phone: "01 23 45 67 89", email: "contact@mbc-expert.fr", address: "巴黎专家大道123号, 75001" }
                },
                chatbot_messages: {
                    welcome: "您好！我是MBC会计师事务所的虚拟助手。今天我能为您提供什么帮助？",
                    greeting_response: (companyName) => `您好！我是${companyName}的虚拟助手。我可以帮助您了解我们的服务、价格、模拟器或任何会计问题。我能为您做些什么？`,
                    help_response: `我能为您提供以下帮助：\n\n🏢 **企业创建** - SARL、SAS、独资企业\n📊 **会计服务** - 专业知识、税务、社保与薪资\n💰 **价格和报价** - 个性化估算\n🛠️ **模拟器** - 4个免费计算工具\n📞 **联系方式** - 电话、电子邮件、地址\n\n您想了解什么？`,
                    default_response: `我理解您正在寻找信息。我能为您提供以下帮助：\n\n🏢 **企业创建** - SARL、SAS、独资企业\n📊 **会计服务** - 专业知识、税务、社保与薪资\n💰 **价格** - 免费个性化报价\n🛠️ **模拟器** - 4个免费计算工具\n📞 **联系方式** - 01 23 45 67 89\n\n您能更具体地说明您感兴趣的内容吗？`,
                    input_placeholder: "输入您的消息...",
                    assistant_name: "MBC助手"
                }
            }
        };
    }

    /**
     * Initialize AI model for intelligent responses
     */
    initializeAIModel() {
        return {
            patterns: {
                greeting: { fr: /^(bonjour|salut|hello|hi)/i, en: /^(hello|hi|good morning|good afternoon)/i, zh: /^(你好|您好)/i },
                services: { fr: /(service|prestation)/i, en: /(service|offerings)/i, zh: /(服务|服务项目)/i },
                pricing: { fr: /(prix|tarif|coût|combien)/i, en: /(price|cost|how much)/i, zh: /(价格|费用|多少钱)/i },
                quote: { fr: /(devis|estimation)/i, en: /(quote|estimate)/i, zh: /(报价|估算)/i },
                creation: { fr: /(créer|entreprise|sarl|sas)/i, en: /(create|business|company|sarl|sas)/i, zh: /(创建|企业|公司)/i },
                simulators: { fr: /(simulateur|calcul|tva|charge)/i, en: /(simulator|calculate|vat|charge)/i, zh: /(模拟器|计算|增值税|费用)/i },
                contact: { fr: /(contact|téléphone|email|adresse)/i, en: /(contact|phone|email|address)/i, zh: /(联系|电话|电子邮件|地址)/i },
                help: { fr: /(aide|help|\?)/i, en: /(help|\?)/i, zh: /(帮助|疑问)/i }
            },
            generateResponse: async (message, language) => {
                const lowerMessage = message.toLowerCase().trim();
                const kb = this.knowledgeBase[language];
                const patterns = this.aiModel.patterns;

                // First, try to find a match in the database
                try {
                    const response = await this.searchDatabaseQA(message, language);
                    if (response) {
                        return response;
                    }
                } catch (error) {
                    console.log('Database search failed, using fallback:', error);
                }

                // Fallback to pattern matching
                if (patterns.greeting[language].test(lowerMessage)) {
                    return kb.chatbot_messages.greeting_response(kb.company.name);
                }
                if (patterns.services[language].test(lowerMessage)) {
                    return kb.chatbot_messages.help_response;
                }
                if (patterns.pricing[language].test(lowerMessage)) {
                    return "Nos tarifs varient selon vos besoins. Expertise comptable à partir de 150€/mois, social & paie à partir de 50€/mois. Demandez un devis personnalisé gratuit !";
                }
                if (patterns.quote[language].test(lowerMessage)) {
                    return "Pour obtenir un devis personnalisé, contactez-nous au 01 23 45 67 89 ou par email à contact@mbc-expert.fr. C'est gratuit et sans engagement !";
                }
                if (patterns.creation[language].test(lowerMessage)) {
                    return "Nous accompagnons la création d'entreprise (SARL, SAS, auto-entrepreneur) à partir de 200€. Nous vous conseillons sur le meilleur statut pour votre projet.";
                }
                if (patterns.simulators[language].test(lowerMessage)) {
                    return "Nous proposons 4 simulateurs gratuits : TVA, charges sociales, épargne & retraite, et aides. Accédez-y via le menu 'Simulateurs' !";
                }
                if (patterns.contact[language].test(lowerMessage)) {
                    return "Contactez-nous au 01 23 45 67 89, par email à contact@mbc-expert.fr, ou venez nous voir au 123 Avenue des Experts, 75001 Paris.";
                }
                if (patterns.help[language].test(lowerMessage)) {
                    return kb.chatbot_messages.help_response;
                }
                return kb.chatbot_messages.default_response;
            }
        };
    }

    /**
     * Search for Q&A in database
     */
    async searchDatabaseQA(message, language) {
        try {
            const response = await fetch('api/chatbot-search.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    message: message,
                    language: language
                })
            });

            if (response.ok) {
                const data = await response.json();
                return data.answer;
            }
        } catch (error) {
            console.log('Database search error:', error);
        }
        return null;
    }

    /**
     * Initialize chatbot UI
     */
    initializeChatbotUI() {
        // Check if chatbot already exists to prevent duplicates
        if (document.getElementById('mbc-chatbot')) {
            return;
        }
        
        const chatbotHTML = `
            <div id="mbc-chatbot" class="mbc-chatbot">
                <div class="chatbot-toggle" onclick="window.multilingualChatbotDB.toggleChatbot()">
                    <i class="fas fa-comments"></i>
                    <span>${this.knowledgeBase[this.currentLanguage].chatbot_messages.assistant_name}</span>
                </div>
                <div class="chatbot-window" id="chatbotWindow">
                    <div class="chatbot-header">
                        <div class="chatbot-title">
                            <i class="fas fa-robot"></i>
                            <span>${this.knowledgeBase[this.currentLanguage].chatbot_messages.assistant_name}</span>
                        </div>
                        <div class="chatbot-language-selector">
                            <select id="chatbotLanguage" onchange="window.multilingualChatbotDB.changeLanguage(this.value)">
                                <option value="fr" ${this.currentLanguage === 'fr' ? 'selected' : ''}>🇫🇷 FR</option>
                                <option value="en" ${this.currentLanguage === 'en' ? 'selected' : ''}>🇬🇧 EN</option>
                                <option value="zh" ${this.currentLanguage === 'zh' ? 'selected' : ''}>🇨🇳 中文</option>
                            </select>
                        </div>
                        <button class="chatbot-close" onclick="window.multilingualChatbotDB.toggleChatbot()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="chatbot-messages" id="chatbotMessages">
                        <div class="message bot-message">
                            <div class="message-content">
                                ${this.knowledgeBase[this.currentLanguage].chatbot_messages.welcome}
                            </div>
                        </div>
                    </div>
                    <div class="chatbot-input">
                        <input type="text" id="chatbotInput" placeholder="${this.knowledgeBase[this.currentLanguage].chatbot_messages.input_placeholder}" onkeypress="window.multilingualChatbotDB.handleKeypress(event)">
                        <button onclick="window.multilingualChatbotDB.sendMessage()">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', chatbotHTML);
    }

    /**
     * Load chatbot messages
     */
    loadChatbotMessages() {
        const messagesContainer = document.getElementById('chatbotMessages');
        messagesContainer.innerHTML = '';
        this.addMessage(this.knowledgeBase[this.currentLanguage].chatbot_messages.welcome, 'bot');
    }

    /**
     * Add event listeners
     */
    addEventListeners() {
        // Event listeners for toggle, send, keypress are handled by inline onclick and onkeypress
    }

    /**
     * Toggle chatbot visibility
     */
    toggleChatbot() {
        const chatbot = document.getElementById('mbc-chatbot');
        const window = document.getElementById('chatbotWindow');

        if (chatbot.classList.contains('active')) {
            chatbot.classList.remove('active');
            window.style.display = 'none';
        } else {
            chatbot.classList.add('active');
            window.style.display = 'flex';
            document.getElementById('chatbotInput').focus();
        }
    }

    /**
     * Send message
     */
    async sendMessage() {
        const input = document.getElementById('chatbotInput');
        const message = input.value.trim();

        if (message) {
            this.addMessage(message, 'user');
            input.value = '';

            // Show typing indicator
            this.addTypingIndicator();

            setTimeout(async () => {
                try {
                    const response = await this.aiModel.generateResponse(message, this.currentLanguage);
                    this.removeTypingIndicator();
                    this.addMessage(response, 'bot');
                } catch (error) {
                    this.removeTypingIndicator();
                    this.addMessage(this.knowledgeBase[this.currentLanguage].chatbot_messages.default_response, 'bot');
                }
            }, 1000);
        }
    }

    /**
     * Add message to chat
     */
    addMessage(text, sender) {
        const messagesContainer = document.getElementById('chatbotMessages');
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}-message`;

        const contentDiv = document.createElement('div');
        contentDiv.className = 'message-content';
        contentDiv.innerHTML = text.replace(/\n/g, '<br>');

        messageDiv.appendChild(contentDiv);
        messagesContainer.appendChild(messageDiv);

        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    /**
     * Add typing indicator
     */
    addTypingIndicator() {
        const messagesContainer = document.getElementById('chatbotMessages');
        const typingDiv = document.createElement('div');
        typingDiv.className = 'message bot-message typing-indicator';
        typingDiv.id = 'typingIndicator';
        typingDiv.innerHTML = `
            <div class="message-content">
                <div class="typing-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        `;
        messagesContainer.appendChild(typingDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    /**
     * Remove typing indicator
     */
    removeTypingIndicator() {
        const typingIndicator = document.getElementById('typingIndicator');
        if (typingIndicator) {
            typingIndicator.remove();
        }
    }

    /**
     * Handle keypress events
     */
    handleKeypress(event) {
        if (event.key === 'Enter') {
            this.sendMessage();
        }
    }

    /**
     * Change language
     */
    changeLanguage(lang) {
        this.currentLanguage = lang;
        localStorage.setItem('mbc_chatbot_language', lang);
        
        // Update UI elements
        document.querySelector('.chatbot-toggle span').textContent = this.knowledgeBase[this.currentLanguage].chatbot_messages.assistant_name;
        document.querySelector('.chatbot-title span').textContent = this.knowledgeBase[this.currentLanguage].chatbot_messages.assistant_name;
        document.getElementById('chatbotInput').placeholder = this.knowledgeBase[this.currentLanguage].chatbot_messages.input_placeholder;
        
        // Reload welcome message
        this.loadChatbotMessages();
    }
}

// Initialize chatbot when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.multilingualChatbotDB = new MultilingualChatbotDB();
});
