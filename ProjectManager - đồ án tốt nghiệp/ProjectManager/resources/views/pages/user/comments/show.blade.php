{{-- @extends('layouts.master')

@section('title', 'Details of Comment')

@section('content')
    <h1 class="text-center">Details of Comment</h1>

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

    <div class="card">
        <div class="card-body">
            <p><strong>{{ $comment->user->name }}</strong> ({{ get_local_date_format($comment->created_at) }})</p>
            <p>{{ $comment->content }}</p>

            <!--  Được edit comment khi: (có quyền edit) và (tài khoản đăng nhập phải là tài khoản người dùng) hoặc (tài khoản đăng nhập phải tài khoản super admin) -->
            <a {!! Auth::user()->hasPermission('user.comments.edit') && (Auth::id() == $comment->user_id || Auth::id() == 1)
                ? ''
                : "disabled onclick='return false;'" !!} href="{{ route('user.comments.edit', $comment->id) }}"
                class="btn btn-warning btn-sm m-2">
                <i class="fa fa-pencil"></i>
                Edit
            </a>

            <!-- delete comment -->
            <form action="{{ route('user.comments.destroy', $comment->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <!-- Được xóa comment khi: (có quyền destroy) và (tài khoản đăng nhập phải là tài khoản người dùng) hoặc (tài khoản đăng nhập phải tài khoản super admin) -->
                <button {!! Auth::user()->hasPermission('user.comments.destroy') && (Auth::id() == $comment->user_id || Auth::id() == 1)
                    ? 'onclick="return confirm(\'Do you really want to delete this comment?\')"'
                    : "disabled onclick='return false;'" !!} type="submit" class="btn btn-danger btn-sm m-2" >
                    <i class="fa-sharp fa-solid fa-trash fa-fw"></i>
                    Delete Comment
                </button>
            </form>
        </div>
    </div>
@stop --}}
