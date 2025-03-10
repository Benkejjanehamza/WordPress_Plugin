<?php
/*
Plugin Name: My Spam
Description: Un plugin pour envoyer des emails aux utilisateurs en fonction de leurs activités sur les quiz.
Version: 1.0
Author: Votre Nom
*/

if (!defined('ABSPATH')) {
    exit;
}

// Ajouter un menu pour l'envoi de mails
add_action('admin_menu', 'my_spam_menu');

function my_spam_menu() {
    add_menu_page(
        'My Spam',
        'My Spam',
        'manage_options',
        'my-spam',
        'my_spam_page',
        'dashicons-email',
        6
    );
}

// Configuration SMTP
add_action('phpmailer_init', 'configure_smtp');
function configure_smtp($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp.gmail.com';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 587;
    $phpmailer->Username = 't35982061@gmail.com'; // Remplacez par votre adresse email
    $phpmailer->Password = 'dpolravwujyweuax'; // Remplacez par votre mot de passe d'application
    $phpmailer->SMTPSecure = 'tls';
    $phpmailer->From = 't35982061@gmail.com'; // Remplacez par votre adresse email
    $phpmailer->FromName = 'toto'; // Remplacez par votre nom

    // Ajouter des logs pour capturer les erreurs
    $phpmailer->SMTPDebug = 2;
    $phpmailer->Debugoutput = function($str, $level) {
        error_log("SMTP [$level]: $str");
    };
}

// Page d'administration pour l'envoi de mails
function my_spam_page() {
    ?>
    <div class="wrap">
        <h1>Envoyer des mails</h1>
        <form method="post" action="">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Sélectionner les utilisateurs</th>
                    <td>
                        <select name="user_selection" required>
                            <option value="quiz_completed">Qui ont passé un ou plusieurs quiz en particulier</option>
                            <option value="quiz_not_completed">Qui n’ont pas passé un ou plusieurs quiz en particulier</option>
                            <option value="logged_in_last_month">Qui se sont connectés au moins une fois depuis 1 mois</option>
                            <option value="not_logged_in_last_month">Qui ne se sont pas connectés au moins une fois depuis 1 mois</option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Objet du mail</th>
                    <td><input type="text" name="email_subject" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Message du mail</th>
                    <td><textarea name="email_message" rows="10" cols="50" required></textarea></td>
                </tr>
            </table>
            <?php submit_button('Envoyer les mails'); ?>
        </form>
    </div>
    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        global $wpdb;
        $user_selection = sanitize_text_field($_POST['user_selection']);
        $subject = sanitize_text_field($_POST['email_subject']);
        $message = wp_kses_post($_POST['email_message']);
        $users = [];

        if ($user_selection === 'quiz_completed') {
            $users = $wpdb->get_col("SELECT DISTINCT user_id FROM {$wpdb->prefix}quizz_responses");
        } elseif ($user_selection === 'quiz_not_completed') {
            $users = $wpdb->get_col("SELECT ID FROM {$wpdb->users} WHERE ID NOT IN (SELECT DISTINCT user_id FROM {$wpdb->prefix}quizz_responses)");
        } elseif ($user_selection === 'logged_in_last_month') {
            $users = $wpdb->get_col($wpdb->prepare("SELECT ID FROM {$wpdb->users} WHERE user_login >= %s", date('Y-m-d H:i:s', strtotime('-1 month'))));
        } elseif ($user_selection === 'not_logged_in_last_month') {
            $users = $wpdb->get_col($wpdb->prepare("SELECT ID FROM {$wpdb->users} WHERE user_login < %s", date('Y-m-d H:i:s', strtotime('-1 month'))));
        }

        foreach ($users as $user_id) {
            $user_info = get_userdata($user_id);
            if ($user_info) {
                $email_sent = wp_mail($user_info->user_email, $subject, $message);
                if ($email_sent) {
                    echo '<div class="updated"><p>Email envoyé à ' . esc_html($user_info->user_email) . '.</p></div>';
                } else {
                    echo '<div class="error"><p>Échec de l\'envoi de l\'email à ' . esc_html($user_info->user_email) . '.</p></div>';
                }
            }
        }

        echo '<div class="updated"><p>Emails envoyés avec succès.</p></div>';
    }
}
?>
