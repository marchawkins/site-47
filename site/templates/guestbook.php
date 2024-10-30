<?php snippet('header') ?>

<?php
    // path to store guestbook entry files
    global $directoryPath;
    $directoryPath = 'content/4_guestbook/guestbook_entries/';

    // function to validate user input
    function validateInput($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    // function to save guestbook entries
    function saveGuestbookEntry($name, $email, $message) {
        global $directoryPath;
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true); // Create the directory if it doesn't exist
        }
        
        $date = new DateTime('now', new DateTimeZone('America/New_York')); // Set timezone to US Eastern
        $timestamp = $date->format('Y-m-d_H-i-s');

        $name = validateInput($name);
        $email = validateInput($email);
        $message = validateInput($message);

        $entry = [
            'name' => $name,
            'message' => $message,
            'email' => $email,
            'status' => 'pending',
            'timestamp' => date('Y-m-d_H-i-s')
        ];
        $fileName = $directoryPath . 'entry_' . $entry['timestamp'] . '.txt'; // Unique file name based on timestamp
        $entryJson = json_encode($entry, JSON_PRETTY_PRINT); // Convert entry to JSON
        file_put_contents($fileName, $entryJson); // Save entry to a new file
    }
?>

<main>
    <article>
        <section>
            <h1>Guestbook</h1>
            <form id="guestbookForm" method="post" action="">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                <input type="submit" value="Submit">
            </form>
            
            <script type="text/javascript">
                document.getElementById('guestbookForm').addEventListener('submit', function(event) {
                    var name = document.getElementById('name').value;
                    var email = document.getElementById('email').value;
                    var message = document.getElementById('message').value;

                    if (!name || !email || !message) {
                        alert('All fields are required.');
                        event.preventDefault();
                    } else if (!/\S+@\S+\.\S+/.test(email)) {
                        alert('Please enter a valid email address.');
                        event.preventDefault();
                    }
                });
            </script>

            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') :
                $name = htmlspecialchars($_POST['name']);
                $email = htmlspecialchars($_POST['email']);
                $message = htmlspecialchars($_POST['message']);
                saveGuestbookEntry($name, $email, $message);
                echo "<p>Thank you, $name, for your message. It will be reviewed before going live.</p>";
            endif; ?>
        </section>

        <?php
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
                        ?>
                        <div class="entry">
                            <p>
                                <strong><?php echo htmlspecialchars($entry['name']); ?></strong> (<?php echo $formattedDate; ?>): 
                                <?php echo htmlspecialchars($entry['message']); ?>
                            </p>
                        </div><!-- .entry -->
                    <?php endforeach; ?>
                </div><!-- .entries -->
            </section>
        <?php endif; ?>
    </article>
</main>

<?php snippet('footer') ?>