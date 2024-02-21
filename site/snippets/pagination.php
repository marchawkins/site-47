<?php if($pagination->hasPages()): ?>
    <nav class="pagination">
        <?php if($pagination->hasPrevPage()): ?>
        <a href="<?php echo $pagination->prevPageUrl() ?>" aria-label="previous page">&larr;</a>
        <?php else: ?>
            <span>&larr;</span>
        <?php endif ?>
        
        <span>Page <?php echo $pagination->page() ?> of <?php echo $pagination->pages() ?></span>

        <?php if($pagination->hasNextPage()): ?>
        <a href="<?php echo $pagination->nextPageUrl() ?>" aria-label="next page">&rarr;</a>
        <?php else: ?>
            <span>&rarr;</span>
        <?php endif ?>
    </nav>
    <?php endif ?>