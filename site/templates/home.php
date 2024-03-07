<?php snippet('head') ?>

<header>
    <h1><?= $page->title() ?></h1>
</header>

<main>
    <div id="home-container">
        <div id="home-content">
            <nav>
                <ul>
                <?php foreach($pages->listed() as $page): ?>
                    <li><a href="<?php echo $page->url() ?>" title="<?php echo $page->title() ?>"><?php echo $page->title() ?></a></li>
                <?php endforeach ?>
                </ul>
            </nav>
            <p>Est. 1976</p>
        </div><!-- #home-content -->
       
    </div><!-- #home-container -->
</main>

<?php snippet('foot') ?>    