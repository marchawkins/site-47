<li class="single-komment komment-type-<?php echo strtolower($komment->kommentType()); ?> <?php echo ($komment->verified()->isTrue()) ? 'verified' : '' ?>" id="komment_<?php echo $komment->id(); ?>">
    <div class="author-avatar">
        <?php if($komment->authorUrl()->isNotEmpty()): ?><a href="<?php echo $komment->authorUrl(); ?>" rel="nofollow" target="_blank"><?php endif; ?>
            <img src="<?php echo $komment->avatar(); ?>" alt="<?php echo $komment->author(); ?>">
        <?php if($komment->authorUrl()->isNotEmpty()): ?></a><?php endif; ?>
    </div>
    <div class="author-action">
        <?php if($komment->authorUrl()->isNotEmpty()): ?><a href="<?php echo $komment->authorUrl(); ?>" rel="nofollow" target="_blank"><?php endif; ?><?php echo $komment->author(); ?><?php if($komment->authorUrl()->isNotEmpty()): ?></a><?php endif; ?>
        posted on <?php echo $komment->published()->published()->toDate('l, F jS, Y'); ?>
    </div>
    <div class="mention-content">
        <?php if ($komment->komment()->komment()->isNotEmpty()) : ?>
            <div class="komment-text"><?php echo $komment->komment()->komment()->kirbytext(); ?></div>
        <?php endif; ?>
        <span class="reply"><a href="#kommentform" class="kommentReply <?php echo option('mauricerenck.komments.replyClassNames'); ?>" data-id="<?php echo $komment->id(); ?>" data-handle="<?php echo $komment->author(); ?>"><?php echo t('mauricerenck.komments.action.reply.text'); ?>&raquo;</a></span>
    </div>
</li>