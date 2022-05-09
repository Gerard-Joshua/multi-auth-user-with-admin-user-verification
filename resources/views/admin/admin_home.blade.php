@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card-header">Admin Dashboard</div><br/>
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h2>User List :-</h2>          
                    <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>Sl No</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if(!empty($users))
                                @foreach($users as $k => $user)
                                <tr>
                                    <td>{{ $k+1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->user_status == "In Review")
                                            <span class="label label-warning">{{ $user->user_status }}</span>
                                        @elseif($user->user_status == "Approved")
                                            <span class="label label-success">{{ $user->user_status }}</span>
                                        @else
                                            <span class="label label-danger">{{ $user->user_status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->user_status == "In Review")
                                            <form class="form-horizontal form-validate form-inline" action="{{ route('admin.update.user.status', $user->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                <select class="form-control" name="user_status" required>
                                                    <option>Choose Status</option>
                                                    <option value="Approved">Approved</option>
                                                    <option value="Rejected">Rejected</option>
                                                </select>&nbsp;
                                                <input type="submit" class="btn btn-primary" name="status_update" value="Update">
                                            </form>
                                        @else
                                            <span class="label label-default">Status Updated</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
