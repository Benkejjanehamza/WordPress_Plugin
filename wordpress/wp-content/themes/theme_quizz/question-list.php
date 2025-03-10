<?php
/*
Template Name: Question List
*/
get_header();

global $wpdb;

$table_name_questions = 'questions';
$table_name_answers = 'answers';

$questions = $wpdb->get_results("SELECT * FROM $table_name_questions ORDER BY created_at DESC");

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
            <a class="navbar-item-inner flexbox-left" href="http://localhost:8000/index.php/question-list/">
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
    <h1>Liste des Questions</h1>
    <div class="question-list">
        <?php if ($questions): ?>
            <?php foreach ($questions as $question): ?>
                <div class="question-item">
                    <h2 style="text-decoration: black underline">Titre : <?php echo esc_html($question->title); ?></h2>
                    <p>Contenu : <?php echo esc_html($question->content); ?></p>

                    <h3 style="text-decoration: black underline">Réponses :</h3>
                    <div class="answers-list">
                        <?php
                        $answers = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name_answers WHERE question_id = %d ORDER BY created_at DESC", $question->id));
                        if ($answers):
                            foreach ($answers as $answer):
                                ?>
                                <div class="answer-item">
                                    <p><?php echo esc_html($answer->content); ?></p>
                                </div>
                            <?php
                            endforeach;
                        else:
                            ?>
                            <p>Aucune réponse pour le moment.</p>
                        <?php endif; ?>
                    </div>

                    <h3>Ajouter une réponse</h3>
                    <form method="post" action="">
                        <div class="answer-form-field">
                            <textarea name="answerContent" class="answer-textarea" required></textarea>
                        </div>
                        <input type="hidden" name="action" value="submit_answer">
                        <input type="hidden" name="question_id" value="<?php echo $question->id; ?>">
                        <button type="submit" class="answer-submit-button">Répondre</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune question trouvée.</p>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
?>
