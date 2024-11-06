<?php snippet('header') ?>

<?php if ($success): ?>
    <div class="alert success">
        <p><?= $success ?></p>
    </div>
<?php else: ?>
    <?php if (empty($alerts) === false): ?>
        <ul>
            <?php foreach ($alerts as $alert): ?>
                <li><?= $alert ?></li>
            <?php endforeach ?>
        </ul>
    <?php endif ?>

<main>
    <article>
    <h1>Guestbook</h1>
        <div id="content">
            <section>  
                <form id="guestbookForm" method="post" enctype="multipart/form-data" action="">
                    <div class="honeypot" style="position: absolute; left: -9999px;">
                        <label for="website">Website <abbr title="required">*</abbr></label>
                        <input type="website" id="website" name="website"/>
                    </div>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required/>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required/>
                    </div>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea id="message" rows="5" name="message" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Upload Image (Webcam Capture):</label>
                        <!-- <input type="file" id="image" name="image" accept="image/*" capture="camera"/> -->
                        <input name="file[]" type="file"/>
                    </div>
                    <input type="submit" name="submit" value="Leave Message"/>
                </form>
            </section>

        <?php
        $directoryPath = 'content/4_guestbook/guestbook_entries/';
        $approvedEntries = [];

        if (file_exists($directoryPath)) {
            $files = glob($directoryPath . 'entry_*.txt');
            foreach ($files as $file) {
                $entry = json_decode(file_get_contents($file), true);
                if ($entry['status'] === 'approved') {
                    $approvedEntries[] = $entry;
                }
            }
        }

        // sort approved entries by timestamp in descending order
        // reverse the order of approved entries
        $approvedEntries = array_reverse($approvedEntries);
        ?>

        <?php if (!empty($approvedEntries)): ?>
            <section>
                <h2>Entries</h2>
                <div class="entries">
                    <?php foreach ($approvedEntries as $entry): ?>
                        <?php 
                            $date = DateTime::createFromFormat('Y-m-d_H-i-s', $entry['timestamp'], new DateTimeZone('America/New_York'));
                            $formattedDate = $date->format('l, F j, Y g:i A');
                            if (isset($entry['images']) && !empty($entry['images'])) {
                                $entryImage = htmlspecialchars($entry['images'][0]);
                            } else if(isset($entry['email']) & !empty($entry['email'])) {
                                $entryImage = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($entry['email']))) . '?s=80&d=mm';
                            } else {
                                $entryImage = 'https://www.gravatar.com/avatar/?s=80&d=mm';
                            }
                        ?>
                        <div class="entry-card">
                            <img src="<?php echo $entryImage ?>" alt="<?php echo $entry['name'] ?>'s gravatar" class="gravatar"/>
                            <div class="entry-content">
                                <strong><?php echo htmlspecialchars($entry['name']); ?></strong> <span class="time"><?php echo $formattedDate; ?></span><br/> 
                                <?php echo htmlspecialchars($entry['message']); ?>
                            </div>
                        </div><!-- .entry-card -->
                    <?php endforeach; ?>
                </div><!-- .entries -->
            </section>
        <?php endif; ?>
        </div><!-- #content -->
    </article>
</main>
<?php endif ?>

<?php snippet('footer') ?>