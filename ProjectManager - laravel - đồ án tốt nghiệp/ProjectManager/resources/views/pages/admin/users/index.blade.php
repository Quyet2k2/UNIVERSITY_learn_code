@extends('layouts.master')

@section('title', 'Account List')

@section('content')
    <div class="row">
        {{-- q-read: Excel Actions Button --}}
        <div class="col-lg-12 text-right">
            <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle mb-3" aria-expanded="false">
                    Import / Export Excel File
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a data-toggle="modal" data-target="#importModal">
                            <i class="fa fa-upload"></i>
                            Import Accounts
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.export') }}">
                            <i class="fa fa-download"></i>
                            Export Accounts
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('admin.users.sample_import') }}" download>
                            <i class="fa fa-download"></i>
                            Download Import Sample
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- q-read: Excel Import Modal --}}
        <div id="importModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-left">
                        <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
                        <h4 class="modal-title">Excel Import</h4>
                    </div>
                    <div class="modal-body">
                        <form id="api_import_account_form">
                            @csrf
                            <div class="form-group text-left">
                                <label for="account_import_file">Select Excel File</label>
                                <input type="file" name="account_import_file" id="account_import_file"
                                    class="form-control">
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- q-read: Account List --}}
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Account List</h3>
                </div>
                <div class="panel-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                            @if (session('error_file'))
                                <a href="{{ session('error_file') }}" class="btn btn-warning">Download Error File</a>
                            @endif
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-sm-6 m-b-sm">
                            <a {!! Auth::user()->hasPermission('admin.users.create') ? '' : "disabled onclick='return false;'" !!} href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Add Account
                            </a>
                        </div>
                        <div class="col-sm-6 m-b-sm text-right">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-default">
                                <i class="fa fa-refresh"></i> Refresh
                            </a>
                        </div>
                    </div>

                    <form class="input-group" action="{{ route('admin.users.index') }}" method="GET">
                        <input name="search_by_account_email" value="{{ request('search_by_account_email') }}"
                            type="text" placeholder="Search by Account Email" class="form-control">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary"> Go!</button>
                        </span>
                    </form>

                    <div class="table-responsive m-t-md">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Created At</th>
                                    <th>Modified At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($accounts as $user)
                                    <tr {!! Auth::user()->hasPermission('admin.users.show') ? '' : "disabled onclick='return false;'" !!}
                                        onclick="window.location='{{ route('admin.users.show', $user->id) }}';"
                                        style="cursor: pointer;">
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->getRoles->pluck('name')->implode(', ') }}</td>
                                        <td>{{ get_local_date_format($user->created_at) }}</td>
                                        <td>{{ get_local_date_format($user->updated_at) }}</td>
                                        <td>
                                            <a {!! Auth::user()->hasPermission('admin.users.edit') && ($user->id == Auth::id() || Auth::id() == 1)
                                                ? ''
                                                : "disabled onclick='return false;'" !!} href="{{ route('admin.users.edit', $user->id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fa fa-pencil"></i> Edit Account
                                            </a>

                                            {{-- <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf @method('DELETE')
                                                <button {!! Auth::user()->hasPermission('admin.users.destroy') && !($user->id == 1) && Auth::id() == 1
                                                    ? 'onclick="return confirm(\'Do you really want to delete this user?\')"'
                                                    : "disabled onclick='return false;'" !!} type="submit"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No user found!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        {{ $accounts->appends(request()->query())->links('pagination::simple-bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- API Import Excel Account --}}
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#api_import_account_form").submit(function(e) {
                e.preventDefault();

                let submitBtn = $(this).find("button[type='submit']");
                let formData = new FormData(this);
                let csrfToken = $('meta[name="csrf-token"]').attr('content'); // Lấy từ meta tag
                formData.append("_token", csrfToken);

                // Đổi trạng thái nút
                submitBtn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Importing...');

                $.ajax({
                    url: "{{ route('admin.users.import') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.error) {
                            alert(response.error);
                            if (response.error_file) {
                                console.log(response.error_file);

                                window.location.href = response.error_file;
                            }
                        } else {
                            alert(response.success);
                            $("#api_import_account_form")[0].reset();
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = "Lỗi: " + xhr.status;
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg += " - " + xhr.responseJSON.message;
                        }
                        alert(errorMsg);
                        console.error("Lỗi chi tiết:", xhr);
                    },
                    complete: function() {
                        // Trả nút về trạng thái ban đầu
                        submitBtn.prop("disabled", false).html('Import');
                    }
                });
            });
        });
    </script>
@endsection
