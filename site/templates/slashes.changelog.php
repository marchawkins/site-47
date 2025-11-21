<?php snippet('header') ?>

 <style>
    .release { margin-bottom: 20px; }
    .commit { list-style-type: disc; margin-left: 20px; }
</style>

<main>    

    <article>
        <h1>/<?= $page->title() ?></h1>
        <p><?php echo $page->text()->kirbytext() ?></p>


        <?php
        $owner = "marchawkins";
        $repo = "site-47";

        // GitHub API URL for commits (max 100 per page)
        $url = "https://api.github.com/repos/{$owner}/{$repo}/commits?per_page=100&sort=author-date&direction=desc";

        // GitHub requires User-Agent header
        $headers = [
            "User-Agent: MyApp/1.0",
            "Accept: application/vnd.github.v3+json"
        ];

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Process response
        if ($httpCode == 200) {
            $commits = json_decode($response, true);

            // Start changelog output
            if (empty($commits)) {
                echo "<p>No commits found in this repository.</p>";
            } else {
                echo "<ol>";
                foreach ($commits as $commit) {
                    // Extract commit details
                    $sha = substr($commit['sha'], 0, 7);
                    try {
                        // Convert to Eastern Time (ET)
                        $utcDate = new DateTime($commit['commit']['author']['date']);
                        $easternZone = new DateTimeZone('America/New_York');
                        $utcDate->setTimezone($easternZone);
                        $formattedDate = $utcDate->format('F j, Y g a T'); // e.g., "November 5, 2025 7am ET"
                    } catch (Exception $e) {
                        $formattedDate = date('F j, Y g a', strtotime($commit['commit']['author']['date'])); // fallback without timezone
                    }

                    $message = nl2br(htmlspecialchars(trim($commit['commit']['message'])));

                    // Format output
                    echo "<li>";
                    echo "<a href='https://github.com/{$owner}/{$repo}/commit/{$commit['sha']}'>" . htmlspecialchars($sha) . "</a><br>";
                    echo "<small><span class='commit-date'>{$formattedDate}</span></small><br/>";
                    echo "<div class='commit-message'>{$message}</div>";
                    echo "</li>";
                }
                echo "</ol>";

            }
            echo "<p>Note: Only showing the first 100 commits. The <a href=\"https://github.com/{$owner}/{$repo}/commits/main/\">repository</a> has more.</p>";
        } else {
            // Error handling
            $errorMessage = "Unknown error";
            try {
                $errorData = json_decode($response, true);
                if (isset($errorData['message'])) {
                    $errorMessage = htmlspecialchars($errorData['message']);
                }
            } catch (Exception $e) {
                // Keep the default message
            }

            echo "<h2>Failed to load changelog (HTTP {$httpCode})</h2>";
            echo "<p>Error: {$errorMessage}</p>";
            echo "<p>Please try again later or check the <a href=\"https://github.com/{$owner}/{$repo}/commits/main/\">repository commits</a>.</p>";
        }
        ?>



        <?php snippet('slashes-footer') ?>
         
    </article>
    
</main>

<?php snippet('footer') ?>

<?php /*

function getAllCommits($owner, $repo) {
    $all_commits = [];
    $page = 1;
    $per_page = 100; // Maximum allowed

    while (true) {
        $url = "https://api.github.com/repos/{$owner}/{$repo}/commits?per_page={$per_page}&page={$page}";

        // Make API request (using the githubApiRequest function from previous example)
        $commits = githubApiRequest($url);

        if (empty($commits)) {
            break; // No more data
        }

        $all_commits = array_merge($all_commits, $commits);

        // If we got fewer than max items, it's the last page
        if (count($commits) < $per_page) {
            break;
        }

        $page++;
    }

    return $all_commits;
}


*/ ?>