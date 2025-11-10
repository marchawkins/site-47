<?php snippet('header') ?>

<main>    
    <?php
        $slashes = $page->children()->listed();
    ?>

    <article>
        <div class="slashes-header">
            <img src="/assets/images/slashes-ai-cow-header.jpg" alt="AI header photo of a robot holding steak sauce in front of a field of cows.">
        </div>
        <h1>/<?= $page->title() ?></h1>
        <p><?php echo $page->text()->kirbytext() ?></p>

    </article>
    
</main>

<?php snippet('footer') ?>