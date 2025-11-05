<?php snippet('header') ?>

<main>    
    <?php
        $slashes = $page->children()->listed();
    ?>

    <article>
        <h1><?= $page->title() ?></h1>
        <p><?php echo $page->text()->kirbytext() ?></p>

        <div class="projects-wrapper">
            <ul>
            <?php foreach($slashes as $slash): ?>
                <li><a class="project" href="<?= $slash->url() ?>" title="<?= $slash->title() ?>"><span>/<?= $slash->title() ?></span></a></li>
                <?php /* <div>
                    <a class="project" href="<?= $project->url() ?>" title="<?= $project->title() ?>">
                    <?php
                    if($project->images()->template('thumbnail-image')->first()):
                        echo $project->images()->template('thumbnail-image')->first()->thumb([
                            'width'   => 150,
                            'height'  => 150,
                            'crop'    => true,
                            'quality' => 80
                        ])->html();
                    endif; ?>
                    <span><?= $project->title() ?></span></a>
                </div> */ ?>
            <?php endforeach ?>
            </ul>
        </div><!-- .projects-wrapper -->
    </article>
    
</main>

<?php snippet('footer') ?>