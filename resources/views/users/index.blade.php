@extends('layouts.app')

@section('title','Users List')

@section('content')

    <div style="margin-top: 40px;">
        <table class="table table-bordered" id="users-table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Manage</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="text" class="form-control" id="userId" value="" hidden>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Username:</label>
                            <input type="text" class="form-control" id="username">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Email:</label>
                            <input type="email" class="form-control" id="email">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateUser">Update</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(function () {
            var table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: 'usersListAjaxHandler',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'username', name: 'username'},
                    {data: 'email', name: 'email'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at'},
                    {data: 'action', name: 'action', orderable: false}
                ]
            });

            // Fetch user details on click of editUser modal button
            $(document.body).on('click', '.editUser', function () {

                $.ajax({
                    'url': '/fetchUserDetails',
                    'method': 'POST',
                    'data': {id: $(this).attr("data-id")},
                    'dataType': 'JSON',
                    success: function (response) {
                        if (response.status == 200) {
                            $('#userId').val(response.data.id);
                            $('#name').val(response.data.name);
                            $('#username').val(response.data.username);
                            $('#email').val(response.data.email);
                        } else {
                            toastr.error(response.message);
                            $('#editUserModal').modal('hide');
                        }
                    }
                });

            });

            // Fetch update user details
            $(document.body).on('click', '#updateUser', function () {
                var id = $('#userId').val();

                var name = $('#name').val();
                var username = $('#username').val();
                var email = $('#email').val();

                if ($.trim(name) == "" || $.trim(username) == "" || $.trim(email) == "") {
                    toastr.error("All fields are required");
                    return false;
                }


                $.ajax({
                    'url': '/updateUser',
                    'method': 'POST',
                    'data': {
                        id: id,
                        name: name,
                        username: username,
                        email: email,
                    },
                    'dataType': 'JSON',
                    success: function (response) {
                        if (response.status == 200) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                            $('#editUserModal').modal('hide');
                        } else {
                            toastr.error(response.message);
                        }
                    }
                });
            });

            // Delete user ajax call
            $(document.body).on('click', '.deleteUser', function () {

                if (confirm("Are you sure to delete this user ?")) {
                    $.ajax({
                        'url': '/deleteUser',
                        'method': 'POST',
                        'data': {id: $(this).attr("data-id")},
                        'dataType': 'JSON',
                        success: function (response) {
                            if (response.status == 200) {
                                toastr.success(response.message);
                                table.ajax.reload(null, false);
                            } else {
                                toastr.error(response.message);
                            }
                        }
                    });
                }

            });

        });
    </script>
@endpush
