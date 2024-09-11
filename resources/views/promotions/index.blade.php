@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="d-flex justify-content-between align-items-baseline">
            <h2>Promotions</h2>
            <a class="btn btn-primary" href="{{ url('promotion/create') }}">Add Promotion</a>
          </div>
          @if (session('msg'))
              <div class="alert alert-success">
                  {{ session('msg') }}
              </div>
          @endif
          <table>
            <tr>
              <th>Bar</th>
              <th>Title</th>
              <th>Actions</th>
            </tr>
            @foreach ($promotions as $promotion)
              <tr>
                <td>{{ $promotion->bar->name }}</td>
                <td>{{ $promotion->title }}</td>
                <td>
                  <div class="d-flex">
                    <form action="{{ route('promotion.destroy', $promotion->id) }}" method="POST">
                      {{ method_field('DELETE') }}
                      @csrf
                      <button class="btn"><i class="fa fa-trash" style="color: #cf2326;"></i></button>
                    </form>
                    {{-- <form action="{{ route('promotion.edit', $promotion->id) }}" method="POST">
                      @csrf
                      <button class="btn"><i class="fa fa-pencil-alt" style="color: #106fb3;"></i></button>
                    </form> --}}
                  </div>
                </td>
              </tr>
            @endforeach
          </table>
        </div>
    </div>
</div>
@endsection
