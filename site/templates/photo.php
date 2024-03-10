<?php snippet('header') ?>

<?php
    
?>
<main>
    <article>
        <h1><?php echo $page->title() ?></h1>
        <?php if($page->text()): ?>
            <p><?php echo $page->text()->kirbytext() ?></p>
        <?php endif ?>

        <div id="photos">
        <?php foreach($page->files() as $file): ?>
            <img loading="lazy" src="<?php echo $file->url() ?>" alt="<?php echo $page->title() ?> photo"/>
        <?php endforeach ?>
        </div><!-- #photos -->

        <nav class="pagination">
        <?php if ($page->hasPrevListed()): ?>
            <a class="next" href="<?= $page->prevListed()->url() ?>" title="previous photo">older photos</a>
        <?php endif ?>

        <?php if ($page->hasNextListed()): ?>
            <a class="prev" href="<?= $page->nextListed()->url() ?>" title="next photo">newer photos</a>
        <?php endif ?>

            <a href="/photos" title="all photos">all photos</a>
        </nav>
    </article>
</main>

<?php snippet('footer') ?>