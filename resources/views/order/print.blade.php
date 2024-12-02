<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Pembelian</title>
</head>

<body>
    <style>
        #back-wrap {
            margin: 30px auto 0 auto;
            width: 500px;
            display: center;
            justify-content: flex-end;
            gap: 20px
        }

        .btn-back {
            width: fit-content;
            padding: 8px 15px;
            color: #ffffff;
            background: #c75e3e;
            border-radius: 5px;
            text-decoration: none;
            box-shadow: 5px 10px 15px rgba(228, 103, 103, 0.5);

        }

        #receipt {
            box-shadow: 5px 10px 15px rgba(228, 103, 103, 0.5);
            padding: 20px;
            margin: 30px auto 0 auto;
            width: 500px;
            background: #d3c6c6;
        }

        h2 {
            font-size: 15px;
        }

        p {
            font-size: .9rem;
            color: #946060;
            line-height: 1.5rem;
        }

        #top {
            margin-top: 20px;
        }

        #top .info {
            text-align: center;
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 5px 0 5px 15px;
            border: 1px solid #252e25;
        }

        .tabletitle {
            font-size: 5rem;
            background: #d47164;
        }

        .service {
            border-bottom: 1px solid #EEE;
        }

        .itemtext {
            font-size: .7rem;
        }

        #legalcopy {
            margin-top: 15px;
        }

        .btn-print {
            float: right;
            color: #333;
        }
    </style>
    
    <div id="receipt">
        <center id="top">
            <div class="info">
                <h2>
                    Apotek SAKITTT
                </h2>
            </div>
        </center>
        <div id="mid">
            <p>
                Alamat: jaksel <br>
                Email: Sick@gmail.com <br>
                Phone: 1234-5678-9101 <br>
            </p>
        </div>
        <div id="bot">
            <div id="table">
                <table>
                    <tr>
                        <td class="item">
                            <h2>Buku</h2>
                        </td>
                        <td class="item">
                            <h2>Total</h2>
                        </td>
                        <td class="item">
                            <h2>Harga</h2>
                        </td>
                    </tr>
                    @foreach ($order['medicines'] as $medicine)
                        <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext"> {{ $medicine['name_medicine'] }} </p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext"> {{ $medicine['qty'] }} </p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext"> Rp. {{ number_format($medicine['price'], 0, ',', '.') }} </p>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="tabletitle">
                        <td></td>
                        <td class="rate">
                            <h2>PPN (10%)</h2>
                        </td>
                        @php
                            $ppn = $order['total_price'] * 0.1;
                        @endphp
                        <td class="payment">
                            <h2>Rp. {{ number_format($ppn, 0, ',', '.') }} </h2>
                        </td>
                    </tr>
                    <tr class="tabletitle">
                        <td></td>
                        <td class="rate">
                            <h2>Total Harga:</h2>
                        </td>
                        <td class="payment">
                            <h2>Rp. {{ number_format($order['total_price'] + $ppn, 0, ',', '.') }} </h2>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="legalcopy">
                <p class="legal"><strong>Terima Kasih atas pembelian anda!</strong>  
                </p>
            </div>
        </div>
    </div>
    <div id="back-wrap">
        <a href="{{ route('orders') }}" class="btn-back">Kembali</a>
        <a href=" {{ route('orders.download', $order['id']) }} " class="btn-back">Cetak (.pdf)</a>
    </div>
</body>

</html>