@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="d-flex justify-content-between align-items-baseline">
            <h2>Users</h2>
            <a class="btn btn-primary" href="{{ url('register') }}">Add User</a>
          </div>
          @if (session('msg'))
              <div class="alert alert-success">
                  {{ session('msg') }}
              </div>
          @endif
          <table>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Actions</th>
            </tr>
            @foreach ($users as $user)
              <tr>
                <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->user_role->title }}</td>
                <td>
                  <div class="d-flex">
                    <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                      {{ method_field('DELETE') }}
                      @csrf
                      <button class="btn"><i class="fa fa-trash" style="color: #cf2326;"></i></button>
                    </form>
                    <form action="{{ route('user.edit', $user->id) }}" method="POST">
                      @csrf
                      <button class="btn"><i class="fa fa-pencil-alt" style="color: #106fb3;"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </table>
        </div>
    </div>
</div>
@endsection
