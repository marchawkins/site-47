<?php snippet('header') ?>

<main>    

    <article>
        <h1>/<?= $page->title() ?></h1>
        <p><?php echo $page->text()->kirbytext() ?></p>

        <?php foreach ($page->items()->toStructure() as $item): ?>
            <div class="canon-item">
                <h3><?= $item->title() ?></h3>
                <p style="display: none;"><?= $item->description() ?></p>
                <p><?= $item->url() ?></p>
                <p><?= $item->year() ?></p>
                <?php if($thumbURL = $item->thumbnail()->toFile()->url()): ?>
                    <img src="<?= $thumbURL?>" alt="thumbnail for <?= $item->title() ?>">
                <?php endif ?> 
            </div><!-- .canon-item -->
        <?php endforeach ?>

        <?php snippet('slashes-footer') ?>
    </article>
    
</main>

<?php snippet('footer') ?>