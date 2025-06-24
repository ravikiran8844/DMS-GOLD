<table>
    <thead>
        <tr>
            <th style="font-weight: bold; text-align: center;">Product SKU</th>
            <th style="font-weight: bold; text-align: center;">Retailer Name</th>
            <th style="font-weight: bold; text-align: center;">Dealer Name</th>
            <th style="font-weight: bold; text-align: center;">Product Quantity</th>
            <th style="font-weight: bold; text-align: center;">Product Weight</th>
            <th style="font-weight: bold; text-align: center;">Approved Quantity</th>
            <th style="font-weight: bold; text-align: center;">Approved Weight</th>
            <th style="font-weight: bold; text-align: center;">Box Name</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order as $item)
            <tr>
                <td>{{ $item->product_unique_id }}</td>
                <td>{{ $item->retailer_name }}</td>
                <td>{{ $item->dealer_name }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ $item->weight }}</td>
                @if ($item->approved_qty)
                    <td>{{ $item->approved_qty }}</td>
                    <td>{{ $item->approved_qty * $item->weight }}</td>
                @else
                    <td style="font-weight: bold; text-align: center;">-</td>
                    <td style="font-weight: bold; text-align: center;">-</td>
                @endif
                <td>{{ $item->box_name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
