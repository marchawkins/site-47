<?php snippet('header') ?>

<main>    
    <?php
        $projects = $page->children()->listed()->sortBy('title', 'asc')->paginate(24);
        
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
            <?php foreach($projects as $project): ?>
                <div>
                    <a class="project" href="<?= $project->url() ?>">
                    <?php
                    if($project->images()->template('thumbnail-image')->first()):
                        echo $project->images()->template('thumbnail-image')->first()->thumb([
                            'width'   => 75,
                            'height'  => 75,
                            'crop'    => true,
                            'quality' => 80
                        ])->html();
                    endif; ?>
                    <span><?= $project->title() ?></span></a>
                </div>
            <?php endforeach ?>
        </div><!-- .projects-wrapper -->

        <?php if($tag): ?>
            <nav class="pagination">
                <a href="/projects/<?php if(isset($_GET['page_num'])):?>page:<?= $_GET['page_num'] ?><?php endif ?>" title="all projects">all projects</a>
            </nav>
        <?php endif; ?>
    </article>
    
</main>

<?php snippet('footer') ?>