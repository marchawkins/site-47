<?php

return function ($kirby, $page) {

  $directoryPath = 'content/4_guestbook/guestbook_entries/';

  $alerts  = [];
  $success = '';

  if ($kirby->request()->is('post') === true && get('submit')) {

    // function to validate user input
    function validateInput($data) {
      return htmlspecialchars(stripslashes(trim($data)));
    }
    
    // check the honeypot
    if (empty(get('website')) === false) {
      go($page->url());
      exit();
    }

    // handle form input
    $name = validateInput($kirby->request()->get('name'));
    $email = validateInput($kirby->request()->get('email'));
    $message = validateInput($kirby->request()->get('message'));
    $entry = [
      'name' => $name,
      'message' => $message,
      'email' => $email,
      'images' => [],
      'status' => 'pending',
      'timestamp' => date('Y-m-d_H-i-s')
    ];



    // handle uploads
    $uploads = $kirby->request()->files()->get('file');
    if($uploads[0]['name']!='') {
      
      // we only want 1 file
      if (count($uploads) > 1) {
        $alerts['exceedMax'] = 'You may only upload 1 file.';
        return compact('alerts', 'success');
      }

      // authenticate as almighty
      $kirby->impersonate('kirby');

      foreach ($uploads as $upload) {

        // check for duplicate
        $files      = page('guestbook-entries')->files();
        $duplicates = $files->filter(function ($file) use ($upload) {
          // get original safename without prefix
          $pos              = strpos($file->filename(), '_');
          $originalSafename = substr($file->filename(), $pos + 1);

          return $originalSafename === F::safeName($upload['name']) &&
                  $file->mime() === $upload['type'] &&
                  $file->size() === $upload['size'];
        });

        if ($duplicates->count() > 0) {
          $alerts[$upload['name']] = "The file already exists";
          continue;
        }

        try {
          $name = crc32($upload['name'].microtime()). '_' . $upload['name'];
          $file = page('guestbook-entries')->createFile([
            'source'   => $upload['tmp_name'],
            'filename' => $name,
            'template' => 'upload',
            'content' => [
                'date' => date('Y-m-d h:m')
            ]
          ]);
          $fullImagePath = $file->url();
          $success = 'Photo uploaded.';
          array_push($entry['images'],$fullImagePath);
        } catch (Exception $e) {
          $alerts[$upload['name']] = $e->getMessage();
        }
      }
    }

    $fileName = $directoryPath . 'entry_' . $entry['timestamp'] . '.txt'; // Unique file name based on timestamp
    $entryJson = json_encode($entry, JSON_PRETTY_PRINT); // Convert entry to JSON
    if(file_put_contents($fileName, $entryJson)) { // Save entry to a new file
      $success = 'Thank you for your message. It will be reviewed before going live.';
    }
  }

  return compact('alerts', 'success');
};