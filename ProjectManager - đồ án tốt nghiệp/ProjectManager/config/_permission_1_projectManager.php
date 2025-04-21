<?php  // q-read: Các route mà người dùng PM có thể dùng 
return array_merge(
 config('_permission_0_base'),
 [
  'user.projects.create',
  'user.projects.store',
  'user.projects.edit',
  'user.projects.update',

  'user.tasks.create',
  'user.tasks.store',

  'user.reports.index',
  'user.reports.user',
 ]
);