@extends('layouts.master')

@section('title', 'Add Comment')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1 col-sm-12">
            <h2 class="text-center">
                Add Comment for Task: <br>
                <strong>{{ $task->name }}</strong>
            </h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Comment Details</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ route('user.comments.store', $task->id) }}" enctype="multipart/form-data"
                        method="POST">
                        @csrf

                        <!-- Nội dung bình luận -->
                        <div class="form-group">
                            <label for="content">Content of Comment:</label>
                            <textarea name="content" id="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tải file đính kèm -->
                        <div class="form-group">
                            <label for="attachment">Attachment (Optional):</label>
                            <input type="file" name="attachment" id="attachment" class="form-control">
                            <small class="text-muted">Allowed: .docx, .txt, .pdf, images</small>
                            @error('attachment')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <!-- Xem trước ảnh (nếu có) -->
                            <img id="preview-img" class="img-thumbnail hidden" style="max-width: 150px; margin-top: 10px;">
                        </div>

                        <!-- ID Task -->
                        <input type="hidden" name="task_id" value="{{ $task->id }}">

                        <!-- Nút lưu (Chỉ hiển thị nếu có quyền) -->
                        <div class="text-center">
                            <button {!! Auth::user()->hasPermission('user.comments.store') ? '' : "disabled onclick='return false;'" !!} type="submit" class="btn btn-success">
                                <i class="fa fa-floppy-disk"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Nếu không có quyền, hiển thị thông báo -->
            @if (!Auth::user()->hasPermission('user.comments.store'))
                <div class="alert alert-warning text-center">
                    <strong>Warning:</strong> You do not have permission to add comments.
                </div>
            @endif
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .hidden {
            display: none;
        }

        @media (max-width: 768px) {
            .panel-body {
                padding: 15px;
            }

            textarea {
                font-size: 14px;
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.getElementById('attachment').addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('preview-img').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('preview-img').classList.add('hidden');
            }
        });
    </script>
@endsection
