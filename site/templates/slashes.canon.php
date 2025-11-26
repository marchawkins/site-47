<?php snippet('header') ?>

<main>    

    <article>
        <h1>/<?= $page->title() ?></h1>
        <p><?php echo $page->text()->kirbytext() ?></p>

        <?php foreach ($page->items()->toStructure() as $item): ?>
            <dl>
                <dt>
                    <?php if($thumbURL = $item->thumbnail()->toFile()->url()): ?>
                        <?php if($item->url()): ?><a href="<?= $item->url() ?>"><?php endif; ?>
                            <img src="<?= $thumbURL?>" alt="thumbnail for <?= $item->title() ?>">
                        <?php if($item->url()): ?></a><?php endif; ?>
                    <?php else: ?>
                        <?php $thumbURL = false; ?>
                        <h3><?= $item->title() ?></h3>
                    <?php endif ?> 
                </dt>
                <dd>
                    <?php if($thumbURL): ?>
                        <h3><?php if($item->url()): ?><a href="<?= $item->url() ?>"><?php endif; ?><?= $item->title() ?><?php if($item->url()): ?></a><?php endif; ?></h3>
                    <?php endif ?>
                    <p><?= $item->description() ?></p>
                    <p><?= $item->year() ?></p>
                </dd>
            </dl><!-- .canon-item -->
        <?php endforeach ?>

        <?php snippet('slashes-footer') ?>
    </article>
    
</main>

<?php snippet('footer') ?>