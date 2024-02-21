<?php snippet('header') ?>

<main>
    <h1><?php echo $page->title() ?></h1>
    
    <nav class="filter">
        <a href="<?php echo $page->url() ?>">All</a>
        <?php foreach($filters as $filter): ?>
        <a href="<?php echo $page->url() ?>?filter=<?php echo $filter ?>"><?php echo $filter ?></a>
        <?php endforeach ?>
    </nav>
    <ul class="projects">
    <?php foreach($projects as $project): ?>
        <li>
            <a href="<?php echo $project->url() ?>">
                <figure>
                    <?php echo $project->image()->crop(400,500) ?>
                    <figcaption><?php echo $project->title()?><br/><small><?php echo $project->category() ?></small></figcaption>
                </figure>
            </a>
        </li>
    <?php endforeach ?>
    </ul>
    
    
</main>

<?php snippet('footer') ?>    