<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title></title>
</head>

<body>

    <div class="informacion-docente">
        <h3>{!! $cliente->nombre !!}</h3>
        <h3>{!! $cliente->dni !!}</h3>
        <h3>{!! nl2br(e($cliente->direccion)) !!}</h3>
    </div>

    <div class="factura-title">
        <h1>FACTURA</h1>
    </div>

    <div class="info-empresa">
        <div class="numero-fecha">
            <p>Nro. Factura: <span> <strong>{{ $factura->id }}</strong></span></p>
            <p>Fecha Factura: <span><strong>{!! Carbon\Carbon::parse($factura->created_at)->format('d/m/Y') !!}</strong></span></p>
        </div>
        <div class="empresa">
            <p>{!! nl2br(e($informacion->informacion_legal)) !!}</p>
        </div>
    </div>

    <div class="table-info">
        <table class="table">
            <thead>
                <tr>
                    <th>Concepto</th>
                    <th style="text-align:center;">Descuento</th>
                    <th style="text-align:center;">Precio</th>
                    <th style="text-align:right;">Total</th>
                </tr>
            </thead>

            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{$item['concepto']}}</td>
                    <td style="text-align:center;">{{$item['descuento']}}%</td>
                    <td style="text-align:center;">{{$item['base_imponible']}}€</td>
                    <td style="text-align:right;">{{$item['total']}}€</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="table-info">
        <table class="table">
            <tbody style="border-top:solid 1px gray;" class="table-no-margin">
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align:right;"> BASE IMPONIBLE </td>
                    <td style="text-align:right;"> {{$factura->precio}}€ </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align:right;"> I.V.A. 21% </td>
                    <td style="text-align:right;"> {{$factura->retencion}}€ </td>
                </tr>
                <tr>
                    <td></td>
                    <th></th>
                    <td style="text-align:right;"> <strong>Total a Pagar </strong> </td>
                    <td style="text-align:right;"> <strong>{{$factura->total}}€</strong> </td>
                </tr>
            </tbody>

        </table>

    </div>


</body>

<style media="screen">
    html {
        color: #637780;
    }

    h3 {
        text-transform: uppercase;
        margin: 2px 0;
        font-size: 16px;

    }

    .info-empresa {
        display: block;
    }

    .info-empresa div {
        display: inline-block;
        vertical-align: top;
    }

    .info-empresa .numero-fecha {
        width: 50%;
        padding-right: 40px;
    }

    .info-empresa .numero-fecha p span {
        float: right;
    }

    .factura-title h1 {
        width: 100%;
        text-align: center;
    }

    .legal-info {
        margin: 60px 0;
        color: #000000;
    }

    .table {
        width: 100%;
    }

    .table {
        border-collapse: collapse;
    }

    .table thead tr th {
        margin: 0;
        border: none;
        padding: 8px 0;
        border-top: solid 1px gray;
        border-bottom: solid 1px gray;
    }

    .table tbody tr td {
        padding: 8px 0;
    }

    .table-no-margin tr td {
        padding: 4px 0 !important;
    }
</style>

</html>