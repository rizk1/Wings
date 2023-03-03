@foreach ($data as $item)
    <div class="row align-items-center">
        <div class="col-md-4">
            <div class="p-4">
                <img src="https://via.placeholder.com/150?text=No%20Image" alt="">
            </div>
        </div>
        <div class="col-md-8">
            <div class="p-4">
                <h5>{{$item->product_name}}</h5>
                <div class="d-flex gap-4 align-items-center my-3"> 
                    <input type="number" id="dataCart{{$item->id}}" min="1" style="width: 3rem;" onchange="handleChangeQty(this, {{$item->id}}, {{$item->total_price}})" required>
                    <p class="card-text fs-6 mb-0">{{$item->unit}}</p>
                </div>
                <div class="d-flex gap-4">
                    <p class="card-text fs-6 mb-1">Subtotal :</p>
                    <p class="card-text fs-6 mb-3">Rp <span id="subtotal{{$item->id}}">{{number_format($item->total_price, 0, ',', '.')}}</span>.-</p>
                </div>
            </div>
        </div>
    </div>
@endforeach

<div class="d-flex justify-content-center">
    <div class="d-flex gap-4 align-items-center border border-dark p-2">
        <p class="fs-3 mb-0">TOTAL :</p>
        <p class="fs-3 mb-0">RP <span id="total">{{number_format($total, 0, ',', '.')}}</span>.-</p>
    </div>
</div>

<div class="text-center my-4">
    <button class="btn btn-primary" onclick="Checkout()">CONFIRM</button>
</div>