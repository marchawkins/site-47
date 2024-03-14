<?php snippet('header') ?>

<main>
    <?php if($photos = $page->files()->shuffle()): ?>
        <div class="main-carousel" data-flickity='{ "cellAlign": "left", "freeScroll": true, "imagesLoaded": true, "percentPosition": false, "wrapAround": true, "prevNextButtons": false, "pageDots": false }'>
        <?php foreach($photos as $photo): ?>
            <div class="carousel-cell"><img src="<?php echo $photo->url() ?>" alt="<?php echo $photo->name() ?> photo" height="300"/></div>
        <?php endforeach ?>
        </div><!-- .carousel -->
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