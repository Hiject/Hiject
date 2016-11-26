<div class="page-header">
    <h2><?= t('Edit project') ?></h2>
    <ul>
        <li ><?= $this->url->link(t('General'), 'ProjectEditController', 'edit', ['project_id' => $project['id']], false, 'popover-link') ?></li>
        <li><?= $this->url->link(t('Dates'), 'ProjectEditController', 'dates', ['project_id' => $project['id']], false, 'popover-link') ?></li>
        <li><?= $this->url->link(t('Description'), 'ProjectEditController', 'description', ['project_id' => $project['id']], false, 'popover-link') ?></li>
        <li class="active"><?= $this->url->link(t('Task priority'), 'ProjectEditController', 'priority', ['project_id' => $project['id']], false, 'popover-link') ?></li>
    </ul>
</div>
<form method="post" class="popover-form" action="<?= $this->url->href('ProjectEditController', 'update', ['project_id' => $project['id'], 'redirect' => 'priority']) ?>" autocomplete="off">
    <?= $this->form->csrf() ?>
    <?= $this->form->hidden('id', $values) ?>
    <?= $this->form->hidden('name', $values) ?>

    <?= $this->form->label(t('Default priority'), 'priority_default') ?>
    <?= $this->form->number('priority_default', $values, $errors) ?>

    <?= $this->form->label(t('Lowest priority'), 'priority_start') ?>
    <?= $this->form->number('priority_start', $values, $errors) ?>

    <?= $this->form->label(t('Highest priority'), 'priority_end') ?>
    <?= $this->form->number('priority_end', $values, $errors) ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-info"><?= t('Save') ?></button>
        <?= t('or') ?>
        <?= $this->url->link(t('cancel'), 'ProjectViewController', 'show', ['project_id' => $project['id']], false, 'btn btn-default close-popover') ?>
    </div>
</form>

<p class="alert alert-info"><?= t('If you put zero to the low and high priority, this feature will be disabled.') ?></p>
