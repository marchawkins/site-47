<?php

return function($page) {

    $filterBy = get('filter');
    $unfiltered = collection('projects');
    $projects = $unfiltered
        ->when($filterBy, function($filterBy) {
            return $this->filterBy('category',$filterBy);
        })
        //->paginate(3)
        ;

    $pagination = $projects->pagination();
    $filters = $unfiltered->pluck('category', null, true);

    return[
       'filterBy'   => $filterBy,
       'unfiltered' => $unfiltered,
       'projects'   => $projects,
       'pagination' => $pagination,
       'filters'    => $filters
    ];


};
