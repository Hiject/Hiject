<section id="main">
    <section class="sidebar-container" id="dashboard">
        <?= $this->render($sidebar_template, ['user' => $user]) ?>
        <div class="sidebar-content">
            <?= $content_for_sublayout ?>
        </div>
    </section>
</section>
