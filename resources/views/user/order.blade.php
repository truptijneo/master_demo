<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>{{ $title }}</title>
    <style>
    .firstDiv {
        width: 50%;
        min-height: 100px;
    }

    .left {
        float: left;
    }

    .right {
        float: right;
        text-align: right;
    }

    table {
        font-size: 75%;
        table-layout: fixed;
        width: 100%;
    }

    table {
        border-collapse: separate;
        border-spacing: 2px;
    }

    th,
    td {
        border-width: 1px;
        padding: 0.5em;
        position: relative;
        text-align: left;
    }

    th,
    td {
        border-radius: 0.25em;
        border-style: solid;
    }

    th {
        background: #EEE;
        border-color: #BBB;
    }

    td {
        border-color: #DDD;
    }

    /* table balance */

    table.balance th,
    table.balance td {
        width: 50%;
    }

    table.balance td {
        text-align: right;
    }
    </style>
</head>

<body>
    <center>
        <h2>Invoice</h2>
    </center>

    <div style="width:100%; min-height:100px">
        <div class="firstDiv left">
            <p>
                Order No. {{ $order['order_no'] }}<br>
                Order Date {{ $order['order_date'] }}<br><br><br><br><br><br>
            </p><br>
        </div>
        <div class="firstDiv right text-center">
            <p>
                Name {{ $order->billing['name'] }} <br>
                Email {{ $order->billing['email'] }} <br>
                Mobile {{$order->billing['mobile']}} <br>
                Address {{$order->billing['address']}} <br>
            </p><br>
        </div>
    </div>

    <br><br><br><br>
    <br><br><br><br>
    <br><br>

    <div style="width:100%; min-height:100px">
        <?php $count = 1; ?>
        <table>
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Product Name </th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @if(count($orderItems->orderItems)>0)
                    @foreach($orderItems->orderItems as $item)
                    <tr>
                        <td> {{ $count++ }}</td>
                        <td> {{ ucwords($item->product->product_name) }} </td>
                        <td> {{ $item['item_qty'] }}</td>
                        <td class="right"> {{ $item->product->product_price }} </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table><br>
        <table class="balance">
            <tr>
                <th><span>Subtotal</span></th>
                <td><span data-prefix></span><span>{{ $order['subtotal'] }}</span></td>
            </tr>
        </table>
        <table class="balance">
            <tr>
                <th><span>Tax</span></th>
                <td><span data-prefix></span><span>{{ $order['tax'] }}</span></td>
            </tr>
        </table>
        <table class="balance">
            <tr>
                <th><span>Total</span></th>
                <td><span data-prefix></span><span>{{ $order['order_total'] }}</span></td>
            </tr>
        </table>
    </div>

    <br><br><br><br> <br><br><br><br> <br><br>
    <center><h5>Thank you for your order.</h5></center>
</body>

</html>