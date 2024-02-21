<?php snippet('head') ?>
<?php snippet('header') ?>    

<main>

    <h1><?php echo $page->title() ?></h1>
    <h2><?php echo $page->subtitle() ?></h2>
    <?php echo $page->text() ?>

</main>

<?php snippet('footer') ?>