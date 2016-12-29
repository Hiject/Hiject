<div class="page-header">
    <h2><?= t('Remove a link') ?></h2>
</div>

<div class="confirm">
    <p class="alert alert-info">
        <?= t('Do you really want to remove this link: "%s"?', $link['label']) ?>
    </p>

    <div class="form-actions">
        <?= $this->url->link(t('Confirm'), 'Admin/LinkController', 'remove', ['link_id' => $link['id']], true, 'btn btn-danger') ?>
        <?= t('or') ?>
        <?= $this->url->link(t('cancel'), 'Admin/LinkController', 'index') ?>
    </div>
</div>
