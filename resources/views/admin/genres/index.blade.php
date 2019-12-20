@extends('layouts.template')

@section('title', 'Genres')

@section('main')
<h1>Genres</h1>

<p>
    <a href="#!" class="btn btn-outline-success" id="btn-create">
        <i class="fas fa-plus-circle mr-1"></i>Create new genre
    </a>
</p>
<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Genre</th>
            <th>Records for this genre</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
    @include('admin.genres.modal')
@endsection
    @section('script_after')
    <script>
         $(function () {
            loadTable();

            $('tbody').on('click', '.btn-delete', function () {
            // Get data attributes from td tag
            let id = $(this).closest('td').data('id');
            let name = $(this).closest('td').data('name');
            let records = $(this).closest('td').data('records');
            // Set some values for Noty
            let text = `<p>Delete the genre <b>${name}</b>?</p>`;
            let type = 'warning';
            let btnText = 'Delete genre';
            let btnClass = 'btn-success';
            // If records not 0, overwrite values for Noty
            if (records > 0) {
                text += `<p>ATTENTION: you are going to delete ${records} records at the same time!</p>`;
                btnText = `Delete genre + ${records} records`;
                btnClass = 'btn-danger';
                type = 'error';
            }
            // Show Noty
            let modal = new Noty({
                timeout: false,
                layout: 'center',
                modal: true,
                type: type,
                text: text,
                buttons: [
                    Noty.button(btnText, `btn ${btnClass}`, function () {
                        // Delete genre and close modal
                        deleteGenre(id);
                        modal.close();
                    }),
                    Noty.button('Cancel', 'btn btn-secondary ml-2', function () {
                        modal.close();
                    })
                ]
            }).show();
        });
        $('tbody').on('click', '.btn-edit', function () {
         // Get data attributes from td tag
         let id = $(this).closest('td').data('id');
         let name = $(this).closest('td').data('name');
         // Update the modal
         $('.modal-title').text(`Edit ${name}`);
         $('form').attr('action', `/admin/genres/${id}`);
         $('#name').val(name);
         $('input[name="_method"]').val('put');
         // Show the modal
         $('#modal-genre').modal('show');
     });
     $('#modal-genre form').submit(function (e) {
        // Don't submit the form
        e.preventDefault();
        // Get the action property (the URL to submit)
        let action = $(this).attr('action');
        // Serialize the form and send it as a parameter with the post
        let pars = $(this).serialize();
        console.log(pars);
        // Post the data to the URL
        $.post(action, pars, 'json')
            .done(function (data) {
                console.log(data);
                // Noty success message
                new Noty({
                    type: data.type,
                    text: data.text
                }).show();
                // Hide the modal
                $('#modal-genre').modal('hide');
                // Rebuild the table
                loadTable();
            })
            .fail(function (e) {
                console.log('error', e);
                // e.responseJSON.errors contains an array of all the validation errors
                console.log('error message', e.responseJSON.errors);
                // Loop over the e.responseJSON.errors array and create an ul list with all the error messages
                let msg = '<ul>';
                $.each(e.responseJSON.errors, function (key, value) {
                    msg += `<li>${value}</li>`;
                });
                msg += '</ul>';
                // Noty the errors
                new Noty({
                    type: 'error',
                    text: msg
                }).show();
            });
    });
    $('#btn-create').click(function () {
        // Update the modal
        $('.modal-title').text(`New genre`);
        $('form').attr('action', `/admin/genres`);
        $('#name').val('');
        $('input[name="_method"]').val('post');
        // Show the modal
        $('#modal-genre').modal('show');
    });
        });

        // Delete a genre
        function deleteGenre(id) {
            // Delete the genre from the database
                let pars = {
            '_token': '{{ csrf_token() }}',
            '_method': 'delete'
        };
        $.post(`/admin/genres/${id}`, pars, 'json')
            .done(function (data) {
                console.log('data', data);
                // Show toast
            new Noty({
                type: data.type,
                text: data.text
            }).show();
                // Rebuild the table
                loadTable();
            })
            .fail(function (e) {
                console.log('error', e);
            });
    }

        // Load genres with AJAX
        function loadTable() {
            $.getJSON('/admin/genres/qryGenres')
                .done(function (data) {
                    console.log('data', data);
                    // Clear tbody tag
                    $('tbody').empty();
                    // Loop over each item in the array
                    $.each(data, function (key, value) {
                        let tr = `<tr>
                               <td>${value.id}</td>
                               <td>${value.name}</td>
                               <td>${value.records_count}</td>
                               <td data-id="${value.id}"
                                   data-records="${value.records_count}"
                                   data-name="${value.name}">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#!" class="btn btn-outline-success btn-edit"
                                            data-toggle="tooltip"
                                            title="Edit ${value.name}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#!" class="btn btn-outline-danger btn-delete"
                                            data-toggle="tooltip"
                                            title="Delete ${value.name}">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                               </td>
                           </tr>`;
                        // Append row to tbody
                        $('tbody').append(tr);
                    });
                })
                .fail(function (e) {
                    console.log('error', e);
                })
        }
    </script>
@endsection

