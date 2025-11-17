<?php snippet('header') ?>

<main>    

    <article>
        <h1>/<?= $page->title() ?></h1>
        <p><?php echo $page->text()->kirbytext() ?></p>

        <?php foreach ($page->items()->toStructure() as $item): ?>
            <div class="canon-item">
                <h3><?= $item->title() ?></h3>
                <p><?= $item->description() ?></p>
                <p><?= $item->url() ?></p>
            </div><!-- .canon-item -->
        <?php endforeach ?>

        <?php snippet('slashes-footer') ?>
    </article>
    
</main>

<?php snippet('footer') ?>