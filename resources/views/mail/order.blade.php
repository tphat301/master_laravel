<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đơn hàng</title>
</head>

<body>
    <table class="table__mail">
        <tbody>
            <tr>
                <td>
                    <h1 style="font-size: 14px; font-weight: bold; color: #444; padding: 0 0 5px 0; margin: 0;">
                        Chào {{ $fullname }}. Đơn hàng của bạn đã đặt thành công!</h1>
                    <p style="margin: 4px 0; font-size: 12px; color: #444; line-height: 18px; font-weight: normal;">
                        Chúng tôi đang chuẩn bị hàng để bàn giao cho đơn vị vận chuyển hàng
                    </p>
                    <h3
                        style="font-size: 13px; font-weight: bold; color: #02acea; text-transform: uppercase; margin: 20px 0 0 0; border-bottom: 1px solid #ddd;">
                        MÃ ĐƠN HÀNG: {{ $code }}<br>Ngày đặt: {{ $time }}
                    </h3>
                </td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td style="font-size: 12px; color: #444; line-height: 18px;">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                        <thead>
                            <tr>
                                <th width="50%" align="left"
                                    style="padding: 6px 9px  0px 9px; font-size: 12px; color: #444; font-weight: bold;">
                                    Thông tin khách hàng</th>
                                <th width="50%" align="left"
                                    style="padding: 6px 9px 0px 9px; font-size: 12px; color: #444; font-weight: bold;">
                                    Địa chỉ giao hàng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 3px 9px 9px 9px; border-top: 0; font-size: 12px; color: #444; line-height: 18px; font-weight: normal;"
                                    valign="top">
                                    <span>Họ và tên: {{ $fullname }}</span><br>
                                    <a>Email: {{ $email }}</a><br> Số điện thoại: {{ $phone }}
                                </td>
                                <td style="padding: 3px 9px 9px 9px; border-top: 0; border-left: 0; font-size: 12px; color: #444; line-height: 18px; font-weight: normal;"
                                    valign="top">
                                    {{ $address }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table
                        style=" width: 100%; border-collapse: collapse; border-spacing: 2px; background: #f5f5f5; display: table; box-sizing: border-box; border: 0; border-color: grey;">
                        <thead style="display: table-header-group; vertical-align: middle; border-color: inherit;">
                            <tr>
                                <th
                                    style="text-align: left; background-color: #02acea; padding: 6px 9px; color: #fff; text-transform: uppercase; font-size: 12px; line-height: 14px;">
                                    STT</th>
                                <th
                                    style="text-align: left; background-color: #02acea; padding: 6px 9px; color: #fff; text-transform: uppercase; font-size: 12px; line-height: 14px;">
                                    Tên sản phẩm</th>
                                <th
                                    style="text-align: left; background-color: #02acea; padding: 6px 9px; color: #fff; text-transform: uppercase; font-size: 12px; line-height: 14px;">
                                    Giá</th>
                                <th
                                    style="text-align: left; background-color: #02acea; padding: 6px 9px; color: #fff; text-transform: uppercase; font-size: 12px; line-height: 14px;">
                                    Số lượng</th>
                                <th
                                    style="text-align: left; background-color: #02acea; padding: 6px 9px; color: #fff; text-transform: uppercase; font-size: 12px; line-height: 14px;">
                                    Thành tiền</th>
                            </tr>
                        </thead>
                        @if (Cart::content())
                            <tbody
                                style="font-size: 12px; color: #444; line-height: 18px; background-color: rgb(238, 238, 238); display: table-row-group; vertical-align: middle; border-color: inherit;">
                                @php
                                    $count = 0;
                                @endphp
                                @foreach (Cart::content() as $k => $v)
                                    @php
                                        $count++;
                                    @endphp
                                    <tr>
                                        <td style="padding: 3px 9px">{{ $count }}</td>
                                        <td style="padding: 3px 9px">
                                            <span>{{ $v->name }}</span>
                                        </td>
                                        <td style="padding: 3px 9px">
                                            <span>{{ number_format($v->price, 0, ',', '.') }}VND</span>
                                        </td>
                                        <td style="padding: 3px 9px">
                                            <span>{{ $v->qty }}</span>
                                        </td>
                                        <td style="padding: 3px 9px">
                                            <span>{{ number_format($v->subtotal, 0, ',', '.') }}đ</span>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3"
                                        style="text-align:left;background-color:rgb(238,238,238);padding:6px 9px;color:rgb(0,0,0);text-transform:capitalize;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                        <strong>Tổng thanh toán:</strong>
                                    </td>
                                    <td colspan="3" style="padding:3px 9px; text-align: center; font-weight: bold">
                                        <span style="color:red">{{ number_format(Cart::total(), 0, ',', '.') }}đ</span>
                                    </td>
                                </tr>
                            </tbody>
                        @endif
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <br>
                    <p style="margin: 0; font-size: 12px; color: #444; line-height: 18px; font-weight: normal;">Quý
                        khách
                        vui lòng giữ lại hóa đơn (nếu có) để trao đổi hoặc khiếu nại khi cần
                        thiết.</p>
                    <p
                        style=" margin: 10px 0 0 0;
            font-size: 12px;
            color: #444;
            line-height: 18px;
            font-weight: normal;">
                        Liên hệ Hotline: <strong style="color: rgb(245, 27, 86);">{{ $hotline }}</strong> (8-21h
                        cả
                        T7,CN).</p>
                </td>
            </tr>
            <tr>
                <td>
                    <br>
                    <p
                        style="font-size: 12px;
            margin: 0;
            padding: 0;
            line-height: 18px;
            color: #444;
            font-weight: bold;">
                        Cảm ơn quý khách đã đặt dịch vụ, chúng tôi sẽ không ngừng nổ lực để phục vụ quý khách tốt
                        hơn!<br>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
