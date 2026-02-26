# WordPress Bankopedia

A professional financial information website built on WordPress, featuring custom financial calculators with interactive charts and comprehensive banking/finance content.

## 🚀 Features

### Custom Financial Calculators Plugin
- **Loan & EMI Calculator** with interactive charts
  - Real-time EMI calculations
  - Payment breakdown pie chart
  - Year-wise payment timeline bar chart
  - Detailed amortization schedule
  - Flexible tenure (Years/Months)
  - Responsive design

### WordPress Setup
- **Theme**: GeneratePress (Premium theme for speed and customization)
- **Key Plugins**:
  - Financial Calculators (Custom)
  - Rank Math SEO Pro
  - LiteSpeed Cache
  - GenerateBlocks
  - Google Site Kit
  - And more...

## 📦 Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.6 or higher
- WordPress 6.0 or higher

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/prashant-fintech/wordpress-bankopedia.git
   cd wordpress-bankopedia
   ```

2. **Create wp-config.php**
   ```bash
   cp wp-config-sample.php wp-config.php
   ```
   Edit `wp-config.php` with your database credentials.

3. **Import database**
   - Create a new MySQL database
   - Import your database backup

4. **Set file permissions**
   ```bash
   chmod 755 wp-content
   chmod 755 wp-content/uploads
   chmod 644 wp-config.php
   ```

5. **Access your site**
   - Navigate to your domain
   - Login to wp-admin

## 🧮 Using Financial Calculators

### Activation
1. Go to **WordPress Admin** → **Plugins** → **Installed Plugins**
2. Find **Financial Calculators** and click **Activate**

### Usage
Add the shortcode to any page or post:

```
[loan_calculator]
```

**With custom parameters:**
```
[loan_calculator title="Home Loan Calculator" currency="₹" default_amount="3000000" default_rate="7.5" default_tenure="20"]
```

### Shortcode Parameters
- `title` - Calculator heading
- `currency` - Currency symbol (default: ₹)
- `default_amount` - Default loan amount
- `default_rate` - Default interest rate
- `default_tenure` - Default tenure

## 📁 Project Structure

```
wordpress-bankopedia/
├── wp-admin/              # WordPress admin files
├── wp-includes/           # WordPress core files
├── wp-content/
│   ├── plugins/
│   │   ├── financial-calculators/    # Custom calculator plugin
│   │   ├── seo-by-rank-math-pro/
│   │   ├── litespeed-cache/
│   │   └── ...
│   ├── themes/
│   │   ├── generatepress/
│   │   └── ...
│   └── uploads/           # Media uploads (not in repo)
├── .gitignore
├── .htaccess
└── README.md
```

## 🔒 Security Notes

**Files excluded from repository:**
- `wp-config.php` (Contains database credentials)
- `/wp-content/uploads/` (User uploaded files)
- Database backups
- Cache files
- Log files

**Important:** Never commit sensitive configuration files to the repository.

## 🛠️ Development

### Adding New Features
1. Create a new branch
   ```bash
   git checkout -b feature/your-feature-name
   ```

2. Make your changes

3. Commit and push
   ```bash
   git add .
   git commit -m "Add: description of your feature"
   git push origin feature/your-feature-name
   ```

4. Create a Pull Request on GitHub

### Custom Plugin Development
The Financial Calculators plugin is located at:
```
wp-content/plugins/financial-calculators/
```

Key files:
- `financial-calculators.php` - Main plugin file
- `assets/js/calculators.js` - Calculator logic and Chart.js integration
- `assets/css/style.css` - Styling

## 📊 Technologies Used

- **Backend**: PHP 8.x, WordPress 6.x
- **Frontend**: HTML5, CSS3, JavaScript (jQuery)
- **Charts**: Chart.js 4.4.1
- **Cache**: LiteSpeed Cache
- **SEO**: Rank Math Pro

## 🔄 Future Enhancements

- [ ] SIP (Systematic Investment Plan) Calculator
- [ ] Compound Interest Calculator
- [ ] Retirement Planning Calculator
- [ ] ROI Calculator
- [ ] Mortgage Calculator
- [ ] Credit Card Payoff Calculator
- [ ] Currency Converter

## 📝 License

This project is proprietary and confidential.

## 👥 Contributors

- Prashant Singh (prashant-fintech)

## 📞 Support

For issues or questions, please create an issue in the repository or contact the development team.

---

**Repository**: https://github.com/prashant-fintech/wordpress-bankopedia  
**Status**: Private Repository  
**Last Updated**: February 2026
