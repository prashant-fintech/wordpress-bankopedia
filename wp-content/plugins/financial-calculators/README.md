# Financial Calculators WordPress Plugin

A professional WordPress plugin for Bankopedia featuring interactive financial calculators with beautiful charts and detailed breakdowns.

## Features

### Loan & EMI Calculator
- **Interactive Sliders** - Easy-to-use sliders for loan amount, interest rate, and tenure
- **Flexible Tenure** - Switch between years and months
- **Real-time Calculations** - Instant EMI calculations
- **Visual Charts**:
  - Payment Breakdown (Pie Chart) - Shows principal vs interest
  - Payment Over Time (Bar Chart) - Year-wise breakdown
- **Amortization Schedule** - Detailed year-by-year payment schedule
- **Responsive Design** - Works perfectly on mobile, tablet, and desktop

## Installation

1. The plugin is already created in: `wp-content/plugins/financial-calculators/`
2. Go to WordPress Admin Dashboard
3. Navigate to **Plugins** → **Installed Plugins**
4. Find **Financial Calculators** and click **Activate**

## Usage

### Adding Calculator to Pages/Posts

Simply add the shortcode to any page or post:

```
[loan_calculator]
```

Or with custom options:

```
[loan_calculator title="Home Loan EMI Calculator" currency="₹" default_amount="1000000" default_rate="7.5" default_tenure="10"]
```

### Shortcode Parameters

- `title` - Calculator heading (default: "Loan & EMI Calculator")
- `currency` - Currency symbol (default: "₹")
- `default_amount` - Default loan amount (default: "500000")
- `default_rate` - Default interest rate (default: "8.5")
- `default_tenure` - Default tenure (default: "5")

### Examples

**Personal Loan Calculator:**
```
[loan_calculator title="Personal Loan Calculator" default_amount="300000" default_rate="12" default_tenure="3"]
```

**Home Loan Calculator:**
```
[loan_calculator title="Home Loan EMI Calculator" default_amount="3000000" default_rate="7.5" default_tenure="20"]
```

**Car Loan Calculator:**
```
[loan_calculator title="Car Loan Calculator" default_amount="500000" default_rate="9" default_tenure="5"]
```

## Features Breakdown

### 1. Input Controls
- Loan Amount: ₹10,000 to ₹1,00,00,000
- Interest Rate: 1% to 30%
- Tenure: 1-30 years or 1-360 months

### 2. Results Display
- Monthly EMI amount
- Total principal amount
- Total interest payable
- Total amount payable

### 3. Visual Charts
- **Payment Breakdown Chart**: Doughnut chart showing principal vs interest ratio
- **Payment Timeline Chart**: Stacked bar chart showing yearly principal and interest payments

### 4. Amortization Schedule
Detailed table showing for each year:
- Opening balance
- Total EMI paid
- Principal paid
- Interest paid
- Closing balance

## Technical Details

- **Built with**: Pure PHP, JavaScript (jQuery), Chart.js
- **Charts**: Interactive charts using Chart.js 4.4.1
- **Responsive**: Mobile-first design
- **Performance**: Optimized with proper asset loading
- **Security**: Follows WordPress coding standards

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## Customization

### CSS Customization
Edit `assets/css/style.css` to customize colors, fonts, and layout.

### JavaScript Customization
Edit `assets/js/calculators.js` to modify calculation logic or chart options.

## Future Calculators

Coming soon:
- SIP Calculator
- Compound Interest Calculator
- Retirement Calculator
- ROI Calculator
- Mortgage Calculator
- Credit Card Payoff Calculator

## Support

For issues or questions, contact: support@bankopedia.com

## Version

Current Version: 1.0.0

## License

GPL v2 or later
