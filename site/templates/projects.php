<?php snippet('header') ?>

<main>    
    <?php
        $projects = $page->children()->listed()->sortBy('year_start', 'desc')->paginate(24);
        
        if($tag = param('tag')):
            $projects = $projects->filterBy('tags', $tag, ',');
        else:
            $tag = false;
        endif;

        $pagination = $projects->pagination();
    ?>

    <article>
        <h1><?= $page->title() ?></h1>
        <?php if($tag): ?>
            <h2>Tagged "<?= $tag ?>"</h2>
        <?php endif; ?>
        
        <div class="projects-wrapper">
            <ul>
            <?php foreach($projects as $project): ?>
                <li><a class="project" href="<?= $project->url() ?>" title="<?= $project->title() ?>"><span><?= $project->title() ?></span></a></li>
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

        <?php if($tag): ?>
            <nav class="pagination">
                <a href="/projects/<?php if(isset($_GET['page_num'])):?>page:<?= $_GET['page_num'] ?><?php endif ?>" title="all projects">all projects</a>
            </nav>
        <?php endif; ?>
    </article>
    
</main>

<?php snippet('footer') ?>