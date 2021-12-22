<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Price</th>
      <th scope="col">Qty</th>
    </tr>
  </thead>
  <tbody>
    @php
      $i = 1;
    @endphp
    @foreach ($cart->items as $product)
      <tr>
        <th scope="row">{{ $i++ }}</th>
        <th>{{ $product['name'] }}</th>
        <th>{{ $product['price'] }}</th>
        <th>{{ $product['qty'] }}</th>
      </tr>
    @endforeach
    <br>
    Total Price: {{ $cart->totalPrice }}
      
    <a href="{{ url('/orders') }}">View your order</a>
  </tbody>
</table>