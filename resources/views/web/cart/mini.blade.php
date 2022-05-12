<table class="table table-bordered mb-0 border-outer-none table-sm" style="width: 340px">
    @unless(empty($cart_data))
    <thead>
    <tr>
        <th style="width: 200px">Make</th>
        <th class="px-1 text-right">Qty</th>
        <th class="text-right" style="width: 75px">Price</th>
        <th class="pr-1"></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($cart_data AS $k => $cart)
    <tr>
        <td class="align-middle">{{ $cart['make'] }} - {{ $cart['model_code'] }}</td>
        <td class="px-1 align-middle text-right">1</td>
        <td class="px-1 align-middle text-right">$ {{ number_format($cart['price'], 2) }}</td>
        <td class="align-middle px-1"><button class="btn btn-sm px-2 btn-outline-danger btn-update-cart" data-method="delete" data-id="{{ $k }}" style="height: 30px; width: 42px"><em class="icon ni ni-trash"></em></button> </td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr style="height: 40px">
        <th colspan="{{ $display_full_cart ? 2 : 1 }}" class="align-middle text-right">Total</th>
        <th class="px-1 align-middle text-right">{{ count($cart_data) }}</th>
        <th class="px-1 align-middle text-right">$ {{ number_format(array_sum(array_column($cart_data, 'price')), 2) }}</th>
        <th class="pr-1"></th>
    </tr>
    </tfoot>
    @else
    <div class="py-3 text-center"><i class="fas fa-info-circle mr-1"></i> Your cart is empty!</div>
    @endunless
</table>
