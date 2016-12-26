<?php

/*
 * This file is part of Jitamin.
 *
 * Copyright (C) 2016 Jitamin Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jitamin\Helper;

use Jitamin\Core\Base;

/**
 * Layout Helper.
 */
class LayoutHelper extends Base
{
    /**
     * Render a template without the layout if Ajax request.
     *
     * @param string $template Template name
     * @param array  $params   Template parameters
     *
     * @return string
     */
    public function app($template, array $params = [])
    {
        if ($this->request->isAjax()) {
            return $this->template->render($template, $params);
        }

        if (!isset($params['no_layout']) && !isset($params['board_selector'])) {
            $params['board_selector'] = $this->projectUserRoleModel->getActiveProjectsByUser($this->userSession->getId());
        }

        return $this->pageLayout($template, $params);
    }

    /**
     * Common layout for user views.
     *
     * @param string $template Template name
     * @param array  $params   Template parameters
     *
     * @return string
     */
    public function user($template, array $params)
    {
        if (isset($params['user'])) {
            $params['title'] = '#'.$params['user']['id'].' '.($params['user']['name'] ?: $params['user']['username']);
        }

        return $this->subLayout('profile/layout', 'profile/subside', $template, $params);
    }

    /**
     * Common layout for task views.
     *
     * @param string $template Template name
     * @param array  $params   Template parameters
     *
     * @return string
     */
    public function task($template, array $params)
    {
        $params['page_title'] = $params['task']['project_name'].', #'.$params['task']['id'].' - '.$params['task']['title'];
        $params['title'] = $params['task']['project_name'];

        return $this->subLayout('task/layout', 'task/subside', $template, $params);
    }

    /**
     * Common layout for project views.
     *
     * @param string $template
     * @param array  $params
     * @param string $subside
     *
     * @return string
     */
    public function project($template, array $params, $subside = 'project/subside')
    {
        if (empty($params['title'])) {
            $params['title'] = $params['project']['name'];
        } elseif ($params['project']['name'] !== $params['title']) {
            $params['title'] = $params['project']['name'].' &raquo; '.$params['title'];
        }

        return $this->subLayout('project/layout', $subside, $template, $params);
    }

    /**
     * Common layout for project user views.
     *
     * @param string $template
     * @param array  $params
     *
     * @return string
     */
    public function projectUser($template, array $params)
    {
        $params['filter'] = ['user_id' => $params['user_id']];

        return $this->subLayout('project_user_overview/layout', 'project_user_overview/subside', $template, $params);
    }

    /**
     * Common layout for setting views.
     *
     * @param string $template
     * @param array  $params
     *
     * @return string
     */
    public function setting($template, array $params)
    {
        if (!isset($params['values'])) {
            $params['values'] = $this->settingModel->getAll();
        }

        if (!isset($params['errors'])) {
            $params['errors'] = [];
        }

        return $this->subLayout('admin/setting/layout', 'admin/setting/subside', $template, $params);
    }

    /**
     * Common layout for plugin views.
     *
     * @param string $template
     * @param array  $params
     *
     * @return string
     */
    public function plugin($template, array $params)
    {
        return $this->subLayout('plugin/layout', 'plugin/subside', $template, $params);
    }

    /**
     * Common layout for dashboard views.
     *
     * @param string $template
     * @param array  $params
     *
     * @return string
     */
    public function dashboard($template, array $params)
    {
        return $this->subLayout('dashboard/layout', 'dashboard/subside', $template, $params);
    }

    /**
     * Common layout for analytic views.
     *
     * @param string $template
     * @param array  $params
     *
     * @return string
     */
    public function analytic($template, array $params)
    {
        if (isset($params['project']['name'])) {
            $params['title'] = $params['project']['name'].' &raquo; '.$params['title'];
        }

        return $this->subLayout('analytic/layout', 'analytic/subside', $template, $params);
    }

    /**
     * Render page layout.
     *
     * @param string $template Template name
     * @param array  $params   Key/value dictionary
     * @param string $layout   Layout name
     *
     * @return string
     */
    public function pageLayout($template, array $params = [], $layout = 'layouts/master')
    {
        return $this->template->render(
            $layout,
            $params + ['content_for_layout' => $this->template->render($template, $params)]
        );
    }

    /**
     * Common method to generate a sub-layout.
     *
     * @param string $sublayout
     * @param string $subside
     * @param string $template
     * @param array  $params
     *
     * @return string
     */
    public function subLayout($sublayout, $subside, $template, array $params = [])
    {
        $content = $this->template->render($template, $params);

        if ($this->request->isAjax()) {
            return $content;
        }

        $params['content_for_sublayout'] = $content;
        $params['subside_template'] = $subside;

        return $this->app($sublayout, $params);
    }
}
