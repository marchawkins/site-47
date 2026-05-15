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
                $images = $photopage->images();
                $imageUrls = [];
                if($images) {
                    foreach($images as $img) {
                        $imageUrls[] = $img->url();
                    }
                }
                $firstImage = $photopage->image();
                $dateStr    = $photopage->date_taken()->isNotEmpty() ? $photopage->date_taken()->toDate('F Y') : '';
                $captionStr = strip_tags($photopage->text()->kirbytext());

                // extract youtube video IDs from raw text field
                $rawText  = $photopage->text()->value();
                $videoIds = [];
                preg_match_all('/youtu\.be\/([a-zA-Z0-9_-]+)|youtube\.com\/shorts\/([a-zA-Z0-9_-]+)/', $rawText, $vidMatches);
                foreach($vidMatches[1] as $i => $id) {
                    $videoIds[] = $id ?: $vidMatches[2][$i];
                }
                $videoIds = array_values(array_filter($videoIds));
            ?>
            <li class="photo-thumb"
                role="button"
                tabindex="0"
                data-title="<?= htmlspecialchars($photopage->title()) ?>"
                data-date="<?= htmlspecialchars($dateStr) ?>"
                data-text="<?= htmlspecialchars($captionStr) ?>"
                data-images="<?= htmlspecialchars(json_encode($imageUrls)) ?>"
                data-videos="<?= htmlspecialchars(json_encode($videoIds)) ?>"
                data-url="<?= $photopage->url() ?>">
                <?php if($firstImage): ?>
                <div class="thumb-img-wrap">
                    <img loading="lazy"
                         src="<?= $firstImage->crop(200, 150)->url() ?>"
                         alt="<?= htmlspecialchars($photopage->title()) ?>"/>
                </div>
                <?php elseif(!empty($videoIds)): ?>
                <div class="thumb-img-wrap thumb-video-only">
                    <span class="thumb-play">&#9654;</span>
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
        <nav class="pagination photos-pagination">
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
            <button class="lb-arrow lb-prev" aria-label="Previous">&#9664;</button>
            <img id="lb-img" class="lb-img" src="" alt=""/>
            <iframe id="lb-video" class="lb-video" src="" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            <button class="lb-arrow lb-next" aria-label="Next">&#9654;</button>
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
// ----- scatter layout -----
(function() {
    function scatter() {
        var grid = document.querySelector('.photo-grid');
        if (!grid) return;
        var thumbs = Array.from(grid.querySelectorAll('.photo-thumb'));
        if (!thumbs.length) return;

        var containerW = grid.offsetWidth;

        // horizontal padding — keeps photos away from the article edges
        var padX   = 40;
        var usableW = containerW - padX * 2;

        // thumb width scales with usable width but caps at 150px
        var thumbW = Math.min(150, Math.floor(usableW / 3.5));

        // column count based on usable width
        var cols = Math.max(3, Math.round(usableW / (thumbW * 1.9)));
        var rows = Math.ceil(thumbs.length / cols);

        // on desktop: fit everything in the viewport (no scroll needed)
        // on mobile: calculate height from row count as before
        var isDesktop  = window.innerWidth > 768;
        var headerEl   = document.querySelector('header#site-header');
        var headerH    = headerEl ? headerEl.offsetHeight : 60;
        var containerH;

        if (isDesktop) {
            containerH = Math.max(480, window.innerHeight - headerH - 120);
        } else {
            containerH = rows * (thumbW * 1.6) + 80;
        }

        grid.style.height = containerH + 'px';

        var cellW = usableW / cols;
        var cellH = containerH / rows;

        // shuffle z-indices so overlap order is random each load
        var zArr = thumbs.map(function(_, i) { return i + 1; });
        for (var i = zArr.length - 1; i > 0; i--) {
            var j = Math.floor(Math.random() * (i + 1));
            var tmp = zArr[i]; zArr[i] = zArr[j]; zArr[j] = tmp;
        }

        thumbs.forEach(function(thumb, i) {
            var col = i % cols;
            var row = Math.floor(i / cols);

            // zone center, offset from left by padX
            var cx = padX + col * cellW + cellW / 2;
            var cy = row * cellH + cellH / 2;

            // random offset large enough to cause overlap between neighbors
            var dx = (Math.random() - 0.5) * cellW * 0.9;
            var dy = (Math.random() - 0.5) * cellH * 0.9;

            var x = cx + dx - thumbW / 2;
            var y = cy + dy - thumbW * 0.55;

            // clamp within padded zone
            x = Math.max(padX / 2, Math.min(containerW - thumbW - padX / 2, x));
            y = Math.max(8, Math.min(containerH - thumbW * 0.4, y));

            var angle = (Math.random() - 0.5) * 34; // ±17 degrees

            thumb.style.position  = 'absolute';
            thumb.style.width     = thumbW + 'px';
            thumb.style.left      = Math.round(x) + 'px';
            thumb.style.top       = Math.round(y) + 'px';
            thumb.style.transform = 'rotate(' + angle.toFixed(2) + 'deg)';
            thumb.style.zIndex    = zArr[i];
        });
    }

    // debounced resize
    var resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(scatter, 200);
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', scatter);
    } else {
        scatter();
    }
})();

// ----- lightbox -----
(function() {
    var thumbs      = Array.from(document.querySelectorAll('.photo-thumb'));
    var lb          = document.getElementById('lightbox');
    var lbImg       = document.getElementById('lb-img');
    var lbVideo     = document.getElementById('lb-video');
    var lbTitle     = document.getElementById('lb-title');
    var lbDate      = document.getElementById('lb-date');
    var lbText      = document.getElementById('lb-text');
    var lbCounter   = document.getElementById('lb-img-counter');
    var lbPermalink = document.getElementById('lb-permalink');
    var lbOlder     = document.getElementById('lb-older');
    var lbNewer     = document.getElementById('lb-newer');
    var lbPrev      = document.querySelector('.lb-prev');
    var lbNext      = document.querySelector('.lb-next');

    var currentPhotoIdx = 0;
    var currentSlideIdx = 0;
    var currentSlides   = [];

    function openLightbox(photoIdx) {
        currentPhotoIdx = photoIdx;
        currentSlideIdx = 0;
        loadPhoto(photoIdx);
        lb.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        lb.querySelector('.lb-close').focus();
    }

    function closeLightbox() {
        lbVideo.src = ''; // stop video playback
        lb.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        thumbs[currentPhotoIdx].focus();
    }

    function loadPhoto(idx) {
        var thumb     = thumbs[idx];
        var imageUrls = JSON.parse(thumb.dataset.images || '[]');
        var videoIds  = JSON.parse(thumb.dataset.videos  || '[]');

        // build unified slides array: photos first, then videos
        currentSlides = [];
        imageUrls.forEach(function(url) {
            currentSlides.push({ type: 'image', url: url });
        });
        videoIds.forEach(function(id) {
            currentSlides.push({ type: 'video', id: id });
        });

        currentSlideIdx = 0;
        updateSlide();

        lbTitle.textContent      = thumb.dataset.title || '';
        lbDate.textContent       = thumb.dataset.date  || '';
        lbText.textContent       = thumb.dataset.text  || '';
        lbPermalink.href         = thumb.dataset.url   || '#';
        lbOlder.style.visibility = (idx < thumbs.length - 1) ? 'visible' : 'hidden';
        lbNewer.style.visibility = (idx > 0)                 ? 'visible' : 'hidden';
    }

    function updateSlide() {
        if (!currentSlides.length) return;
        var slide = currentSlides[currentSlideIdx];

        if (slide.type === 'image') {
            lbImg.src             = slide.url;
            lbImg.alt             = lbTitle.textContent;
            lbImg.style.display   = 'block';
            lbVideo.src           = '';
            lbVideo.style.display = 'none';
        } else {
            lbVideo.src           = 'https://www.youtube.com/embed/' + slide.id;
            lbVideo.style.display = 'block';
            lbImg.style.display   = 'none';
            lbImg.src             = '';
        }

        lbPrev.style.visibility = (currentSlideIdx > 0)                          ? 'visible' : 'hidden';
        lbNext.style.visibility = (currentSlideIdx < currentSlides.length - 1)   ? 'visible' : 'hidden';

        if (currentSlides.length > 1) {
            lbCounter.textContent = (currentSlideIdx + 1) + ' / ' + currentSlides.length;
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

    // close — X button or Escape key
    document.querySelector('.lb-close').addEventListener('click', closeLightbox);

    // slide prev / next
    lbPrev.addEventListener('click', function() {
        if (currentSlideIdx > 0) { currentSlideIdx--; updateSlide(); }
    });
    lbNext.addEventListener('click', function() {
        if (currentSlideIdx < currentSlides.length - 1) { currentSlideIdx++; updateSlide(); }
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
            if (currentSlideIdx > 0) { currentSlideIdx--; updateSlide(); }
            else if (currentPhotoIdx > 0) { currentPhotoIdx--; loadPhoto(currentPhotoIdx); }
        } else if (e.key === 'ArrowRight') {
            if (currentSlideIdx < currentSlides.length - 1) { currentSlideIdx++; updateSlide(); }
            else if (currentPhotoIdx < thumbs.length - 1) { currentPhotoIdx++; loadPhoto(currentPhotoIdx); }
        }
    });
})();
</script>

<?php snippet('footer') ?>
