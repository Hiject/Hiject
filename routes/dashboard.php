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

// Dashboard routes
'dashboard'               => 'Dashboard/DashboardController@index',
'dashboard/projects'      => 'Dashboard/ProjectController@index',
'dashboard/starred'       => 'Dashboard/ProjectController@starred',

'dashboard/tasks'         => 'Dashboard/DashboardController@tasks',
'dashboard/subtasks'      => 'Dashboard/DashboardController@subtasks',
'dashboard/calendar'      => 'Dashboard/DashboardController@calendar',
'dashboard/activities'    => 'Dashboard/DashboardController@activities',

'dashboard/notifications' => 'Dashboard/NotificationController@index',

];
