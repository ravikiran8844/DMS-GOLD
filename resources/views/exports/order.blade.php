<table>
    <thead>
        <!-- Row for the logo -->
        <tr>
            <th colspan="5"></th>
            <th colspan="5" style="text-align: center;">
                <img src="{{ public_path('mobile-logo.png') }}" alt="Description of Logo" width="50"
                    height="50">
            </th>
        </tr>
        <tr>
            <th colspan="9" style="font-weight: bold; text-align: center;">Address: 230, E TV Swamy Rd, R.S. Puram,
                Coimbatore, Tamil Nadu 641002</th>
        </tr>
        @if ($orders->reference)
            <tr>
                <th></th>
                <th style="font-weight: bold; background-color:yellow;border: 1px solid #000;">Reference</th>
                <th style="font-weight: bold;border: 1px solid #000;">{{ $orders->reference }}</th>
            </tr>
        @endif
        <tr>
            <th style="font-weight: bold;"></th>
            <th style="font-weight: bold;background-color:yellow;border: 1px solid #000;">Order ID</th>
            @foreach ($details as $detail)
                <th style="font-weight: bold;border: 1px solid #000;">{{ $detail->order_no }}</th>
                <!-- Displaying each item's 'name' property in C cell -->
                @php
                    break;
                @endphp
            @endforeach
        </tr>
        <tr>
            <th style="font-weight: bold;"></th>
            <th style="font-weight: bold;background-color:yellow;border: 1px solid #000;">Name</th>
            @foreach ($details as $detail)
                <th style="font-weight: bold;border: 1px solid #000;">{{ $detail->name }}</th>
                <!-- Displaying each item's 'name' property in C cell -->
                @php
                    break;
                @endphp
            @endforeach
        </tr>
        <tr>
            <th style="font-weight: bold;"></th>
            <th style="font-weight: bold;background-color:yellow;border: 1px solid #000;">Date</th>
            @foreach ($details as $detail)
                <th style="font-weight: bold;border: 1px solid #000;">{{ $detail->created_at }}</th>
                <!-- Displaying each item's 'name' property in C cell -->
                @php
                    break;
                @endphp
            @endforeach
        </tr>
        <tr>
            <th style="font-weight: bold;"></th>
            <th style="font-weight: bold;background-color:yellow;border: 1px solid #000;">Email</th>
            @foreach ($details as $detail)
                <th style="font-weight: bold;border: 1px solid #000;">{{ $detail->email }}</th>
                <!-- Displaying each item's 'name' property in C cell -->
                @php
                    break;
                @endphp
            @endforeach
        </tr>
        <tr>
            <th style="font-weight: bold;"></th>
            <th style="font-weight: bold;background-color:yellow;border: 1px solid #000;">Mobile</th>
            @foreach ($details as $detail)
                <th style="font-weight: bold; text-align: left;border: 1px solid #000;">{{ $detail->mobile }}</th>
                <!-- Displaying each item's 'name' property in C cell -->
                @php
                    break;
                @endphp
            @endforeach
        </tr>
        <!-- Row for the table headers -->
        <tr>
            <th style="font-weight: bold; text-align: center;">S.No</th>
            <th style="font-weight: bold; text-align: center;">Product Image</th>
            <th style="font-weight: bold; text-align: center;">Product SKU</th>
            <th style="font-weight: bold; text-align: center;">Quantity</th>
            <th style="font-weight: bold; text-align: center;">Weight Per Piece</th>
            <th style="font-weight: bold; text-align: center;">Total Weight</th>
            <th style="font-weight: bold; text-align: center;">Finish</th>
            <th style="font-weight: bold; text-align: center;">Box</th>
            <th style="font-weight: bold; text-align: center;">Remark Finish</th>
            <th style="font-weight: bold; text-align: center;">Remark Box</th>
            <th style="font-weight: bold; text-align: center;">Remark Others</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach ($details as $detail)
            <tr>
                <td>{{ $i }}</td>
                <td><img src="{{ public_path('upload/product/' . $detail->product_image) }}" alt="Description of Image"
                        width="100" height="100">
                </td>
                <td style="text-align: center;">{{ $detail->product_unique_id }}</td>
                <td style="text-align: center;">{{ $detail->qty }}</td>
                <td style="text-align: center;">{{ $detail->weight }}</td>
                <td style="text-align: center;">{{ $detail->weight * $detail->qty }}</td>
                <td style="text-align: center;">{{ $detail->finish_name }}</td>
                <td style="text-align: center;">{{ $detail->style_name }}</td>
                <td style="text-align: center;">{{ $detail->remarks }}</td>
                <td style="text-align: center;">{{ $detail->box_details }}</td>
                <td style="text-align: center;">{{ $detail->others }}</td>
                @php $i++; @endphp
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        @php
            $totalWeight = 0;
            foreach ($details as $detail) {
                $totalWeight += $detail->qty * $detail->weight;
            }
        @endphp
        <tr>
            <th></th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th style="font-size:18px; text-align: center;background-color: olivedrab"><strong>Grand Total
                    :</strong></th>
            <th style="font-size:18px; text-align: center;background-color: olivedrab;">
                {{ $details->sum('qty') }}</th>
            <th></th>
            <th style="font-size:18px; text-align: center;background-color: olivedrab;">{{ $totalWeight }}
            </th>
        </tr>
        <tr>
            <th></th>
        </tr>

        @if ($orders->remarks != null)
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th
                    style="font-weight: bold; text-align: center; font-size: 18px; border: 1px solid #000;background-color: yellow;">
                    Finish</th>
                <th
                    style="font-size: 12px; text-align: center; font-weight: bold; border: 1px solid #000;background-color: yellow;">
                    {{ $orders->remarks }}</th>
            </tr>
        @endif
        @if ($orders->box != null)
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th
                    style="font-weight: bold; text-align: center; font-size: 18px; border: 1px solid #000;background-color: yellow;">
                    Box</th>
                <th
                    style="text-align: center; font-size: 12px; font-weight: bold; border: 1px solid #000;background-color: yellow;">
                    {{ $orders->box }}</th>
            </tr>
        @endif
        @if ($orders->others != null)
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th
                    style="font-weight: bold; text-align: center; font-size: 18px; border: 1px solid #000;background-color: yellow;">
                    Others</th>
                <th
                    style="font-weight: bold; font-size: 12px; text-align: center; border: 1px solid #000;background-color: yellow;">
                    {{ $orders->others }}</th>
            </tr>
        @endif

    </tfoot>

</table>
