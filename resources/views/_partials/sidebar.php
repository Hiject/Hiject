<?php $has_project_creation_access = $this->user->hasAccess('Project/ProjectController', 'create'); ?>
<?php $is_private_project_enabled = $this->app->setting('disable_private_project', 0) == 0; ?>
<div class="sidebar">
    <div class="sidememu">
        <a href="/"><div class="menu-top"></div></a>
        <div class="menu-tab">
            <ul class="sidebar-menu">
                <li <?= $this->app->setActive('Dashboard/DashboardController', 'index') ?>>
                    <?= $this->url->link('<i class="fa fa-dashboard"></i><br />'.t('My'), 'Dashboard/DashboardController', 'index') ?>
                </li>
                <li <?= $this->app->setActive('SearchController', 'index') ?>>
                    <?= $this->url->link('<i class="fa fa-search"></i><br />'.t('Search'), 'SearchController', 'index') ?>
                </li>
                <li <?= $this->app->setActive('Dashboard/DashboardController', 'notifications') ?>>
                    <?php if ($this->user->hasNotifications()): ?>
                        <?= $this->url->link('<i class="fa fa-bell web-notification-icon"></i><br />'.t('Notice'), 'Dashboard/DashboardController', 'notifications', [], false, '', t('You have unread notifications')) ?>
                    <?php else: ?>
                        <?= $this->url->link('<i class="fa fa-bell"></i><br />'.t('Notice'), 'Dashboard/DashboardController', 'notifications', [], false, '', t('You have no unread notifications')) ?>
                    <?php endif ?>
                </li>
                <?php if ($has_project_creation_access || (!$has_project_creation_access && $is_private_project_enabled)): ?>
                <hr/>
                <li class="dropdown">
                    <a href="#" class="dropdown-menu" title="<?= t('New project') ?>"><i class="fa fa-plus-circle"></i><br /><?= t('Create') ?></a>
                    <ul>
                        <?php if ($has_project_creation_access): ?>
                            <li><i class="fa fa-cube"></i>
                                <?= $this->url->link(t('New project'), 'Project/ProjectController', 'create', [], false, 'popover') ?>
                            </li>
                        <?php endif ?>
                        <?php if ($is_private_project_enabled): ?>
                            <li>
                                <i class="fa fa-lock"></i>
                                <?= $this->url->link(t('New private project'), 'Project/ProjectController', 'createPrivate', [], false, 'popover') ?>
                            </li>
                        <?php endif ?>
                        <?= $this->hook->render('template:sidebar:creation-dropdown') ?>
                    </ul>
                </li>
                <?php endif ?>
                 <?php if ($this->user->hasAccess('Project/ProjectController', 'index')): ?>
                <li <?= $this->app->setActive('Project/ProjectController', 'index') ?>>
                    <?= $this->url->link('<i class="fa fa-wrench"></i><br />'.t('Manage'), 'Project/ProjectController', 'index', [], false, '', t('Project management')) ?>
                </li>
                <?php endif ?>
                <?php if ($this->user->hasAccess('Admin/AdminController', 'index')): ?>
                <hr/>
                <li <?= $this->app->setActive('Admin/AdminController', 'index') ?>>
                    <?= $this->url->link('<i class="fa fa-gear"></i><br />'.t('Admin'), 'Admin/AdminController', 'index', [], false, '', t('Admin Control Panel')) ?>
                </li>
                <?php endif ?>
            </ul>
        </div>
        <div class="menu-bottom"></div>
    </div>
</div>