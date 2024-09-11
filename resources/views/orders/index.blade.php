@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="d-flex justify-content-between align-items-baseline">
            <h2>Orders</h2>
            <a class="btn btn-primary" href="{{ url('order/create') }}" style="display: none">Create Order</a>
          </div>
          @if (session('msg'))
              <div class="alert alert-success">
                  {{ session('msg') }}
              </div>
          @endif
          <table>
            <tr>
              <th>Order #</th>
              <th>Customer Name</th>
              <th>Customer Email</th>
              <th>Bar</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
            @foreach ($orders as $order)
              <tr>
                <td>
                  <form action="{{ route('order.show', $order->id) }}" method="POST">
                    @csrf
                    <button style="padding:0;" class="btn btn-link">{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</button>
                  </form>
                </td>
                <td>{{ $order->user->first_name . ' ' . $order->user->last_name ?? 'N/A' }}</td>
                <td>{{ $order->user->email ?? 'N/A' }}</td>
                <td>{{ $order->bar->name ?? 'N/A' }}</td>
                <td>
                    <select id="{{ $order->id }}" type="text" class="form-control" onchange="updateStatus(this)" required>
                      @foreach ($order_statuses as $order_status)
                        @if ($order_status->id == $order->status->id)
                          <option value="{{ $order_status->id }}" selected>{{ $order_status->name }}</option>
                        @else
                          <option value="{{ $order_status->id }}">{{ $order_status->name }}</option>
                        @endif
                      @endforeach
                  </select>
                </td>
                <td>
                  <div class="d-flex">
                    <form action="{{ route('order.show', $order->id) }}" method="POST">
                      @csrf
                      <button class="btn"><i class="fa fa-eye" style="color: #32a852;"></i></button>
                    </form>
                    <form action="{{ route('order.destroy', $order->id) }}" method="POST">
                      {{ method_field('DELETE') }}
                      @csrf
                      <button class="btn"><i class="fa fa-trash" style="color: #cf2326;"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </table>
        </div>
    </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  });

  function updateStatus(evt) {

    $.post( '{{ env('BASE_URL') }}' + 'order/' + evt.id + '/update',
      { status_id: evt.value },
      function(data, status, jqXHR) {
        alert(data.msg);
      });
  }
</script>
@endsection
