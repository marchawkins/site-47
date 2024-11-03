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
    <h1>Guestbook</h1>
        <div id="content">
        <section>
            
            <form id="guestbookForm" method="post" action="">
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
                <input type="submit" value="Leave Message"/>
            </form>
            
            <script type="text/javascript">
                const MAX_SUBMISSIONS = 5;
                const SUBMISSION_INTERVAL = 3600 * 1000; // 1 hour in milliseconds
                const STORAGE_KEY = 'guestbookSubmissions';

                function getSubmissionCount() {
                    let count = localStorage.getItem(STORAGE_KEY);
                    return count ? JSON.parse(count) : { submissions: 0, lastSubmissionTime: 0 };
                }

                function setSubmissionCount(count) {
                    localStorage.setItem(STORAGE_KEY, JSON.stringify(count));
                }

                document.getElementById('guestbookForm').addEventListener('submit', function(event) {
                    const name = document.getElementById('name').value;
                    const email = document.getElementById('email').value;
                    const message = document.getElementById('message').value;

                    const { submissions, lastSubmissionTime } = getSubmissionCount();
                    if (submissions >= MAX_SUBMISSIONS && Date.now() - lastSubmissionTime < SUBMISSION_INTERVAL) {
                        alert("You have reached your submission limit for the day.");
                        return;
                    }
                    
                    if (!name || !email || !message) {
                        alert('All fields are required.');
                        event.preventDefault();
                    } else if (!/\S+@\S+\.\S+/.test(email)) {
                        alert('Please enter a valid email address.');
                        event.preventDefault();
                    }
                });
            </script>

            <?php
                function sendEmail($name, $email, $message) {
                    $to = 'marc@marchawkins.com';
                    $subject = 'New Guestbook Entry';
                    $headers = "From: no-reply@marchawkins.com\r\n";
                    $headers .= "Reply-To: no-reply@marchawkins.com\r\n";
                    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

                    $message = "Name: $name\nEmail: $email\nMessage: $message";

                    // if (mail($to, $subject, $message, $headers)) {
                    //     echo '<p>Email sent successfully.</p>';
                    // } else {
                    //     echo '<p>Email sending failed.</p>';
                    // }
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') :
                    $name = htmlspecialchars($_POST['name']);
                    $email = htmlspecialchars($_POST['email']);
                    $message = htmlspecialchars($_POST['message']);
                    saveGuestbookEntry($name, $email, $message);
                    sendEmail($name, $email, $message); // Send email with the new entry
                    echo "<p id='response'>Thank you for your message. It will be reviewed before going live.</p>";
                endif;
            ?>
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
                        if(isset($entry['email']) & !empty($entry['email'])):
                            $gravatarUrl = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($entry['email']))) . '?s=80&d=mm';
                        else:
                            $gravatarUrl = 'https://www.gravatar.com/avatar/?s=80&d=mm';
                        endif
                        ?>
                        <div class="entry-card">
                            <img src="<?php echo $gravatarUrl ?>" alt="<?php echo $entry['name'] ?>'s gravatar" class="gravatar"/>
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

<?php snippet('footer') ?>