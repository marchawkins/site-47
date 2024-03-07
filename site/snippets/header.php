<?php snippet('head') ?> 

    <header>
        <nav class="menu">
            <ul>
                <?php foreach($site->children()->listed() as $item): ?>
                    <?php if($item->title()=='About'): ?>
                        <li class="logo"><a href="<?php echo $site->url() ?>" title="<?php echo $site->title() ?>">link</a></li>
                    <?php endif ?>
                    <li><a href="<?php echo $item->url() ?>" title="<?php echo $item->title() ?>" <?php e($item->isOpen(), ' class="active"') ?>><?php echo $item->title()?></a></li>
                <?php endforeach ?>
            </ul>
        </nav>
    </header>