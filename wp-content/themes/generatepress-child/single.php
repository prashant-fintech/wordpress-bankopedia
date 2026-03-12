<?php
/**
 * Single Post Template — Bankopedia
 *
 * @package GeneratePress Child - Bankopedia
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="site-content" class="bp-single-page" role="main">
<div class="bp-single__container">

<?php while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class( 'bp-article' ); ?> itemscope itemtype="https://schema.org/Article">

        <!-- ── Article Header ── -->
        <header class="bp-article__header">

            <?php
            $cats = get_the_category();
            if ( $cats ) :
            ?>
                <div class="bp-article__cats">
                    <?php foreach ( array_slice( $cats, 0, 2 ) as $cat ) : ?>
                        <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"
                           class="bp-article__cat-badge">
                            <?php echo esc_html( $cat->name ); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <h1 class="bp-article__title" itemprop="headline"><?php the_title(); ?></h1>

            <div class="bp-article__meta">
                <span class="bp-article__meta-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" itemprop="datePublished">
                        <?php echo esc_html( get_the_date( 'j F Y' ) ); ?>
                    </time>
                </span>
                <span class="bp-article__meta-sep" aria-hidden="true">·</span>
                <span class="bp-article__meta-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    <span itemprop="author" itemscope itemtype="https://schema.org/Person">
                        <span itemprop="name"><?php the_author(); ?></span>
                    </span>
                </span>
                <span class="bp-article__meta-sep" aria-hidden="true">·</span>
                <span class="bp-article__meta-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                    <?php
                    $content   = get_the_content();
                    $word_count = str_word_count( wp_strip_all_tags( $content ) );
                    $read_time  = max( 1, (int) ceil( $word_count / 200 ) );
                    echo $read_time . ' min read';
                    ?>
                </span>
            </div>

            <?php if ( has_post_thumbnail() ) : ?>
                <div class="bp-article__featured-img">
                    <?php the_post_thumbnail( 'large', [
                        'loading'  => 'eager',
                        'itemprop' => 'image',
                        'alt'      => get_the_title(),
                    ] ); ?>
                </div>
            <?php endif; ?>

        </header><!-- .bp-article__header -->

        <!-- ── Article Body ── -->
        <div class="bp-article__body bp-prose" itemprop="articleBody">
            <?php the_content(); ?>
        </div>

        <!-- ── Tags ── -->
        <?php
        $tags = get_the_tags();
        if ( $tags ) :
        ?>
            <footer class="bp-article__tags">
                <span class="bp-article__tags-label">Tags:</span>
                <?php foreach ( $tags as $tag ) : ?>
                    <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"
                       class="bp-article__tag">
                        #<?php echo esc_html( $tag->name ); ?>
                    </a>
                <?php endforeach; ?>
            </footer>
        <?php endif; ?>

        <!-- ── Post Navigation ── -->
        <nav class="bp-post-nav" aria-label="Article navigation">
            <?php
            $prev = get_previous_post();
            $next = get_next_post();
            ?>
            <?php if ( $prev ) : ?>
                <a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" class="bp-post-nav__link bp-post-nav__link--prev">
                    <span class="bp-post-nav__dir">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                        </svg>
                        Previous
                    </span>
                    <span class="bp-post-nav__title"><?php echo esc_html( get_the_title( $prev ) ); ?></span>
                </a>
            <?php else : ?>
                <span></span>
            <?php endif; ?>

            <?php if ( $next ) : ?>
                <a href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="bp-post-nav__link bp-post-nav__link--next">
                    <span class="bp-post-nav__dir">
                        Next
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </span>
                    <span class="bp-post-nav__title"><?php echo esc_html( get_the_title( $next ) ); ?></span>
                </a>
            <?php endif; ?>
        </nav>

    </article><!-- .bp-article -->

    <!-- ── Related Posts ── -->
    <?php
    $current_cats = wp_get_post_categories( get_the_ID() );
    $related = new WP_Query( [
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => 3,
        'post__not_in'        => [ get_the_ID() ],
        'category__in'        => $current_cats ?: [],
        'ignore_sticky_posts' => true,
        'orderby'             => 'rand',
    ] );
    if ( $related->have_posts() ) :
    ?>
        <section class="bp-related" aria-label="Related articles">
            <h2 class="bp-related__title">Related Articles</h2>
            <div class="bp-related__grid">
                <?php while ( $related->have_posts() ) : $related->the_post(); ?>
                    <article class="bp-article-card">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                                <?php the_post_thumbnail( 'medium', [
                                    'class'   => 'bp-article-card__thumb',
                                    'loading' => 'lazy',
                                    'alt'     => '',
                                ] ); ?>
                            </a>
                        <?php else : ?>
                            <div class="bp-article-card__thumb-placeholder" aria-hidden="true">📰</div>
                        <?php endif; ?>
                        <div class="bp-article-card__body">
                            <?php $rcats = get_the_category(); if ( $rcats ) : ?>
                                <a href="<?php echo esc_url( get_category_link( $rcats[0]->term_id ) ); ?>"
                                   class="bp-article-card__category"><?php echo esc_html( $rcats[0]->name ); ?></a>
                            <?php endif; ?>
                            <h3 class="bp-article-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <div class="bp-article-card__footer">
                                <span class="bp-article-card__date">
                                    <?php echo esc_html( get_the_date( 'j M Y' ) ); ?>
                                </span>
                                <a href="<?php the_permalink(); ?>" class="bp-article-card__read-more">
                                    Read →
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </section>
    <?php endif; ?>

<?php endwhile; ?>

</div><!-- .bp-single__container -->
</main>

<?php get_footer(); ?>
