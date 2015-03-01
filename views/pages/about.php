<?php
namespace jm_twitter_cards;

if (!defined('JM_TC_VERSION')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

?>
<div class="wrap">
    <h2>JM Twitter Cards : <?php echo esc_html(get_admin_page_title()); ?></h2>

    <?php echo Tabs::admin_tabs(); ?>

    <?php
    //plugin list
    $slugs = array(
        'jm-wp-cookie-bar' => 'JM WP Cookie Bar',
        'jm-wp-d-vine' => 'JM WP D-Vine',
        'jm-instagram-feed-widget' => 'JM Instagram Feed Widget'
    );

    Author::get_author_infos(
        'Julien Maury',
        __('I am a WordPress Developer, I like to make it simple.', JM_TC_TEXTDOMAIN),
        'contact@tweetpress.fr',
        'http://tweetpressfr.github.io',
        '7BJYYT486HEH6',
        'tweetpressfr',
        'https://plus.google.com/u/0/+JulienMaury',
        $slugs
    );
    ?>
</div>


