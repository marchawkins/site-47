<?php

return function() {
    return collection('projects')
        ->filterBy('featured', true);
};

?>