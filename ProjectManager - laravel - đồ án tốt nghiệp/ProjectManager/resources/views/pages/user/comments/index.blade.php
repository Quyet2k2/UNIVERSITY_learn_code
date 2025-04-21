@extends('layouts.master')

@section('title', 'Comments of Task')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="panel panel-primary">
        <div class="panel-heading"><strong>Comments List</strong></div>
        <div class="panel-body">

            {{-- q-read: Tìm kiếm và refresh --}}
            <div class="row m-b-sm m-t-sm px-3">
                {{-- q-read: Refresh --}}
                <div class="col-md-1 m-b-sm">
                    <a href="{{ route('user.comments.index') }}" class="btn btn-white btn-sm">
                        <i class="fa fa-refresh"></i>
                        Refresh
                    </a>
                </div>
                {{-- q-read: Tìm kiếm --}}
                <div class="col-md-11 m-b-sm">
                    <form class="input-group" action="{{ route('user.comments.index') }}" method="GET">
                        <input name="search_by_comment_content" value="{{ request('search_by_comment_content') }}"
                            type="text" placeholder="Search by Comment Content" class="input-sm form-control">

                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary"> Go!</button>
                        </span>
                    </form>
                </div>
            </div>

            {{-- q-read: Danh sách comment --}}
            <div class="table-responsive m-t-md">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Comment Content</th>
                            <th>Attachment</th>
                            <th>Comment Time</th>
                            <th>Comment User</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($comments as $comment)
                            <tr>
                                {{-- q-read: Index --}}
                                <td>{{ $comment->id }}</td>
                                {{-- q-read: Content --}}
                                <td style="white-space: pre-line; word-wrap: break-word;">
                                    {{ $comment->content }}</td>
                                {{-- q-read: Attachment --}}
                                <td>
                                    <!-- Hiển thị tệp đính kèm nếu có -->
                                    @if ($comment->attachment)
                                        <a href="{{ asset('storage/' . $comment->attachment) }}" download
                                            class="btn btn-primary btn-sm m-2" target="_blank">
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    @endif
                                </td>
                                {{-- q-read: Created At --}}
                                <td> {{ $comment->created_at->diffForHumans() }}</td>
                                {{-- q-read: Comment Owner --}}
                                <td> <strong>{{ $comment->user->name }}</strong> </td>

                                <td>
                                    <!-- Được xem task khi: (có quyền xem) -->
                                    <a {!! Auth::user()->hasPermission('user.tasks.show') ? '' : "disabled onclick='return false;'" !!} href="{{ route('user.tasks.show', $comment->task_id) }}"
                                        class="btn btn-info btn-sm m-2">
                                        <i class="fa-classic fa-thin fa-circle-info fa-fw"></i>
                                        View Task Details
                                    </a>

                                    {{-- Được sửa comment khi: (có quyền sửa) và (tài khoản đăng nhập phải là - (tài khoản comment) hoặc (tài khoản super admin)  --}}
                                    <a {!! Auth::user()->hasPermission('user.comments.edit') && (Auth::id() == $comment->user_id || Auth::id() == 1)
                                        ? ''
                                        : "disabled onclick='return false;'" !!} href="{{ route('user.comments.edit', $comment->id) }}"
                                        class="btn btn-warning btn-sm m-2">
                                        <i class="fa fa-pencil"></i>
                                        Edit Comment
                                    </a>

                                    <!-- delete comment -->
                                    <form action="{{ route('user.comments.destroy', $comment->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf @method('DELETE')
                                        <!-- Được xóa comment khi: (có quyền destroy) và ((phải đăng nhập đúng tài khoản của mình) hoặc (tài khoản đăng nhập phải là tài khoản super admin)) -->
                                        <button {!! Auth::user()->hasPermission('user.comments.destroy') && (Auth::id() == $comment->user_id || Auth::id() == 1)
                                            ? "onclick=\"return confirm('Do you really want to delete this comment?')\""
                                            : "disabled onclick='return false;'" !!} type="submit" class="btn btn-danger btn-sm m-2">
                                            <i class="fa-sharp fa-solid fa-trash fa-fw"></i>
                                            Delete Comment
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="55" class="text-center">No Comments found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="text-center">{{ $comments->appends(request()->query())->links('pagination::simple-bootstrap-4') }}
            </div>
        </div>
    </div>
@stop
