<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo de caja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<body>
    @php
        function formatearMoneda($numero) {
            $num = floatval($numero);
            return '$ ' . number_format($num, 2, '.', ',');
        }
    @endphp

    <div class="container">
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-6">
                        <img src="/assets/images/agrohelp.png" alt="lofo" style="width: 80%;">
                        <b>900406066-4</b>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <span class="float-right">
                    <b>Sucursal: PRINCIPAL</b>
                </span>                
            </div>

            <div class="col-12 mt-4">
                <div class="row">
                    <div class="col-12">
                        <b>RECIBO DE CAJA No. </b> <span class="float-right"><b>FECHA: {{$pagoAmor->fecha_pagar}}</b></span>
                        <br>
                        <div class="row">
                            <div class="col-3">
                                <b>RECIBIDO DE</b> <br>
                                <b>NIT o C.C</b> <br>
                                <b>VALOR PAGADO</b><br>
                                <b>METODO DE PAGO</b><br>
                                <b>TIPO DE PAGO</b><br>
                                @if ($pagoAmor->is_table == false)                                    
                                    <b>TIPO DE CRÉDITO</b>
                                @endif
                            </div>
                            <div class="col-9">
                                <span>{{ $pagoAmor->cliente->nombre }}</span><br>
                                <span>{{ $pagoAmor->cliente->documento }}</span><br>
                                <span>{{ formatearMoneda($pagoAmor->pago) }}</span><br>
                                <span>{{ $pagoAmor->metodo->name }}</span><br>
                                <span>{{ $pagoAmor->tipo }}</span><br>
                                @if ($pagoAmor->is_table == false)                                    
                                    <span>{{ $pagoAmor->tipo_credito->nombre }}</span>
                                @endif
                                
                            </div>
                        </div>
                        
                    </div>

                    @if ($pagoAmor->is_table == true)                        
                        <div class="col-12 mt-4">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>CUOTA</th>
                                        <th>CREDITO</th>
                                        <th>CAPITAL</th>
                                        <th>INTERES</th>
                                        <th>MORA</th>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($pagoAmor->pago_amortiz as $item)                                    
                                        <tr>
                                            <td>{{ $item->amortizacion->cuota_numero }}</td>
                                            <td>{{ $item->credito->nombre }}</td>
                                            <td>{{ formatearMoneda($item->amortizacion->amortizacion_pagado) }}</td>
                                            <td>{{ formatearMoneda($item->amortizacion->interes_pagado) }}</td>
                                            <td>{{ formatearMoneda($item->amortizacion->mora) }}</td>
                                            <td>{{ formatearMoneda($item->amortizacion->amortizacion_pagado + $item->amortizacion->interes_pagado + $item->amortizacion->mora) }}</td>
                                        </tr>
                                    @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td colspan="2">
                                                <b style="margin-left: 70px">TOTAL PAGADO: {{ formatearMoneda($pagoAmor->pago) }}</b> 
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        setTimeout(() => {
            window.print();
        }, 500);
    </script>
</body>
</html>