<?php
/**
 * Plugin Name: Financial Calculators
 * Plugin URI: https://bankopedia.com
 * Description: Professional financial calculators with interactive charts including Loan/EMI Calculator, SIP Calculator, and more.
 * Version: 1.0.0
 * Author: Bankopedia
 * Author URI: https://bankopedia.com
 * License: GPL v2 or later
 * Text Domain: financial-calculators
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('FC_VERSION', '1.0.0');
define('FC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('FC_PLUGIN_URL', plugin_dir_url(__FILE__));

class Financial_Calculators {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_shortcode('loan_calculator', array($this, 'loan_calculator_shortcode'));
        add_shortcode('emi_calculator', array($this, 'loan_calculator_shortcode')); // Alias
    }
    
    /**
     * Enqueue plugin assets
     */
    public function enqueue_assets() {
        // Enqueue Chart.js from CDN
        wp_enqueue_script(
            'chartjs',
            'https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js',
            array(),
            '4.4.1',
            true
        );
        
        // Enqueue plugin CSS
        wp_enqueue_style(
            'financial-calculators-css',
            FC_PLUGIN_URL . 'assets/css/style.css',
            array(),
            FC_VERSION
        );
        
        // Enqueue plugin JavaScript
        wp_enqueue_script(
            'financial-calculators-js',
            FC_PLUGIN_URL . 'assets/js/calculators.js',
            array('jquery', 'chartjs'),
            FC_VERSION,
            true
        );
        
        // Localize script for AJAX (if needed in future)
        wp_localize_script('financial-calculators-js', 'fcData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('fc_nonce')
        ));
    }
    
    /**
     * Loan/EMI Calculator Shortcode
     */
    public function loan_calculator_shortcode($atts) {
        $atts = shortcode_atts(array(
            'title' => 'Loan & EMI Calculator',
            'currency' => '₹',
            'default_amount' => '500000',
            'default_rate' => '8.5',
            'default_tenure' => '5',
        ), $atts);
        
        ob_start();
        ?>
        <div class="fc-calculator-wrapper loan-calculator-wrapper">
            <div class="fc-calculator-container">
                <?php if (!empty($atts['title'])): ?>
                    <h2 class="fc-calculator-title"><?php echo esc_html($atts['title']); ?></h2>
                <?php endif; ?>
                
                <div class="fc-calculator-content">
                    <!-- Input Section -->
                    <div class="fc-input-section">
                        <div class="fc-form-group">
                            <label for="fc-loan-amount">
                                <span class="fc-label-text">Loan Amount</span>
                                <span class="fc-label-value" id="fc-loan-amount-display"><?php echo esc_attr($atts['currency']); ?> <span><?php echo number_format($atts['default_amount']); ?></span></span>
                            </label>
                            <input 
                                type="range" 
                                id="fc-loan-amount" 
                                class="fc-slider" 
                                min="10000" 
                                max="10000000" 
                                step="10000" 
                                value="<?php echo esc_attr($atts['default_amount']); ?>"
                                data-currency="<?php echo esc_attr($atts['currency']); ?>">
                            <div class="fc-range-labels">
                                <span><?php echo esc_html($atts['currency']); ?> 10K</span>
                                <span><?php echo esc_html($atts['currency']); ?> 1Cr</span>
                            </div>
                        </div>
                        
                        <div class="fc-form-group">
                            <label for="fc-interest-rate">
                                <span class="fc-label-text">Interest Rate (% p.a.)</span>
                                <span class="fc-label-value"><span id="fc-interest-rate-display"><?php echo esc_attr($atts['default_rate']); ?></span>%</span>
                            </label>
                            <input 
                                type="range" 
                                id="fc-interest-rate" 
                                class="fc-slider" 
                                min="1" 
                                max="30" 
                                step="0.1" 
                                value="<?php echo esc_attr($atts['default_rate']); ?>">
                            <div class="fc-range-labels">
                                <span>1%</span>
                                <span>30%</span>
                            </div>
                        </div>
                        
                        <div class="fc-form-group">
                            <label for="fc-loan-tenure">
                                <span class="fc-label-text">Loan Tenure</span>
                                <span class="fc-label-value"><span id="fc-loan-tenure-display"><?php echo esc_attr($atts['default_tenure']); ?></span> <span id="fc-tenure-unit">Years</span></span>
                            </label>
                            <input 
                                type="range" 
                                id="fc-loan-tenure" 
                                class="fc-slider" 
                                min="1" 
                                max="30" 
                                step="1" 
                                value="<?php echo esc_attr($atts['default_tenure']); ?>">
                            <div class="fc-range-labels">
                                <span>1 Year</span>
                                <span>30 Years</span>
                            </div>
                            <div class="fc-tenure-toggle">
                                <button type="button" class="fc-tenure-btn active" data-unit="years">Years</button>
                                <button type="button" class="fc-tenure-btn" data-unit="months">Months</button>
                            </div>
                        </div>
                        
                        <button type="button" class="fc-calculate-btn" id="fc-calculate-loan">
                            Calculate EMI
                        </button>
                    </div>
                    
                    <!-- Results Section -->
                    <div class="fc-results-section" id="fc-loan-results" style="display: none;">
                        <div class="fc-result-cards">
                            <div class="fc-result-card fc-card-primary">
                                <div class="fc-result-label">Monthly EMI</div>
                                <div class="fc-result-value" id="fc-monthly-emi">₹ 0</div>
                            </div>
                            
                            <div class="fc-result-card">
                                <div class="fc-result-label">Principal Amount</div>
                                <div class="fc-result-value" id="fc-principal-amount">₹ 0</div>
                            </div>
                            
                            <div class="fc-result-card">
                                <div class="fc-result-label">Total Interest</div>
                                <div class="fc-result-value" id="fc-total-interest">₹ 0</div>
                            </div>
                            
                            <div class="fc-result-card">
                                <div class="fc-result-label">Total Amount</div>
                                <div class="fc-result-value fc-total-highlight" id="fc-total-amount">₹ 0</div>
                            </div>
                        </div>
                        
                        <!-- Charts Section -->
                        <div class="fc-charts-section">
                            <div class="fc-chart-container">
                                <h3 class="fc-chart-title">Payment Breakdown</h3>
                                <div class="fc-chart-wrapper">
                                    <canvas id="fc-payment-breakdown-chart"></canvas>
                                </div>
                            </div>
                            
                            <div class="fc-chart-container">
                                <h3 class="fc-chart-title">Payment Over Time</h3>
                                <div class="fc-chart-wrapper">
                                    <canvas id="fc-payment-timeline-chart"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Amortization Schedule -->
                        <div class="fc-amortization-section">
                            <h3 class="fc-section-title">
                                Amortization Schedule
                                <button type="button" class="fc-toggle-schedule" id="fc-toggle-schedule">
                                    <span class="fc-toggle-text">Show Details</span>
                                    <span class="fc-toggle-icon">▼</span>
                                </button>
                            </h3>
                            <div class="fc-amortization-table-wrapper" id="fc-amortization-table" style="display: none;">
                                <div class="fc-schedule-view-toggle">
                                    <button type="button" class="fc-view-btn active" data-view="yearly">Yearly</button>
                                    <button type="button" class="fc-view-btn" data-view="monthly">Monthly</button>
                                </div>
                                <table class="fc-amortization-table">
                                    <thead>
                                        <tr>
                                            <th id="fc-period-header">Year</th>
                                            <th>Opening Balance</th>
                                            <th>EMI Paid</th>
                                            <th>Principal Paid</th>
                                            <th>Interest Paid</th>
                                            <th>Closing Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody id="fc-amortization-body">
                                        <!-- Populated by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

// Initialize the plugin
function financial_calculators_init() {
    return Financial_Calculators::get_instance();
}
add_action('plugins_loaded', 'financial_calculators_init');
