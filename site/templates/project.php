<?php snippet('header') ?>    
<main>
    <article>
        <h1><?php echo $page->title() ?></h1>
        <div class="project-layout">
            <div class="project-info">
                <?php if($page->text()->isNotEmpty()): ?>
                    <div class="project-text">
                        <?php echo $page->text()->kirbytext() ?>
                    </div>
                <?php endif ?>
                
                <dl>
                    <?php if($page->year_start()->isNotEmpty()): ?>
                    <dt>Year</dt>
                    <dd><?= $page->year_start() ?><?php if($page->year_end()->isNotEmpty() && $page->year_end()->value()!=$page->year_start()->value()): ?> - <?= $page->year_end() ?><?php endif; ?></dd>
                    <?php endif ?>
                    
                    <?php if($page->link()->isNotEmpty()): ?>
                    <dt>Link</dt>
                    <dd><?= $page->link() ?></dd>
                    <?php endif ?>

                    <?php if($page->tags()->isNotEmpty()): ?>
                    <dt>Tags</dt>
                    <dd>
                        <ul>
                        <?php foreach ($page->tags()->split() as $tag): ?>
                            <li><?= $tag ?></li>
                        <?php endforeach ?>
                        </ul>
                    </dd>
                    <?php endif ?>
                </dl>
            </div><!-- .project-info -->
            
            <?php if($page->full_gallery()->toBool() === true): ?>
            <div class="project-gallery">
                <ul>
                    <?php foreach($page->images() as $image): ?>
                    <li>
                        <figure>
                        <a href="<?php echo $image->url() ?>">
                            <img src="<?php echo $image->resize(600, 600)->url() ?>" alt="<?php echo $image->alt() ?>"/>
                        </a>
                        <figcaption><?php echo $image->caption() ?></figcaption>
                        </figure>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div><!--. project-gallery -->
            <?php endif ?>
        </div><!-- .project-layout -->
    </article>
</main>

<?php snippet('footer') ?>    