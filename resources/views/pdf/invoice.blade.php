<p>Order Id: {{$order_info->id}}</p>
<p>Date: {{$order_info->created_at}}</p>
<p>Discount ammount: {{$order_info->discount_ammount}}</p>
<p>Total: {{$order_info->total}}</p>
<p>Coupon : @if($order_info->coupon_name == '-')
        {{ 'You have to no coupon used' }}      
    @else
        {{$order_info->coupon_name}}
    @endif    
</p>