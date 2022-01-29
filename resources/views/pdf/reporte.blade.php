<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Reporte Ventas</title>
</head>
<body>
    <div class="invoice-header">
        <h3> REPORTE FACTURAS - TICKETS </h3> 
        <p style="margin-right: 20px !important; font-size: 12px !important;"> DESDE : {{ $desde }} - HASTA : {{ $hasta }} </p>
    </div>

    <div class="invoice-table-products">
        <table>
            <thead>
                <tr style="font-weight: bold !important;">
                    <th class="border" style="width:15%;">Nro. Ticket</th>
                    <th class="border" style="width:15%;">Nro. Factura</th>
                    <th class="border" style="width:20%;">Fecha</th>
                    <th class="border" style="width:25%;">Cliente</th>
                    <th class="border" style="width:15%;">IVA</th>
                    <th class="border" style="width:20%;">TOTAL</th>
                </tr>
            </thead>
               @php $ivatotal = 0; @endphp 
               @php $grantotal = 0; @endphp 
                @foreach($data as $item)
                <tr>
                    @php if($item['nro_t'] != null){ @endphp
                        <td style="width:10%;text-align:center;">{{ $item['nro_t'] }}</td>
                    @php } else { @endphp <td style="width:10%"> </td> @php } @endphp

                    @php if($item['nro_f'] != null){ @endphp 
                        <td style="width:10%;text-align:center;">{{ $item['nro_f'] }}</td>
                    @php } else { @endphp <td style="width:10%"> </td> @php } @endphp

                    @php if($item['created_at'] != null){ @endphp
                        <td style="width:20%;text-align:center;">{{ $item['created_at'] }}</td>
                    @php } else { @endphp <td style="width:20%"> </td> @php } @endphp

                    @php if($item['cliente_id'] != null){ @endphp 
                        <td style="width:25%;text-align:left;">{{ $item['cliente']['nombre'] }}</td>
                    @php } else { @endphp <td style="width:25%"></td> @php } @endphp

                    @php if($item['iva'] != null){ @endphp
                        <td style="width:15%;text-align:center;">{{ $item['iva'] }}</td>
                    @php } else { @endphp <td style="width:15%"> </td> @php } @endphp

                    @php if($item['total'] != null){ @endphp 
                        <td style="width:20%;text-align:center;">{{ $item['total'] }}</td>
                    @php } else { @endphp <td style="width:20%"> </td> @php } @endphp

                    @php $ivatotal = $ivatotal + $item['iva']; @endphp 
                    @php $grantotal = $grantotal + $item['total']; @endphp 
                                        
                </tr>
                @endforeach               
        </table>
        <p>IVA TOTAL : {{$ivatotal}} €</p>
        <p>TOTAL PERIODO : {{$grantotal}} €</p>
    </div>

    <style>
        html {
            margin: 0;
            padding: 0;
        }

        body {
            padding: 15px 20px;
            color: #546e7a !important;
        }

        P {
            color: black !important;
            font-weight: bold !important;
            text-align: right;
            margin-right: 12px;
            font-size: 9px !important;
        }

        table {
            font-weight: lighter !important;
            border-collapse: collapse;
            font-size: 9px !important;
            width: 100%;
            color: black !important;
        }

        table thead tr th {
            padding: 5px 5px;
            border-bottom: solid 1px gray;
            color: black !important;
        }

        .invoice-header {
            text-align: left;
            display: block;
            margin-top: 8px;
            color: black !important;
        }

        .invoice-header h3 {
            margin: 0;
            color: black !important;
        }

        .invoice-table-products {
            width: 98%
            color: black !important;
        }

        .invoice-table-products table {
            width: 98%;
            margin-top: 20px;
            margin-left: 15px;
            color: black !important;
        }

        .border {
            border-bottom: solid 1px gray;
            color: black !important;
        }

        .border-top {
            border-top: solid 1px gray;
            color: black !important;
        }

        table tr:nth-child(even) {
            background-color: #e3e3e3;
            border: 1px solid black;
            color: black !important;
        }

        table{
            border: 1px solid black;
        }

    </style>    
</body>
</html>