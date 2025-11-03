<?php snippet('head') ?> 

    <header id="site-header">
        <nav class="menu">
            <ul>
                <?php foreach($site->children()->listed() as $item): ?>
                    <?php if($item->title()=='About'): ?>
                        <li class="logo"><a href="<?php echo $site->url() ?>" title="<?php echo $site->title() ?>">home</a></li>
                    <?php endif ?>
                    <li><a href="<?php echo $item->url() ?>" title="<?php echo $item->title() ?>" <?php e($item->isOpen(), ' class="active"') ?>><?php echo $item->title()?></a></li>
                <?php endforeach ?>
            </ul>
        </nav>
        <button id="mobile-menu-toggle" class="menu-toggle" aria-controls="mobile-menu" aria-expanded="false" aria-label="Open menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>

        <!-- mobile-only centered logo (visible even when desktop nav is hidden) -->
        <button class="mobile-logo" aria-controls="mobile-menu" aria-expanded="false" aria-label="Toggle menu">
            <span class="sr-only"><?php echo $site->title() ?></span>
        </button>

        <nav id="mobile-menu" class="mobile-menu" aria-hidden="true">
            <ul>
                <li><a href="<?php echo $site->url() ?>" title="<?php echo $site->title() ?>">Home</a></li>
                <?php foreach($site->children()->listed() as $item): ?>
                    <li class="text-link"><a href="<?php echo $item->url() ?>" title="<?php echo $item->title() ?>" <?php e($item->isOpen(), ' class="active"') ?>><?php echo $item->title()?></a></li>
                <?php endforeach ?>
            </ul>
        </nav>

        <script>
        (function(){
          var btn = document.getElementById('mobile-menu-toggle');
          var logo = document.querySelector('.mobile-logo');
          var menu = document.getElementById('mobile-menu');
          if(!btn || !menu) return;
          
          function toggleMenu(e) {
            var isOpen = menu.classList.toggle('open');
            menu.setAttribute('aria-hidden', !isOpen);
            btn.setAttribute('aria-expanded', isOpen);
            if(logo) logo.setAttribute('aria-expanded', isOpen);
          }
          
          btn.addEventListener('click', toggleMenu);
          if(logo) logo.addEventListener('click', toggleMenu);
        })();
        </script>
    </header>