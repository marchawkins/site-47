<?php snippet('header') ?>

<main>
    <article>
        <section class="text">
            <h1><?php echo $page->title() ?></h1>
       
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
                    <dd><a href="<?= $page->link() ?>" title="view project"><?= $page->link() ?></a></dd>
                    <?php endif ?>

                    <?php if($page->tags()->isNotEmpty()): ?>
                    <dt>Tags</dt>
                    <dd>
                        <ul class="comma-list">
                        <?php foreach ($page->tags()->split() as $tag): ?>
                            <li><?= $tag ?></li>
                        <?php endforeach ?>
                        </ul>
                    </dd>
                    <?php endif ?>
                </dl>
        </section>
        
        <?php if($page->full_gallery()->toBool() === true): ?>
            <section class="gallery">
                <ul>
                    <?php foreach($page->images() as $image): ?>
                    <li>
                        <a href="<?php echo $image->url() ?>" target="_blank" title="View larger">
                            <img src="<?php echo $image->crop(300,300)->url() ?>" alt="<?php echo $image->alt() ?>"/>
                        </a>
                        <!-- <?php echo $image->caption() ?> -->
                    </li>
                    <?php endforeach ?>
                    <li></li>
                </ul>
            </section>
        <?php endif ?>

    </article>
</main>

<?php snippet('footer') ?>    