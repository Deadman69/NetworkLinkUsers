@extends('layout.default')
@section('title') Users @endsection

@section('content')
    <div class="row">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Validated</th>
                    <th scope="col">Administrateur</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                <tr userid="{{ $user->id }}">
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->validated ? "Yes" : "No" }}</td>
                    <td>{{ $user->is_admin ? "Yes" : "No" }}</td>
                    <td>
                        @if($user->id != \App\Models\User::DEFAULT_USER)
                        <button type="button" class="btn btn-success">Activer/Désactiver</button>
                        <button type="button" class="btn btn-danger">Supprimer</button>
                        <button type="button" class="btn btn-info">Admin</button>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('bottom-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('button.btn').click(function(event) {
                event.preventDefault();

                var userID = $(this).parent().parent().attr('userid');
                var url = "{{ route('users.delete') }}/" + userID;
                if($(this).hasClass('btn-success')) {
                    url = "{{ route('users.toggle') }}/" + userID;
                } else if($(this).hasClass('btn-info')) {
                    url = "{{ route('users.admin') }}/" + userID;
                }

                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(data) {
                        alert('Action successfull');
                    },
                    error: function(xhr) {
                        alert('An error occurred while doing action');
                    }
                });
            });
        });
    </script>
@endsection
