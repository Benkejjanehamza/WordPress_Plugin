<?php
/**
 * @package WordPress
 * @subpackage Theme_Compat
 * @deprecated 3.0.0
 *
 * This file is here for backward compatibility with old themes and will be removed in a future version
 */
_deprecated_file(
/* translators: %s: Template name. */
    sprintf( __( 'Theme without %s' ), basename( __FILE__ ) ),
    '3.0.0',
    null,
    /* translators: %s: Template name. */
    sprintf( __( 'Please include a %s template in your theme.' ), basename( __FILE__ ) )
);
?>

<hr />
<div id="footer" role="contentinfo">
    <!-- If you'd like to support WordPress, having the "powered by" link somewhere on your blog is the best way; it's our only promotion or advertising. -->
    <div class="footer">

        <p class="textFooter"> B***h, I did this !</p>
        <div class="link">
            <a class="navbar-item-inner flexbox-left" style="width: fit-content" href="http://localhost:8000/index.php/my-main-page/">
                <p>Home</p>
            </a>
            <a class="navbar-item-inner flexbox-left" style="width: fit-content" href="http://localhost:8000/index.php/pose-une-question/">
                <p>Je préfère poser les questions</p>
            </a>
            <a class="navbar-item-inner flexbox-left" style="width: fit-content" href="http://localhost:8000/index.php/question-list/">
                <p>Je préfère donner les réponses</p>
            </a>
        </div>
    </div>
</div>
</div>

<!-- Gorgeous design by Michael Heilemann - http://binarybonsai.com/ -->
<?php /* "Just what do you think you're doing Dave?" */ ?>

<?php wp_footer(); ?>
</body>
</html>
