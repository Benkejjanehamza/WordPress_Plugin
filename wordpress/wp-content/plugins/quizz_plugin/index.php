<?php
/*
Plugin Name: Quizz Plugin
Description: Un plugin pour créer des questionnaires avec plusieurs questions.
Version: 1.0
Author: Votre Nom
*/

if (!defined('ABSPATH')) {
    exit;
}

// Actions à l'activation et à la désactivation
register_activation_hook(__FILE__, 'quizz_plugin_activate_unique');
register_deactivation_hook(__FILE__, 'quizz_plugin_deactivate_unique');

function quizz_plugin_activate_unique() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $table_name = $wpdb->prefix . 'quizz_plugin';
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        questions longtext NOT NULL,
        answers longtext NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    $table_name = $wpdb->prefix . 'quizz_responses';
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        quizz_id mediumint(9) NOT NULL,
        user_id bigint(20) unsigned NOT NULL,
        responses longtext NOT NULL,
        is_correct tinyint(1) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
    dbDelta($sql);
}

function quizz_plugin_deactivate_unique() {
    // Code pour nettoyer les options ou les tables créées
}

// Ajouter un menu pour l'administrateur
add_action('admin_menu', 'quizz_plugin_menu_unique');

function quizz_plugin_menu_unique() {
    if (current_user_can('manage_options')) {
        add_menu_page(
            'Quizz Plugin',
            'Quizz Plugin',
            'manage_options',
            'quizz-plugin',
            'quizz_plugin_page_unique',
            'dashicons-welcome-learn-more',
            6
        );

        add_submenu_page(
            'quizz-plugin',
            'Ajouter un Quizz',
            'Ajouter un Quizz',
            'manage_options',
            'quizz-plugin-add',
            'quizz_plugin_add_page_unique'
        );

        add_submenu_page(
            null,
            'Modifier un Quizz',
            '',
            'manage_options',
            'quizz-plugin-edit',
            'quizz_plugin_edit_page_unique'
        );

        add_submenu_page(
            'quizz-plugin',
            'Réponses aux Quizz',
            'Réponses aux Quizz',
            'manage_options',
            'quizz-plugin-responses',
            'quizz_plugin_responses_page_unique'
        );
    }
}

// Page d'administration du plugin
function quizz_plugin_page_unique() {
    if (!current_user_can('manage_options')) {
        return;
    }

    global $wpdb;

    // Récupérer les quiz existants
    $table_name = $wpdb->prefix . 'quizz_plugin';
    $quizzes = $wpdb->get_results("SELECT * FROM $table_name");

    ?>
    <div class="wrap">
        <h1>Quizz Plugin</h1>
        <h2>Liste des Quiz</h2>
        <table class="widefat fixed" cellspacing="0">
            <thead>
            <tr>
                <th class="manage-column column-columnname" scope="col">Nom du Quiz</th>
                <th class="manage-column column-columnname" scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($quizzes): ?>
                <?php foreach ($quizzes as $quiz): ?>
                    <tr>
                        <td><?php echo esc_html($quiz->name); ?></td>
                        <td>
                            <a href="<?php echo admin_url('admin.php?page=quizz-plugin-edit&id=' . $quiz->id); ?>">Modifier</a> |
                            <a href="<?php echo admin_url('admin.php?page=quizz-plugin&action=delete&id=' . $quiz->id); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce quiz ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">Aucun quiz trouvé.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php

    // Traitement de la suppression
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $quiz_id = intval($_GET['id']);
        $wpdb->delete($table_name, array('id' => $quiz_id));
        echo '<div class="updated"><p>Quiz supprimé avec succès.</p></div>';
    }
}

// Page pour ajouter un quiz
function quizz_plugin_add_page_unique() {
    if (!current_user_can('manage_options')) {
        return;
    }

    ?>
    <div class="wrap">
        <h1>Ajouter un Quizz</h1>
        <form method="post" action="">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Nom du quiz</th>
                    <td><input type="text" name="quizz_plugin_name" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Questions et options</th>
                    <td>
                        <div id="questions-container">
                            <div class="question-item">
                                <label>Question :</label>
                                <input type="text" name="questions[0][question]" required />
                                <label>Options :</label>
                                <div class="options-container">
                                    <input type="text" name="questions[0][options][]" required />
                                    <input type="text" name="questions[0][options][]" required />
                                    <input type="text" name="questions[0][options][]" />
                                    <input type="text" name="questions[0][options][]" />
                                </div>
                                <label>Réponse correcte :</label>
                                <input type="text" name="questions[0][answer]" required />
                                <button type="button" class="remove-question">Supprimer</button>
                            </div>
                        </div>
                        <button type="button" id="add-question">Ajouter une question</button>
                    </td>
                </tr>
            </table>
            <?php submit_button('Ajouter le Quiz'); ?>
        </form>
    </div>
    <script>
        let questionIndex = 1;

        document.getElementById('add-question').addEventListener('click', function() {
            let container = document.getElementById('questions-container');
            let questionItem = document.createElement('div');
            questionItem.classList.add('question-item');
            questionItem.innerHTML = `
                <label>Question :</label>
                <input type="text" name="questions[${questionIndex}][question]" required />
                <label>Options :</label>
                <div class="options-container">
                    <input type="text" name="questions[${questionIndex}][options][]" required />
                    <input type="text" name="questions[${questionIndex}][options][]" required />
                    <input type="text" name="questions[${questionIndex}][options][]" />
                    <input type="text" name="questions[${questionIndex}][options][]" />
                </div>
                <label>Réponse correcte :</label>
                <input type="text" name="questions[${questionIndex}][answer]" required />
                <button type="button" class="remove-question">Supprimer</button>
            `;
            container.appendChild(questionItem);

            questionItem.querySelector('.remove-question').addEventListener('click', function() {
                questionItem.remove();
            });

            questionIndex++;
        });

        document.querySelectorAll('.remove-question').forEach(button => {
            button.addEventListener('click', function() {
                button.closest('.question-item').remove();
            });
        });
    </script>
    <?php

    // Traitement du formulaire
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        global $wpdb;

        $name = sanitize_text_field($_POST['quizz_plugin_name']);
        $questions = array_map(function($question) {
            return [
                'question' => sanitize_text_field($question['question']),
                'options' => array_map('sanitize_text_field', $question['options']),
                'answer' => sanitize_text_field($question['answer']),
            ];
        }, $_POST['questions']);

        $table_name = $wpdb->prefix . 'quizz_plugin';
        $wpdb->insert(
            $table_name,
            array(
                'name' => $name,
                'questions' => maybe_serialize($questions),
                'answers' => maybe_serialize(array_column($questions, 'answer'))
            )
        );

        echo '<div class="updated"><p>Quizz ajouté avec succès.</p></div>';
    }
}

// Page pour modifier un quiz
function quizz_plugin_edit_page_unique() {
    if (!current_user_can('manage_options')) {
        return;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'quizz_plugin';

    if (isset($_GET['id'])) {
        $quiz_id = intval($_GET['id']);
        $quiz = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $quiz_id));

        if (!$quiz) {
            echo '<div class="error"><p>' . __('Quiz non trouvé.', 'quizz-plugin') . '</p></div>';            return;
        }

        $questions = maybe_unserialize($quiz->questions);

        ?>
        <div class="wrap">
            <h1>Modifier le Quizz</h1>
            <form method="post" action="">
                <input type="hidden" name="quizz_id" value="<?php echo esc_attr($quiz->id); ?>" />
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Nom du quiz</th>
                        <td><input type="text" name="quizz_plugin_name" value="<?php echo esc_attr($quiz->name); ?>" required /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Questions et options</th>
                        <td>
                            <div id="questions-container">
                                <?php foreach ($questions as $index => $question): ?>
                                    <div class="question-item">
                                        <label>Question :</label>
                                        <input type="text" name="questions[<?php echo $index; ?>][question]" value="<?php echo esc_attr($question['question']); ?>" required />
                                        <label>Options :</label>
                                        <div class="options-container">
                                            <?php foreach ($question['options'] as $option_index => $option): ?>
                                                <input type="text" name="questions[<?php echo $index; ?>][options][]" value="<?php echo esc_attr($option); ?>" <?php echo $option_index < 2 ? 'required' : ''; ?> />
                                            <?php endforeach; ?>
                                            <?php for ($i = count($question['options']); $i < 4; $i++): ?>
                                                <input type="text" name="questions[<?php echo $index; ?>][options][]" />
                                            <?php endfor; ?>
                                        </div>
                                        <label>Réponse correcte :</label>
                                        <input type="text" name="questions[<?php echo $index; ?>][answer]" value="<?php echo esc_attr($question['answer']); ?>" required />
                                        <button type="button" class="remove-question">Supprimer</button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="add-question">Ajouter une question</button>
                        </td>
                    </tr>
                </table>
                <?php submit_button('Mettre à jour le Quiz'); ?>
            </form>
        </div>
        <script>
            let questionIndex = <?php echo count($questions); ?>;

            document.getElementById('add-question').addEventListener('click', function() {
                let container = document.getElementById('questions-container');
                let questionItem = document.createElement('div');
                questionItem.classList.add('question-item');
                questionItem.innerHTML = `
                    <label>Question :</label>
                    <input type="text" name="questions[${questionIndex}][question]" required />
                    <label>Options :</label>
                    <div class="options-container">
                        <input type="text" name="questions[${questionIndex}][options][]" required />
                        <input type="text" name="questions[${questionIndex}][options][]" required />
                        <input type="text" name="questions[${questionIndex}][options][]" />
                        <input type="text" name="questions[${questionIndex}][options][]" />
                    </div>
                    <label>Réponse correcte :</label>
                    <input type="text" name="questions[${questionIndex}][answer]" required />
                    <button type="button" class="remove-question">Supprimer</button>
                `;
                container.appendChild(questionItem);

                questionItem.querySelector('.remove-question').addEventListener('click', function() {
                    questionItem.remove();
                });

                questionIndex++;
            });

            document.querySelectorAll('.remove-question').forEach(button => {
                button.addEventListener('click', function() {
                    button.closest('.question-item').remove();
                });
            });
        </script>
        <?php

        // Traitement du formulaire
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = sanitize_text_field($_POST['quizz_plugin_name']);
            $questions = array_map(function($question) {
                return [
                    'question' => sanitize_text_field($question['question']),
                    'options' => array_map('sanitize_text_field', $question['options']),
                    'answer' => sanitize_text_field($question['answer']),
                ];
            }, $_POST['questions']);

            $wpdb->update(
                $table_name,
                array(
                    'name' => $name,
                    'questions' => maybe_serialize($questions),
                    'answers' => maybe_serialize(array_column($questions, 'answer'))
                ),
                array('id' => intval($_POST['quizz_id']))
            );

            echo '<div class="updated"><p>Quizz mis à jour avec succès.</p></div>';
        }
    }
}

// Créer un shortcode pour afficher les questionnaires
add_shortcode('display_quizz', 'quizz_plugin_display_unique');

function quizz_plugin_display_unique() {
    global $wpdb;

    // Récupérer tous les questionnaires de la base de données
    $table_name = $wpdb->prefix . 'quizz_plugin';
    $quizzes = $wpdb->get_results("SELECT * FROM $table_name");

    ob_start();

    // Afficher chaque questionnaire
    if ($quizzes) {
        foreach ($quizzes as $quiz) {
            echo '<div class="blocQuizz">';
            echo '<h2 class="titleQuizzBloc">' . esc_html($quiz->name) . '</h2>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="quizz_id" value="' . esc_attr($quiz->id) . '">';
            $questions = maybe_unserialize($quiz->questions);
            foreach ($questions as $index => $question) {
                echo '<p class="titleQuestion"> Question : '  . esc_html($question['question']) . '</p>';
                foreach ($question['options'] as $option_index => $option) {
                    echo '<label>';
                    echo '<input type="checkbox" class="radioInput" name="responses[' . $index . '][]" value="' . esc_attr($option) . '">';
                    echo esc_html($option);
                    echo '</label><br>';
                }
            }
            echo '<br><br><button type="submit" class="answer-submit-button" name="submit_quizz" value="Envoyer">Envoyer</button>';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo 'Aucun quiz disponible.';
    }

    return ob_get_clean();
}

// Traiter les soumissions de quiz
add_action('init', 'quizz_plugin_handle_submission_unique');

function quizz_plugin_handle_submission_unique() {
    if (isset($_POST['submit_quizz']) && isset($_POST['quizz_id']) && is_user_logged_in()) {
        global $wpdb;

        $quizz_id = intval($_POST['quizz_id']);
        $user_id = get_current_user_id();
        $table_name = $wpdb->prefix . 'quizz_responses';

        $responses = array_map(function($response) {
            return array_map('sanitize_text_field', $response);
        }, $_POST['responses']);

        $quiz = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}quizz_plugin WHERE id = %d", $quizz_id));
        $correct_answers = maybe_unserialize($quiz->answers);

        $is_correct = 1;
        foreach ($responses as $index => $response) {
            if (!in_array($correct_answers[$index], $response)) {
                $is_correct = 0;
                break;
            }
        }

        $wpdb->insert(
            $table_name,
            array(
                'quizz_id' => $quizz_id,
                'user_id' => $user_id,
                'responses' => maybe_serialize($responses),
                'is_correct' => $is_correct
            )
        );

        if ($is_correct) {
            echo '<div class="updated"><p>Félicitations! Vous avez bien répondu au quiz.</p></div>';
        } else {
            echo '<div class="updated"><p>Désolé, vos réponses ne sont pas correctes.</p></div>';
        }
    }
}

// Page pour afficher les réponses aux quiz
function quizz_plugin_responses_page_unique() {
    if (!current_user_can('manage_options')) {
        return;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'quizz_responses';
    $responses = $wpdb->get_results("SELECT * FROM $table_name");

    ?>
    <div class="wrap">
        <h1>Réponses aux Quizz</h1>
        <table class="widefat fixed" cellspacing="0">
            <thead>
            <tr>
                <th class="manage-column column-columnname" scope="col">ID du Quiz</th>
                <th class="manage-column column-columnname" scope="col">Utilisateur</th>
                <th class="manage-column column-columnname" scope="col">Réponses</th>
                <th class="manage-column column-columnname" scope="col">Correct</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($responses): ?>
                <?php foreach ($responses as $response): ?>
                    <tr>
                        <td><?php echo esc_html($response->quizz_id); ?></td>
                        <td><?php
                            $user_info = get_userdata($response->user_id);
                            echo esc_html($user_info->user_login);
                            ?></td>
                        <td><?php
                            $answers = maybe_unserialize($response->responses);
                            if (is_array($answers)) {
                                foreach ($answers as $question_index => $response_options) {
                                    echo 'Question ' . ($question_index + 1) . ':<br>';
                                    foreach ($response_options as $option) {
                                        echo esc_html($option) . '<br>';
                                    }
                                    echo '<br>';
                                }
                            }
                            ?></td>
                        <td><?php echo $response->is_correct ? 'Oui' : 'Non'; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Aucune réponse trouvée.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}
?>
