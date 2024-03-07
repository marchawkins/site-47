<?php snippet('header') ?>

<main>
    <article>
        <h1><?php echo $page->title() ?></h1>
        <ul>
            <?php foreach($page->children()->listed()->sortBy('date_taken', 'desc') as $subpage): ?>
            <li>
                <a href="<?= $subpage->url() ?>" title="<?php echo $subpage->title() ?>"><img loading="lazy" src="<?php echo $subpage->image()->crop(200,200)->url() ?>" alt="<?php echo $subpage->title() ?>"/></a>
            </li>
            <?php endforeach ?>
            <li></li>
        </ul>
    </article>
</main>

<?php snippet('footer') ?>    