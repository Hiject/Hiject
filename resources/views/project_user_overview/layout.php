<div class="page-header">
    <?= $this->render('project/_partials/nav') ?>
</div>
<section class="page-container">
    <div class="page-content">
        <div class="page-header">
            <h2><?= $this->text->e($title) ?></h2>
        </div>
        <?= $content_for_sublayout ?>
    </div>
    <?= $this->render($subside_template, ['users' => $users, 'filter' => $filter]) ?>
</section>
