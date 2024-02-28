<?php snippet('head') ?> 

    <header>
        <a class="logo" href="<?php echo $site->url() ?>"><?php echo $site->title() ?></a>
        <nav class="menu">
            <ul>
                <?php foreach($site->children()->listed() as $item): ?>
                    <li><a href="<?php echo $item->url() ?>"><?php echo $item->title()?></a></li>
                <?php endforeach ?>
            </ul>
        </nav>
    </header>