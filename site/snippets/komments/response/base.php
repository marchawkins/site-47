<?php
$classNames = ['u-comment', 'h-cite'];
$classNames[] = 'comment-type_' . $comment->type();

if ($comment->verified()->isTrue()) {
    $classNames[] = 'verified';
}
?>
<li class="<?= implode(' ', $classNames); ?>" id="c<?= $comment->id(); ?>">
    <?php if ($header = $slots->header()): ?>
        <?= $header ?>
    <?php else: ?>
        <header class="comment-header h-card">
            <div class="comment-header-left">
                Posted by 
                <?php if ($comment->authorUrl()->isNotEmpty()): ?>
                    <a class="u-author" href="<?= $comment->authorUrl(); ?>" rel="nofollow" target="_blank"><?= $comment->authorName(); ?></a>
                <?php else: ?>
                    <span class="p-author"><?= $comment->authorName(); ?></span>
                <?php endif; ?>
                on <a class="u-url" href="<?= $comment->permalink(); ?>"><time class="dt-published"><?php
                    $raw = $comment->createdAt();
                    $formatted = $raw;
                    try {
                        $dt = new DateTime($raw);
                        $formatted = $dt->format('l, F j, Y');
                    } catch (\Throwable $e) {
                        // leave raw
                    }
                    echo htmlspecialchars($formatted, ENT_QUOTES, 'UTF-8');
                ?></time></a>
            </div>
        </header>
    <?php endif; ?>

    <?php if ($body = $slots->body()): ?>
        <?= $body ?>
    <?php else: ?>
        <div class="p-content p-name">
            <!-- avatar moved from header to content -->
            <div class="comment-avatar"><img src="<?= $comment->authorAvatar(); ?>" alt="<?= $comment->authorName(); ?>" class="u-photo gravatar" /></div>
            <div class="comment-content"><?php
            // safe rendering for content which may be a Kirby\Content\Content / Field
            $c = null;
            if (method_exists($comment, 'content')) {
                try { $c = $comment->content(); } catch (\Throwable $e) { $c = null; }
            }
            
            if ($c) {
                // debug removed; using normalizer below
                // normalizer: try many common renderer methods for Kirby objects/fields
                $asStr = function($v) {
                    if ($v === null) return '';
                    if (is_object($v)) {
                        $try = function($obj, $m) {
                            if (method_exists($obj, $m)) {
                                try { return $obj->$m(); } catch (\Throwable $e) { return null; }
                            }
                            return null;
                        };

                        $candidates = ['kirbytext', 'html', 'toHtml', 'text', 'toText', 'toMarkup', 'kt', 'toString', 'value', '__toString'];
                        foreach ($candidates as $method) {
                            $out = $try($v, $method);
                            if ($out !== null && $out !== false && $out !== '') return $out;
                        }

                        // arrays/structures
                        if (method_exists($v, 'toArray')) {
                            try { return print_r($v->toArray(), true); } catch (\Throwable $e) {}
                        }
                        if (method_exists($v, 'toStructure')) {
                            try { return print_r($v->toStructure(), true); } catch (\Throwable $e) {}
                        }

                        try { return print_r($v, true); } catch (\Throwable $e) {}
                        try { return json_encode($v); } catch (\Throwable $e) {}
                        return '';
                    }
                    return (string)$v;
                };

                // prefer kirbytext if available on the content object
                if (method_exists($c, 'kirbytext')) {
                    try { echo $c->kirbytext(); }
                    catch (\Throwable $e) {
                        $out = $asStr($c);
                        $decoded = html_entity_decode($out, ENT_QUOTES, 'UTF-8');
                        echo htmlspecialchars($decoded, ENT_NOQUOTES, 'UTF-8');
                    }
                } else {
                    // try to extract the inner 'content' field from Kirby\Content\Content
                    $inner = null;
                    if (is_object($c) && method_exists($c, 'get')) {
                        try { $inner = $c->get('content'); } catch (\Throwable $e) { $inner = null; }
                    }
                    if ($inner === null && is_object($c) && method_exists($c, 'toArray')) {
                        try { $arr = $c->toArray(); if (is_array($arr) && array_key_exists('content', $arr)) $inner = $arr['content']; } catch (\Throwable $e) { $inner = null; }
                    }

                    if ($inner !== null && $inner !== '') {
                        $out = $asStr($inner);
                        $decoded = html_entity_decode($out, ENT_QUOTES, 'UTF-8');
                        echo htmlspecialchars($decoded, ENT_NOQUOTES, 'UTF-8');
                    } else {
                        $out = $asStr($c);
                        $decoded = html_entity_decode($out, ENT_QUOTES, 'UTF-8');
                        echo htmlspecialchars($decoded, ENT_NOQUOTES, 'UTF-8');
                    }
                }
            } else {
                echo 'not found'; // empty content fallback
            }
            ?></div><!-- .comment-content -->
        </div>
    <?php endif; ?>

    <?php if ($replies = $slots->replies()): ?>
        <?= $replies ?>
    <?php endif; ?>
</li>