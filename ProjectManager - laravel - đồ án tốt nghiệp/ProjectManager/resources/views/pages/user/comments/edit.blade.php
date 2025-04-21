@extends('layouts.master')

@section('title', 'Edit Comment')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2 class="text-center">Edit Comment</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="panel panel-primary">
                <div class="panel-heading">Comment Details</div>
                <div class="panel-body">
                    <form action="{{ route('user.comments.update', $comment->id) }}" enctype="multipart/form-data"
                        method="POST">
                        @csrf @method('PUT')

                        <!-- q-read: content -->
                        <div class="form-group">
                            <label for="content">Content of comment:</label>
                            <textarea name="content" id="content" class="form-control" rows="5" required>{{ old('content', $comment->content) }}</textarea>
                            @error('content')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- q-read: File Attachment (Hiển thị tệp cũ nếu có) -->
                        @if ($comment->attachment)
                            <div class="form-group">
                                <label>Current Attachment:</label>
                                <div>
                                    <a href="{{ asset('storage/' . $comment->attachment) }}" download target="_blank"
                                        class="btn btn-info btn-sm">Download</a>
                                    <p class="help-block">Click above to view or download the current file.</p>
                                </div>
                            </div>
                        @endif

                        <!-- q-read: Chọn tệp mới để thay thế (nếu có) -->
                        <div class="form-group">
                            <label for="attachment">Attach a new file (optional):</label>
                            <input type="file" name="attachment" id="attachment" class="form-control">
                            @error('attachment')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group text-center">
                            <!-- q-read: Được update comment khi: (có quyền update) và (tài khoản đăng nhập phải là tài khoản người dùng) hoặc (tài khoản đăng nhập phải tài khoản super admin) -->
                            <button {!! Auth::user()->hasPermission('user.comments.update') && ($comment->user_id == Auth::id() || Auth::id() == 1)
                                ? ''
                                : "disabled onclick='return false;'" !!} type="submit" class="btn btn-warning">
                                <i class="fat fa-pen-to-square"></i> Update
                            </button>

                            <!-- Được xem task khi: (có quyền xem) -->
                            <a {!! Auth::user()->hasPermission('user.tasks.show')
                                ? "onclick=\"return confirm('Do you really want to view this task?')\""
                                : "disabled onclick='return false;'" !!} href="{{ route('user.tasks.show', $comment->task_id) }}"
                                class="btn btn-info">
                                <i class="fa fa-info-circle"></i> View Task Details
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
