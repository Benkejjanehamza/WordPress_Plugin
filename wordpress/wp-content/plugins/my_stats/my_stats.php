<?php
/*
Plugin Name: My Stats
Description: Un plugin pour afficher des statistiques sur les visiteurs et les quiz.
Version: 1.0
Author: Votre Nom
*/

if (!defined('ABSPATH')) {
    exit;
}

// Inclure Chart.js et jQuery
function my_stats_enqueue_scripts($hook) {
    if ($hook !== 'toplevel_page_my-stats') {
        return;
    }

    wp_enqueue_script('jquery');
    wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js', array(), null, true);
    wp_enqueue_script('my-stats-script', plugins_url('my_stats.js', __FILE__), array('jquery', 'chart-js'), null, true);

    wp_localize_script('my-stats-script', 'myStats', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('admin_enqueue_scripts', 'my_stats_enqueue_scripts');

// Ajouter un menu pour les statistiques
add_action('admin_menu', 'my_stats_menu');

function my_stats_menu() {
    add_menu_page(
        'My Stats',
        'My Stats',
        'manage_options',
        'my-stats',
        'my_stats_page',
        'dashicons-chart-bar',
        6
    );
}

// Page d'administration pour les statistiques
function my_stats_page() {
    ?>
    <div class="wrap">
        <h1>Statistiques des Quiz</h1>
        <canvas id="myStatsChart" width="400" height="200"></canvas>
    </div>
    <?php
}

// Récupérer les données pour les statistiques
add_action('wp_ajax_my_stats_data', 'my_stats_data');

function my_stats_data() {
    global $wpdb;

    $labels = ['Dernière année', 'Dernier mois', 'Dernière semaine', 'Dernières 24 heures'];
    $data = [];

    $time_frames = [
        '-1 year',
        '-1 month',
        '-1 week',
        '-1 day'
    ];

    foreach ($time_frames as $time_frame) {
        $count = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}quizz_responses WHERE submission_time > %s",
            date('Y-m-d H:i:s', strtotime($time_frame))
        ));
        $data[] = (int) $count;
    }

    wp_send_json_success([
        'labels' => $labels,
        'data' => $data
    ]);
}
?>
