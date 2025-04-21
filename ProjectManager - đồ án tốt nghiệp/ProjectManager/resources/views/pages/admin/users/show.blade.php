@extends('layouts.master')
@section('title', 'Account Details')

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

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default text-center">
                <div class="panel-body">
                    <!-- Avatar -->
                    <img src="{{ $user->avatar_url }}" alt="Avatar"
                        class="img-circle profile-avatar img-responsive center-block">
                    <h2 class="profile-name">{{ $user->name }}</h2>
                    <p class="profile-role">{{ implode(', ', $user->getRoles->pluck('name')->toArray()) }}</p>
                </div>
            </div>

            <!-- Thông tin tài khoản -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Account Details</h3>
                </div>
                <div class="panel-body">
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Created At:</strong> {{ get_local_date_format($user->created_at) }}</p>
                    <p><strong>Updated At:</strong> {{ get_local_date_format($user->updated_at) }}</p>
                </div>

                <!-- Actions -->
                <div class="panel-footer text-center">
                    <div class="btn-group btn-group-responsive">
                        <a {!! Auth::user()->hasPermission('admin.users.edit') && (Auth::id() == $user->id || Auth::id() == 1)
                            ? ''
                            : "disabled onclick='return false;'" !!} href="{{ route('admin.users.edit', $user->id) }}"
                            class="btn btn-warning">
                            <i class="fa fa-pencil"></i> Edit Account
                        </a>

                        {{-- <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-form">
                            @csrf @method('DELETE')
                            <button {!! Auth::user()->hasPermission('admin.users.destroy') && Auth::id() == 1 && $user->id != 1
                                ? 'onclick="return confirm(\'Do you really want to delete this user?\')"'
                                : "disabled onclick='return false;'" !!} type="submit" class="btn btn-danger" >
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
        }

        .profile-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .profile-role {
            font-size: 16px;
            color: #777;
        }

        .inline-form {
            display: inline-block;
        }

        .btn-group-responsive {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }
    </style>
@endsection
