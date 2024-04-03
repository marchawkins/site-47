<?php snippet('header') ?>
<style>
/* The work below, CSSBox, is released under the Creative Commons
   Attribution-ShareAlike 4.0 license and is available on
   https://github.com/TheLastProject/CSSBox. You are not required to add
   additional credit to your website, just leave the above text in this file */
   div.cssbox {
  display: inline-block;
}

span.cssbox_full {
  z-index: 999999;
  position: fixed;
  height: 100%;
  width: 100%;
  background-color: rgba(0,0,0,0.8);
  top: 0;
  left: 0;
  opacity: 0;
  pointer-events: none;
  cursor: default;
  transition: opacity 0.5s linear;
}

span.cssbox_full img {
  position: fixed;
  background-color: white;
  margin: 0;
  padding: 0;
  max-height: 90%;
  max-width: 90%;
  top: 50%;
  left: 50%;
  margin-right: -50%;
  transform: translate(-50%, -50%);
  box-shadow: 0 0 20px black;
}

a.cssbox_close,
a.cssbox_prev,
a.cssbox_next {
  z-index: 999999;
  position: fixed;
  text-decoration: none;
  visibility: hidden;
  color: #fff;
  font-size: 36px;
  display: block;
  background: #000;
  padding: .5rem;
  border-radius: .5rem;
}

a.cssbox_close:visited,
a.cssbox_prev:visited,
a.cssbox_next:visited {
    color: #fff;
}

a.cssbox_close {
  top: 1%;
  right: 1%
}

a.cssbox_close::after {
  content: '\00d7';
}

a.cssbox_prev,
a.cssbox_next {
  top: 50%;
  transform: translate(0%, -50%);
}

a.cssbox_prev {
  left: 5%;
}

a.cssbox_next {
  right: 5%;
}

a:target ~ a.cssbox_close,
a:target ~ a.cssbox_prev,
a:target ~ a.cssbox_next {
  visibility: visible;
}

a:target > img.cssbox_thumb + span.cssbox_full {
  visibility: visible;
  opacity: 1;
  pointer-events: initial;
}
/* This is the end of CSSBox */

</style>

<main>
    <article>
        <section class="text">
            <h1><?php echo $page->title() ?></h1>
       
                <?php if($page->text()->isNotEmpty()): ?>
                    <div class="project-text">
                        <?php echo $page->text()->kirbytext() ?>
                    </div>
                <?php endif ?>

                <h4>Project Details</h4>
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
                            <li><a href="<?= url('projects', ['params' => ['tag' => $tag]]) ?>" title="more <?= $tag ?> projects"><?= $tag ?></a></li>
                        <?php endforeach ?>
                        </ul>
                    </dd>
                    <?php endif ?>
                </dl>
        </section>
        
        <?php if($page->full_gallery()->toBool() === true): ?>
            <?php
                $galleryTotal   = $page->images()->count();
                $counter        = 1;
            ?>
            <section class="gallery cssbox">
                <h4>Gallery</h4>
                <ul>
                    <?php foreach($page->images() as $image): ?>
                        <?php $counter++ ?>
                    <li>
                        <!-- <a href="<?php echo $image->url() ?>" target="_blank" title="View larger">
                            <img src="<?php echo $image->crop(300,300)->url() ?>" alt="<?php echo $image->alt() ?>"/>
                        </a> -->
                        <!-- <?php echo $image->caption() ?> -->
                        <a id="image<?= $counter ?>" href="#image<?= $counter ?>"><img class="cssbox_thumb" src="<?php echo $image->crop(300,300)->url() ?>" />
                            <span class="cssbox_full"><img src="<?php echo $image->url() ?>" /></span>
                        </a>
                        <a class="cssbox_close" href="#void"></a>
                        <a class="cssbox_prev" href="#image<?= $counter-1 ?>">&lt;</a>
                        <a class="cssbox_next" href="#image<?= $counter+1 ?>">&gt;</a>
                    </li>
                    <?php endforeach ?>
                    <li></li>
                </ul>
            </section>
        <?php endif ?>
        
        <nav class="pagination">
            <a href="/projects/<?php if(isset($_GET['page_num'])):?>page:<?= $_GET['page_num'] ?><?php endif ?>" title="all projects">all projects</a>
        </nav>
    </article>
</main>

<?php snippet('footer') ?>    