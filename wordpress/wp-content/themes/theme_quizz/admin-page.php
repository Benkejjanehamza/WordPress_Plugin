<?php
/*
Template Name: Admin Page
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
    <h1>Admin Page</h1>
    <?php
    if (!current_user_can('manage_options')) {
        wp_die('Vous n\'avez pas les permissions nécessaires pour accéder à cette page.');
    }

    global $wpdb;

    $table_name_questions = 'questions';
    $table_name_answers = 'answers';

    $questions = $wpdb->get_results("SELECT * FROM $table_name_questions ORDER BY created_at DESC");

    echo '<div class="wrap">';
    echo '<h1>Toutes les Séries de Réponses</h1>';

    if ($questions) {
        foreach ($questions as $question) {
            $user_info = get_userdata($question->user_id);
            $user_name = $user_info ? $user_info->display_name : 'Anonyme';

            echo '<div class="response-series-item">';
            echo '<h2>' . esc_html($question->title) . ' - <small>Posté par ' . esc_html($user_name) . '</small></h2>';
            echo '<p>' . esc_html($question->content) . '</p>';

            // Récupérer les réponses à la question
            $answers = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name_answers WHERE question_id = %d ORDER BY created_at DESC", $question->id));
            if ($answers) {
                echo '<h3>Réponses</h3>';
                echo '<ul>';
                foreach ($answers as $answer) {
                    $answer_user_info = get_userdata($answer->user_id);
                    $answer_user_name = $answer_user_info ? $answer_user_info->display_name : 'Anonyme';

                    echo '<li>' . esc_html($answer->content) . ' - <small>Posté par ' . esc_html($answer_user_name) . '</small></li>';
                }
                echo '</ul>';
            } else {
                echo '<p>Aucune réponse pour cette question.</p>';
            }

            echo '</div>';
        }
    } else {
        echo '<p>Aucune série de réponses trouvée.</p>';
    }

    echo '</div>';
    ?>
</main>

<?php
get_footer();
?>
