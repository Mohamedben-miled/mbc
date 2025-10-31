<!-- Simulators Modal -->
<div id="simulatorsModal" class="modal simulators-modal">
    <div class="modal-content simulators-modal-content">
        <div class="modal-header">
            <h2>Simulateurs en ligne</h2>
            <p>Utilisez nos outils de simulation pour estimer rapidement vos charges, impôts et aides</p>
            <button class="modal-close" onclick="closeSimulatorsModal()">&times;</button>
        </div>
        
        <div class="modal-body simulators-modal-body">
            <!-- Navigation Tabs -->
            <div class="simulators-nav">
                <button class="nav-tab active" data-tab="fiscalite">Fiscalité</button>
                <button class="nav-tab" data-tab="charges">Charges sociales</button>
                <button class="nav-tab" data-tab="epargne">Épargne & Retraite</button>
                <button class="nav-tab" data-tab="aides">Aides</button>
            </div>
            
            <div class="simulators-content">
                <div class="simulators-main">
                    <!-- Fiscalité Tab -->
                    <div class="tab-content active" id="fiscalite">
                        <div class="simulator-card">
                            <h3>Calculateur de TVA</h3>
                            <div class="simulator-form">
                                <div class="form-group">
                                    <label for="tva-ht">Montant HT</label>
                                    <input type="number" id="tva-ht" placeholder="0.00" step="0.01">
                                </div>
                                <div class="form-group">
                                    <label for="tva-rate">Taux de TVA</label>
                                    <select id="tva-rate">
                                        <option value="20">20%</option>
                                        <option value="10">10%</option>
                                        <option value="5.5">5.5%</option>
                                        <option value="2.1">2.1%</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tva-amount">Montant TVA</label>
                                    <input type="text" id="tva-amount" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="tva-ttc">Montant TTC</label>
                                    <input type="text" id="tva-ttc" readonly>
                                </div>
                                <div class="simulator-actions">
                                    <button class="btn btn-secondary" onclick="saveSimulation('tva')">
                                        <i class="fas fa-save"></i> Sauvegarder / Charger
                                    </button>
                                    <button class="btn btn-primary" onclick="exportToPDF('tva')">
                                        <i class="fas fa-file-pdf"></i> Exporter en PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="simulator-card">
                            <h3>Simulateur de fiscalité des dividendes</h3>
                            <div class="simulator-form">
                                <div class="form-group">
                                    <label for="div-brut">Montant brut des dividendes</label>
                                    <input type="number" id="div-brut" placeholder="0.00" step="0.01">
                                </div>
                                <div class="form-group">
                                    <label for="div-option">Option d'imposition</label>
                                    <select id="div-option">
                                        <option value="flat">Prélèvement forfaitaire (30%)</option>
                                        <option value="progressif">Barème progressif</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="div-social">Prélèvements sociaux</label>
                                    <input type="text" id="div-social" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="div-impot">Impôt sur le revenu</label>
                                    <input type="text" id="div-impot" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="div-net">Net après impôt</label>
                                    <input type="text" id="div-net" readonly value="0.00 €">
                                </div>
                                <div class="simulator-actions">
                                    <button class="btn btn-primary" onclick="exportToPDF('dividends')">
                                        <i class="fas fa-file-pdf"></i> Exporter en PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Charges sociales Tab -->
                    <div class="tab-content" id="charges">
                        <div class="simulator-card">
                            <h3>Simulateur de charges sociales</h3>
                            <div class="simulator-form">
                                <div class="form-group">
                                    <label for="charges-brut">Rémunération brute annuelle</label>
                                    <input type="number" id="charges-brut" placeholder="0.00" step="0.01">
                                </div>
                                <div class="form-group">
                                    <label for="charges-status">Statut juridique</label>
                                    <select id="charges-status">
                                        <option value="salarie">Salarié</option>
                                        <option value="micro">Micro-entreprise</option>
                                        <option value="auto">Auto-entrepreneur</option>
                                        <option value="sarl">SARL</option>
                                        <option value="sas">SAS</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="charges-total">Total charges sociales</label>
                                    <input type="text" id="charges-total" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="charges-net">Net après charges</label>
                                    <input type="text" id="charges-net" readonly>
                                </div>
                                <p class="disclaimer">* Ces calculs sont des estimations. Consultez un expert-comptable pour des calculs précis.</p>
                                <div class="simulator-actions">
                                    <button class="btn btn-secondary" onclick="saveSimulation('charges')">
                                        <i class="fas fa-save"></i> Sauvegarder / Charger
                                    </button>
                                    <button class="btn btn-primary" onclick="exportToPDF('charges')">
                                        <i class="fas fa-file-pdf"></i> Exporter en PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Épargne & Retraite Tab -->
                    <div class="tab-content" id="epargne">
                        <div class="simulator-card">
                            <h3>Simulateur de sortie du PER</h3>
                            <div class="simulator-form">
                                <div class="form-group">
                                    <label for="per-age">Âge</label>
                                    <input type="number" id="per-age" placeholder="Votre âge">
                                </div>
                                <div class="form-group">
                                    <label for="per-montant">Montant du rachat</label>
                                    <input type="number" id="per-montant" placeholder="0.00" step="0.01">
                                </div>
                                <div class="form-group">
                                    <label for="per-type">Type de sortie</label>
                                    <select id="per-type">
                                        <option value="partiel">Rachat partiel</option>
                                        <option value="total">Rachat total</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="per-situation">Situation</label>
                                    <select id="per-situation">
                                        <option value="actif">Actif</option>
                                        <option value="retraite">Retraité</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="per-impot">Imposition estimée</label>
                                    <input type="text" id="per-impot" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="per-net">Montant net estimé</label>
                                    <input type="text" id="per-net" readonly value="0.00 €">
                                </div>
                                <div class="simulator-actions">
                                    <button class="btn btn-primary" onclick="exportToPDF('per')">
                                        <i class="fas fa-file-pdf"></i> Exporter en PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Aides Tab -->
                    <div class="tab-content" id="aides">
                        <div class="simulator-card">
                            <h3>Simulateur d'aides au logement</h3>
                            <div class="simulator-form">
                                <div class="form-group">
                                    <label for="aide-revenus">Revenus fiscaux annuels</label>
                                    <input type="number" id="aide-revenus" placeholder="0.00" step="0.01">
                                </div>
                                <div class="form-group">
                                    <label for="aide-loyer">Loyer mensuel (charges comprises)</label>
                                    <input type="number" id="aide-loyer" placeholder="0.00" step="0.01">
                                </div>
                                <div class="form-group">
                                    <label for="aide-famille">Situation familiale</label>
                                    <select id="aide-famille">
                                        <option value="celibataire">Célibataire</option>
                                        <option value="couple">Couple</option>
                                        <option value="divorce">Divorcé(e)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="aide-enfants">Nombre d'enfants à charge</label>
                                    <select id="aide-enfants">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4+</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="aide-zone">Zone géographique</label>
                                    <select id="aide-zone">
                                        <option value="1">Zone 1</option>
                                        <option value="2">Zone 2</option>
                                        <option value="3">Zone 3</option>
                                    </select>
                                </div>
                                <div class="aide-result">
                                    <span class="aide-label">Aide mensuelle estimée:</span>
                                    <span class="aide-amount" id="aide-amount">0 €</span>
                                </div>
                                <p class="disclaimer">* Cette estimation est donnée à titre indicatif. Le montant réel de votre aide peut varier en fonction de votre situation précise.</p>
                                <div class="simulator-actions">
                                    <button class="btn btn-primary" onclick="exportToPDF('housing-aid')">
                                        <i class="fas fa-file-pdf"></i> Exporter en PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Simulation History Sidebar -->
                <div class="simulators-sidebar">
                    <div class="history-card">
                        <h4>Historique des simulations</h4>
                        <div class="history-content" id="simulation-history">
                            <i class="fas fa-file-alt"></i>
                            <p>Vous n'avez pas encore de simulations sauvegardées. Utilisez le bouton "Sauvegarder" dans les simulateurs pour conserver vos calculs.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Call to Action -->
            <div class="simulators-cta">
                <h3>Besoin d'un calcul plus précis ?</h3>
                <p>Ces simulateurs donnent des estimations. Pour des calculs précis adaptés à votre situation, prenez rendez-vous avec l'un de nos experts-comptables.</p>
                <div class="cta-buttons">
                    <a href="contact-form.php" class="btn btn-primary">
                        <i class="fas fa-calendar"></i> Prendre rendez-vous avec un expert
                    </a>
                    <a href="contact-form.php" class="btn btn-secondary">
                        <i class="fas fa-file-alt"></i> Demander un devis personnalisé
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Tab Navigation
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.nav-tab');
    const tabContents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all tabs and contents
            tabs.forEach(t => t.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding content
            this.classList.add('active');
            const targetContent = document.getElementById(targetTab);
            if (targetContent) {
                targetContent.classList.add('active');
            }
        });
    });

    // TVA Calculator - Real-time calculation
    const tvaHtInput = document.getElementById('tva-ht');
    const tvaRateSelect = document.getElementById('tva-rate');
    const tvaAmountInput = document.getElementById('tva-amount');
    const tvaTtcInput = document.getElementById('tva-ttc');

    function calculateTVA() {
        if (tvaHtInput && tvaRateSelect && tvaAmountInput && tvaTtcInput) {
            const ht = parseFloat(tvaHtInput.value) || 0;
            const rate = parseFloat(tvaRateSelect.value) / 100;
            const tva = ht * rate;
            const ttc = ht + tva;
            
            tvaAmountInput.value = tva.toFixed(2) + ' €';
            tvaTtcInput.value = ttc.toFixed(2) + ' €';
        }
    }

    if (tvaHtInput) tvaHtInput.addEventListener('input', calculateTVA);
    if (tvaRateSelect) tvaRateSelect.addEventListener('change', calculateTVA);

    // Dividend Calculator
    const divBrutInput = document.getElementById('div-brut');
    const divOptionSelect = document.getElementById('div-option');
    const divSocialInput = document.getElementById('div-social');
    const divImpotInput = document.getElementById('div-impot');
    const divNetInput = document.getElementById('div-net');

    function calculateDividends() {
        if (divBrutInput && divOptionSelect && divSocialInput && divImpotInput && divNetInput) {
            const brut = parseFloat(divBrutInput.value) || 0;
            const option = divOptionSelect.value;
            
            let social, impot, net;
            if (option === 'flat') {
                social = brut * 0.17; // 17% prélèvements sociaux
                impot = brut * 0.13; // 13% impôt forfaitaire
                net = brut - social - impot;
            } else {
                social = brut * 0.17; // 17% prélèvements sociaux
                impot = brut * 0.12; // 12% barème progressif
                net = brut - social - impot;
            }
            
            divSocialInput.value = social.toFixed(2) + ' €';
            divImpotInput.value = impot.toFixed(2) + ' €';
            divNetInput.value = net.toFixed(2) + ' €';
        }
    }

    if (divBrutInput) divBrutInput.addEventListener('input', calculateDividends);
    if (divOptionSelect) divOptionSelect.addEventListener('change', calculateDividends);

    // Social Charges Calculator
    const chargesBrutInput = document.getElementById('charges-brut');
    const chargesStatusSelect = document.getElementById('charges-status');
    const chargesTotalInput = document.getElementById('charges-total');
    const chargesNetInput = document.getElementById('charges-net');

    function calculateSocialCharges() {
        if (chargesBrutInput && chargesStatusSelect && chargesTotalInput && chargesNetInput) {
            const brut = parseFloat(chargesBrutInput.value) || 0;
            const status = chargesStatusSelect.value;
            
            let charges, net;
            switch(status) {
                case 'salarie':
                    charges = brut * 0.22; // 22% charges salariales
                    net = brut - charges;
                    break;
                case 'micro':
                    charges = brut * 0.12; // 12% micro-entreprise
                    net = brut - charges;
                    break;
                case 'auto':
                    charges = brut * 0.22; // 22% auto-entrepreneur
                    net = brut - charges;
                    break;
                case 'sarl':
                    charges = brut * 0.45; // 45% SARL
                    net = brut - charges;
                    break;
                case 'sas':
                    charges = brut * 0.50; // 50% SAS
                    net = brut - charges;
                    break;
                default:
                    charges = 0;
                    net = brut;
            }
            
            chargesTotalInput.value = charges.toFixed(2) + ' €';
            chargesNetInput.value = net.toFixed(2) + ' €';
        }
    }

    if (chargesBrutInput) chargesBrutInput.addEventListener('input', calculateSocialCharges);
    if (chargesStatusSelect) chargesStatusSelect.addEventListener('change', calculateSocialCharges);

    // PER Calculator
    const perAgeInput = document.getElementById('per-age');
    const perMontantInput = document.getElementById('per-montant');
    const perTypeSelect = document.getElementById('per-type');
    const perSituationSelect = document.getElementById('per-situation');
    const perImpotInput = document.getElementById('per-impot');
    const perNetInput = document.getElementById('per-net');

    function calculatePER() {
        if (perAgeInput && perMontantInput && perTypeSelect && perSituationSelect && perImpotInput && perNetInput) {
            const age = parseInt(perAgeInput.value) || 0;
            const montant = parseFloat(perMontantInput.value) || 0;
            const type = perTypeSelect.value;
            const situation = perSituationSelect.value;
            
            let impot, net;
            if (situation === 'retraite') {
                impot = montant * 0.10; // 10% si retraité
            } else if (age >= 60) {
                impot = montant * 0.15; // 15% si 60+ ans
            } else {
                impot = montant * 0.30; // 30% si avant 60 ans
            }
            
            net = montant - impot;
            
            perImpotInput.value = impot.toFixed(2) + ' €';
            perNetInput.value = net.toFixed(2) + ' €';
        }
    }

    if (perAgeInput) perAgeInput.addEventListener('input', calculatePER);
    if (perMontantInput) perMontantInput.addEventListener('input', calculatePER);
    if (perTypeSelect) perTypeSelect.addEventListener('change', calculatePER);
    if (perSituationSelect) perSituationSelect.addEventListener('change', calculatePER);

    // Housing Aid Calculator
    const aideRevenusInput = document.getElementById('aide-revenus');
    const aideLoyerInput = document.getElementById('aide-loyer');
    const aideFamilleSelect = document.getElementById('aide-famille');
    const aideEnfantsSelect = document.getElementById('aide-enfants');
    const aideZoneSelect = document.getElementById('aide-zone');
    const aideAmountSpan = document.getElementById('aide-amount');

    function calculateHousingAid() {
        if (aideRevenusInput && aideLoyerInput && aideFamilleSelect && aideEnfantsSelect && aideZoneSelect && aideAmountSpan) {
            const revenus = parseFloat(aideRevenusInput.value) || 0;
            const loyer = parseFloat(aideLoyerInput.value) || 0;
            const famille = aideFamilleSelect.value;
            const enfants = parseInt(aideEnfantsSelect.value) || 0;
            const zone = parseInt(aideZoneSelect.value) || 1;
            
            // Simplified calculation for housing aid
            let aide = 0;
            if (revenus > 0 && loyer > 0) {
                const revenusParPersonne = revenus / (1 + (famille === 'couple' ? 1 : 0) + enfants);
                const loyerMax = 300 + (enfants * 50); // Simplified max rent
                
                if (loyer <= loyerMax && revenusParPersonne < 20000) {
                    aide = Math.min(loyer * 0.3, 200); // Max 30% of rent, capped at 200€
                }
            }
            
            aideAmountSpan.textContent = aide.toFixed(0) + ' €';
        }
    }

    if (aideRevenusInput) aideRevenusInput.addEventListener('input', calculateHousingAid);
    if (aideLoyerInput) aideLoyerInput.addEventListener('input', calculateHousingAid);
    if (aideFamilleSelect) aideFamilleSelect.addEventListener('change', calculateHousingAid);
    if (aideEnfantsSelect) aideEnfantsSelect.addEventListener('change', calculateHousingAid);
    if (aideZoneSelect) aideZoneSelect.addEventListener('change', calculateHousingAid);
});

// Save simulation to localStorage
function saveSimulation(type) {
    try {
        let data = {};
        switch(type) {
            case 'tva':
                data = {
                    type: 'tva',
                    ht: document.getElementById('tva-ht').value,
                    rate: document.getElementById('tva-rate').value,
                    tva: document.getElementById('tva-amount').value,
                    ttc: document.getElementById('tva-ttc').value
                };
                break;
            case 'charges':
                data = {
                    type: 'charges',
                    brut: document.getElementById('charges-brut').value,
                    status: document.getElementById('charges-status').value,
                    total: document.getElementById('charges-total').value,
                    net: document.getElementById('charges-net').value
                };
                break;
        }
        
        let simulations = JSON.parse(localStorage.getItem('simulations') || '[]');
        data.id = Date.now();
        data.date = new Date().toLocaleDateString('fr-FR');
        simulations.push(data);
        localStorage.setItem('simulations', JSON.stringify(simulations));
        
        alert('Simulation sauvegardée !');
        updateSimulationHistory();
    } catch (e) {
        console.error('Error saving simulation:', e);
        alert('Erreur lors de la sauvegarde');
    }
}

// Load simulation history
function updateSimulationHistory() {
    const historyDiv = document.getElementById('simulation-history');
    if (!historyDiv) return;
    
    try {
        const simulations = JSON.parse(localStorage.getItem('simulations') || '[]');
        if (simulations.length === 0) {
            historyDiv.innerHTML = '<i class="fas fa-file-alt"></i><p>Vous n\'avez pas encore de simulations sauvegardées. Utilisez le bouton "Sauvegarder" dans les simulateurs pour conserver vos calculs.</p>';
        } else {
            let html = '<ul class="history-list">';
            simulations.slice(-5).reverse().forEach(sim => {
                html += `<li class="history-item">
                    <span class="history-type">${sim.type.toUpperCase()}</span>
                    <span class="history-date">${sim.date}</span>
                    <button onclick="loadSimulation(${sim.id})" class="btn-small">Charger</button>
                </li>`;
            });
            html += '</ul>';
            historyDiv.innerHTML = html;
        }
    } catch (e) {
        console.error('Error loading history:', e);
    }
}

// Load simulation
function loadSimulation(id) {
    try {
        const simulations = JSON.parse(localStorage.getItem('simulations') || '[]');
        const sim = simulations.find(s => s.id === id);
        if (!sim) return;
        
        if (sim.type === 'tva') {
            document.getElementById('tva-ht').value = sim.ht;
            document.getElementById('tva-rate').value = sim.rate;
            calculateTVA();
        } else if (sim.type === 'charges') {
            document.getElementById('charges-brut').value = sim.brut;
            document.getElementById('charges-status').value = sim.status;
            calculateSocialCharges();
        }
    } catch (e) {
        console.error('Error loading simulation:', e);
    }
}

// Export to PDF (placeholder function)
function exportToPDF(type) {
    alert('Fonctionnalité d\'export PDF en cours de développement. Les données seront exportées bientôt.');
    // In a real implementation, you would use a library like jsPDF or send data to server
}

// Update history on modal open
document.addEventListener('DOMContentLoaded', function() {
    updateSimulationHistory();
    
    // Update history when modal is opened
    const modal = document.getElementById('simulatorsModal');
    if (modal) {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (modal.classList.contains('show') || modal.style.display !== 'none') {
                    updateSimulationHistory();
                }
            });
        });
        observer.observe(modal, { attributes: true, attributeFilter: ['class', 'style'] });
    }
});
</script>
