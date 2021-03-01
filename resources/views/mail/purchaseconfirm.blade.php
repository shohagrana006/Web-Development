<style>
    .table{
        width: 80%;
        padding: 5px;
        margin: 0 auto;
    }
    .table tbody{
        text-align: center;
    }
    .table tr{
        border: 1px solid #444;
    }
</style>


<table class="table">
  <thead>
    <tr>
      <th>S.L</th>
      <th>Product name</th>
      <th>Product quantity</th>
      <th>Product price</th>
      <th>total</th>
    </tr>
  </thead>
  <tbody>
      @foreach ($showClints as $showClint)
        <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td>{{ $showClint->OrderdetailToProduct->product_name }}</td>
            <td>{{ $showClint->product_quantity }}</td>
            <td>{{ $showClint->product_price }}</td>
            <td>{{ $showClint->product_quantity }}</td>
        </tr>
    @endforeach
  </tbody>
</table>