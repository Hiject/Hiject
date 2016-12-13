<p class="activity-title">
    <?= e('%s set a new internal link for the task %s',
        $this->url->link($author, 'ProfileController', 'profile', ['user_id' => $author_username]),
        $this->url->link(t('#%d', $task['id']), 'TaskViewController', 'show', ['task_id' => $task['id'], 'project_id' => $task['project_id']])
    ) ?>
    <small class="activity-date"><?= $this->dt->datetime($date_creation) ?></small>
</p>
<div class="activity-description">
    <p class="activity-task-title">
        <?= e(
            'This task is now linked to the task %s with the relation "%s"',
            $this->url->link(t('#%d', $task_link['opposite_task_id']), 'TaskViewController', 'show', ['task_id' => $task_link['opposite_task_id']]),
            $this->text->e(t($task_link['label']))
        ) ?>
    </p>
</div>
