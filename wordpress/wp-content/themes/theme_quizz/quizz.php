<?php
/*
Template Name: Quizz
*/
get_header();
?>

<div class="content-area">
    <nav id="navbar">
        <ul class="navbar-items flexbox-col">
            <li class="navbar-logo flexbox-left">
                <a class="navbar-item-inner flexbox">
                    <img class="zeldaLogo" src="<?php echo get_template_directory_uri(); ?>/assets/img/zeldaFlute.png" alt="Zelda Intro"/>
                </a>
            </li>
            <li class="navbar-item flexbox-left">
                <a class="navbar-item-inner flexbox-left" href="http://localhost:8000/index.php/my-main-page/">
                    <div class="navbar-item-inner-icon-wrapper flexbox">
                        <ion-icon name="home-outline"></ion-icon>
                    </div>
                    <span class="link-text">Home</span>
                </a>
            </li>
            <li class="navbar-item flexbox-left">
                <a class="navbar-item-inner flexbox-left" href="http://localhost:8000/index.php/pose-une-question/">
                    <div class="navbar-item-inner-icon-wrapper flexbox">
                        <ion-icon name="folder-open-outline"></ion-icon>
                    </div>
                    <span class="link-text">Je préfère poser les questions</span>
                </a>
            </li>
            <li class="navbar-item flexbox-left">
                <a class="navbar-item-inner flexbox-left" href="http://localhost:8000/index.php/question-list">
                    <div class="navbar-item-inner-icon-wrapper flexbox">
                        <ion-icon name="pie-chart-outline"></ion-icon>
                    </div>
                    <span class="link-text">Je préfère donner les réponses</span>
                </a>
            </li>
            <li class="navbar-item flexbox-left">
                <a class="navbar-item-inner flexbox-left" href="http://localhost:8000/index.php/quizz/">
                    <div class="navbar-item-inner-icon-wrapper flexbox">
                        <ion-icon name="pie-chart-outline"></ion-icon>
                    </div>
                    <span class="link-text">Voir les quizz</span>
                </a>
            </li>
            <?php if (current_user_can('manage_options')) : ?>
                <li class="navbar-item flexbox-left">
                    <a class="navbar-item-inner flexbox-left" href="http://localhost:8000/index.php/admin-page/">
                        <div class="navbar-item-inner-icon-wrapper flexbox">
                            <ion-icon name="pie-chart-outline"></ion-icon>
                        </div>
                        <span class="link-text">Admin pannel</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <main class="site-main" id="main">
        <h1>Les quizz</h1>
        <?php
        while ( have_posts() ) :
            the_post();
            the_content();
        endwhile;

        echo do_shortcode('[display_quizz]');
        ?>
    </main>
</div>

<?php
get_footer();
?>
