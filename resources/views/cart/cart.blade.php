@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="w-50 border rounded">
            <div id="listCart">
                <div class="text-center my-4">
                    <p>Tidak ada produk</p>
                    <a href="/" class="btn btn-primary">BACK</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const handleTotal = () => {
            let local = localStorage.getItem("productID")
            let localParse = JSON.parse(local)
            let total = 0

            for (let index = 0; index < localParse.length; index++) {
                total += localParse[index].price
            }

            document.getElementById('total').innerHTML = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        }

        const handleChangeQty = (e, id, price) => {
            let local = localStorage.getItem("productID")
            let localParse = JSON.parse(local)

            objIndex = localParse.findIndex((obj => obj.id == id));
            localParse[objIndex].qty = parseInt(e.value);
            localParse[objIndex].price = price * localParse[objIndex].qty;

            localStorage.setItem("productID", JSON.stringify(localParse));

            let subtotal = price * localParse[objIndex].qty;
            document.getElementById('subtotal'+id).innerHTML = subtotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            handleTotal()
        }

        const getCart = async () => {
            let local = localStorage.getItem("productID")
            let localParse = JSON.parse(local)
            let arr = []

            for (let index = 0; index < localParse.length; index++) {
                arr.push(localParse[index].id)
            }

            const playload = {
                id: arr
            }
            
            const data = await axios.get('/cart-product', {params: playload}).then(res => {
                if (res.data) {
                    document.getElementById('listCart').innerHTML = res.data
    
                    for (let index = 0; index < arr.length; index++) {
                        const find = localParse.find(obj => obj.id == arr[index])
                        document.getElementById('dataCart'+arr[index]).value = find.qty
                        if (find.price) {
                            document.getElementById('subtotal'+arr[index]).innerHTML = find.price
                        }
                    }

                    handleTotal()
                }
            }).catch(err => {
                console.log(err);
            })
        }

        const Checkout = async () => {
            let local = localStorage.getItem("productID")
            let localParse = JSON.parse(local)

            let playload = {
                data: localParse
            }

            const data = await axios.post('/checkout', playload).then(res => {
                localStorage.setItem("productID", JSON.stringify([]));
                Swal.fire({
                    title: 'Success!',
                    text: 'Checkout berhasil!',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                })
                window.location.href = '{{ url('/sales-report') }}'
            }).catch(err => {
                console.log(err);
            })
        }

        getCart()
    </script>
@endsection