@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">{{ __('Bar Details') }}</h4>

                <div class="card-body">

                    <img src="{{ asset('storage/' . $bar->image) }}" height="150px">

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <div class="form-control">{{ $bar->name }}</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                        <div class="col-md-6">
                            <div class="form-control">{{ $bar->address }}</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                        <div class="col-md-6">
                            <div class="form-control">{{ $bar->city }}</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>

                        <div class="col-md-6">
                            <div class="form-control">{{ $bar->country }}</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="latitude" class="col-md-4 col-form-label text-md-right">{{ __('Latitude') }}</label>

                        <div class="col-md-6">
                            <div class="form-control">{{ $bar->lat }}</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="longitude" class="col-md-4 col-form-label text-md-right">{{ __('Longitude') }}</label>

                        <div class="col-md-6">
                            <div class="form-control">{{ $bar->lon }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-baseline">
                    <h4>{{ __('Modifiers') }}</h4>
                    <form action="{{ route('menu.modifier.create', $bar->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-primary">Add Category</button>
                    </form>
                </div>

                <div class="card-body">

                    @if (session('msg_modifier'))
                        <div class="alert alert-success">
                            {{ session('msg_modifier') }}
                        </div>
                    @endif

                    @foreach ($bar->menu_modifier_categories as $cat)
                        <div class="card-header d-flex justify-content-between align-items-baseline">
                            <h5>{{ __($cat->name) }}</h5>

                            <div class="d-flex">
                                <form action="{{ route('menu.modifier.destroy', [$bar->id, $cat->id]) }}" method="POST">
                                    {{ method_field('DELETE') }}
                                    @csrf
                                    <button class="btn btn-danger">Remove</button>
                                </form>
                                <form class="ml-2" action="{{ route('menu.modifier.item.create', [$bar->id, $cat->id]) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-primary">Add Item</button>
                                </form>
                            </div>
                        </div>

                        <table class="mb-4">
                            <tr>
                                <th>Item #</th>
                                <th>Item</th>
                                <th>Actions</th>
                            </tr>
                            @foreach ($cat->items as $item)
                                <tr>
                                    <td>{{ str_pad($item->id, 6, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <div class="d-flex">
                                          <form action="{{ route('menu.modifier.item.edit', [$bar->id, $cat->id, $item]) }}" method="POST">
                                            @csrf
                                            <button class="btn"><i class="fa fa-pencil-alt" style="color: #106fb3;"></i></button>
                                          </form>
                                          <form action="{{ route('menu.modifier.item.destroy', [$bar->id, $item]) }}" method="POST">
                                            {{ method_field('DELETE') }}
                                            @csrf
                                            <button class="btn"><i class="fa fa-trash" style="color: #cf2326;"></i></button>
                                          </form>
                                        </div>
                                      </td>
                                </tr>
                            @endforeach
                        </table>
                    @endforeach

                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-baseline">
                    <h4>{{ __('Menu') }}</h4>
                    <form action="{{ route('menu.category.create', $bar->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-primary">Add Category</button>
                    </form>
                </div>

                <div class="card-body">

                    @if (session('msg'))
                        <div class="alert alert-success">
                            {{ session('msg') }}
                        </div>
                    @endif

                    @foreach ($bar->menu_categories as $cat)
                        <div class="card-header d-flex justify-content-between align-items-baseline">
                            <h5>{{ __($cat->name) }}</h5>

                            <div class="d-flex">
                                <form action="{{ route('menu.category.destroy', [$bar->id, $cat->id]) }}" method="POST">
                                    {{ method_field('DELETE') }}
                                    @csrf
                                    <button class="btn btn-danger">Remove</button>
                                </form>
                                <form class="ml-2" action="{{ route('menu.category.item.create', [$bar->id, $cat->id]) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-primary">Add Item</button>
                                </form>
                            </div>
                        </div>

                        <table class="mb-4">
                            <tr>
                                <th>Item #</th>
                                <th>Item</th>
                                <th>Types</th>
                                <th>Prices</th>
                                <th>Mod Status</th>
                                <th>Modifiers</th>
                                <th>Currency</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                            @foreach ($cat->items as $item)
                                <tr>
                                    <td>{{ str_pad($item->id, 6, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @foreach (json_decode($item->types) as $type)
                                            {{ $type->type }}
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach (json_decode($item->types) as $type)
                                            {{ number_format($type->price, 2, '.', '') }}
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach (json_decode($item->types) as $type)
                                            {{ $type->modifiers }}
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($item->modifier_categories as $mod_cat)
                                            {{ $mod_cat->name }}
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>{{ $item->currency }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>
                                        <div class="d-flex">
                                          {{-- <form action="{{ route('menu.category.item.edit', [$bar->id, $cat->id, $item]) }}" method="POST">
                                            @csrf
                                            <button class="btn"><i class="fa fa-pencil-alt" style="color: #106fb3;"></i></button>
                                          </form> --}}
                                          <form action="{{ route('menu.category.item.destroy', [$bar->id, $item]) }}" method="POST">
                                            {{ method_field('DELETE') }}
                                            @csrf
                                            <button class="btn"><i class="fa fa-trash" style="color: #cf2326;"></i></button>
                                          </form>
                                        </div>
                                      </td>
                                </tr>
                            @endforeach
                        </table>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
