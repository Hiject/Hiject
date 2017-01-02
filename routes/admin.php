<?php

/*
 * This file is part of Jitamin.
 *
 * Copyright (C) Jitamin Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
// Users admin
'admin/users'                         => 'Admin/UserController@index',
'admin/users/create'                  => 'Admin/UserController@create',
'admin/users/create/:remote'          => 'Admin/UserController@create',
'admin/users/import'                  => 'Admin/UserImportController@show',
'admin/users/:user_id/authentication' => 'Admin/UserController@changeAuthentication',
'admin/users/:user_id/disable'        => 'Admin/UserStatusController@confirmDisable',
'admin/users/:user_id/remove'         => 'Admin/UserStatusController@confirmRemove',

// Groups admin
'admin/groups'                    => 'Admin/GroupController@index',
'admin/groups/create'             => 'Admin/GroupController@create',
'admin/groups/:group_id/edit'     => 'Admin/GroupController@edit',
'admin/groups/:group_id/remove'   => 'Admin/GroupController@confirm',
'admin/group/:group_id/members'   => 'Admin/GroupController@users',
'admin/group/:group_id/associate' => 'Admin/GroupController@associate',

// Config admin
'admin/settings'              => 'Admin/SettingController@index',
'admin/settings/application'  => 'Admin/SettingController@application',
'admin/settings/theme'        => 'Admin/SettingController@theme',
'admin/settings/localization' => 'Admin/SettingController@localization',
'admin/settings/email'        => 'Admin/SettingController@email',
'admin/settings/project'      => 'Admin/SettingController@project',
'admin/settings/project'      => 'Admin/SettingController@project',
'admin/settings/board'        => 'Admin/SettingController@board',
'admin/settings/calendar'     => 'Admin/SettingController@calendar',
'admin/settings/integrations' => 'Admin/SettingController@integrations',
'admin/settings/webhook'      => 'Admin/SettingController@webhook',
'admin/settings/api'          => 'Admin/SettingController@api',
'admin/settings/links'        => 'Admin/LinkController@index',
'admin/settings/tags'         => 'Admin/TagController@index',

// Plugins admin
'admin/plugins'        => 'Admin/PluginController@show',
'admin/plugins/market' => 'Admin/PluginController@directory',

// Admin routes
'admin'       => 'Admin/AdminController@index',

];
