<?php snippet('header') ?>

<?php
    $photos   = $page->children()->listed()->sortBy('date_taken', 'desc')->paginate(24);
    $pagination = $photos->pagination();
?>
<main>
    <article class="gallery">
        <h1><?php echo $page->title() ?></h1>
        <ul class="photo-grid">
            <?php foreach($photos as $photopage): ?>
            <?php
                $images = $photopage->files()->images();
                $imageUrls = [];
                foreach($images as $img) {
                    $imageUrls[] = $img->url();
                }
                $firstImage = $photopage->image();
                $dateStr = $photopage->date_taken()->isNotEmpty() ? $photopage->date_taken()->toDate('F Y') : '';
                $captionStr = strip_tags($photopage->text()->kirbytext());
            ?>
            <li class="photo-thumb"
                role="button"
                tabindex="0"
                data-title="<?= htmlspecialchars($photopage->title()) ?>"
                data-date="<?= htmlspecialchars($dateStr) ?>"
                data-text="<?= htmlspecialchars($captionStr) ?>"
                data-images="<?= htmlspecialchars(json_encode($imageUrls)) ?>"
                data-url="<?= $photopage->url() ?>">
                <?php if($firstImage): ?>
                <div class="thumb-img-wrap">
                    <img loading="lazy"
                         src="<?= $firstImage->crop(400, 300)->url() ?>"
                         alt="<?= htmlspecialchars($photopage->title()) ?>"/>
                </div>
                <?php endif ?>
                <span class="thumb-caption"><?= htmlspecialchars($photopage->title()) ?></span>
                <?php if($dateStr): ?>
                <span class="thumb-date"><?= htmlspecialchars($dateStr) ?></span>
                <?php endif ?>
            </li>
            <?php endforeach ?>
        </ul>
    </article>

    <?php if ($pagination->hasPages()): ?>
        <nav class="pagination">
        <?php if ($pagination->hasPrevPage()): ?>
            <a class="prev" href="<?= $pagination->prevPageURL() ?>">newer</a>
        <?php endif ?>
        <?php if ($pagination->hasNextPage()): ?>
            <a class="next" href="<?= $pagination->nextPageURL() ?>">older</a>
        <?php endif ?>
        </nav>
    <?php endif ?>
</main>

<!-- Lightbox -->
<div id="lightbox" class="lightbox" aria-hidden="true" role="dialog" aria-modal="true" aria-label="Photo viewer">
    <div class="lb-overlay"></div>
    <div class="lb-wrap">
        <button class="lb-close" aria-label="Close">&times;</button>
        <div class="lb-stage">
            <button class="lb-arrow lb-prev" aria-label="Previous image">&#9664;</button>
            <img id="lb-img" class="lb-img" src="" alt=""/>
            <button class="lb-arrow lb-next" aria-label="Next image">&#9654;</button>
        </div>
        <p class="lb-img-counter" id="lb-img-counter"></p>
        <div class="lb-info">
            <h2 id="lb-title" class="lb-title"></h2>
            <p id="lb-date" class="lb-date"></p>
            <p id="lb-text" class="lb-text"></p>
            <div class="lb-photo-nav">
                <button id="lb-newer" class="lb-photo-btn">&#9664; newer</button>
                <a id="lb-permalink" class="lb-permalink" href="#" title="view full page">[view page]</a>
                <button id="lb-older" class="lb-photo-btn">older &#9654;</button>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    var thumbs = Array.from(document.querySelectorAll('.photo-thumb'));
    var lb        = document.getElementById('lightbox');
    var lbImg     = document.getElementById('lb-img');
    var lbTitle   = document.getElementById('lb-title');
    var lbDate    = document.getElementById('lb-date');
    var lbText    = document.getElementById('lb-text');
    var lbCounter = document.getElementById('lb-img-counter');
    var lbPermalink = document.getElementById('lb-permalink');
    var lbOlder   = document.getElementById('lb-older');
    var lbNewer   = document.getElementById('lb-newer');
    var lbPrev    = document.querySelector('.lb-prev');
    var lbNext    = document.querySelector('.lb-next');

    var currentPhotoIdx = 0;
    var currentImgIdx   = 0;
    var currentImages   = [];

    function openLightbox(photoIdx) {
        currentPhotoIdx = photoIdx;
        currentImgIdx   = 0;
        loadPhoto(photoIdx);
        lb.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        lb.querySelector('.lb-close').focus();
    }

    function closeLightbox() {
        lb.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        thumbs[currentPhotoIdx].focus();
    }

    function loadPhoto(idx) {
        var thumb = thumbs[idx];
        currentImages   = JSON.parse(thumb.dataset.images || '[]');
        currentImgIdx   = 0;
        updateImage();
        lbTitle.textContent     = thumb.dataset.title || '';
        lbDate.textContent      = thumb.dataset.date  || '';
        lbText.textContent      = thumb.dataset.text  || '';
        lbPermalink.href        = thumb.dataset.url   || '#';
        lbOlder.style.visibility = (idx < thumbs.length - 1) ? 'visible' : 'hidden';
        lbNewer.style.visibility = (idx > 0)                 ? 'visible' : 'hidden';
    }

    function updateImage() {
        if (!currentImages.length) return;
        lbImg.src = currentImages[currentImgIdx];
        lbImg.alt = lbTitle.textContent;
        lbPrev.style.visibility = (currentImgIdx > 0)                          ? 'visible' : 'hidden';
        lbNext.style.visibility = (currentImgIdx < currentImages.length - 1)   ? 'visible' : 'hidden';
        if (currentImages.length > 1) {
            lbCounter.textContent = (currentImgIdx + 1) + ' / ' + currentImages.length;
        } else {
            lbCounter.textContent = '';
        }
    }

    // open on click / keyboard
    thumbs.forEach(function(thumb, idx) {
        thumb.addEventListener('click', function() { openLightbox(idx); });
        thumb.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openLightbox(idx); }
        });
    });

    // close
    document.querySelector('.lb-close').addEventListener('click', closeLightbox);
    document.querySelector('.lb-overlay').addEventListener('click', closeLightbox);

    // image prev / next
    lbPrev.addEventListener('click', function() {
        if (currentImgIdx > 0) { currentImgIdx--; updateImage(); }
    });
    lbNext.addEventListener('click', function() {
        if (currentImgIdx < currentImages.length - 1) { currentImgIdx++; updateImage(); }
    });

    // photo page prev / next
    lbOlder.addEventListener('click', function() {
        if (currentPhotoIdx < thumbs.length - 1) { currentPhotoIdx++; loadPhoto(currentPhotoIdx); }
    });
    lbNewer.addEventListener('click', function() {
        if (currentPhotoIdx > 0) { currentPhotoIdx--; loadPhoto(currentPhotoIdx); }
    });

    // keyboard nav
    document.addEventListener('keydown', function(e) {
        if (lb.getAttribute('aria-hidden') === 'true') return;
        if (e.key === 'Escape') {
            closeLightbox();
        } else if (e.key === 'ArrowLeft') {
            if (currentImgIdx > 0) { currentImgIdx--; updateImage(); }
            else if (currentPhotoIdx > 0) { currentPhotoIdx--; loadPhoto(currentPhotoIdx); }
        } else if (e.key === 'ArrowRight') {
            if (currentImgIdx < currentImages.length - 1) { currentImgIdx++; updateImage(); }
            else if (currentPhotoIdx < thumbs.length - 1) { currentPhotoIdx++; loadPhoto(currentPhotoIdx); }
        }
    });
})();
</script>

<?php snippet('footer') ?>
