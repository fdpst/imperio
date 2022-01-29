<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Factura</title>
</head>

<body>
    <div class="invoice-header">
        <h5>{!! nl2br(e($legal['informacion_legal'])) !!}</h5>
    </div>

    <div class="invoice-body">
        <p>Factura simplificada: {{$factura['nro_t']}}</p>
        <p style="float:right;">Fecha: {{$factura['nro_ticket']['fecha']}}</p>
    </div>

    <div class="invoice-table-products">
        <table>
            <thead>
                <tr>
                    <th class="border" style="padding-right: 5;width:25%;text-align:center;">Cod.</th>
                    <th class="border" style="padding-left: 0;width:60%;text-align:left;">Descripción</th>
                    <th class="border" style="width:10%;text-align:center;">Uds.</th>
                    <th class="border" style="width:25%;text-align:right;">PVP</th>
                </tr>
            </thead>

            <tbody>
                @foreach($factura['productos'] as $item)
                <tr>
                    <td style="padding-left: 0;width:5%">{{ $item['id'] }}</td>
                    <td style="padding-left: 0;width 100%;font-size: 7px !important;margin-left: 1;">{{ $item['descripcion'] }}</td>
                    <td style="width:5%;text-align:center;margin-left: 1;" valign="bottom">{{ $item['cantidad'] }}</td>
                    <!-- sacar descuento e iva  -->
                    <td style="width:15%;text-align:center;">
                        @php
                        $importe_total = ($factura['descuento'] > 0) ? $item['producto']['precio'] * (1 - $factura['porcentaje_descuento'] / 100) : $item['producto']['precio'];

                        $suma_sin_iva = $item['cantidad'] * $importe_total;
                        @endphp
                        {!! number_format((float)$suma_sin_iva, 2) !!}
                    </td>
                </tr>
                @endforeach

                @if($factura['descuento'] > 0)

                <tr>
                    <td colspan="2" style="text-align:left;">Descuento {{$factura['porcentaje_descuento']}}% </td>
                    <td style="text-align:right;">{{ $factura['descuento'] }}</td>
                </tr>

                @endif

                <tr>
                    <td colspan="2" class="border-top padding-row-top" style="font-size: 12px !important;text-align:right;">TOTAL (€)</td>
                    <td colspan="2" class="border-top padding-row-top" style="font-size: 12px !important;text-align:right;">{{ $factura['total'] }}</td>
                </tr>

            </tbody>
        </table>
    </div>

    <div class="invoice-detalle-iva">

        <table>
            <thead>
                <tr>
                    <th style="width:33%;text-align:left;">IVA</th>
                    <th style="width:33%;text-align:center;">Base imp.</th>
                    <th style="width:33%;text-align:right;">Cuota</th>
                </tr>
            </thead>

            <tbody>
                @foreach($iva as $key => $detalle)
                <tr>
                    <th style="width:33%;text-align:left;">{{ $key }}%</th>
                    <th style="width:33%;text-align:center;">{{ $detalle['total_sin_iva'] }}</th>
                    <th style="width:33%;text-align:right;">{{ $detalle['total_iva'] }}</th>
                </tr>
                @endforeach
                <tr>
                    <th style="width:33%;text-align:left;">Total</th>
                    <th style="width:33%;text-align:center;">{{ $factura['sub_total'] }}</th>
                    <th style="width:33%;text-align:right;">{{ $factura['iva'] }}</th>
                </tr>
            </tbody>
        </table>

    </div>

    <div class="footer">
        <p>gracias por su visita</p>
        <h5>www.panaderiaelchicharra.com/</h5>
    </div>

    <style>
        .footer {
            margin-top: 20px;
            margin-left: 3px;
            padding: 3px 5px 3px 3px;
            border-top: solid 1px #000;
            border-bottom: solid 1px #000;
            text-align: center;
        }

        .footer p {
            font-size: 9px;
            margin: 0 0 1px 0;
            padding: 0;
            text-align: center;
            text-transform: uppercase;
        }

        .footer h5 {
            font-size: 9px;
            margin: 0;
            padding: 0
        }

        @page {
            margin: 0;
        }

        .padding-row-top {
            margin-top: 5px;
        }

        * {
            padding: 0;
            margin: 0;
            font-weight: lighter;
        }

        body {
            padding-right: 5px;
            margin: 0;
        }

        .invoice-header {
            padding: 3px;
            text-align: center;
        }

        .invoice-body {
            padding: 3px 6px;
            text-align: left;
        }

        .invoice-body p {
            font-size: 9px !important;
        }

        .invoice-table-products {
            padding: 3px 6px;
            width: 100%
        }

        table {
            width: 100%;
            font-size: 9px !important;
            border-collapse: collapse;
        }

        .invoice-table-products table th,
        td {
            padding-left: 0;
        }

        .invoice-detalle-iva {
            width: 75%;
            padding: 3px 6px;
            margin-top: 12px;
        }

        .border {
            border-bottom: solid 1px #000;
        }

        .border-top {
            border-top: solid 1px #000;
        }

        .invoice-body {
            display: inline-block;
        }

        .invoice-body p {
            display: inline-block;
        }

    </style>
</body>

</html>
