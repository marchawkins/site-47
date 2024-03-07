<?php snippet('header') ?>    

<main>
    <?php if($photos = $page->files()->shuffle()): ?>
        <div id="photostrip">
        <?php foreach($photos as $photo): ?>
            <img loading="lazy" src="<?php echo $photo->url() ?>" alt="<?php echo $photo->name() ?> photo" height="300"/>
        <?php endforeach ?>
        </div><!-- #photostrip -->
    <?php endif ?>
    <article>
        <h1><?php echo $page->title() ?></h1>
        <h2><?php echo $page->subtitle() ?></h2>
        <div id="content">
            <?php echo $page->text()->kirbytext() ?>
        </div><!-- #content -->
    </article>
</main>

<?php snippet('footer') ?>