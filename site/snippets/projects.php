<ul class="projects">
<?php foreach($projects as $project): ?>
    <li>
        <a href="<?php echo $project->url() ?>">
            <figure>
                <?php echo $project->image()->crop(400,500) ?>
                <figcaption><?php echo $project->title()?><br/><small><?php echo $project->category() ?></small></figcaption>
            </figure>
        </a>
    </li>
<?php endforeach ?>
</ul>