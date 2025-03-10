<?php
/*
Template Name: Pose Une Question
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
    <h1>Posez Votre Question</h1>
    <form id="questionSubmissionForm" method="post" action="">
        <div class="question-form-field">
            <label for="questionTitle">Titre de la Question</label>
            <input type="text" id="questionTitle" name="questionTitle" class="question-input" required>
        </div>
        <div class="question-form-field">
            <label for="questionContent">Votre Question</label>
            <textarea id="questionContent" name="questionContent" class="question-textarea" required></textarea>
        </div>
        <input type="hidden" name="action" value="submit_question">
        <button type="submit" class="question-submit-button">Poser la Question</button>
    </form>
</main>


<?php
get_footer();
?>
