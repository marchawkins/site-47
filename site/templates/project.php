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
                    <?php if($page->year()->isNotEmpty()): ?>
                    <dt>Year</dt>
                    <dd><?php echo $page->year() ?></dd>
                    <?php endif ?>
                    
                    <?php if($page->client()->isNotEmpty()): ?>
                    <dt>Client</dt>
                    <dd><?php echo $page->client() ?></dd>
                    <?php endif ?>

                    <?php if($page->category()->isNotEmpty()): ?>
                    <dt>Category</dt>
                    <dd><?php echo $page->category() ?></dd>
                    <?php endif ?>

                    <?php if($page->link()->isNotEmpty()): ?>
                    <dt>Link</dt>
                    <dd><?php echo $page->link() ?></dd>
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