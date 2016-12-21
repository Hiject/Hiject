<?php

/*
 * This file is part of Jitamin.
 *
 * Copyright (C) 2016 Jitamin Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jitamin\Controller;

/**
 * Setting Controller.
 */
class SettingController extends BaseController
{
    /**
     * Display the application settings page.
     */
    public function index()
    {
        $is_outdated = false;
        $current_version = APP_VERSION;
        $latest_version = APP_VERSION;
        if ($this->userSession->isAdmin()) {
            $latest_tag = str_replace(['V', 'v'], '', $this->updateManager->latest());
            $is_outdated = version_compare($latest_tag, APP_VERSION, '>');
            $current_version = APP_VERSION;
            $latest_version = $latest_tag;
        }

        $this->response->html($this->helper->layout->setting('admin/setting/application', [
            'is_outdated'      => $is_outdated,
            'current_version'  => $current_version,
            'latest_version'   => $latest_version,
            'mail_transports'  => $this->emailClient->getAvailableTransports(),
            'skins'            => $this->skinModel->getSkins(),
            'languages'        => $this->languageModel->getLanguages(),
            'timezones'        => $this->timezoneModel->getTimezones(),
            'date_formats'     => $this->dateParser->getAvailableFormats($this->dateParser->getDateFormats()),
            'datetime_formats' => $this->dateParser->getAvailableFormats($this->dateParser->getDateTimeFormats()),
            'time_formats'     => $this->dateParser->getAvailableFormats($this->dateParser->getTimeFormats()),
            'title'            => t('Settings').' &raquo; '.t('Application settings'),
        ]));
    }

    /**
     * Display the email settings page.
     */
    public function email()
    {
        $values = $this->settingModel->getAll();

        if (empty($values['mail_transport'])) {
            $values['mail_transport'] = MAIL_TRANSPORT;
        }

        $this->response->html($this->helper->layout->setting('admin/setting/email', [
            'values'          => $values,
            'mail_transports' => $this->emailClient->getAvailableTransports(),
            'title'           => t('Settings').' &raquo; '.t('Email settings'),
        ]));
    }

    /**
     * Display the project settings page.
     */
    public function project()
    {
        $this->response->html($this->helper->layout->setting('admin/setting/project', [
            'colors'          => $this->colorModel->getList(),
            'default_columns' => implode(', ', $this->boardModel->getDefaultColumns()),
            'title'           => t('Settings').' &raquo; '.t('Project settings'),
        ]));
    }

    /**
     * Display the board settings page.
     */
    public function board()
    {
        $this->response->html($this->helper->layout->setting('admin/setting/board', [
            'title' => t('Settings').' &raquo; '.t('Board settings'),
        ]));
    }

    /**
     * Display the calendar settings page.
     */
    public function calendar()
    {
        $this->response->html($this->helper->layout->setting('admin/setting/calendar', [
            'title' => t('Settings').' &raquo; '.t('Calendar settings'),
        ]));
    }

    /**
     * Display the integration settings page.
     */
    public function integrations()
    {
        $this->response->html($this->helper->layout->setting('admin/setting/integrations', [
            'title' => t('Settings').' &raquo; '.t('Integrations'),
        ]));
    }

    /**
     * Display the webhook settings page.
     */
    public function webhook()
    {
        $this->response->html($this->helper->layout->setting('admin/setting/webhook', [
            'title' => t('Settings').' &raquo; '.t('Webhook settings'),
        ]));
    }

    /**
     * Display the api settings page.
     */
    public function api()
    {
        $this->response->html($this->helper->layout->setting('admin/setting/api', [
            'title' => t('Settings').' &raquo; '.t('API'),
        ]));
    }

    /**
     * Display the help page.
     */
    public function help()
    {
        $this->response->html($this->helper->layout->setting('admin/setting/help', [
            'db_size'    => $this->settingModel->getDatabaseSize(),
            'db_version' => $this->db->getDriver()->getDatabaseVersion(),
            'user_agent' => $this->request->getServerVariable('HTTP_USER_AGENT'),
            'title'      => t('Settings').' &raquo; '.t('About'),
        ]));
    }

    /**
     * Display the about page.
     */
    public function about()
    {
        $this->response->html($this->helper->layout->setting('admin/setting/about', [
            'db_size'    => $this->settingModel->getDatabaseSize(),
            'db_version' => $this->db->getDriver()->getDatabaseVersion(),
            'user_agent' => $this->request->getServerVariable('HTTP_USER_AGENT'),
            'title'      => t('Settings').' &raquo; '.t('About'),
        ]));
    }

    /**
     * Save settings.
     */
    public function save()
    {
        $values = $this->request->getValues();
        $redirect = $this->request->getStringParam('redirect', 'index');

        switch ($redirect) {
            case 'index':
                $values += ['password_reset' => 0];
                break;
            case 'project':
                $values += [
                    'subtask_restriction'      => 0,
                    'subtask_time_tracking'    => 0,
                    'cfd_include_closed_tasks' => 0,
                    'disable_private_project'  => 0,
                ];
                break;
            case 'integrations':
                $values += ['integration_gravatar' => 0];
                break;
            case 'calendar':
                $values += ['calendar_user_subtasks_time_tracking' => 0];
                break;
        }

        if ($this->settingModel->save($values)) {
            $this->languageModel->loadCurrentLanguage();
            $this->flash->success(t('Settings saved successfully.'));
        } else {
            $this->flash->failure(t('Unable to save your settings.'));
        }

        $this->response->redirect($this->helper->url->to('SettingController', $redirect));
    }

    /**
     * Download the Sqlite database.
     */
    public function downloadDb()
    {
        $this->checkCSRFParam();
        $this->response->withFileDownload('db.sqlite.gz');
        $this->response->binary($this->settingModel->downloadDatabase());
    }

    /**
     * Optimize the Sqlite database.
     */
    public function optimizeDb()
    {
        $this->checkCSRFParam();
        $this->settingModel->optimizeDatabase();
        $this->flash->success(t('Database optimization done.'));
        $this->response->redirect($this->helper->url->to('SettingController', 'index'));
    }

    /**
     * Regenerate webhook token.
     */
    public function token()
    {
        $type = $this->request->getStringParam('type');

        $this->checkCSRFParam();
        $this->settingModel->regenerateToken($type.'_token');

        $this->flash->success(t('Token regenerated.'));
        $this->response->redirect($this->helper->url->to('SettingController', $type));
    }
}
