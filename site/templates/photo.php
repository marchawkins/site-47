<?php snippet('header') ?>

<main>
    <article>
        <h1><?php echo $page->title() ?></h1>
        <?php if($page->files()->count() < 2): ?>
            single
        <?php else: ?>
            multiple
        <?php endif ?>
    </article>
</main>

<?php snippet('footer') ?>