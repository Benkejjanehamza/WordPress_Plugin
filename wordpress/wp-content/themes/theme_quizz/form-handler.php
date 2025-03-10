<?php
function handle_form_submission() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['action'] === 'signup') {
            handle_signup_form_submission();
        } elseif ($_POST['action'] === 'login') {
            handle_login_form_submission();
        }
    }
}

add_action('template_redirect', 'handle_form_submission');

function handle_signup_form_submission() {
    if (isset($_POST['signupUsername']) && isset($_POST['signupEmail']) && isset($_POST['signupPassword'])) {
        $username = sanitize_text_field($_POST['signupUsername']);
        $email = sanitize_email($_POST['signupEmail']);
        $password = $_POST['signupPassword'];

        $userdata = array(
            'user_login' => $username,
            'user_email' => $email,
            'user_pass' => $password,
        );

        $user_id = wp_insert_user($userdata);

        if (!is_wp_error($user_id)) {
            error_log('User registered successfully. Redirecting...');
            wp_redirect(home_url('/my-main-page/'));
            exit();
        } else {
            // Gérer les erreurs
            error_log('Error registering user: ' . $user_id->get_error_message());
            echo 'Erreur : ' . $user_id->get_error_message();
        }
    }
}

function handle_login_form_submission() {
    if (isset($_POST['loginUsername']) && isset($_POST['loginPassword'])) {
        $username = sanitize_text_field($_POST['loginUsername']);
        $password = $_POST['loginPassword'];

        $creds = array(
            'user_login' => $username,
            'user_password' => $password,
            'remember' => true,
        );

        $user = wp_signon($creds, false);

        if (!is_wp_error($user)) {
            error_log('User logged in successfully. Redirecting...');
            wp_redirect(home_url('/index.php/my-main-page/'));
            exit();
        } else {
            error_log('Error logging in user: ' . $user->get_error_message());
            echo 'Erreur : ' . $user->get_error_message();
        }
    }
}
function handle_question_submission() {
    global $wpdb;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'submit_question') {
        if (isset($_POST['questionTitle']) && isset($_POST['questionContent']) && is_user_logged_in()) {
            $title = sanitize_text_field($_POST['questionTitle']);
            $content = sanitize_textarea_field($_POST['questionContent']);
            $user_id = get_current_user_id();

            $table_name = 'questions';

            $data = array(
                'title' => $title,
                'content' => $content,
                'user_id' => $user_id,
                'created_at' => current_time('mysql')
            );

            $format = array('%s', '%s', '%d', '%s');

            $inserted = $wpdb->insert($table_name, $data, $format);

            if ($inserted) {
                wp_redirect(home_url('/index.php/question-list/'));
                exit;
            } else {
                echo 'Erreur lors de l\'insertion de la question.';
            }
        }
    }
}

add_action('template_redirect', 'handle_question_submission');

function handle_answer_submission() {
    global $wpdb;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'submit_answer') {
        if (isset($_POST['answerContent']) && isset($_POST['question_id']) && is_user_logged_in()) {
            $content = sanitize_textarea_field($_POST['answerContent']);
            $question_id = intval($_POST['question_id']);
            $user_id = get_current_user_id();

            $table_name = 'answers';

            $data = array(
                'question_id' => $question_id,
                'content' => $content,
                'user_id' => $user_id,
                'created_at' => current_time('mysql')
            );

            $format = array('%d', '%s', '%d', '%s');

            $inserted = $wpdb->insert($table_name, $data, $format);

            if ($inserted) {
                wp_redirect(get_permalink());
                exit;
            } else {
                echo 'Erreur lors de l\'insertion de la réponse.';
            }
        }
    }
}

add_action('template_redirect', 'handle_answer_submission');
