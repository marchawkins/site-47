<?php snippet('header') ?>

<main>    
    <?php
        $slashes = $page->children()->listed();
    ?>

    <article>
        <h1>/<?= $page->title() ?></h1>
        <p><?php echo $page->text()->kirbytext() ?></p>

        <?php snippet('slashes-footer') ?>
         
    </article>
    
</main>

<?php snippet('footer') ?>