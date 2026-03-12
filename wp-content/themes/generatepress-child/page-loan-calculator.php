<?php
/**
 * Template Name: Loan Calculator Page
 *
 * Full-width page template for the EMI / Loan Calculator.
 * Assign via WP Admin → Pages → Edit (Loan Calculator) → Page Attributes → Template.
 *
 * @package GeneratePress Child - Bankopedia
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="site-content" class="bp-calc-page" role="main">

    <!-- Page header band -->
    <div class="bp-calc-page__header">
        <div class="bp-calc-page__header-inner">
            <nav class="bp-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
                <span aria-hidden="true">›</span>
                <span aria-current="page">Loan &amp; EMI Calculator</span>
            </nav>
            <h1 class="bp-calc-page__title">Loan &amp; EMI Calculator</h1>
            <p class="bp-calc-page__subtitle">
                Calculate your monthly EMI, total interest payable, and view a complete
                amortisation schedule — instantly and for free.
            </p>
        </div>
    </div>

    <!-- Calculator shortcode wrapper -->
    <div class="bp-calc-page__body">
        <div class="bp-calc-page__wrapper">
            <?php
            while ( have_posts() ) :
                the_post();
                // Output the page content (which contains the [loan_calculator] shortcode)
                the_content();
            endwhile;
            ?>
        </div>
    </div>

    <!-- Info strip below calculator -->
    <div class="bp-calc-page__info-strip">
        <div class="bp-calc-page__info-inner">
            <div class="bp-calc-info-card">
                <span class="bp-calc-info-card__icon">📐</span>
                <h3>Standard EMI Formula</h3>
                <p>EMI = P × R × (1+R)<sup>N</sup> / ((1+R)<sup>N</sup> − 1)</p>
            </div>
            <div class="bp-calc-info-card">
                <span class="bp-calc-info-card__icon">💡</span>
                <h3>What is EMI?</h3>
                <p>Equated Monthly Instalment — a fixed payment made every month towards repaying a loan including principal and interest.</p>
            </div>
            <div class="bp-calc-info-card">
                <span class="bp-calc-info-card__icon">🏦</span>
                <h3>Tip</h3>
                <p>A higher down payment reduces your principal and total interest. Even 1% lower interest rate saves significantly over long tenures.</p>
            </div>
        </div>
    </div>

</main>

<?php get_footer(); ?>
