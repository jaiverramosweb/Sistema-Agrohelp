<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pre aprobado</title>
    <style>
      .border {
        border: 1px solid black;
      }
      .text-xs {
        font-size: 9px;
      }
      .text-sm {
        font-size: 15px;
      }
      .text-md {
        font-size: 13px;
      }
      .text-bold {
         font-weight: bold;
      }
      .text-center {
         text-align: center;
      }
      .container {
         width: 100%;
         max-width: 700px;
         margin-right: auto;
         margin-left: auto;
         padding-right: 15px;
         padding-left: 15px;
      }
      .float-right {
        text-align: right;
      }
    </style>
</head>
<body>
    @php
        // echo $sol;

        function formatearMoneda($numero) {
            return "$" . number_format($numero, 0, ',', '.');
        }
    @endphp

    <div class="container">

        <div class="text-sm" style="margin-bottom: 70px;">
            Señores: <br>
            <span class="text-bold">HORTI ORGANIC SAS CI BIC</span> <br>
            <span class="text-bold" style="text-transform: uppercase">Atn: {{$sol->cliente->nombre}} {{$sol->cliente->apellido}} {{$sol->cliente->segundo_apellido}}</span> <br>
            Ciudad <br>
        </div>
    
        <div class="text-sm" style="text-align: justify; margin-bottom: 25px;">
            Nos complace informarle que AGRO HELP SAS, le ha pre-aprobado la siguiente operación, para financiar la compra de UN (1) 
            <span class="text-bold">TRACTOR AGRÍCOLA KUBOTA M9540 DTQ CABINADO CON CREEPER </span>
            que usted ha seleccionado para su negociación. Con los siguientes términos y condiciones.
        </div>
    
        <div style="margin-bottom: 25px;">
            <table style="border: 1px solid black; width: 100%;">
                <tr>
                    <td class="text-md text-bold text-center border" style="width: 35%">CONDICIONES ECONOMICAS</td>
                    <td class="text-md text-bold text-center border">ESCENARIO</td>
                </tr>
                <tr>
                    <td class="border">Valor del Activo</td>
                    <td class="border float-right">227.613.820.oo</td>
                </tr>
                <tr>
                    <td class="border">Canon Extraordinario</td>
                    <td class="border float-right">85.000.000.oo</td>
                </tr>
                <tr>
                    <td class="border">Valor a Financiar</td>
                    <td class="border float-right">{{formatearMoneda($sol->monto)}}</td>
                </tr>
                <tr>
                    <td class="border">Plazo de la Operación</td>
                    <td class="border float-right">{{$sol->tiempo}} meses</td>
                </tr>
                <tr>
                    <td class="border">Periodicidad de Pago</td>
                    <td class="border float-right">Pago de interés Mensual y abonos a Capital cada 6 Meses </td>
                </tr>
                <tr>
                    <td class="border">Tasa de Interés</td>
                    <td class="border float-right">{{$sol->tasa_interes}}%</td>
                </tr>
            </table>
        </div>
    
        <div class="text-sm" style="text-align: justify; margin-bottom: 50px">
            <span class="text-bold">Observaciones: </span>
    
            Garantías Personales: <span style="text-transform: uppercase">{{$sol->cliente->nombre}} {{$sol->cliente->apellido}} {{$sol->cliente->segundo_apellido}}</span>firma como Representante Legal Codeudor Principal Carta de Instrucciones, Pagare y Contrato de Mutuo. <br><br>
    
            Garantía Real: Prenda sin Tenencia a favor de Agro Help SAS del Tractor que se está comprando, Póliza Todo Riesgo, Obligatorio instalación de GPS y suministro de clave y usuario durante la vigencia de crédito.<br><br>
    
            La operación estará sujeta a la debida constitución de las garantías, una vez cumplidos los anteriores requisitos se procederá con el respectivo desembolso y autorización de orden de entrega. Vigencia 30 días.<br><br>
            
            Cordialmente:
        </div>
    
        <div class="text-sm">
            <span class="text-bold">CLAUDIA LILIANA ARIAS VIVI</span> <br>
            carias@agrohelpsas.com <br>
            Tel: 6016761314 Ext: 1412 – 3114476365 <br>
            Gerente Agro Help SAS
    
        </div>
    </div>

</body>
</html>