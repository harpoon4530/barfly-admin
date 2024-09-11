@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Details of order # ' . str_pad($order->id, 6, '0', STR_PAD_LEFT)) }}</div>

                <div class="card-body">
                <p><b>Bar: </b>{{ $order->bar->name ?? 'N/A' }}</p>
                <p><b>Customer Name: </b>{{ $order->user->first_name . ' ' . $order->user->last_name ?? 'N/A' }}</p>
                <p><b>Customer Email: </b>{{ $order->user->email ?? 'N/A' }}</p>
                <p><b>Status: </b>{{ $order->status->name }}</p>
                    <table>
                        <tr>
                          <th>Item #</th>
                          <th>Item</th>
                          <th>Category</th>
                          <th>Price</th>
                          <th>Type</th>
                          <th>Quantity</th>
                          <th>Mod Category</th>
                          <th>Modifiers</th>
                        </tr>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ str_pad($item->id, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->category }}</td>
                                <td>{{ $item->currency . ' ' . $item->price }}</td>
                                <td>{{ $item->type }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    @foreach (json_decode($item->modifiers) as $mods)
                                        {{ $mods->category->name }}
                                        <br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach (json_decode($item->modifiers) as $mods)
                                        {{ $mods->modifier->name }}
                                        <br>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection