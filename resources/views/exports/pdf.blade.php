<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Email Template</title>

</head>

<body style="margin: auto; background-color: #fff;box-sizing: border-box;font-size: 14px;max-width: 750px;">
    <main style="font-family: 'Helvetica Neue', Arial, sans-serif; font-size: 12px; color: #0a312d;">
        <table style="border-collapse: collapse; width: 100%; margin: auto; max-width: 100%;">
            <!-- Header row with logo and address -->
            <tr>
                <td colspan="2"
                    style="width: 100%; text-align: center; background-color: #0a312d; color: white; padding: 20px;">
                    <img src="{{ public_path('/retailer/assets/img/pdf-logo.svg') }}" alt="Logo" width="150"
                        style="width: 100%; height: auto; max-width: 200px;" />
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 10px;">
                        <tr style="text-align: center;">
                            <td style="font-size: 12px; color: white;text-align: center;">
                                Address: 460, Central Reserve Police Force Rd, opp. roots industries, Coimbatore
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Row for customer details and order details -->
            <tr style="vertical-align: top;">
                @foreach ($datas as $item)
                <!-- Left column with customer details -->
                <td style="text-align: start; border: none;" width="50%">
                    <table width="100%" cellpadding="0" cellspacing="10px" border="0"
                        style="margin-top: 20px;">
                        <tr>
                            <td style="font-weight: 600; padding-bottom: 10px;">Name:</td>
                            <td style="padding-bottom: 10px;">{{ $item->name }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; padding-bottom: 10px;">Date:</td>
                            <td style="padding-bottom: 10px;">{{ $item->created_at }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; padding-bottom: 10px;">Email:</td>
                            <td style="padding-bottom: 10px;">{{ $item->email }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; padding-bottom: 10px;">Mobile:</td>
                            <td style="padding-bottom: 10px;">+91 {{ $item->mobile }}</td>
                        </tr>
                    </table>
                </td>
                @php break; @endphp
                @endforeach
                <!-- Right column with order details -->
                <td style="text-align: start; border: none;" width="50%">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 20px;">
                        <tr>
                            <td style="font-weight: 600; padding-bottom: 10px;">Order Reference:</td>
                            <td style="padding-bottom: 10px;">{{ $order->reference != null ? $order->reference : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; padding-bottom: 10px;">Remarks:</td>
                            <td style="padding-bottom: 10px;"> {{ $order->others != null ? $order->others : '-' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>


        <table style="margin-top: 10px; width: 100%; border-collapse: collapse;">
            <tr>
                <td colspan="2"
                    style="text-align: center; font-weight: bold; background-color: #ccf0f0; border: none;padding:10px;">
                    Order Summary</td>
            </tr>
            <tr>
                <td style="border: none;">
                    <div
                        style="border: 1px solid #14744F; background: #fff; text-align: center;margin: auto;margin-top: 20px; max-width: 240px; border-radius: 10px; overflow: hidden;">
                        <div
                            style="font-weight: 700; background: #fff9ca; padding: 10px; border-bottom: 1px solid #14744F;">
                            Total Pieces Ordered</div>
                        <div style="padding: 10px; font-weight: 700;">{{ $datas->sum('qty') }}</div>
                    </div>
                </td>
                <td style="border: none;">
                    <div
                        style="border: 1px solid #14744F; background: #fff; text-align: center;margin: auto;margin-top: 20px; max-width: 240px; border-radius: 10px; overflow: hidden;">
                        <div
                            style="font-weight: 700; background: #fff9ca; padding: 10px; border-bottom: 1px solid #14744F;">
                            Total Weight Ordered</div>
                        <div style="padding: 10px; font-weight: 700;">{{ $order->totalweight }}</div>
                    </div>
                </td>
            </tr>
        </table>

        <table
            style="background-color: #fff; width: 100%; border-radius: 8px; margin: auto; margin-top: 30px; overflow: hidden;border-collapse: collapse;">
            <tr>
                <td colspan="9"
                    style="background-color: #0a312d; color: white; padding: 10px; border-radius: 8px 8px 0 0; text-align: center;">
                    <strong>Order ID: {{ $order->order_no }}</strong>
                </td>
            </tr>
            <tr>
                <th style="background-color: #ccf0f0;padding: 5px;border: 1px solid #14744F; text-align: center;">S.No
                </th>
                <th style="background-color: #ccf0f0;padding: 5px;border: 1px solid #14744F; text-align: center;">
                    Product Image</th>
                <th style="background-color: #ccf0f0;padding: 5px;border: 1px solid #14744F; text-align: center;">
                    Project</th>
                <th style="background-color: #ccf0f0;padding: 5px;border: 1px solid #14744F; text-align: center;">
                    Product SKU</th>
                <th style="background-color: #ccf0f0;padding: 5px;border: 1px solid #14744F; text-align: center;">Purity
                </th>
                <th style="background-color: #ccf0f0;padding: 5px;border: 1px solid #14744F; text-align: center;">Weight
                    Per Piece</th>
                <th style="background-color: #ccf0f0;padding: 5px;border: 1px solid #14744F; text-align: center;">Order
                    Quantity</th>
                <th style="background-color: #ccf0f0;padding: 5px;border: 1px solid #14744F; text-align: center;">Total
                    Weight</th>
                <th style="background-color: #ccf0f0;padding: 5px;border: 1px solid #14744F; text-align: center;">Box
                </th>
            </tr>
            @foreach ($datas as $item)
            <tr>
                <td style=" border: 1px solid #14744F; text-align: center;">1</td>
                <td style=" border: 1px solid #14744F; text-align: center; "><img
                        src="{{ public_path('upload/product/' . $item->product_image) }}" alt="Product"
                        width="50" height="50"></td>
                <td style=" border: 1px solid #14744F; text-align: center; ">{{ $item->project_name }}</td>
                <td style=" border: 1px solid #14744F; text-align: center; ">{{ $item->product_unique_id }}</td>
                <td style=" border: 1px solid #14744F; text-align: center; ">
                    {{ str_replace('SIL-', '', $item->silver_purity_percentage) }}
                </td>
                <td style=" border: 1px solid #14744F; text-align: center; ">{{ $item->weight }}</td>
                <td style=" border: 1px solid #14744F; text-align: center; ">{{ $item->qty }}</td>
                <td style=" border: 1px solid #14744F; text-align: center; ">{{ $item->weight * $item->qty }}</td>
                <td style=" border: 1px solid #14744F;  text-align: center;">{{ $item->style_name }}</td>
            </tr>
            @endforeach
            @php
            $totalWeight = 0;
            foreach ($datas as $detail) {
            $totalWeight += $detail->qty * $detail->weight;
            }
            @endphp
            <tr>
                <td class="no-border" colspan="6" style="border: none;"></td>
                <td
                    style="text-align: center; font-weight: bold; background-color: #ccf0f0; border: 1px solid #14744F;">
                    Total Quantity: {{ $datas->sum('qty') }}</td>
                <td
                    style="text-align: center; font-weight: bold; background-color: #ccf0f0; border: 1px solid #14744F;">
                    Total Weight: {{ $totalWeight }}</td>
                <td class="no-border" style="border: none;"></td>
            </tr>
        </table>
    </main>
</body>

</html>