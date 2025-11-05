<?php snippet('header') ?>

<main>    
    <?php
        $slashes = $page->children()->listed();
    ?>

    <article>
        <p>AI template</p>
        <h1><?= $page->title() ?></h1>
        <p><?php echo $page->text()->kirbytext() ?></p>

    </article>
    
</main>

<?php snippet('footer') ?>