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
                <b>AGRO HELP S.A.S</b> <br>
                <b>900406066-4</b>
            </div>
            <div class="col-6">
                <span class="float-right">
                    <b>Sucursal: PRINCIPAL</b>
                </span>                
            </div>

            <div class="col-12 mt-2">
                <div class="row">
                    <div class="col-12">
                        <b>RECIBO DE CAJA No. </b> <span class="float-right"><b>FECHA: {{$pagoAmor->amortiz->fecha}}</b></span>
                        <br>
                        <div class="row">
                            <div class="col-2">
                                <b>RECIBIDO DE</b> <br>
                                <b>NIT o C.C</b> <br>
                                <b>VALOR</b><br>
                                <b>METODO DE PAGO</b>
                            </div>
                            <div class="col-10">
                                <span>{{ $pagoAmor->cliente->nombre }}</span><br>
                                <span>{{ $pagoAmor->cliente->documento }}</span><br>
                                <span>{{ formatearMoneda($pagoAmor->pago->pago) }}</span><br>
                                <span>{{ $pagoAmor->metodo->name }}</span>
                                
                            </div>
                        </div>
                        
                    </div>

                    <div class="col-12 mt-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>CUOTA</th>
                                    <th>CAPITAL</th>
                                    <th>INTERES</th>
                                    <th>MORA</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>{{ $pagoAmor->amortiz->cuota_numero }}</td>
                                    <td>{{ formatearMoneda($pagoAmor->amortiz->amortizacion_pagado) }}</td>
                                    <td>{{ formatearMoneda($pagoAmor->amortiz->interes_pagado) }}</td>
                                    <td>{{ formatearMoneda($pagoAmor->amortiz->mora) }}</td>
                                    <td>{{ formatearMoneda($pagoAmor->amortiz->amortizacion_pagado + $pagoAmor->amortiz->interes_pagado + $pagoAmor->amortiz->mora) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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