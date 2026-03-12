<?php
/**
 * Front Page Template — Bankopedia
 *
 * Custom homepage with: Hero → Stats → Calculators → Topics → Articles → Newsletter
 *
 * @package GeneratePress Child - Bankopedia
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="site-content" class="bp-homepage" role="main">

    <!-- =========================================================
         SECTION 1: HERO
         ========================================================= -->
    <section class="bp-hero" aria-label="Hero">
        <div class="bp-hero__inner">

            <span class="bp-hero__badge">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                India's Banking &amp; Finance Hub
            </span>

            <h1 class="bp-hero__title">
                Your Guide to<br>
                <span>Indian Banking</span><br>
                &amp; Finance
            </h1>

            <p class="bp-hero__subtitle">
                Free financial calculators, expert banking guides, and
                up-to-date finance knowledge — built for Indian professionals and students.
            </p>

            <div class="bp-hero__actions">
                <a href="<?php echo esc_url( home_url( '/loan-calculator/' ) ); ?>"
                   class="bp-btn bp-btn--primary"
                   aria-label="Open EMI Calculator">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="4" y="2" width="16" height="20" rx="2"/>
                        <line x1="8" y1="6" x2="16" y2="6"/>
                        <line x1="8" y1="10" x2="16" y2="10"/>
                        <line x1="8" y1="14" x2="12" y2="14"/>
                    </svg>
                    Try EMI Calculator
                </a>

                <a href="<?php echo esc_url( home_url( '/knowledge-base/' ) ); ?>"
                   class="bp-btn bp-btn--outline"
                   aria-label="Browse Topics">
                    Browse Topics
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
            </div>

        </div>
    </section><!-- .bp-hero -->


    <!-- =========================================================
         SECTION 2: STATS BAR
         ========================================================= -->
    <div class="bp-stats" role="region" aria-label="Site statistics">
        <div class="bp-stats__inner">

            <div class="bp-stat">
                <span class="bp-stat__number"><span>15</span>+</span>
                <span class="bp-stat__label">Financial Calculators</span>
            </div>

            <div class="bp-stat">
                <span class="bp-stat__number"><span>500</span>+</span>
                <span class="bp-stat__label">Finance Articles</span>
            </div>

            <div class="bp-stat">
                <span class="bp-stat__number"><span>100</span>%</span>
                <span class="bp-stat__label">Free to Use</span>
            </div>

        </div>
    </div><!-- .bp-stats -->


    <!-- =========================================================
         SECTION 3: FINANCIAL CALCULATORS
         ========================================================= -->
    <section class="bp-section bp-section--white" aria-label="Financial Calculators">
        <div class="bp-section__inner">

            <header class="bp-section__header">
                <span class="bp-section__eyebrow">Tools</span>
                <h2 class="bp-section__title">Financial Calculators</h2>
                <p class="bp-section__desc">
                    Instant, accurate calculations for loans, investments, and savings —
                    no sign-up required.
                </p>
            </header>

            <div class="bp-calc-grid">

                <!-- EMI / Loan Calculator -->
                <div class="bp-calc-card bp-calc-card--featured">
                    <span class="bp-calc-card__badge bp-calc-card__badge--live">Live</span>
                    <div class="bp-calc-card__icon bp-calc-card__icon--blue" aria-hidden="true">🏦</div>
                    <h3 class="bp-calc-card__title">EMI &amp; Loan Calculator</h3>
                    <p class="bp-calc-card__desc">
                        Calculate your monthly EMI, total interest payable, and see a
                        complete year-wise amortisation schedule for any loan.
                    </p>
                    <a href="<?php echo esc_url( home_url( '/loan-calculator/' ) ); ?>"
                       class="bp-calc-card__link"
                       aria-label="Open EMI Calculator">
                        Calculate EMI
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <line x1="5" y1="12" x2="19" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </a>
                </div>

                <!-- SIP Calculator (Coming Soon) -->
                <div class="bp-calc-card">
                    <span class="bp-calc-card__badge bp-calc-card__badge--soon">Coming Soon</span>
                    <div class="bp-calc-card__icon bp-calc-card__icon--gold" aria-hidden="true">📈</div>
                    <h3 class="bp-calc-card__title">SIP Calculator</h3>
                    <p class="bp-calc-card__desc">
                        Plan your mutual fund investments — estimate the future value of
                        your SIP with compound interest projections.
                    </p>
                    <span class="bp-calc-card__link bp-calc-card__link--disabled" aria-disabled="true">
                        Coming Soon
                    </span>
                </div>

                <!-- FD Calculator (Coming Soon) -->
                <div class="bp-calc-card">
                    <span class="bp-calc-card__badge bp-calc-card__badge--soon">Coming Soon</span>
                    <div class="bp-calc-card__icon bp-calc-card__icon--green" aria-hidden="true">🏛️</div>
                    <h3 class="bp-calc-card__title">Fixed Deposit Calculator</h3>
                    <p class="bp-calc-card__desc">
                        Calculate maturity amount and interest earned on your FDs across
                        different compounding frequencies and tenures.
                    </p>
                    <span class="bp-calc-card__link bp-calc-card__link--disabled" aria-disabled="true">
                        Coming Soon
                    </span>
                </div>

            </div><!-- .bp-calc-grid -->

        </div>
    </section><!-- Calculators -->


    <!-- =========================================================
         SECTION 4: BROWSE BY TOPIC
         ========================================================= -->
    <section class="bp-topics" aria-label="Browse finance topics">
        <div class="bp-section__inner">

            <header class="bp-section__header">
                <span class="bp-section__eyebrow">Knowledge Base</span>
                <h2 class="bp-section__title">Explore Finance Topics</h2>
                <p class="bp-section__desc">
                    From RBI regulations to personal finance basics — browse by the topic that matters to you.
                </p>
            </header>

            <div class="bp-topics-grid">

                <?php
                $bp_topics = [
                    [ 'label' => '🏛️ RBI &amp; Monetary Policy', 'q' => 'RBI',            'color' => 'blue'   ],
                    [ 'label' => '📊 SEBI &amp; Markets',         'q' => 'SEBI',           'color' => 'blue'   ],
                    [ 'label' => '🏦 Banking Basics',             'q' => 'banking',        'color' => 'green'  ],
                    [ 'label' => '💰 Loans &amp; EMI',            'q' => 'loan EMI',       'color' => 'gold'   ],
                    [ 'label' => '📈 Investments',                'q' => 'investment',     'color' => 'green'  ],
                    [ 'label' => '👤 Personal Finance',           'q' => 'personal finance','color' => 'purple' ],
                    [ 'label' => '🏧 Savings &amp; FD',           'q' => 'savings FD',     'color' => 'gold'   ],
                    [ 'label' => '💳 Credit Cards',               'q' => 'credit card',    'color' => 'purple' ],
                    [ 'label' => '🛡️ Insurance',                  'q' => 'insurance',      'color' => 'green'  ],
                    [ 'label' => '🧾 Tax &amp; ITR',              'q' => 'tax ITR',        'color' => 'blue'   ],
                    [ 'label' => '📂 Mutual Funds',               'q' => 'mutual fund',    'color' => 'gold'   ],
                    [ 'label' => '📉 Stock Market',               'q' => 'stock market',   'color' => 'green'  ],
                ];
                foreach ( $bp_topics as $topic ) :
                ?>
                    <a href="<?php echo esc_url( home_url( '/?s=' . urlencode( $topic['q'] ) ) ); ?>"
                       class="bp-topic-chip bp-topic-chip--<?php echo esc_attr( $topic['color'] ); ?>">
                        <?php echo $topic['label']; ?>
                    </a>
                <?php endforeach; ?>

            </div><!-- .bp-topics-grid -->

        </div>
    </section><!-- Topics -->


    <!-- =========================================================
         SECTION 5: LATEST ARTICLES
         ========================================================= -->
    <section class="bp-section bp-section--gray" aria-label="Latest articles">
        <div class="bp-section__inner">

            <header class="bp-section__header">
                <span class="bp-section__eyebrow">Blog</span>
                <h2 class="bp-section__title">Latest from Bankopedia</h2>
                <p class="bp-section__desc">
                    Expert articles on Indian banking, finance, and investment — simplified.
                </p>
            </header>

            <?php
            $bp_query = new WP_Query( [
                'post_type'           => 'post',
                'post_status'         => 'publish',
                'posts_per_page'      => 3,
                'ignore_sticky_posts' => true,
                'orderby'             => 'date',
                'order'               => 'DESC',
            ] );
            ?>

            <div class="bp-articles-grid">

                <?php if ( $bp_query->have_posts() ) : ?>

                    <?php while ( $bp_query->have_posts() ) : $bp_query->the_post(); ?>

                        <article class="bp-article-card">

                            <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                                    <?php the_post_thumbnail( 'medium_large', [
                                        'class'   => 'bp-article-card__thumb',
                                        'loading' => 'lazy',
                                        'alt'     => '',
                                    ] ); ?>
                                </a>
                            <?php else : ?>
                                <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                                    <div class="bp-article-card__thumb-placeholder" aria-hidden="true">📰</div>
                                </a>
                            <?php endif; ?>

                            <div class="bp-article-card__body">

                                <?php
                                $cats = get_the_category();
                                if ( $cats ) :
                                ?>
                                    <a href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>"
                                       class="bp-article-card__category">
                                        <?php echo esc_html( $cats[0]->name ); ?>
                                    </a>
                                <?php endif; ?>

                                <h3 class="bp-article-card__title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>

                                <p class="bp-article-card__excerpt">
                                    <?php echo wp_trim_words( get_the_excerpt(), 18, '…' ); ?>
                                </p>

                                <div class="bp-article-card__footer">
                                    <span class="bp-article-card__date">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                            <line x1="16" y1="2" x2="16" y2="6"/>
                                            <line x1="8" y1="2" x2="8" y2="6"/>
                                            <line x1="3" y1="10" x2="21" y2="10"/>
                                        </svg>
                                        <?php echo esc_html( get_the_date( 'j M Y' ) ); ?>
                                    </span>
                                    <a href="<?php the_permalink(); ?>" class="bp-article-card__read-more"
                                       aria-label="<?php echo esc_attr( 'Read: ' . get_the_title() ); ?>">
                                        Read more
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <line x1="5" y1="12" x2="19" y2="12"/>
                                            <polyline points="12 5 19 12 12 19"/>
                                        </svg>
                                    </a>
                                </div>

                            </div><!-- .bp-article-card__body -->

                        </article><!-- .bp-article-card -->

                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>

                <?php else : ?>

                    <div class="bp-no-posts">
                        <p>Articles coming soon. Check back shortly!</p>
                    </div>

                <?php endif; ?>

            </div><!-- .bp-articles-grid -->

            <div style="text-align:center; margin-top:40px;">
                <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="bp-btn bp-btn--primary">
                    View All Articles
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
            </div>

        </div>
    </section><!-- Latest Articles -->


    <!-- =========================================================
         SECTION 6: NEWSLETTER CTA
         ========================================================= -->
    <section class="bp-newsletter" aria-label="Newsletter subscription">
        <div class="bp-newsletter__inner">

            <h2 class="bp-newsletter__title">Stay ahead in Indian Finance</h2>
            <p class="bp-newsletter__subtitle">
                Join thousands of banking professionals and students who get weekly
                finance insights, regulatory updates, and calculator tips.
            </p>

            <?php
            // Check if MailPoet shortcode is available; fall back to a basic HTML form.
            if ( shortcode_exists( 'mailpoet_form' ) ) {
                echo do_shortcode( '[mailpoet_form id="1"]' );
            } else {
            ?>
                <form class="bp-newsletter__form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" aria-label="Subscribe to newsletter">
                    <?php wp_nonce_field( 'bp_newsletter_subscribe', 'bp_nonce' ); ?>
                    <input type="hidden" name="action" value="bp_newsletter_subscribe">
                    <input
                        type="email"
                        name="email"
                        placeholder="Enter your email address"
                        required
                        aria-label="Email address"
                        autocomplete="email"
                    >
                    <button type="submit">Subscribe Free →</button>
                </form>
            <?php } ?>

        </div>
    </section><!-- Newsletter -->

</main><!-- #site-content -->

<?php get_footer(); ?>
