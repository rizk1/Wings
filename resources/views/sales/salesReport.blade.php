@extends('layouts.app')

@section('content')
    <div class="border rounded p-3">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Transaction</th>
                    <th scope="col">User</th>
                    <th scope="col">Total</th>
                    <th scope="col">Date</th>
                    <th scope="col">Item</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr style="vertical-align: middle">
                        <td>{{$item->document_code.' - '.$item->document_number}}</td>
                        <td>{{$item->user}}</td>
                        <td>Rp {{number_format($item->total,0,',','.')}}.-</td>
                        <td>{{date_format($item->created_at, 'd M Y')}}</td>
                        <td>
                            @foreach ($item->detail as $d)
                                <p class="mb-0">{{$d->product_name.' x '.$d->quantity}}</p> 
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection