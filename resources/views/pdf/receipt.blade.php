<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #FF9800; padding-bottom: 10px; }
        .logo { font-size: 24px; font-weight: bold; color: #002d18; }
        .title { font-size: 18px; color: #666; margin-top: 5px; }
        
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px; }
        .label { font-weight: bold; width: 150px; }

        .receipt-box { border: 1px solid #ddd; padding: 20px; border-radius: 8px; background: #fffbe6; }
        .amount { font-size: 24px; font-weight: bold; color: #28a745; }
        
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #888; border-top: 1px solid #eee; padding-top: 10px; }
        .stamp { 
            border: 2px dashed #28a745; color: #28a745; 
            padding: 10px 20px; display: inline-block; 
            font-weight: bold; transform: rotate(-5deg);
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Patani Trinidad Boarding House</div>
        <div class="title">Official Payment Receipt</div>
    </div>

    <div class="receipt-box">
        <table class="info-table">
            <tr>
                <td class="label">Reference No:</td>
                <td>{{ $payment-> id }}</td>
            </tr>
            <tr>
                <td class="label">Date Paid:</td>
                <td>{{ $payment->created_at->format('F d, Y h:i A') }}</td>
            </tr>
            <tr>
                <td class="label">Payer Name:</td>
                <td>{{ Auth::user()->name }}</td>
            </tr>
            <tr>
                <td class="label">Payment Type:</td>
                <td>{{ ucfirst($payment->payment_method) }}</td>
            </tr>
            <tr>
                <td class="label">Status:</td>
                <td style="color:green; font-weight:bold;">PAID</td>
            </tr>
        </table>

        <div style="text-align: center; margin-top: 20px;">
            <div style="font-size: 14px;">Total Amount Paid</div>
            <div class="amount"> Php {{ ($payment->amount ) }}</div>
            
            <div class="stamp">OFFICIAL RECEIPT</div>
        </div>
    </div>

    <div class="footer">
        This is a computer-generated receipt. No signature required.<br>
        Patani Trinidad Boarding House System
    </div>
</body>
</html>