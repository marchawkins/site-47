<?php snippet('header') ?>    

<main>
    <article>
        <h1><?php echo $page->title() ?></h1>
        <h2><?php echo $page->subtitle() ?></h2>
        <div id="content">
            <?php echo $page->text()->kirbytext() ?>
        </div><!-- .section -->
    </article>
</main>

<?php snippet('footer') ?>