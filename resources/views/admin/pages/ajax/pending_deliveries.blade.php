<div class="alert alert-secondary">
    <b>Date : </b> {{$order->updated_at}}<br>
    <b>Customer Name : </b> {{$order->firstname." ".$order->lastname}}<br>
    <b>Customer Line 1 : </b> {{$order->user_phone}}<br>
    <b>Customer Line 2 : </b> {{$order->phone}}<br>
    <b>Total : </b> &#8358;{{$order->total}}<br>
    <b>Vendor : </b> {{$order->name}} ({{$order->vendor_lga}}, {{$order->vendor_state}})<br>
    <b>Address : </b> {{$order->address}} ({{$order->lga.", ".$order->state}})<br>
    <b>Rider Name : </b> {{$rider->firstname." ".$rider->lastname}}<br>
    <b>Rider Phone : </b> {{$rider->phone}}
</div>
