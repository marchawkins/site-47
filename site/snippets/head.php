<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php snippet('ascii-title01') ?> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page->title() ?> | <?= $site->title() ?></title>
    <?php
        $metaTags = ['marc hawkins','marchawkins.com'];
        array_push($metaTags,$page->title());
        if($page->year_start()->isNotEmpty()):
            array_push($metaTags,$page->year_start());
        elseif($page->date_taken()):
            array_push($metaTags,$page->date_taken()->toDate('F, Y'));
        endif;
        if($page->tags()->isNotEmpty()):
            $tagsArray = $page->tags()->split();
            $metaTags = array_merge($metaTags, $tagsArray);
        endif;
        $keywords = implode(', ', $metaTags);
    ?>
    <meta name="keywords" content="<?php echo htmlspecialchars($keywords, ENT_QUOTES, 'UTF-8'); ?>"/>
    
    <?php
        $metaDescription = "";
        $maxLength = 155;
        if($page->text()->isNotEmpty()):
            $metaDescription .= $page->text();
            if (strlen($metaDescription) > $maxLength):
                $metaDescription = substr($metaDescription, 0, $maxLength)."...";
            endif;
        else:
            $metaDescription .= $page->title()." from marchawkins.com";
        endif;
    ?>
    <meta name="description" content="<?php echo htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8'); ?>"/>

    <?php if($page->title()!='Home'): ?>
        <?= css('assets/css/styles.css'); ?>
    <?php endif ?>
    <?php if($page->title()=='About' || $page->title()=='Projects' || $page->intendedTemplate()->name()=='project'): ?>
        <?= css('assets/css/flickity.css'); ?>
        <?= js('assets/js/flickity.pkgd.min.js'); ?>
    <?php endif ?>
    <?php if($page->title()=='Guestbook'): ?>
        <?php echo css(['/media/plugins/mauricerenck/komments/komments.css']); ?>
    <?php endif ?>
    <?= css('@auto'); ?>
    <?= css($page->files()->filterBy('extension', 'css')->pluck('url')) ?>
    <?= js($page->files()->filterBy('extension', 'js')->pluck('url')) ?>
</head>
<body id="<?= $page->slug() ?>">