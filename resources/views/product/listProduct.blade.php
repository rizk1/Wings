@extends('layouts.app')

@section('content')
    <div class="row">
        @foreach ($data as $item)
        <div class="col-lg-3">
            <div class="card h-100">
                <img src="https://via.placeholder.com/300x150?text=No%20Image" class="card-img-top" alt="{{$item->product_name}}">
                <div class="card-body">
                    <h5 class="card-title">{{$item->product_name}}</h5>
                    @if ($item->discount)
                    <p class="card-text fs-6 text-decoration-line-through mb-0">Rp {{number_format($item->price, 0, ',', '.')}}</p>                        
                    @endif
                    <p class="card-text fs-5">Rp {{number_format($item->total_price, 0, ',', '.')}}</p>

                    <button onclick="handleCart({{$item->id}}, {{$item->total_price}})" class="btn btn-primary">BUY</button>
                    <a href="/product/{{$item->id}}" class="btn btn-primary">Detail</a>
                </div>
            </div>
        </div>
        @endforeach
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

            let dataID = { id: id, qty: 1, price}
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