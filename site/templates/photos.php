<?php snippet('header') ?>

<?php
    $photos   = $page->children()->listed()->sortBy('date_taken', 'desc')->paginate(5);
    $pagination = $photos->pagination();
?>
<main>
    <article>
        <h1><?php echo $page->title() ?></h1>
        <ul>
            <?php foreach($photos as $photopage): ?>
            <li>
                <a href="<?= $photopage->url() ?>" title="<?php echo $photopage->title() ?>"><img loading="lazy" src="<?php echo $photopage->image()->crop(200,200)->url() ?>" alt="<?php echo $photopage->title() ?>"/></a>
            </li>
            <?php endforeach ?>
            <li></li>
        </ul>
    </article>

    <?php if ($pagination->hasPages()): ?>
        <nav class="pagination">
        <?php if ($pagination->hasNextPage()): ?>
            <a class="next" href="<?= $pagination->nextPageURL() ?>">older photos</a>
        <?php endif ?>

        <?php if ($pagination->hasPrevPage()): ?>
            <a class="prev" href="<?= $pagination->prevPageURL() ?>">newer photos</a>
        <?php endif ?>
        </nav>
    <?php endif ?>
</main>

<?php snippet('footer') ?>    