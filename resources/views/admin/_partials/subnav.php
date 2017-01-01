<div class="page-header">
    <ul class="nav nav-tabs">
        <li <?= $this->app->setActive('Admin/SettingController', 'index') ?>>
            <?= $this->url->link(t('Application settings'), 'Admin/SettingController', 'index') ?>
        </li>
        <li <?= $this->app->setActive('Admin/UserController', 'index') ?>>
            <?= $this->url->link(t('Users management'), 'Admin/UserController', 'index') ?>
        </li>
        <li <?= $this->app->setActive('Admin/GroupController', 'index') ?>>
            <?= $this->url->link(t('Groups management'), 'Admin/GroupController', 'index') ?>
        </li>
        <li <?= $this->app->setActive('Admin/PluginController', 'show') ?>>
            <?= $this->url->link(t('Plugins management'), 'Admin/PluginController', 'show') ?>
        </li>
        <li <?= $this->app->setActive('Admin/AdminController', 'help') ?>>
            <?= $this->url->link(t('Help'), 'Admin/AdminController', 'help') ?>
        </li>
        <li <?= $this->app->setActive('Admin/AdminController', 'about') ?>>
            <?= $this->url->link(t('About'), 'Admin/AdminController', 'about') ?>
        </li>
        <?= $this->hook->render('template:config:subside') ?>
    </ul>
</div>