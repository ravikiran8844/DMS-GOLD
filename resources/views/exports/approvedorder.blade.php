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
        {{-- @if ($details->reference)
            <tr>
                <th></th>
                <th style="font-weight: bold; background-color:yellow;border: 1px solid #000;">Reference</th>
                <th style="font-weight: bold;border: 1px solid #000;">{{ $details->reference }}</th>
            </tr>
        @endif
        @if ($details->dealer_name)
            <tr>
                <th></th>
                <th style="font-weight: bold; background-color:yellow;border: 1px solid #000;">Dealer Name</th>
                <th style="font-weight: bold;border: 1px solid #000;">{{ $details->dealer_name }}</th>
            </tr>
        @endif --}}
        <tr>
            <th style="font-weight: bold;"></th>
            <th style="font-weight: bold;background-color:yellow;border: 1px solid #000;">Reference</th>
            @foreach ($details as $detail)
                <th style="font-weight: bold;border: 1px solid #000;">
                    {{ $detail->reference == null ? '-' : $detail->reference }}</th>
                <!-- Displaying each item's 'name' property in C cell -->
                @php
                    break;
                @endphp
            @endforeach
        </tr>
        <tr>
            <th style="font-weight: bold;"></th>
            <th style="font-weight: bold;background-color:yellow;border: 1px solid #000;">Dealer Name</th>
            @foreach ($details as $detail)
                <th style="font-weight: bold;border: 1px solid #000;">{{ $detail->dealer_name }}</th>
                <!-- Displaying each item's 'name' property in C cell -->
                @php
                    break;
                @endphp
            @endforeach
        </tr>
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
            <th style="font-weight: bold;background-color:yellow;border: 1px solid #000;">Address</th>
            @foreach ($details as $detail)
                <th style="font-weight: bold;border: 1px solid #000;">
                    {{ $detail->address, $detail->district, '-', $detail->pincode }}</th>
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
            <th style="font-weight: bold; text-align: center;">Order Quantity</th>
            <th style="font-weight: bold; text-align: center;">Weight Per Piece</th>
            <th style="font-weight: bold; text-align: center;">Total Weight</th>
            <th style="font-weight: bold; text-align: center;">Box</th>
            @foreach ($details as $detail)
                @if ($detail->approved_qty != null)
                    <th style="font-weight: bold; text-align: center;">Approved Quantity</th>
                    <th style="font-weight: bold; text-align: center;">Approved Weight</th>
                @endif
            @endforeach
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
                <td style="text-align: center;">{{ $detail->style_name }}</td>
                @if ($detail->approved_qty != null)
                    <td style="text-align: center;">{{ $detail->approved_qty }}</td>
                    <td style="text-align: center;">{{ $detail->weight * $detail->approved_qty }}</td>
                @endif
                @php $i++; @endphp
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        @php
            $totalWeight = 0;
            foreach ($details as $detail) {
                if ($detail->approved_qty == null) {
                    $totalWeight += $detail->qty * $detail->weight;
                } else {
                    $totalWeight += $detail->approved_qty * $detail->weight;
                }
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
            @foreach ($details as $detail)
                @if ($detail->approved_qty != null)
                    <th style="font-size:18px; text-align: center;background-color: olivedrab;">
                        {{ $details->sum('approved_qty') }}</th>
                @endif
            @endforeach
            <th></th>
            <th style="font-size:18px; text-align: center;background-color: olivedrab;">{{ $totalWeight }}
            </th>
        </tr>
        <tr>
            <th></th>
        </tr>

        @if ($orders->others != null)
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th
                    style="font-weight: bold; text-align: center; font-size: 14px; border: 1px solid #000;background-color: grey;">
                    Remarks</th>
                <th
                    style="font-weight: bold; font-size: 12px; text-align: center; border: 1px solid #000;background-color: yellow;">
                    {{ $orders->others }}</th>
            </tr>
        @endif
        @if ($orders->admin_remarks != null)
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th
                    style="font-weight: bold; text-align: center; font-size: 14px; border: 1px solid #000;background-color: grey;">
                    Admin Remarks</th>
                <th
                    style="font-weight: bold; font-size: 12px; text-align: center; border: 1px solid #000;background-color: yellow;">
                    {{ $orders->admin_remarks }}</th>
            </tr>
        @endif

    </tfoot>

</table>
