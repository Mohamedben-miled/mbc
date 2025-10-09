<!-- Simulators Modal -->
<div id="simulatorsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><?php echo __('modal.simulators.title'); ?></h2>
            <p><?php echo __('modal.simulators.subtitle'); ?></p>
            <button class="modal-close" onclick="closeSimulatorsModal()">&times;</button>
        </div>
        
        <div class="modal-body">
            <!-- Navigation Tabs -->
            <div class="simulators-nav">
                <button class="nav-tab active" data-tab="fiscalite"><?php echo __('contact.simulators_fiscalite'); ?></button>
                <button class="nav-tab" data-tab="charges"><?php echo __('contact.simulators_charges'); ?></button>
                <button class="nav-tab" data-tab="epargne"><?php echo __('contact.simulators_epargne'); ?></button>
                <button class="nav-tab" data-tab="aides"><?php echo __('contact.simulators_aides'); ?></button>
            </div>
            
            <div class="simulators-content">
                <div class="simulators-main">
                    <!-- Fiscalité Tab -->
                    <div class="tab-content active" id="fiscalite">
                        <div class="simulator-card">
                            <h3><?php echo __('contact.simulator_tva_title'); ?></h3>
                            <div class="simulator-form">
                                <div class="form-group">
                                    <label for="tva-ht"><?php echo __('contact.simulator_tva_ht'); ?></label>
                                    <input type="number" id="tva-ht" placeholder="10000" step="0.01" value="10000" onchange="calculateTVA()" oninput="calculateTVA()">
                                </div>
                                <div class="form-group">
                                    <label for="tva-rate"><?php echo __('contact.simulator_tva_rate'); ?></label>
                                    <select id="tva-rate" onchange="calculateTVA()">
                                        <option value="20">20% - <?php echo __('contact.simulator_tva_normal'); ?></option>
                                        <option value="10">10% - <?php echo __('contact.simulator_tva_intermediate'); ?></option>
                                        <option value="5.5">5,5% - <?php echo __('contact.simulator_tva_reduced'); ?></option>
                                        <option value="2.1">2,1% - <?php echo __('contact.simulator_tva_super_reduced'); ?></option>
                                        <option value="0">0% - <?php echo __('contact.simulator_tva_exempt'); ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tva-amount"><?php echo __('contact.simulator_tva_amount'); ?></label>
                                    <input type="text" id="tva-amount" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="tva-ttc"><?php echo __('contact.simulator_tva_ttc'); ?></label>
                                    <input type="text" id="tva-ttc" readonly>
                                </div>
                                <div class="simulator-actions">
                                    <button class="btn btn-secondary">
                                        <i class="fas fa-save"></i> <?php echo __('contact.simulator_save'); ?>
                                    </button>
                                    <button class="btn btn-primary">
                                        <i class="fas fa-download"></i> <?php echo __('contact.simulator_export'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Charges Tab -->
                    <div class="tab-content" id="charges">
                        <div class="simulator-card">
                            <h3><?php echo __('contact.simulator_charges_title'); ?></h3>
                            <p><?php echo __('contact.simulator_charges_dev'); ?></p>
                        </div>
                    </div>
                    
                    <!-- Épargne Tab -->
                    <div class="tab-content" id="epargne">
                        <div class="simulator-card">
                            <h3><?php echo __('contact.simulator_epargne_title'); ?></h3>
                            <p><?php echo __('contact.simulator_charges_dev'); ?></p>
                        </div>
                    </div>
                    
                    <!-- Aides Tab -->
                    <div class="tab-content" id="aides">
                        <div class="simulator-card">
                            <h3><?php echo __('contact.simulator_aides_title'); ?></h3>
                            <p><?php echo __('contact.simulator_charges_dev'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Simulators Modal Functions
function openSimulatorsModal() {
    const modal = document.getElementById('simulatorsModal');
    if (modal) {
        modal.style.display = 'flex';
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

function closeSimulatorsModal() {
    const modal = document.getElementById('simulatorsModal');
    if (modal) {
        modal.classList.remove('show');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// TVA Calculator
function calculateTVA() {
    const tvaHtInput = document.getElementById('tva-ht');
    const tvaRateSelect = document.getElementById('tva-rate');
    const tvaAmountInput = document.getElementById('tva-amount');
    const tvaTtcInput = document.getElementById('tva-ttc');

    if (tvaHtInput && tvaRateSelect && tvaAmountInput && tvaTtcInput) {
        const ht = parseFloat(tvaHtInput.value) || 0;
        const rate = parseFloat(tvaRateSelect.value) / 100;
        const tva = ht * rate;
        const ttc = ht + tva;
        
        tvaAmountInput.value = tva.toFixed(2) + ' €';
        tvaTtcInput.value = ttc.toFixed(2) + ' €';
    }
}

// Tab switching functionality
document.addEventListener('DOMContentLoaded', function() {
    const navTabs = document.querySelectorAll('.nav-tab');
    const tabContents = document.querySelectorAll('.tab-content');

    navTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all tabs and contents
            navTabs.forEach(t => t.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding content
            this.classList.add('active');
            document.getElementById(targetTab).classList.add('active');
        });
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('simulatorsModal');
        if (modal && event.target === modal) {
            closeSimulatorsModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeSimulatorsModal();
        }
    });

    // Check for #simulators anchor on page load
    if (window.location.hash === '#simulators') {
        openSimulatorsModal();
    }
    
    // Listen for hash changes
    window.addEventListener('hashchange', function() {
        if (window.location.hash === '#simulators') {
            openSimulatorsModal();
        } else {
            closeSimulatorsModal();
        }
    });
});
</script>
