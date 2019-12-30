@extends('layouts.template')

@section('title', 'Users')

@section('main')
    <h1>Users</h1>
    <form method="get" action="/admin/users" id="searchForm">
        <div class="row">
            <div class="col-sm-6 mb-2">
                <input type="text" class="form-control" name="user_name" id="user_name"
                    placeholder="Filter Name or Email"
                    value="{{ old('user_name'), request()->user()->name}}">
            
            </div>
            <div class="col-sm-4 mb-2">
                <select class="form-control" name="user_filter" id="user_filter">
                        @foreach($sortlist as $i => $order)
                        <option value="{{ $i }}"
                            {{(request()->user_filter==$i ? 'selected' : '')}}>
                            {{$order['displayname']}}
                            </option>
                        @endforeach
                </select>
            </div>
        </div>
    </form>
<hr>
@if ($users->count() == 0)
    <div class="alert alert-danger alert-dismissible fade show">
        Can't find the user <b>'{{ request()->user }}'</b>
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
@endif 
{{ $users->links() }}
<div class="alert alert-success alert-dismissable" id="delalert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span id="spannone" aria-hidden="true">×</span>
    </button>
    <p>User is deleted!</p>
</div>

    @include('shared.alert')
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Active</th>
                <th>Admin</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email}}</td>
                    <td>
                    @if($user->active == 1)
                    <i class="fas fa-check"></i>
                    @endif
                    </td>
                    <td>
                        @if($user->admin == 1)
                        <i class="fas fa-check"></i>
                        @endif
                        </td>
                    <td>
                        <form action="/admin/users/{{ $user->id }}" method="post" class="deleteForm">
                            @method('delete')
                            @csrf
                            <div class="btn-group btn-group-sm">
                                <a @if ($user->name === "Wout Sips") disabled href="#" @endif href="/admin/users/{{ $user->id }}/edit" class="btn btn-outline-success"
                                   data-toggle="tooltip"
                                   title="Edit {{ $user->name }}"
                                   >
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger"
                                        data-toggle="tooltip"
                                        data-id="{{$user->id}}"
                                        data-name="{{$user->name}}"
                                        title="Delete {{ $user->name }}" @if ($user->name === "Wout Sips") disabled @endif>
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->links() }}
    @section('script_after')
    <script>
        $("#delalert").hide();

        $(function () {
            // submit form when leaving text field 'artist'
            $('#user_name').blur(function () {
                $('#searchForm').submit();
            });
            // submit form when changing dropdown list 'genre_id'
            $('#user_filter').change(function () {
                $('#searchForm').submit();
            });
        })

        $(function () {
            $('.deleteForm button').click(function () {
                let name = $(this).data('name');
                let id = $(this).data('id');
                // Set some values for Noty
                let text = `<p>Delete the user <b>${name}</b>?</p>`;
                let type = 'warning';
                let btnText = 'Delete user';
                let btnClass = 'btn-success';
               
                let msg = `Delete this user?`;
                /* if(confirm(msg)) {
                    $(this).closest('form').submit();
                } */
                let modal = new Noty({
                    timeout:false,
                    layout:'center',
                    modal:true,
                    type: type,
                    text: text,
                    buttons: [
                        Noty.button(btnText, `btn ${btnClass}`, function(){
                            deleteUser(id);
                            modal.close();
                        }),
                        Noty.button("Cancel", "btn btn-secondary ml-2", function(){
                            modal.close();
                        })
                    ]

                }).show();
            });
        });

            function deleteUser(id) {
        // Delete the genre from the database
        let pars = {
            '_token': '{{ csrf_token() }}',
            '_method': 'delete'
        };
        $.post(`/admin/users/${id}`, pars)
            .done(function (data) {
                console.log("user deleted");
                location.reload();
                $("#delalert").show();
                
            })
            .fail(function (e) {
                console.log('error', e);
            });
    } 

    </script>
@endsection
@endsection
