<?php

namespace App\Http\Controllers\User;

use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;

class CommentController extends Controller
{
 public function index()
 {
  // session(['url.intended' => url()->current()]); // BUG: lưu route back để quay trở lại khi xong hành động
  $query = Comment::query(); // Xác định truy vấn cơ bản
  $search_by_comment_content = request('search_by_comment_content') ?? '';

  if (auth()->user()->id != 1) { // Nếu không là admin (id != 1), lọc theo 'user_id'
   $query->where('user_id', auth()->user()->id);
  }
  $comments = $query
   ->where('content', 'like', '%' . $search_by_comment_content . '%')
   ->orderBy('created_at', 'desc') // Sắp xếp comment theo ngày tạo gần nhất
   ->paginate(4);

  return view('pages.user.comments.index', compact('comments'));
 }
 public function create()
 {
  $task_id = request()->query('task_id');
  $task = Task::findOrFail($task_id);
  return view('pages.user.comments.create', compact('task'));
 }
 public function store(Request $request)
 {
  $request->validate([
   'content' => 'required|string',
   'task_id' => 'required|exists:tasks,id',
   'attachment' => 'nullable|file',
   // 'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,txt|max:10240', // Định dạng và kích thước tệp
  ]);

  $attachmentPath = null;
  if ($request->hasFile('attachment'))
   $attachmentPath = $request->file('attachment')->store('attachments', 'public'); // Lưu tệp vào thư mục "attachments" trong disk public

  $comment = new Comment();
  $comment->task_id = $request->task_id;
  $comment->user_id = auth()->id();
  $comment->content = $request->content;
  $comment->attachment = $attachmentPath;
  $comment->save();

  $task = Task::find($request->task_id);
  return redirect()->route('user.tasks.show', ['task' => $task])->with('success', 'Comment created successfully.');
 }

 public function show($id)
 {
  return back()->with('error', 'App does not support this action.');
 }

 public function edit($id)
 {
  $comment = Comment::findOrFail($id);
  return view('pages.user.comments.edit', compact('comment'));
 }
 public function update(Request $request, $id)
 {
  $request->validate([
   'content' => 'required|string|max:1000',
   'attachment' => 'nullable|file', // Tùy chỉnh các loại file và kích thước
  ]);

  $comment = Comment::findOrFail($id);
  if ($request->hasFile('attachment')) {
   if ($comment->attachment && Storage::disk('public')->exists($comment->attachment))
    Storage::disk('public')->delete($comment->attachment); // Xóa tệp đi khi có mới

   // Lưu tệp mới vào thư mục public
   $attachmentPath = $request->file('attachment')->store('attachments', 'public');
   $comment->attachment = $attachmentPath;
  }

  $comment->content = $request->content;
  $comment->save();
  return back()->with('success', 'Comment updated successfully.');
 }
 public function destroy($id)
 {
  // $s = 0;
  // for ($i = 0; $i < 10; $i++)
  //  $s += $i;
  // dd($s);
  $comment = Comment::findOrFail($id);

  // Xóa tệp đi khi xóa comment
  if ($comment->attachment && Storage::disk('public')->exists($comment->attachment))
   Storage::disk('public')->delete($comment->attachment);

  $comment->delete();
  return redirect()->route('user.tasks.show', ['task' => $comment->task_id])->with('success', 'Comment deleted successfully.');
 }
}
