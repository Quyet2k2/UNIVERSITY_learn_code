<?php // q-read: Các base route
return [
 'user.dashboard',
 'user.error',
 'admin.users.show',
 'admin.users.edit',
 'admin.users.update',

 'user.projects.index',
 'user.projects.show',

 // q-read: Tasks - tất cả có quyền, trừ tạo và xóa task
 'user.tasks.index',
 'user.tasks.show',
 'user.tasks.edit',
 'user.tasks.update',

 // q-read: Comments - tất cả có toàn quyền với comment của mình
 'user.comments.index',
 'user.comments.create',
 'user.comments.store',
 'user.comments.show',
 'user.comments.edit',
 'user.comments.update',
 'user.comments.destroy',
];