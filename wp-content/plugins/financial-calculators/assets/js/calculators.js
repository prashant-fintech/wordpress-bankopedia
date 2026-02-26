/**
 * Financial Calculators JavaScript
 * Handles all calculator logic and chart rendering
 */

(function($) {
    'use strict';
    
    let paymentBreakdownChart = null;
    let paymentTimelineChart = null;
    
    $(document).ready(function() {
        initLoanCalculator();
    });
    
    /**
     * Initialize Loan Calculator
     */
    function initLoanCalculator() {
        // Update display values on slider change
        $('#fc-loan-amount').on('input', function() {
            const value = parseInt($(this).val());
            const currency = $(this).data('currency');
            $('#fc-loan-amount-display span').text(formatCurrency(value));
        });
        
        $('#fc-interest-rate').on('input', function() {
            const value = parseFloat($(this).val()).toFixed(1);
            $('#fc-interest-rate-display').text(value);
        });
        
        $('#fc-loan-tenure').on('input', function() {
            const value = parseInt($(this).val());
            $('#fc-loan-tenure-display').text(value);
        });
        
        // Tenure unit toggle
        $('.fc-tenure-btn').on('click', function() {
            const unit = $(this).data('unit');
            $('.fc-tenure-btn').removeClass('active');
            $(this).addClass('active');
            
            const $tenureSlider = $('#fc-loan-tenure');
            const currentValue = parseInt($tenureSlider.val());
            
            if (unit === 'months') {
                $tenureSlider.attr('min', '1').attr('max', '360').attr('step', '1');
                if (currentValue <= 30) {
                    $tenureSlider.val(currentValue * 12);
                    $('#fc-loan-tenure-display').text(currentValue * 12);
                }
                $('#fc-tenure-unit').text('Months');
                $('.fc-range-labels span:first-child').text('1 Month');
                $('.fc-range-labels span:last-child').text('360 Months');
            } else {
                $tenureSlider.attr('min', '1').attr('max', '30').attr('step', '1');
                if (currentValue > 30) {
                    $tenureSlider.val(Math.round(currentValue / 12));
                    $('#fc-loan-tenure-display').text(Math.round(currentValue / 12));
                }
                $('#fc-tenure-unit').text('Years');
                $('.fc-range-labels span:first-child').text('1 Year');
                $('.fc-range-labels span:last-child').text('30 Years');
            }
        });
        
        // Calculate button
        $('#fc-calculate-loan').on('click', function() {
            calculateLoan();
        });
        
        // Toggle amortization schedule
        $(document).on('click', '#fc-toggle-schedule', function() {
            const $table = $('#fc-amortization-table');
            const $icon = $(this).find('.fc-toggle-icon');
            const $text = $(this).find('.fc-toggle-text');
            
            $table.slideToggle();
            if ($table.is(':visible')) {
                $icon.text('▲');
                $text.text('Hide Details');
            } else {
                $icon.text('▼');
                $text.text('Show Details');
            }
        });
        
        // Toggle between monthly and yearly view
        $(document).on('click', '.fc-view-btn', function() {
            const view = $(this).data('view');
            $('.fc-view-btn').removeClass('active');
            $(this).addClass('active');
            
            // Re-generate schedule with new view
            const loanAmount = parseFloat($('#fc-loan-amount').val());
            const interestRate = parseFloat($('#fc-interest-rate').val());
            const tenureUnit = $('.fc-tenure-btn.active').data('unit');
            let tenure = parseInt($('#fc-loan-tenure').val());
            const tenureInMonths = tenureUnit === 'years' ? tenure * 12 : tenure;
            const monthlyRate = interestRate / 12 / 100;
            const emi = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, tenureInMonths)) / 
                        (Math.pow(1 + monthlyRate, tenureInMonths) - 1);
            const currency = $('#fc-loan-amount').data('currency');
            
            generateAmortizationSchedule(loanAmount, interestRate, tenureInMonths, emi, currency, tenureUnit, view);
        });
        
        // Auto-calculate on page load
        calculateLoan();
    }
    
    /**
     * Calculate Loan/EMI
     */
    function calculateLoan() {
        const loanAmount = parseFloat($('#fc-loan-amount').val());
        const interestRate = parseFloat($('#fc-interest-rate').val());
        const tenureUnit = $('.fc-tenure-btn.active').data('unit');
        let tenure = parseInt($('#fc-loan-tenure').val());
        
        // Convert to months
        const tenureInMonths = tenureUnit === 'years' ? tenure * 12 : tenure;
        
        // Calculate EMI using formula: EMI = [P x R x (1+R)^N]/[(1+R)^N-1]
        const monthlyRate = interestRate / 12 / 100;
        const emi = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, tenureInMonths)) / 
                    (Math.pow(1 + monthlyRate, tenureInMonths) - 1);
        
        const totalAmount = emi * tenureInMonths;
        const totalInterest = totalAmount - loanAmount;
        
        // Get currency symbol
        const currency = $('#fc-loan-amount').data('currency');
        
        // Display results
        $('#fc-monthly-emi').text(currency + ' ' + formatCurrency(Math.round(emi)));
        $('#fc-principal-amount').text(currency + ' ' + formatCurrency(loanAmount));
        $('#fc-total-interest').text(currency + ' ' + formatCurrency(Math.round(totalInterest)));
        $('#fc-total-amount').text(currency + ' ' + formatCurrency(Math.round(totalAmount)));
        
        // Show results section
        $('#fc-loan-results').fadeIn();
        
        // Render charts
        renderPaymentBreakdownChart(loanAmount, totalInterest, currency);
        renderPaymentTimelineChart(loanAmount, interestRate, tenureInMonths, emi, currency);
        
        // Generate amortization schedule
        generateAmortizationSchedule(loanAmount, interestRate, tenureInMonths, emi, currency, tenureUnit, 'yearly');
    }
    
    /**
     * Render Payment Breakdown Pie Chart
     */
    function renderPaymentBreakdownChart(principal, interest, currency) {
        const ctx = document.getElementById('fc-payment-breakdown-chart');
        
        if (paymentBreakdownChart) {
            paymentBreakdownChart.destroy();
        }
        
        paymentBreakdownChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Principal Amount', 'Total Interest'],
                datasets: [{
                    data: [principal, interest],
                    backgroundColor: [
                        '#4CAF50',
                        '#FF6B6B'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return label + ': ' + currency + ' ' + formatCurrency(Math.round(value)) + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }
    
    /**
     * Render Payment Timeline Line Chart
     */
    function renderPaymentTimelineChart(principal, interestRate, tenureMonths, emi, currency) {
        const ctx = document.getElementById('fc-payment-timeline-chart');
        
        if (paymentTimelineChart) {
            paymentTimelineChart.destroy();
        }
        
        const monthlyRate = interestRate / 12 / 100;
        let balance = principal;
        const principalData = [];
        const interestData = [];
        const labels = [];
        
        // Calculate year-wise data
        const years = Math.ceil(tenureMonths / 12);
        for (let year = 1; year <= years; year++) {
            const monthsInYear = year === years ? (tenureMonths % 12 || 12) : 12;
            let yearPrincipal = 0;
            let yearInterest = 0;
            
            for (let month = 1; month <= monthsInYear; month++) {
                const interest = balance * monthlyRate;
                const principalPaid = emi - interest;
                
                yearPrincipal += principalPaid;
                yearInterest += interest;
                balance -= principalPaid;
            }
            
            labels.push('Year ' + year);
            principalData.push(Math.round(yearPrincipal));
            interestData.push(Math.round(yearInterest));
        }
        
        paymentTimelineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Principal',
                        data: principalData,
                        backgroundColor: '#4CAF50',
                        borderRadius: 5
                    },
                    {
                        label: 'Interest',
                        data: interestData,
                        backgroundColor: '#FF6B6B',
                        borderRadius: 5
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        stacked: true,
                        ticks: {
                            callback: function(value) {
                                return currency + ' ' + formatCurrency(value);
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + currency + ' ' + formatCurrency(context.parsed.y);
                            }
                        }
                    }
                }
            }
        });
    }
    
    /**
     * Generate Amortization Schedule
     */
    function generateAmortizationSchedule(principal, interestRate, tenureMonths, emi, currency, tenureUnit, view = 'yearly') {
        const monthlyRate = interestRate / 12 / 100;
        let balance = principal;
        const tbody = $('#fc-amortization-body');
        tbody.empty();
        
        // Update header based on view
        $('#fc-period-header').text(view === 'monthly' ? 'Month' : 'Year');
        
        if (view === 'monthly') {
            // Generate month-wise schedule
            for (let month = 1; month <= tenureMonths; month++) {
                const openingBalance = balance;
                const interest = balance * monthlyRate;
                const principalPaid = emi - interest;
                balance -= principalPaid;
                
                const row = `
                    <tr>
                        <td>${month}</td>
                        <td>${currency} ${formatCurrency(Math.round(openingBalance))}</td>
                        <td>${currency} ${formatCurrency(Math.round(emi))}</td>
                        <td>${currency} ${formatCurrency(Math.round(principalPaid))}</td>
                        <td>${currency} ${formatCurrency(Math.round(interest))}</td>
                        <td>${currency} ${formatCurrency(Math.max(0, Math.round(balance)))}</td>
                    </tr>
                `;
                tbody.append(row);
            }
        } else {
            // Generate year-wise schedule
            const years = Math.ceil(tenureMonths / 12);
            
            for (let year = 1; year <= years; year++) {
                const openingBalance = balance;
                const monthsInYear = year === years ? (tenureMonths % 12 || 12) : 12;
                let yearPrincipal = 0;
                let yearInterest = 0;
                let totalEmi = 0;
                
                for (let month = 1; month <= monthsInYear; month++) {
                    const interest = balance * monthlyRate;
                    const principalPaid = emi - interest;
                    
                    yearPrincipal += principalPaid;
                    yearInterest += interest;
                    totalEmi += emi;
                    balance -= principalPaid;
                }
                
                const row = `
                    <tr>
                        <td>${year}</td>
                        <td>${currency} ${formatCurrency(Math.round(openingBalance))}</td>
                        <td>${currency} ${formatCurrency(Math.round(totalEmi))}</td>
                        <td>${currency} ${formatCurrency(Math.round(yearPrincipal))}</td>
                        <td>${currency} ${formatCurrency(Math.round(yearInterest))}</td>
                        <td>${currency} ${formatCurrency(Math.max(0, Math.round(balance)))}</td>
                    </tr>
                `;
                tbody.append(row);
            }
        }
    }
    
    /**
     * Format number as currency
     */
    function formatCurrency(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    
})(jQuery);
