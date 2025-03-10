<?php
/*
Template Name: My Main Page
*/
get_header();
?>
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
<main id="main" class="flexbox-col">
    <h1 class="zelda-title">Zelda ocarina of time -Quizz</h1>
    <div class="section1">
        <h2 class="title1">Plongez dans le monde épique de 'The Legend of Zelda: Ocarina of Time', où aventures héroïques, mystères
            enchantés et batailles légendaires vous attendent au tournant.</h2>
        <div class="container">
            <div>
                <a href="https://zelda.fandom.com/wiki/Princess_Zelda" target="_blank">
                <div class="content">
                    <h2>Zelda</h2>
                    <span>Princess of Hyrule</span>
                </div>
                </a>
            </div>
            <div>
                <a href="https://zelda.fandom.com/wiki/Hero_of_Time" target="_blank">
                <div class="content">
                    <h2>Link</h2>
                    <span>Hero of time</span>
                </div>
                </a>
            </div>
            <div>
                <a href="https://zelda.fandom.com/wiki/Ganon" target="_blank">
                <div class="content">
                        <h2>Ganon</h2>
                        <span>King of gerudo</span>

                </div>
                </a>
            </div>
            <div>
                <a href="https://zelda.fandom.com/wiki/Skull_Kid" target="_blank">
                    <div class="content">
                        <h2>Skull</h2>
                        <span>Forest child</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</main>
<?php
get_footer();
?>
