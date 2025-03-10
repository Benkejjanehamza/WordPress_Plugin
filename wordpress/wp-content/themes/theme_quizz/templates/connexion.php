<section class="hola">
    <div class="navi">
        <div class="asa-g-e"></div>
        <div class="asa-g-d"></div>
        <div class="asa-p-e"></div>
        <div class="asa-p-d"></div>
        <div class="corpo"></div>
    </div>
    <div class="navi2">
        <div class="asa-g-e"></div>
        <div class="asa-g-d"></div>
        <div class="asa-p-e"></div>
        <div class="asa-p-d"></div>
        <div class="corpo"></div>
    </div>
    <div class="zelda-form-container">
        <div class="zelda-form-toggle">
            <button id="toggleToSignup" class="zelda-toggle-button">Inscription</button>
            <button id="toggleToLogin" class="zelda-toggle-button">Connexion</button>
        </div>
        <form class="zelda-form" id="signupForm" method="post" action="">
            <h2 class="zelda-form-title">Inscription</h2>
            <div class="zelda-form-group">
                <label for="signupUsername" class="zelda-form-label">Nom d'utilisateur</label>
                <input type="text" id="signupUsername" name="signupUsername" class="zelda-form-input" required>
            </div>
            <div class="zelda-form-group">
                <label for="signupEmail" class="zelda-form-label">Email</label>
                <input type="email" id="signupEmail" name="signupEmail" class="zelda-form-input" required>
            </div>
            <div class="zelda-form-group">
                <label for="signupPassword" class="zelda-form-label">Mot de passe</label>
                <input type="password" id="signupPassword" name="signupPassword" class="zelda-form-input" required>
            </div>
            <input type="hidden" name="action" value="signup">
            <button type="submit" class="zelda-form-button">S'inscrire</button>
        </form>

        <form class="zelda-form" id="loginForm" method="post" action="" style="display: none;">
            <h2 class="zelda-form-title">Connexion</h2>
            <div class="zelda-form-group">
                <label for="loginUsername" class="zelda-form-label">Nom d'utilisateur</label>
                <input type="text" id="loginUsername" name="loginUsername" class="zelda-form-input" required>
            </div>
            <div class="zelda-form-group">
                <label for="loginPassword" class="zelda-form-label">Mot de passe</label>
                <input type="password" id="loginPassword" name="loginPassword" class="zelda-form-input" required>
            </div>
            <input type="hidden" name="action" value="login">
            <button type="submit" class="zelda-form-button">Se connecter</button>
        </form>
    </div>
    <script>
        document.getElementById('toggleToSignup').addEventListener('click', function() {
            document.getElementById('signupForm').style.display = 'block';
            document.getElementById('loginForm').style.display = 'none';
        });

        document.getElementById('toggleToLogin').addEventListener('click', function() {
            document.getElementById('signupForm').style.display = 'none';
            document.getElementById('loginForm').style.display = 'block';
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const audioMusic = new Audio('<?php echo get_template_directory_uri(); ?>/assets/music/zelda.mp3');

            window.onload = function() {
                audioMusic.play().catch(error => {
                    console.log("L'utilisateur doit interagir avec la page avant que la musique puisse être lue.", error);
                });
            };

            document.addEventListener('click', function() {
                if (audioMusic.paused) {
                    audioMusic.play();
                }
            }, { once: true });
        });
    </script>
</section>
