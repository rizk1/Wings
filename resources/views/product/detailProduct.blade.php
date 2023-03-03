@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="w-50 border rounded">
            <div class="row">
                <div class="col-md-4">
                    <div class="p-4">
                        <div style="height: 150px; width: 150px; background-color: aqua"></div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="p-4">
                        <h3>{{$data->product_name}}</h3>

                        @if ($data->discount)
                        <p class="card-text text-decoration-line-through mb-0" style="font-size: 12px;">Rp {{number_format($data->price, 0, ',', '.')}}</p>                        
                        @endif

                        <p class="card-text fs-6 mb-1">Rp {{number_format($data->total_price, 0, ',', '.')}}</p>
                        <p class="card-text fs-6 mb-1">Dimension : {{$data->dimension}}</p>
                        <p class="card-text fs-6 mb-3">Price Unit : {{$data->unit}}</p>
                        <button type="button" class="btn btn-primary" onclick="handleCart({{$data->id}}, {{$data->total_price}})" style="width: 6rem;">Buy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const handleCart = (id, price) => {
            let stored = JSON.parse(localStorage.getItem("productID"));
            var prod = []

            if (stored?.length) {
                prod = stored;
            }

            let dataID = { id: id, qty: 1, price }
            const found = prod.some(el => el.id === id);
            if (!found) {
                prod.push(dataID)
                localStorage.setItem("productID", JSON.stringify(prod));

                return Swal.fire({
                    title: 'Success!',
                    text: 'Product berhasil ditambahkan!',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                })
            }

            return Swal.fire({
                title: 'Info!',
                text: 'Product sudah di keranjang!',
                icon: 'info',
                confirmButtonText: 'Ok'
            })

        }
    </script>
@endsection