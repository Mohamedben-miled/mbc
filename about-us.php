<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/translations.php';

$auth = new Auth();

$pageTitle = __("nav.about_us") . " - MBC Expert Comptable";
$pageDescription = "MB Consulting est un cabinet d'expertise comptable spécialisé dans l'externalisation de la comptabilité et paie Française implanté à Nice et Tunis.";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="<?php echo $pageDescription; ?>">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="assets/mbc.png">
</head>
<body class="about-us-page">
    <!-- Header -->
    <header class="header" role="banner">
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <div class="logo">
                    <a href="index.php#accueil" aria-label="MBC Expert Comptable - Retour à l'accueil">
                        <img src="assets/mbc.png" alt="MBC Expert Comptable" loading="eager" class="logo-img">
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="nav" role="navigation" aria-label="<?php echo __('nav.main_navigation'); ?>">
                    <ul class="nav-list">
                        <li><a href="index.php#accueil" class="nav-link"><?php echo __('nav.home'); ?></a></li>
                        <li><a href="mbc.php" class="nav-link"><?php echo __('nav.about'); ?></a></li>
                        <li><a href="about-us.php" class="nav-link active" aria-current="page"><?php echo __('nav.about_us'); ?></a></li>
                        <li><a href="services.php" class="nav-link"><?php echo __('nav.services'); ?></a></li>
                        <li><a href="#simulators" class="nav-link" onclick="openSimulatorsModal()"><?php echo __('nav.simulators'); ?></a></li>
                        <li><a href="blog-dynamic.php" class="nav-link"><?php echo __('nav.blog'); ?></a></li>
                        <li><a href="contact-form.php" class="nav-link"><?php echo __('nav.contact'); ?></a></li>
                    </ul>
                </nav>

                <!-- Header Utils -->
                <div class="header-utils">
                    <!-- Search Button -->
                    <button class="search-btn-header" onclick="openSearchModal()" aria-label="Rechercher">
                        <i class="fas fa-search"></i>
                    </button>
                    
                    <select class="language-selector" aria-label="<?php echo __('nav.select_language'); ?>" onchange="changeLanguage(this.value)">
                        <option value="fr" <?php echo getCurrentLanguage() === 'fr' ? 'selected' : ''; ?>>FR</option>
                        <option value="en" <?php echo getCurrentLanguage() === 'en' ? 'selected' : ''; ?>>EN</option>
                        <option value="zh" <?php echo getCurrentLanguage() === 'zh' ? 'selected' : ''; ?>>中文</option>
                    </select>
                    
                    <!-- Authentication Section Removed -->
                    
                    <button class="mobile-menu-toggle" aria-label="<?php echo __('btn.open_mobile_menu'); ?>">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation -->
    <div class="mobile-nav" id="mobileNav">
        <div class="mobile-nav-content">
            <button class="mobile-nav-close" aria-label="<?php echo __('common.close_menu'); ?>">
                <i class="fas fa-times"></i>
            </button>
            <ul class="mobile-nav-list">
                <li><a href="index.php#accueil" class="mobile-nav-link"><?php echo __('nav.home'); ?></a></li>
                <li><a href="mbc.php" class="mobile-nav-link"><?php echo __('nav.about'); ?></a></li>
                <li><a href="about-us.php" class="mobile-nav-link active"><?php echo __('nav.about_us'); ?></a></li>
                <li><a href="services.php" class="mobile-nav-link"><?php echo __('nav.services'); ?></a></li>
                <li><a href="#simulators" class="mobile-nav-link" onclick="openSimulatorsModal(); return false;"><?php echo __('nav.simulators'); ?></a></li>
                <li><a href="blog-dynamic.php" class="mobile-nav-link"><?php echo __('nav.blog'); ?></a></li>
                <li><a href="contact-form.php" class="mobile-nav-link"><?php echo __('nav.contact'); ?></a></li>
            </ul>
            
            <!-- Mobile Auth Section Removed -->
        </div>
    </div>

    <!-- Main Content -->
    <main role="main">
        <!-- Hero Section -->
        <section class="about-us-hero">
            <div class="container">
                <div class="about-us-hero-content">
                    <h1 class="about-us-title">OFFRE DE SERVICE D'EXTERNALISATION DE LA<br>COMPTABILITÉ ET PAIE FRANÇAISE EN TUNISIE</h1>
                    <p class="about-us-intro">MB Consulting est un cabinet d'expertise comptable spécialisé dans l'externalisation de la comptabilité et paie Française implanté à Nice et Tunis.</p>
                </div>
            </div>
        </section>

        <!-- Atouts Section -->
        <section class="about-us-section atouts-section">
            <div class="container">
                <h2 class="section-title">Atouts</h2>
                <div class="atouts-grid">
                    <div class="atout-item">
                        <i class="fas fa-user-check"></i>
                        <p>Supervision et vérification des travaux par un Expert-comptable</p>
                    </div>
                    <div class="atout-item">
                        <i class="fas fa-check-circle"></i>
                        <p>Conformité avec les normes comptables et dispositions fiscales et juridiques Françaises et Normes internationales (IFRS)</p>
                    </div>
                    <div class="atout-item">
                        <i class="fas fa-shield-alt"></i>
                        <p>Respects des normes établies par le Conseil Supérieur de l'Ordre des Experts Comptables</p>
                    </div>
                    <div class="atout-item">
                        <i class="fas fa-lock"></i>
                        <p>Absence d'exercice illégal (ou couverture)<br>Vigilance TRACFIN</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Logiciels Section -->
        <section class="about-us-section logiciels-section">
            <div class="container">
                <h2 class="section-title">Logiciels maîtrisés*</h2>
                <div class="logiciels-grid">
                    <div class="logiciel-group">
                        <h3>Comptabilité</h3>
                        <div class="logiciel-tags">
                            <span class="logiciel-tag">Sage</span>
                            <span class="logiciel-tag">Cegid</span>
                            <span class="logiciel-tag">Quadra</span>
                            <span class="logiciel-tag">Ciel</span>
                        </div>
                    </div>
                    <div class="logiciel-group">
                        <h3>Paie</h3>
                        <div class="logiciel-tags">
                            <span class="logiciel-tag">Silae RH</span>
                        </div>
                    </div>
                    <div class="logiciel-group">
                        <h3>Autres plateformes en ligne</h3>
                        <div class="logiciel-tags">
                            <span class="logiciel-tag">macompta.fr</span>
                            <span class="logiciel-tag">Téogest</span>
                            <span class="logiciel-tag">Exact</span>
                        </div>
                    </div>
                </div>
                <p class="logiciel-note">*Version en ligne</p>
            </div>
        </section>

        <!-- Contact Info Section -->
        <section class="about-us-section contact-info-section">
            <div class="container">
                <div class="contact-card">
                    <div class="contact-header">
                        <div class="contact-avatar">
                            <img src="assets/Majdi.png" alt="Majdi BESBES" onerror="this.style.display='none'">
                        </div>
                        <div class="contact-name-title">
                            <h2>Majdi BESBES</h2>
                            <p class="contact-title">Expert-comptable</p>
                        </div>
                    </div>
                    <div class="contact-credentials">
                        <p><i class="fas fa-certificate"></i> Membre de l'Ordre des Experts Comptables de France - Conseil Régional PACA</p>
                        <p><i class="fas fa-certificate"></i> Membre de l'Ordre des Experts Comptables de Tunisie</p>
                    </div>
                    <div class="contact-details">
                        <div class="contact-detail-item">
                            <i class="fas fa-globe"></i>
                            <span>www.mbconsulting.tn</span>
                        </div>
                        <div class="contact-detail-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>26 Chemin de l'Arieta, 06200 Nice</span>
                        </div>
                        <div class="contact-detail-item">
                            <i class="fas fa-mobile-alt"></i>
                            <span>+33 6 76 57 00 97</span>
                        </div>
                        <div class="contact-detail-item">
                            <i class="fas fa-phone"></i>
                            <span>+33 4 22 13 84 47</span>
                        </div>
                        <div class="contact-detail-item">
                            <i class="fab fa-linkedin"></i>
                            <span>Majdi Besbes</span>
                        </div>
                        <div class="contact-detail-item">
                            <i class="fas fa-envelope"></i>
                            <span>majdi.besbes@gmail.com</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="about-us-section services-section">
            <div class="container">
                <h2 class="section-title-large">OFFRES FLEXIBLES, MODULABLES ET À LA CARTE :<br>À VOUS DE CHOISIR !</h2>
                <div class="services-grid-two">
                    <div class="service-card">
                        <h3>Prestations de comptabilité</h3>
                        <ul class="service-list">
                            <li><i class="fas fa-circle"></i> Extraction des données</li>
                            <li><i class="fas fa-circle"></i> Tenue et justification</li>
                            <li><i class="fas fa-circle"></i> Préparation des liasses</li>
                            <li><i class="fas fa-circle"></i> Télédéclarations</li>
                            <li><i class="fas fa-circle"></i> Révision</li>
                            <li><i class="fas fa-circle"></i> Présentation</li>
                            <li><i class="fas fa-circle"></i> Contrôle qualité</li>
                            <li><i class="fas fa-circle"></i> Questionnaire TRACFIN</li>
                            <li><i class="fas fa-circle"></i> Clôture et PV annuels</li>
                        </ul>
                    </div>
                    <div class="service-card">
                        <h3>Prestations de paie</h3>
                        <ul class="service-list">
                            <li><i class="fas fa-circle"></i> Contacts avec les organismes sociaux</li>
                            <li><i class="fas fa-circle"></i> Gestion des contrats et des ruptures</li>
                            <li><i class="fas fa-circle"></i> Calcul de la Paie / STC</li>
                            <li><i class="fas fa-circle"></i> Gestion des congés, accidents de travail</li>
                            <li><i class="fas fa-circle"></i> Envoi des Bulletins avec votre adresse électronique</li>
                            <li><i class="fas fa-circle"></i> Télédéclarations</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Process Section -->
        <section class="about-us-section process-section">
            <div class="container">
                <h2 class="section-title">Processus</h2>
                <div class="process-flow">
                    <div class="process-step">
                        <div class="process-number">1</div>
                        <div class="process-content">
                            <h3>Signature</h3>
                            <ul>
                                <li>Signature du contrat d'externalisation</li>
                                <li>Affectation des dossiers et prise en compte des lettres de missions</li>
                                <li>Affectation d'un Chef de mission (interlocuteur unique)</li>
                                <li>Mise en place de l'équipe et gestion des accès aux plateformes en lignes</li>
                                <li>Compréhension des enjeux de la mission et fixation du risque TRACFIN</li>
                            </ul>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="process-number">2</div>
                        <div class="process-content">
                            <h3>Réalisation</h3>
                            <ul>
                                <li>Traitements (comptabilité, paie, liasses)</li>
                                <li>Justification, révision, contrôle qualité / TRACFIN</li>
                                <li>Sauvegarde finale / GED / Traçabilité</li>
                            </ul>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="process-number">3</div>
                        <div class="process-content">
                            <h3>Livraison</h3>
                            <ul>
                                <li>Envoi des livrables mensuels:</li>
                                <li>• 07 Jours ouvrables pour la tenue de comptabilité et liasses. Ce délai peut être révisé en fonction du volume de travail</li>
                                <li>• 05 Jours ouvrables pour la paie</li>
                                <li>Envoi des livrables annuels:</li>
                                <li>• Toujours avec respect des délais et en concertation mutuelle</li>
                                <li>• En tenant compte des RDV clients</li>
                            </ul>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="process-number">4</div>
                        <div class="process-content">
                            <h3>Planification</h3>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="process-number">5</div>
                        <div class="process-content">
                            <h3>Clôture</h3>
                            <ul>
                                <li>Mémo final et clôture d'exercice</li>
                                <li>Revue du process et évaluation</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Engagements & Benefits Section -->
        <section class="about-us-section engagements-section">
            <div class="container">
                <div class="two-columns">
                    <div class="column">
                        <h2 class="section-title">NOS ENGAGEMENTS</h2>
                        <ul class="commitment-list">
                            <li><i class="fas fa-check"></i> Respects des délais</li>
                            <li><i class="fas fa-check"></i> Maîtrise des coûts et transparence</li>
                            <li><i class="fas fa-check"></i> Sécurité des données et confidentialité</li>
                            <li><i class="fas fa-check"></i> Fiabilité et réactivité</li>
                            <li><i class="fas fa-check"></i> Flexibilité et adaptabilité</li>
                            <li><i class="fas fa-check"></i> Evaluation continue</li>
                            <li><i class="fas fa-check"></i> Respect des règles de déontologie en cours et à la fin de notre relation</li>
                        </ul>
                    </div>
                    <div class="column">
                        <h2 class="section-title">VOS BÉNÉFICES</h2>
                        <ul class="benefit-list">
                            <li><i class="fas fa-check"></i> Réduction significative des coûts de production</li>
                            <li><i class="fas fa-check"></i> Elimination des coûts d'investissements</li>
                            <li><i class="fas fa-check"></i> Allégement de votre charge de travail</li>
                            <li><i class="fas fa-check"></i> Flexibilité pendant les périodes de pic</li>
                            <li><i class="fas fa-check"></i> Collaborateurs qualifiés / Plus de soucis de recrutement / Equipe stable</li>
                            <li><i class="fas fa-check"></i> Absence des risques de non-conformité</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Secteurs & Avantages Section -->
        <section class="about-us-section secteurs-section">
            <div class="container">
                <div class="two-columns">
                    <div class="column">
                        <h2 class="section-title">SECTEURS</h2>
                        <ul class="secteur-list">
                            <li><i class="fas fa-circle"></i> BNC</li>
                            <li><i class="fas fa-circle"></i> Bâtiment – Immobilier</li>
                            <li><i class="fas fa-circle"></i> Services – Technologie et Informatique</li>
                            <li><i class="fas fa-circle"></i> Commerce – Industrie</li>
                            <li><i class="fas fa-circle"></i> Restauration et hôtellerie</li>
                            <li><i class="fas fa-circle"></i> Santé – Education</li>
                            <li><i class="fas fa-circle"></i> Transport et logistique</li>
                            <li><i class="fas fa-circle"></i> ONG</li>
                        </ul>
                    </div>
                    <div class="column">
                        <h2 class="section-title">AVANTAGES TUNISIE</h2>
                        <ul class="avantage-list">
                            <li><i class="fas fa-check"></i> Même fuseau horaire et proximité</li>
                            <li><i class="fas fa-check"></i> Régime 40h</li>
                            <li><i class="fas fa-check"></i> Francophone</li>
                            <li><i class="fas fa-check"></i> Niveau d'éducation élevé dans d'innombrables domaines (comptabilité, médecine, informatique…etc)</li>
                            <li><i class="fas fa-check"></i> Coûts compétitifs et réduits</li>
                            <li><i class="fas fa-check"></i> Infrastructure technologique solide</li>
                            <li><i class="fas fa-check"></i> Conformité pays au normes internationales (IFRS, ISA)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Organisation Section -->
        <section class="about-us-section organisation-section">
            <div class="container">
                <h2 class="section-title">ORGANISATION DES CABINETS</h2>
                <div class="organisation-grid">
                    <div class="cabinet-card">
                        <h3>CABINET DE NICE</h3>
                        <ul>
                            <li><i class="fas fa-check"></i> Signature de la convention d'externalisation</li>
                            <li><i class="fas fa-check"></i> Coordination - Supervision</li>
                            <li><i class="fas fa-check"></i> Liasses – Télédéclarations - Contacts avec les organismes sociaux</li>
                            <li><i class="fas fa-check"></i> Révision - Présentation</li>
                            <li><i class="fas fa-check"></i> Qualité – Trafin • Sauvegardes et Clôture</li>
                        </ul>
                    </div>
                    <div class="cabinet-card">
                        <h3>CABINET DE TUNIS</h3>
                        <ul>
                            <li><i class="fas fa-check"></i> Production (Compta. et Paie)</li>
                        </ul>
                    </div>
                </div>
                <div class="infrastructure-card">
                    <h3>INFRASTRUCTURE</h3>
                    <ul>
                        <li><i class="fas fa-check"></i> 100% dématérialisée</li>
                        <li><i class="fas fa-check"></i> Office 365 (Drive 1 Téra par collaborateur - Teams - Calendriers - OneNote - Skype - ToDo…etc)</li>
                        <li><i class="fas fa-check"></i> Possibilité d'utiliser d'autres outils ou plateformes</li>
                        <li><i class="fas fa-check"></i> Ligne téléphonique fixe française pour assistance (gratuite pour tous les fixes en France)</li>
                        <li><i class="fas fa-check"></i> Bureaux hautement équipés</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section class="about-us-section pricing-section">
            <div class="container">
                <h2 class="section-title">HONORAIRES</h2>
                
                <div class="pricing-tables">
                    <div class="pricing-table">
                        <h3>Prestations de comptabilité</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Prestations</th>
                                    <th>Tarifs</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Extraction des données</td>
                                    <td>0.75 Euro par écriture<br>Ou 30% de vos honoraires</td>
                                </tr>
                                <tr>
                                    <td>Tenue et justification</td>
                                    <td>0.75 Euro par écriture<br>Ou 30% de vos honoraires</td>
                                </tr>
                                <tr>
                                    <td>Préparation des liasses</td>
                                    <td>50 Euro par déclaration</td>
                                </tr>
                                <tr>
                                    <td>Télédéclarations</td>
                                    <td>50 Euro par déclaration</td>
                                </tr>
                                <tr>
                                    <td>Révision</td>
                                    <td>0.25 Euro par écriture<br>Ou 10% de vos honoraires</td>
                                </tr>
                                <tr>
                                    <td>Présentation</td>
                                    <td>0.25 Euro par écriture<br>Ou 10% de vos honoraires</td>
                                </tr>
                                <tr>
                                    <td>Contrôle qualité</td>
                                    <td>0.25 Euro par écriture<br>Ou 10% de vos honoraires</td>
                                </tr>
                                <tr>
                                    <td>Questionnaire TRACFIN</td>
                                    <td>0.25 Euro par écriture<br>Ou 10% de vos honoraires</td>
                                </tr>
                                <tr>
                                    <td>PV annuels</td>
                                    <td>100 Euro par PV</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="pricing-table">
                        <h3>Prestations de Paie</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Prestations</th>
                                    <th>Tarifs</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Etablissement des bulletins de paie</td>
                                    <td>12 Euro par bulletin par salarié</td>
                                </tr>
                                <tr>
                                    <td>Nouvelle embauche</td>
                                    <td>14 Euro par salarié</td>
                                </tr>
                                <tr>
                                    <td>Déclaration préalable à l'embauche (DPAE)</td>
                                    <td>5 Euro par salarié</td>
                                </tr>
                                <tr>
                                    <td>Bulletin STC licenciement ou rupture conventionnelle (cerfa à l'appui)</td>
                                    <td>21 Euro par bulletin par salarié</td>
                                </tr>
                                <tr>
                                    <td>Gestion des sorties de personnel CDD –CDI</td>
                                    <td>17 Euro par sortie par bulletin</td>
                                </tr>
                                <tr>
                                    <td>Simulation d'un bulletin de paie</td>
                                    <td>8 Euro par bulletin</td>
                                </tr>
                                <tr>
                                    <td>Déclaration et suivi des arrêts de travail</td>
                                    <td>Gratuit</td>
                                </tr>
                                <tr>
                                    <td>Déclarations sociales (DSN) par dossier</td>
                                    <td>8 Euro par dossier</td>
                                </tr>
                                <tr>
                                    <td>Inscription dossier sur net entreprise/Edition état de charge</td>
                                    <td>3 Euro</td>
                                </tr>
                                <tr>
                                    <td>Migration /création dossier / Nouvel établissement</td>
                                    <td>75 Euro par société jusqu'à 10 salariés</td>
                                </tr>
                                <tr>
                                    <td>Gestion d'une rupture conventionnelle</td>
                                    <td>150 Euro</td>
                                </tr>
                                <tr>
                                    <td>Rédaction d'un contrat de travail : Contrat à durée déterminée (CDD)</td>
                                    <td>45 Euro</td>
                                </tr>
                                <tr>
                                    <td>Rédaction d'un contrat de travail : Contrat à durée indéterminée (CDI)</td>
                                    <td>45 Euro</td>
                                </tr>
                                <tr>
                                    <td>Avenant à un contrat de travail</td>
                                    <td>30 Euro</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="pricing-notes">
                    <p><strong>Note importante :</strong> Le droit d'accès aux plateformes en ligne est à votre charge - Pas de TVA à facturer pour les prestations réalisées en Tunisie (Export)</p>
                    <p><strong>Facturation :</strong> Mensuelle fin du mois</p>
                    <p><strong>Autres missions à forte valeur ajoutée :</strong> Audit, conseil fiscal et social, secrétariat juridique, Présentation des EF conformément aux normes internationales (IFRS), Reporting financier et budgétaire - Mentorat et coaching de startup - Etudes de projets et Business Model Canvas - Recrutement et gestion de ressources humaines - Accompagnement des investisseurs locaux et étrangers en Tunisie et la région MENA.</p>
                </div>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/simulators-modal.php'; ?>

    <!-- Scripts -->
    <script src="script.js"></script>
    <script src="js/mobile-nav.js"></script>
    <script src="js/main.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/chatbot-multilingual-db.js"></script>
    <script>
        // Initialize chatbot
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof window.multilingualChatbotDB !== 'undefined') {
                window.multilingualChatbotDB.init();
            }
        });

        // Check for #simulators anchor on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.hash === '#simulators') {
                openSimulatorsModal();
            }
        });
        
        // Listen for hash changes
        window.addEventListener('hashchange', function() {
            if (window.location.hash === '#simulators') {
                openSimulatorsModal();
            } else {
                closeModal();
            }
        });

        // Language change function
        function changeLanguage(lang) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'change-language.php';
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'lang';
            input.value = lang;
            
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    </script>

    <!-- Search Modal -->
    <div id="searchModal" class="modal search-modal">
        <div class="modal-content search-modal-content">
            <div class="modal-header search-modal-header">
                <h2>Rechercher sur le site</h2>
                <button class="modal-close" onclick="closeSearchModal()">&times;</button>
            </div>
            <div class="modal-body search-modal-body">
                <div class="search-modal-input-wrapper">
                    <input type="text" id="siteSearchInput" class="search-modal-input" placeholder="Tapez votre recherche..." autocomplete="off">
                    <button class="search-modal-btn" onclick="performSiteSearch()">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="search-modal-results" id="searchModalResults">
                    <div class="search-placeholder">
                        <i class="fas fa-search"></i>
                        <p>Tapez un mot-clé pour rechercher dans tout le site</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/search-modal.js"></script>
</body>
</html>

