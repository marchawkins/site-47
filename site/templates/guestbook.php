<?php snippet('header') ?>

<main>
    <article>
        <h1><?php echo $page->title() ?></h1>
        <div id="content">
            <section>
                <?php echo $page->text() ?>

                <?php snippet('komments/form'); ?>

                <?php snippet('komments/list/comments'); ?>
            </section>
        </div><!-- #content -->
    </article>
</main>

<?php snippet('footer') ?>