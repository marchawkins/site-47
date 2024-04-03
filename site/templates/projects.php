<?php snippet('header') ?>

<main>
    <h1><?= $page->title() ?></h1>
    
    <?php
        $projects = $page->children()->listed()->sortBy('title', 'asc')->paginate(24);

        if($tag = param('tag')) {
            $projects = $projects->filterBy('tags', $tag, ',');
        }

        $pagination = $projects->pagination();
    ?>

    <div class="main-carousel" data-flickity='{ "cellAlign": "left", "freeScroll": true, "imagesLoaded": true, "percentPosition": false, "wrapAround": true, "prevNextButtons": false, "pageDots": false }'>
    <?php foreach($projects->shuffle() as $project): ?>
        <div class="carousel-cell"><a href="<?= $project->url() ?>" title="<?= $project->title() ?>"><img src="<?= $project->file()->url() ?>" alt="<?= $project->title() ?> photo" height="300"/></a></div>
    <?php endforeach ?>
    </div><!-- .carousel -->
    
    <article>
        <div class="projects-wrapper">
        <?php foreach($projects as $project): ?>
            <div><a href="<?= $project->url() ?>"><?= $project->title() ?></a></div>
        <?php endforeach ?>
        </div>
    </article>
    
</main>

<?php snippet('footer') ?>