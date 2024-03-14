<?php snippet('header') ?>

<?php
    
?>
<main>
    <article>
        <h1><?php echo $page->title() ?></h1>
        <?php if($page->text()): ?>
            <p><?php echo $page->text()->kirbytext() ?></p>
        <?php endif ?>
        
        <?php if($photos = $page->files()): ?>
            <div id="photos">
            <?php foreach($photos as $photo): ?>
                <img src="<?php echo $photo->url() ?>" alt="<?php echo $photo->name() ?> photo"/>
            <?php endforeach ?>
            </div><!-- #photos -->
        <?php endif ?>       

        <nav class="pagination">
        <?php if ($page->hasPrevListed()): ?>
            <a class="next" href="<?= $page->prevListed()->url() ?>" title="previous photo">older</a>
        <?php endif ?>

        <?php if ($page->hasNextListed()): ?>
            <a class="prev" href="<?= $page->nextListed()->url() ?>" title="next photo">newer</a>
        <?php endif ?>

            <a href="/photos/<?php if(isset($_GET['page_num'])):?>page:<?= $_GET['page_num'] ?><?php endif ?>" title="all photos">all</a>
        </nav>
    </article>
</main>

<?php snippet('footer') ?>