<?php snippet('header') ?>

<main>
    <?php if($photos = $page->files()->shuffle()): ?>
        <div class="main-carousel" data-flickity='{ "cellAlign": "left", "freeScroll": true, "imagesLoaded": true, "percentPosition": false, "wrapAround": true, "prevNextButtons": false, "pageDots": false }'>
        <?php foreach($photos as $photo): ?>
            <div class="carousel-cell"><img src="<?php echo $photo->url() ?>" alt="<?php echo $photo->name() ?> photo" height="300"/></div>
        <?php endforeach ?>
        </div><!-- .carousel -->
    <?php endif ?>

<section class="page-layout">
  <aside class="aside-left">
    <section class="h-card-section">
      <div class="h-card">
        <div class="h-card-details">
          <p class="p-name fn">Marc Hawkins</p>
          <p class="p-org org"><strong>Sideshow</strong></p>
          <p class="p-job-title title">Webmaster</p>
          <p><em>Employee #70</em></p>
          <hr/>
          <p><a class="u-url url" href="https://www.marchawkins.com">marchawkins.com</a></p>
          <p><a class="u-email email">marc@marchawkins.com</a></p>
          <hr/>
          <p><span class="p-locality locality">West Chester</span>, <span class="p-region region">PA</span>
          <p class="p-country-name country-name">USA</p>
          <div class="hide">
            <p class="h-geo geo">
              <span class="p-latitude latitude">39.9003875</span>,
              <span class="p-longitude longitude">-75.6257656</span>
            </p>
            <img class="u-logo logo" src="<?php echo url('assets/images/mh-logo-vanilla.png') ?>" alt="Marc Hawkins Logo"/>
            <img class="u-photo photo" src="<?php echo url('assets/images/home-me@2x.gif') ?>" alt="Marc Hawkins Photo"/>
          </div><!-- .hide -->
        </div><!-- .h-card-details -->
      </div><!-- .h-card -->
    </section>
  </aside>
  <article class="content-right">
    <h1><?php echo $page->title() ?></h1>
    <h2><?php echo $page->subtitle() ?></h2>
    <div id="content">
      <?php echo $page->text()->kirbytext() ?>
    </div><!-- #content -->
  </article>
</section>
</main>

<?php snippet('footer') ?>