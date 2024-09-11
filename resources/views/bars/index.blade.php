@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="d-flex justify-content-between align-items-baseline">
            <h2>Bars</h2>
            <a class="btn btn-primary" href="{{ url('bar/create') }}">Add Bar</a>
          </div>
          @if (session('msg'))
              <div class="alert alert-success">
                  {{ session('msg') }}
              </div>
          @endif
          <table>
            <tr>
              <th>Bar #</th>
              <th>Name</th>
              <th>Address</th>
              <th>City</th>
              <th>Country</th>
              <th>Actions</th>
            </tr>
              @foreach ($bars as $bar)
              <tr>
                <td>{{ str_pad($bar->id, 6, '0', STR_PAD_LEFT) }}</td>
                <td>
                  <form action="{{ route('bar.show', $bar->id) }}" method="POST">
                    @csrf
                    <button style="padding:0;" class="btn btn-link">{{ $bar->name }}</button>
                  </form>
                </td>
                <td>{{ $bar->address }}</td>
                <td>{{ $bar->city }}</td>
                <td>{{ $bar->country }}</td>
                <td>
                  <div class="d-flex">
                    <form action="{{ route('bar.show', $bar->id) }}" method="POST">
                      @csrf
                      <button class="btn"><i class="fa fa-eye" style="color: #32a852;"></i></button>
                    </form>
                    <form action="{{ route('bar.destroy', $bar->id) }}" method="POST">
                      {{ method_field('DELETE') }}
                      @csrf
                      <button class="btn"><i class="fa fa-trash" style="color: #cf2326;"></i></button>
                    </form>
                    <form action="{{ route('bar.edit', $bar->id) }}" method="POST">
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