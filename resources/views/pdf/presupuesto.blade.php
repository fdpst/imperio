<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>presupuesto</title>
</head>

<body>

    <div class="buyer-info">
        <p>{{$factura['cliente']['nombre']}}</p>
        <p>{{$factura['cliente']['direccion']}}</p>
        <p>CIF: {{$factura['cliente']['dni']}}</p>
    </div>

    <div class="invoice-header">
        <h3>PRESUPUESTO</h3>
    </div>

    <div class="invoice-info">

        <div class="invoice-info-n">
            <p>Fecha: 12/12/2020</p>
        </div>

        <div class="invoice-info-e">
            <p>{!! nl2br(e($legal['informacion_legal'])) !!}</p>
        </div>

    </div>


    <div class="invoice-table-products">
        <table>
            <thead>
                <tr>
                    <th class="border" style="width:55%;text-align:left;">Descripción</th>
                    <th class="border" style="width:15%;text-align:center;">Cantidad</th>
                    <th class="border" style="width:15%;text-align:center;">Precio unitario</th>
                    <th class="border" style="width:15%;text-align:right;">Importe total</th>
                </tr>
            </thead>

            <tbody>
                @foreach($factura['productos'] as $item)
                <tr>
                    <td style="width:55%">{{ $item['descripcion'] }}</td>

                    <td style="width:15%;text-align:center;">{{ $item['cantidad'] }}</td>

                    <td style="width:15%;text-align:center;">{{$item['producto']['precio']}}</td>

                    <td style="width:15%;text-align:right;">{{$item['total']}}</td>
                </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="2" style="text-align:right;"></td>
                    <td style="text-align:center;"><strong>Total (€)</strong></td>
                    <td style="width:15%;text-align:right;">{{ $factura['total'] }}</td>
                </tr>
            </tfoot>

        </table>
    </div>

    <style>
        .end-tables {
            margin-top: 35px;
        }

        .padding-row-top {
            margin-top: 5px;

        }

        html {
            margin: 0;
            padding: 0;
        }

        body {
            padding: 15px 20px;
            color: #546e7a !important;
        }

        table {
            font-weight: lighter !important;
            border-collapse: collapse;
            font-size: 9px !important;
            width: 100%;
        }

        table thead tr th {
            padding: 5px 5px;
            border-bottom: solid 1px gray;

        }

        table tbody tr td {
            padding: 2px 5px;
            vertical-align: bottom;
        }

        table tfoot tr td {
            padding: 5px 5px;
            vertical-align: bottom;
        }

        .invoice-header {
            text-align: left;
            display: block;
            margin-top: 8px;
        }

        .invoice-header h3 {
            margin: 0;
        }

        .invoice-body {
            padding: 3px 6px;
            text-align: left;
        }

        .invoice-body p {
            font-size: 9px !important;
        }

        .invoice-table-products {
            width: 100%
        }

        .invoice-table-products table {
            width: 100%;

        }

        .border {
            border-bottom: solid 1px gray;
        }

        .border-top {
            border-top: solid 1px gray;
        }

        .buyer-info p {
            text-transform: uppercase;
            margin: 0 !important;
            font-size: 9px;
        }

        .buyer-info p strong {
            font-weight: 700 !important;
        }



        .invoice-info {
            display: block;
        }

        .invoice-info div {
            vertical-align: top;
            display: inline-block;
        }

        .invoice-info .invoice-info-n {
            width: 50%;
            padding-right: 40px;
        }
    </style>
</body>

</html>