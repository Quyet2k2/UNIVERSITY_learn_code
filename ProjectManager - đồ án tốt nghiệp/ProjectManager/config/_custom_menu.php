<?php
return [
 [ // Dashboard
  'label' => 'Dashboard',
  'route' => 'user.dashboard',
  'request' => 'dashboard',
  'icon' => '<i class="fa fa-home"></i>',
 ],
 // Accounts
 [
  'label' => 'Manage Accounts',
  'route' => 'admin.users.index',
  'request' => 'admin/users*',
  'icon' => '<i class="fa fa-users"></i>',
 ], // Projects
 [
  'label' => 'Manage Projects',
  'route' => 'user.projects.index',
  'request' => 'user/projects*',
  'icon' => '<i class="fa fa-square-kanban"></i>',
 ], // Tasks
 [
  'label' => 'Manage Tasks',
  'route' => 'user.tasks.index',
  'request' => 'user/tasks*',
  'icon' => '<i class="fa fa-list-check"></i>',
 ], // Comments
 [
  'label' => 'Manage Comments',
  'route' => 'user.comments.index',
  'request' => 'user/comments*',
  'icon' => '<i class="fas fa-comment-lines"></i>',
 ], // Reports
 [
  'label' => 'Manage KPI Reports',
  'route' => 'user.reports.index',
  'request' => 'user/reports*',
  'icon' => '<i class="fal fa-file-chart-column"></i>',
 ],
 // Roles
 [
  'label' => 'Manage Roles',
  'route' => 'admin.roles.index',
  'request' => 'admin/roles*',
  'icon' => '<i class="fa fa-user-shield"></i>',
 ],
];
