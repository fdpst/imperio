<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Factura</title>
</head>

<body>

    <div class="buyer-info">
        <p>{{$factura['cliente']['nombre']}}</p>
        <p>{{$factura['cliente']['direccion']}}</p>
        <p>CIF: {{$factura['cliente']['dni']}}</p>
    </div>

    <div class="invoice-header">
        <h3>FACTURA</h3>
    </div>

    <div class="invoice-info">

        <div class="invoice-info-n">
            <p>Nro Factura: {{$factura['nro_f']}}</p>
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
                    <th class="border" style="width:20%;text-align:left;">Descripción</th>
                    <th class="border" style="width:10%;text-align:center;">Cantidad</th>
                    <th class="border" style="width:15%;text-align:center;">Precio unitario</th>
                    <th class="border" style="width:15%;text-align:center;">Descuento</th>
                    <th class="border" style="width:15%;text-align:center;">Impuestos</th>
                    <th class="border" style="width:15%;text-align:right;">Importe total</th>
                </tr>
            </thead>

            <tbody>
                @foreach($factura['productos'] as $item)
                <tr>
                    <td style="width:20%">{{ $item['descripcion'] }}</td>

                    <td style="width:10%;text-align:center;">{{ $item['cantidad'] }}</td>

                    <!-- precio / 1.21 (iva..)-->

                    <td style="width:15%;text-align:center;">
                        @php
                        $precio_sin_iva = $item['producto']['precio'] / (($item['producto']['tipo_iva'] / 100) + 1);
                        @endphp
                        {!! number_format((float)$precio_sin_iva, 2) !!}
                    </td>

                    <!-- descuento en (%) : 15% -->
                    <td style="width:15%;text-align:center;">{{$factura['porcentaje_descuento']}}%</td>

                    <!-- iva en (%) : 21% -->
                    <td style="width:15%;text-align:center;">{{$item['producto']['tipo_iva']}}%</td>

                    <!-- sacar descuento e iva  -->
                    <td style="width:15%;text-align:center;">
                        @php
                        $precio_sin_iva = $item['producto']['precio'] / (($item['producto']['tipo_iva'] / 100) + 1);

                        $importe_total = ($factura['descuento'] > 0) ? $precio_sin_iva * (1 - $factura['porcentaje_descuento'] / 100) : $precio_sin_iva;

                        $suma_sin_iva = $item['cantidad'] * $importe_total;
                        @endphp
                        {!! number_format((float)$suma_sin_iva, 2) !!}
                    </td>

                </tr>
                @endforeach

            </tbody>


        </table>
    </div>

    <div class="end-tables">


        <table style="float: left; width:40%">
            <thead>
                <tr>
                    <th style="width:33%;text-align:left;">IVA</th>
                    <th style="width:33%;text-align:center;">Base imp.</th>
                    <th style="width:33%;text-align:right;">Cuota</th>
                </tr>
            </thead>

            <tbody>
                @foreach($lista_iva as $key => $detalle)
                <tr>
                    <td style="width:33%;text-align:left;">{{ $key }}%</td>
                    <td style="width:33%;text-align:center;">{{ $detalle['total_sin_iva'] }}</td>
                    <td style="width:33%;text-align:right;">{{ $detalle['total_iva'] }}</td>
                </tr>
                @endforeach
                <tr>
                    <td style="width:33%;text-align:left;">Total</td>
                    <td style="width:33%;text-align:center;">{{ $factura['sub_total'] }}</td>
                    <td style="width:33%;text-align:right;">{{ $factura['iva'] }}</td>
                </tr>
            </tbody>
        </table>

        <table style="margin-top: 5px;float: right; width:60%">
            <tbody>
                <tr>
                    <td style="width:50%;"></td>
                    <td style="width:25%;text-align:right;">Sub Total:</td>
                    <td style="width:25%;text-align:left;">{{ $factura['sub_total'] }} EUR</td>
                </tr>
                <tr>
                    <td style="width:50%;"></td>
                    <td style="width:25%;text-align:right;">Impuestos:</td>
                    <td style="width:25%;text-align:left;">{{ $factura['iva'] }} EUR</td>
                </tr>
                <tr>
                    <td style="width:50%;"></td>
                    <td style="width:25%;text-align:right;">Total:</td>
                    <td style="width:25%;text-align:left;">{{ $factura['total'] }} EUR</td>
                </tr>
            </tbody>
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
