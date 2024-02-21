<?php snippet('header') ?>

<main>
    <h1><?php echo $page->title() ?></h1>
    
    <ul>
    <?php foreach($page->children() as $subpage): ?>
        <li>
            <a href="<?= $subpage->url() ?>">
                <figure>
                    <?php echo $subpage->image()->crop(200,200) ?>
                    <figcaption><?php echo $subpage->title()?><br/><small><?php echo $subpage->date_taken() ?></small></figcaption>
                </figure>
            </a>
    </li>
    <?php endforeach ?>
    </ul>
    
</main>

<?php snippet('footer') ?>    