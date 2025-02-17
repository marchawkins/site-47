<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php snippet('ascii-title01') ?> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page->title() ?> | <?= $site->title() ?></title>
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