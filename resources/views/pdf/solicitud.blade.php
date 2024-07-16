<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>SOLICITUD DE CRÉDITO</title>

   <style>
      table {
         border: 1px solid black;
         border-radius: 10px;
         width:855px;
         margin-top: 10px;         
      }
      .border {
         border: 1px solid black;
      }
      .border-top {
         border-top: 1px solid black;
      }
      .border-right {
         border-right: 1px solid black;
      }
      .border-left {
         border-left: 1px solid black;
      }
      .border-bottom {
         border-bottom: 1px solid black;
      }
      .spacio {
         width: 30px;
      }
      .text-xs {
         font-size: 9px;
      }
      .text-sm {
         font-size: 11px;
      }
      .text-md {
         font-size: 13px;
      }
      .text-lg {
         font-size: 15px;         
      }
      .text-center {
         text-align: center;
      }
      .text-bold {
         font-weight: bold;
      }
      .bg-header {
         background-color: rgb(225, 217, 217);
         text-align: center;
         font-weight: bold;
      }
      .title-ref {
         writing-mode: vertical-rl;
         transform: rotate(180deg);
         padding: 5px;
         font-size: 12px;
         font-weight: bold;
      }
      .row {
         display: flex;
      }
      .col-3 {
         flex: 0 0 25%;
         max-width: 25%;
      }
      .col-6 {
         flex: 0 0 50%;
         max-width: 50%;
      }
      .col-9 {
         flex: 0 0 75%;
         max-width: 75%;
      }
      .container {
         width: 100%;
         max-width: 700px;
         margin-right: auto;
         margin-left: auto;
         padding-right: 15px;
         padding-left: 15px;
      }
      .card {
         border: 1px solid black;
         border-radius: 10px;
      }
      .page-break {
         page-break-before: always; /* Forces a page break before the element */
         page-break-after: avoid;   /* Avoids a page break after the element */
      }
   </style>
</head>
<body style="width: 855px;">

   @php
      $date = new DateTime($data->created_at);
      $day = $date->format('d');
      $month = $date->format('m');
      $year = $date->format('Y');
      // dd($data);
   @endphp

   <div class="row">
      <div class="col-3 text-center">
         <img src="/assets/images/agrohelp.png" width="150" alt="img agrohep"> <br>
         <span class="text-md">NIT. 900.406.066-4</span>
      </div>
      <div class="col-9">
         <h3 style="margin-left: 100px; margin-top: 25px;">SOLICITUD DE CRÉDITO</h3>
         <div class="row">
            <div class="col-6"></div>
            <div class="col-6">

               <table style="width: 320px; margin-top:-10px;">
                  <tr>
                     <td class="border-right text-md text-bold" style="width: 130px;">CIUDAD</td>
                     <td></td>
                     <td class="text-md text-bold text-center">DIA</td>
                     <td class="text-md text-bold text-center">MES</td>
                     <td class="text-md text-bold text-center">AÑO</td>
                  </tr>
                  <tr class="text-center">
                     <td class="border-right"></td>
                     <td class="border-right text-md text-bold">FECHA</td>
                     <td class="border-right">{{ $day }}</td>
                     <td class="border-right">{{ $month }}</td>
                     <td>{{ $year }}</td>
                  </tr>
               </table>

            </div>
         </div>
      </div>
   </div>
   {{--------------------------------      INICO        ---------------------------------}}
   <table style="padding: 3px">
      <tr>
         <td class="text-md">
            1. Formulario de solicitud de Crédito (Asegúrese de llenar toda la información solicitada y adjuntar los documentos exigidos)
         </td>

      </tr>
      <tr>
         <td class="text-md">
            2. Carta de Autorización y Pagaré. A). cuando sea persona jurídica debe firmar el representante legal como tal y como persona natural, asimilándose como
            Codeudor. B). Cuando sea persona natural firmará como tal y como codeudor otra persona natural o jurídica.
            <br><br>
         </td>
      </tr>
      <tr>
         <td class="text-md text-bold">
            NOTA: La documentación debe ser autenticada con huella biométrica, si no es firmada en las instalaciones de Agro Help SAS.
         </td>
      </tr>
   </table>

   {{-------------------------------- PERSONAS JURÍDICAS ---------------------------------}}
   <table>
      <tr style="text-align: center; font-weight: bold; background-color: rgb(225, 217, 217); border-radius: 10px;">
         <th colspan="22" class="border-bottom">PERSONAS JURÍDICAS</th>
      </tr>

      <tr>
         <td class="text-sm border-bottom border-right" colspan="10">
            Nombre o Razón Social:<br> 
            @if ($data->cliente->tipo_documento == 'NIT')
                {{ $data->cliente->nombre }}
            @else  
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom border-right" colspan="5">
            Nit.<br>
            @if ($data->cliente->tipo_documento == 'NIT')
                {{ $data->cliente->documento }}
            @else  
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom" colspan="7">
            Domicilio<br>
            @if (isset($data->domicilio) && $data->cliente->tipo_documento == 'NIT')
                {{ $data->domicilio }}
            @else  
               <br>
            @endif
         </td>
      </tr> 

      <tr>
         <td class="text-sm border-bottom border-right" colspan="13">
            Dirección Comercial:<br>
            @if (isset($data->direccion_comercial) && $data->cliente->tipo_documento == 'NIT')
                {{ $data->direccion_comercial }}
            @else  
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom border-right" colspan="4">
            Teléfono<br>
            @if (isset($data->telefono_comercial) && $data->cliente->tipo_documento == 'NIT')
                {{ $data->telefono_comercial }}
            @else  
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom" colspan="5">
            Fax<br>
            @if (isset($data->fax_comercial) && $data->cliente->tipo_documento == 'NIT')
                {{ $data->fax_comercial }}
            @else  
               <br>
            @endif
         </td>
      </tr> 

      <tr>
         <td class="text-sm border-bottom border-right" colspan="13">
            Dirección Judicial:<br>
            @if (isset($data->direccion_judicial) && $data->cliente->tipo_documento == 'NIT')
                {{ $data->direccion_judicial }}
            @else  
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom border-right" colspan="4">
            Teléfono<br>
            @if (isset($data->telefono_judicial) && $data->cliente->tipo_documento == 'NIT')
                {{ $data->telefono_judicial }}
            @else  
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom" colspan="5">
            Fax<br>
            @if (isset($data->fax_judicial) && $data->cliente->tipo_documento == 'NIT')
                {{ $data->fax_judicial }}
            @else  
               <br>
            @endif
         </td>
      </tr> 

      <tr>
         <td class="text-sm border-bottom border-right" colspan="11">
            Correo electrónico:<br>
            @if (isset($data->email) && $data->cliente->tipo_documento == 'NIT')
                {{ $data->email }}
            @else  
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom" colspan="11">
            Dirección<br>
            @if (isset($data->direccion_pers) && $data->cliente->tipo_documento == 'NIT')
                {{ $data->direccion_pers }}
            @else  
               <br>
            @endif
         </td>
      </tr> 

      <tr>
         <td class="text-sm border-bottom border-right" colspan="5">
            Teléfono<br>
            @if (isset($data->telefono) && $data->cliente->tipo_documento == 'NIT')
                {{ $data->telefono }}
            @else  
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom border-right"  colspan="4">
            Fax<br><br>
         </td>
         <td class="text-sm border-bottom border-right"  colspan="7">
            Representante Legal<br>
            @if (isset($data->representante) && $data->cliente->tipo_documento == 'NIT')
                {{ $data->representante }}
            @else  
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom" colspan="6">
            Cédula No.<br>
            @if (isset($data->representante_doc) && $data->cliente->tipo_documento == 'NIT')
                {{ $data->representante_doc }}
            @else  
               <br>
            @endif
         </td>
      </tr> 

      <tr>
         <td rowspan="2" class="border-right text-md" colspan="7">
            Tipo de Cliente <br>
            @if (isset($data->tipo_cliente) && $data->cliente->tipo_documento == 'NIT')
                {{ $data->tipo_cliente }}
            @endif
         </td>

         <td rowspan="2" colspan="2" class="text-sm">Que tipo de Declarante es? <br> (Marque las opciones que aplique) </td>
         <td rowspan="2" class="spacio border-right"></td>
         <td rowspan="2" class="text-xs">Empresa <br> Estatal</td>
         <td rowspan="2" class="spacio border-right text-center"> 
            @if ($data->tipo_declarante == 'Empresa Estatal')
                X
            @endif
         </td>

         <td rowspan="2" class="text-xs">Régimen <br> Común</td>
         <td rowspan="2"class="spacio border-right text-center">
            @if ($data->tipo_declarante == 'Régimen Común')
               X
            @endif
         </td>

         <td rowspan="2" class="text-xs">No Responsable<br> IVA</td>
         <td rowspan="2"class="spacio border-righ text-centert">
            @if ($data->tipo_declarante == 'No Responsable de IVA')
               X
            @endif
         </td>

         <td rowspan="2" class="text-xs">Gran <br> Contribuyente</td>
         <td rowspan="2" class="spacio border-right text-center">
            @if ($data->tipo_declarante == 'Gran Contribuyente')
               X
            @endif
         </td>
         <td colspan="4"  class="text-md">Autorretenedor</td>
      </tr>
      <tr>
         <td class="border-top text-md">SI </td>
         <td class="border-top spacio text-center">
            @if ($data->autorretenedor == 'Si')
               X
            @endif
         </td>
         <td class="border-top text-md">NO</td>
         <td class="border-top spacio text-center">
            @if ($data->autorretenedor == 'No')
               X
            @endif
         </td>
      </tr>

      <tr>
         <td rowspan="2" class="text-md text-bold text-center border-top border-right">
            PAGO <br> 
            EN
         </td>
         <td colspan="9" class="text-sm border-top border-bottom border-right">
            Persona que <br> autoriza los pagos &nbsp;&nbsp;
            @if (isset($data->persona_pago) && $data->cliente->tipo_documento == 'NIT')
                {{ $data->persona_pago }}
            @endif
         </td>
         <td colspan="12" class="text-sm border-top border-bottom">
            Dirección y ciudad donde <br> se realizarán los pagos
            @if (isset($data->direccion_pago) && $data->cliente->tipo_documento == 'NIT')
                {{ $data->direccion_pago }}
            @endif
         </td>
      </tr>
      <tr>
         <td class="text-sm" colspan="2">Teléfono <br>
            @if (isset($data->telefono_pago) && $data->cliente->tipo_documento == 'NIT')
                {{ $data->telefono_pago }}
            @else
               <br>
            @endif
         </td>
         <td style="width: 30px"></td>
         <td class="border-right" style="width: 30px"></td>
         <td class="text-sm" style="width: 60px">Dia de Pago <br>
            @if (isset($data->dia_pago) && $data->cliente->tipo_documento == 'NIT')
                {{ $data->dia_pago }}
            @else
               <br>
            @endif
         </td>
         <td style="width: 30px border-right"></td>
         <td class="border-right" style="width: 30px"></td>
         <td colspan="2" class="border-right text-sm">Horario de Pago <br>
            @if (isset($data->hora_pago) && $data->cliente->tipo_documento == 'NIT')
                {{ $data->hora_pago }}
            @else
               <br>
            @endif
         </td>
         
         <td colspan="12" class="text-sm">Comentario Adicional <br>
            @if (isset($data->comentatio_pago) && $data->cliente->tipo_documento == 'NIT')
               {{ $data->comentatio_pago }}
            @else
               <br>
            @endif
         </td>
      </tr>

   </table>

   {{-------------------------------- PERSONAS NATURALES ---------------------------------}}
   <table>
      <tr style="text-align: center; font-weight: bold; background-color: rgb(225, 217, 217); border-radius: 10px;">
         <th colspan="22" class="border-bottom">PERSONAS NATURALES</th>
      </tr>

      <tr>
         <td class="text-sm border-bottom border-right" colspan="10">
            Nombres y Apellidos:<br>
            @if (isset($data->cliente->nombre) && $data->cliente->tipo_documento == 'CC')
               {{ $data->cliente->nombre }}
            @else
               <br>
            @endif
            
         </td>
         <td class="text-sm border-bottom border-right" colspan="5">
            Cédula No.<br>
            @if (isset($data->cliente->documento) && $data->cliente->tipo_documento == 'CC')
               {{ $data->cliente->documento }}
            @else
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom border-right" colspan="2">
            Edad<br>
            @if (isset($data->edad) && $data->cliente->tipo_documento == 'CC')
               {{ $data->edad }}
            @else
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom" colspan="5">
            Estado Civil<br>
            @if (isset($data->estado_civil) && $data->cliente->tipo_documento == 'CC')
               {{ $data->estado_civil }}
            @else
               <br>
            @endif
         </td>
      </tr> 

      <tr>
         <td class="text-sm border-bottom border-right" colspan="10">
            Dirección de Residencia:<br>
            @if (isset($data->direccion_recidencia) && $data->cliente->tipo_documento == 'CC')
               {{ $data->direccion_recidencia }}
            @else
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom border-right" colspan="5">
            Teléfono<br>
            @if (isset($data->telefono_recidencia) && $data->cliente->tipo_documento == 'CC')
               {{ $data->telefono_recidencia }}
            @else
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom" colspan="7">
            Cuidad y Dept.<br>
            @if (isset($data->ciudad_recidencia) && $data->cliente->tipo_documento == 'CC')
               {{ $data->ciudad_recidencia }}
            @else
               <br>
            @endif
         </td>
      </tr> 

      <tr>
         <td class="text-sm border-bottom border-right" colspan="13">
            Correo electrónico::<br>
            @if (isset($data->email) && $data->cliente->tipo_documento == 'CC')
               {{ $data->email }}
            @else
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom border-right" colspan="4">
            Teléfono<br>
            @if (isset($data->telefono) && $data->cliente->tipo_documento == 'CC')
               {{ $data->telefono }}
            @else
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom" colspan="5">
            Fax<br><br>
         </td>
      </tr> 

      <tr>
         <td class="text-sm border-bottom border-right" colspan="6">
            Profesión:<br>
            @if (isset($data->profesion) && $data->cliente->tipo_documento == 'CC')
               {{ $data->profesion }}
            @else
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom border-right" colspan="6">
            Empresa donde trabaja<br>
            @if (isset($data->empresa) && $data->cliente->tipo_documento == 'CC')
               {{ $data->empresa }}
            @else
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom border-right" colspan="7">
            Dirección y Ciudad<br>
            @if (isset($data->empresa_direccion) && $data->cliente->tipo_documento == 'CC')
               {{ $data->empresa_direccion }}
            @else
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom" colspan="3">
            Tel.<br>
            @if (isset($data->empresa_telefono) && $data->cliente->tipo_documento == 'CC')
               {{ $data->empresa_telefono }}
            @else
               <br>
            @endif
         </td>
      </tr> 

      <tr>
         <td class="text-sm border-bottom border-right" colspan="5">
            Cargo Actual<br>
            @if (isset($data->cargo_actual) && $data->cliente->tipo_documento == 'CC')
               {{ $data->cargo_actual }}
            @else
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom border-right espacio"  colspan="5">
            Antigüedad de la Empresa<br>
            @if (isset($data->antoguedad_empresa) && $data->cliente->tipo_documento == 'CC')
               {{ $data->antoguedad_empresa }}
            @else
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom border-right espacio"  colspan="5">
            No. Personas a Cargo<br>
            @if (isset($data->personas_cargo) && $data->cliente->tipo_documento == 'CC')
               {{ $data->personas_cargo }}
            @else
               <br>
            @endif
         </td>
         <td class="text-sm border-bottom" colspan="5">
            Vivienda<br>
            @if (isset($data->vivienda) && $data->cliente->tipo_documento == 'CC')
               {{ $data->vivienda }}
            @else
               <br>
            @endif
         </td>
      </tr> 

      <tr>
         <td class="text-md">Es independiente?</td>
         <td class="spacio text-center">
            @if ($data->independiente == 'Si' && $data->cliente->tipo_documento == 'CC')
               X
            @endif
         </td>
         <td class="text-md">SI </td>
         <td class="spacio text-center">
            @if ($data->independiente == 'No' && $data->cliente->tipo_documento == 'CC')
               X
            @endif
         </td>
         <td class="border-right text-md">NO</td>

         <td class="text-sm">Tiene Negocio <br>Registrado en Cámara?</td>
         <td class=" spacio text-center">
            @if ($data->camara_comercio == 'Si' && $data->cliente->tipo_documento == 'CC')
               X
            @endif
         </td>
         <td class=" text-md">SI </td>
         <td class=" spacio text-center">
            @if ($data->camara_comercio == 'No' && $data->cliente->tipo_documento == 'CC')
               X
            @endif
         </td>
         <td class="border-right text-md">NO</td>

         <td class="text-sm">
            Nombre del Negocio Registrado
            @if (isset($data->nombre_negocio) && $data->cliente->tipo_documento == 'CC')
               {{ $data->nombre_negocio }}
            @else
               <br>
            @endif
         </td>
         <td class="text-sm" colspan="11"> &nbsp;</td>

      </tr>

      <tr>
         <td class="text-md border-top border-right" colspan=10">
            Nombre del Cónyuge<br>
            @if (isset($data->nombre_conyuge) && $data->cliente->tipo_documento == 'CC')
               {{ $data->nombre_conyuge }}
            @else
               <br>
            @endif 
         </td>
         <td class="text-md border-top border-right" colspan="6">
            Ocupación<br>
            @if (isset($data->ocupacion_conyuge) && $data->cliente->tipo_documento == 'CC')
               {{ $data->ocupacion_conyuge }}
            @else
               <br>
            @endif 
         </td>
         <td class="text-md border-top" colspan="5">
            Empresa<br>
            @if (isset($data->empresa_conyuge) && $data->cliente->tipo_documento == 'CC')
               {{ $data->empresa_conyuge }}
            @else
               <br>
            @endif 
         </td>
      </tr>

      <tr>
         <td class="text-md border-top text-center border-right text-bold">PAGO <br> 
            EN</td>
         <td class="text-md border-top border-right" colspan="15">
            Dirección y ciudad donde se realizarán los pagos <br>
            @if (isset($data->direccion_pago) && $data->cliente->tipo_documento == 'CC')
               {{ $data->direccion_pago }}
            @else
               <br>
            @endif 
         </td>
         <td class="text-md border-top " colspan="5">
            Teléfono <br>
            @if (isset($data->telefono_pago) && $data->cliente->tipo_documento == 'CC')
               {{ $data->telefono_pago }}
            @else
               <br>
            @endif 
         </td>
      </tr>


   </table>

   {{--------------------------------     REFERENCIAS     ---------------------------------}}
   <table>
      <tr style="text-align: center; font-weight: bold; background-color: rgb(225, 217, 217); border-radius: 10px;">
         <th colspan="4" class="border-bottom">REFERENCIAS</th>
      </tr>

      <tr>
         <td rowspan="3" class="border-bottom" style="width: 20px;">
            <span class="title-ref">BANCARIA</h4>
         </td>
         <td class="bg-header border">BANCO</td>
         <td class="bg-header border">SUCURSAL</td>
         <td class="bg-header border">Cta. Cte. No.</td>
      </tr>
      <tr>
         <td class="border text-center text-sm">
            @if (isset($data->referencias->banco))
               {{ $data->referencias->banco }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-center text-sm">
            @if (isset($data->referencias->sucursal))
               {{ $data->referencias->sucursal }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-center text-sm">
            @if (isset($data->referencias->banco_numero))
               {{ $data->referencias->banco_numero }}
            @else
               &nbsp;
            @endif 
         </td>
      </tr>
      <tr>
         <td class="border text-center text-sm">
            @if (isset($data->referencias->banco_dos))
               {{ $data->referencias->banco_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-center text-sm">
            @if (isset($data->referencias->sucursal_dos))
               {{ $data->referencias->sucursal_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-center text-sm">
            @if (isset($data->referencias->banco_numero_dos))
               {{ $data->referencias->banco_numero_dos }}
            @else
               &nbsp;
            @endif 
         </td>
      </tr>

      <tr>
         <td rowspan="3" class="border-bottom" style="width: 20px;">
            <span class="title-ref">COMERCIAL</h4>
         </td>
         <td class="bg-header border">NOMBRE</td>
         <td class="bg-header border">DIRECCION Y CIUDAD</td>
         <td class="bg-header border">TELÉFONO</td>
      </tr>
      <tr>
         <td class="border text-center text-sm">
            @if (isset($data->referencias->nombre_comercal))
               {{ $data->referencias->nombre_comercal }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-center text-sm">
            @if (isset($data->referencias->direccion_comercal))
               {{ $data->referencias->direccion_comercal }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-center text-sm">
            @if (isset($data->referencias->telefono_comercal))
               {{ $data->referencias->telefono_comercal }}
            @else
               &nbsp;
            @endif 
         </td>
      </tr>
      <tr>
         <td class="border text-center text-sm">
            @if (isset($data->referencias->nombre_comercal_dos))
               {{ $data->referencias->nombre_comercal_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-center text-sm">
            @if (isset($data->referencias->direccion_comercal_dos))
               {{ $data->referencias->direccion_comercal_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-center text-sm">
            @if (isset($data->referencias->telefono_comercal_dos))
               {{ $data->referencias->telefono_comercal_dos }}
            @else
               &nbsp;
            @endif 
         </td>
      </tr>

      <tr>
         <td rowspan="3" class="" style="width: 20px;">
            <span class="title-ref">FAMILIAR</h4>
         </td>
         <td class="border text-center text-sm">
            @if (isset($data->referencias->nombre_familiar))
               {{ $data->referencias->nombre_familiar }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-center text-sm">
            @if (isset($data->referencias->direccion_familiar))
               {{ $data->referencias->direccion_familiar }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-center text-sm">
            @if (isset($data->referencias->telefono_familiar))
               {{ $data->referencias->telefono_familiar }}
            @else
               &nbsp;
            @endif 
         </td>
      </tr>
      <tr>
         <td class="border text-center text-sm">
            @if (isset($data->referencias->nombre_familiar_dos))
               {{ $data->referencias->nombre_familiar_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-center text-sm">
            @if (isset($data->referencias->direccion_familiar_dos))
               {{ $data->referencias->direccion_familiar_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-center text-sm">
            @if (isset($data->referencias->telefono_familiar_dos))
               {{ $data->referencias->telefono_familiar_dos }}
            @else
               &nbsp;
            @endif 
         </td>
      </tr>

   </table>

   <div class="page-break"></div>

   {{--------------------------------  LINEA DE CRÉDITO   ---------------------------------}}
   <table style="margin-top: 40px;">
      <tr style="text-align: center; font-weight: bold; background-color: rgb(225, 217, 217); border-radius: 10px;">
         <th colspan="4" class="border-bottom">LINEA DE CRÉDITO</th>
      </tr>
      <tr>
         <td class="text-sm text-bold text-center border-right border-bottom" style="width: 100px">
            ROTATORIO
            @if ($data->linea->tipo_credito == 'Rotativo')
               &nbsp;(X)
            @endif 
         </td>
         <td class="text-sm text-bold text-center border-right border-bottom" style="width: 100px">
            CUPO
            @if ($data->linea->tipo_credito == 'Cupo')
               &nbsp;(X)
            @endif 
         </td>
         <td class="text-sm border-right border-bottom">
            Oficina <br>
            @if (isset($data->linea->oficina_credito))
               {{ $data->linea->oficina_credito }}
            @else
               <br>
            @endif 
         </td>
         <td class="text-sm border-bottom">
            Vendedor <br>
            @if (isset($data->linea->vendedor_credito))
               {{ $data->linea->vendedor_credito }}
            @else
               <br>
            @endif 
         </td>
      </tr>

      <tr>
         <td class="text-sm text-bold text-center border-right" style="width: 100px">
            ADQUISICIÓN
            @if ($data->linea->tipo_credito == 'Adquisición')
               &nbsp;(X)
            @endif 
         </td>
         <td class="text-sm text-bold text-center border-right" style="width: 100px">
            MAQUINARIA
            @if ($data->linea->tipo_credito == 'Maquinaria')
               &nbsp;(X)
            @endif 
         </td>
         <td class="text-sm border-right">
            Monto Solicitado <br>
            @if (isset($data->linea->monto_solicitado_credito))
               {{ $data->linea->monto_solicitado_credito }}
            @else
               <br>
            @endif 
         </td>
         <td class="text-sm">
            Forma de Pago <br>
            @if (isset($data->linea->forma_pago_credito))
               {{ $data->linea->forma_pago_credito }}
            @else
               <br>
            @endif 
         </td>
      </tr>
   </table>

   {{--------------------------------   LINEA DE CRÉDITO  ---------------------------------}}
   <table>
      <tr style="text-align: center; font-weight: bold; background-color: rgb(225, 217, 217); border-radius: 10px;">
         <th class="border-bottom">PERSONAS JURÍDICAS</th>
      </tr>
      <tr>
         <td style="text-align: justify;" class="text-sm">            
            Autorizo con carácter permanente y de manera irrevocable a <span class="text-bold">AGRO HELP S.A.S.</span>  para obtener, consultar y reportar en las centrales de información de la asociación Bancaria de Colombia, Datacredito, Cifin y/o de cualquier fuente y base de datos, la información y referencia relativas a mi documento de identificación, comportamiento crediticio, a mi comportamiento comercial y al producto de toda clase de operaciones que efectúe o haya efectuado con entidades del sector financiero y otros sectores. y que en general sirva de referencia para determinar hasta que <span class="text-bold">AGRO HELP S.A.S.</span> o las centrales de información lo consideren necesario.                        
         </td>
      </tr>
   </table>

   {{--------------------------------       PATRIMONIO     ---------------------------------}}
   <table> 
      <tr style="text-align: center; font-weight: bold; background-color: rgb(225, 217, 217); border-radius: 10px;">
         <th colspan="14" class="border-bottom">PATRIMONIO</th>
      </tr>
      
      <tr>
         <td rowspan="5" class="border-bottom" style="background-color:rgb(225, 217, 217);">
            <span class="title-ref">BIENES INMUEBLES</span>            
         </td>
         <td rowspan="2" class="bg-header text-sm border">
            DESCRIPCIÓN
         </td>
         <td rowspan="2" class="bg-header text-sm border">
            CIUDAD
         </td>
         <td colspan="2" class="bg-header text-sm border">
            HIPOTECA
         </td>
         <td colspan="2" class="bg-header text-sm border">
            AVALUO
         </td>
         <td rowspan="2" class="bg-header text-sm border">
            CÉDULA CATASTRAL No.
         </td>
         <td rowspan="2" class="bg-header text-sm border">
            MATRICULA INMOBILIARIA No.
         </td>
         <td rowspan="2" class="bg-header text-sm border">
            ESCRITURA PÚBLICA No.
         </td>
         <td rowspan="2" class="bg-header text-sm border">
            NOTARIA
         </td>
         <td rowspan="2" class="bg-header text-sm border">
            FECHA
         </td>
         <td rowspan="2" colspan="2" class="bg-header text-sm border">
            CIUDAD
         </td>
      </tr>
      <tr>
         <td class="bg-header text-xs border">
            SI
         </td>
         <td class="bg-header text-xs border">
            NO
         </td>
         <td class="bg-header text-xs border">
            COMERCIAL
         </td>
         <td class="bg-header text-xs border">
            CATASTRAL
         </td>
      </tr>

      <tr>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->descripcion_bien))
               {{ $data->parimonio->descripcion_bien }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->ciudad_bien))
               {{ $data->parimonio->ciudad_bien }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if ($data->parimonio->hipoteca_bien == 'Si')
               X
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if ($data->parimonio->hipoteca_bien == 'No')
               X
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->avaluo_comercial_bien))
               {{ $data->parimonio->avaluo_comercial_bien }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->avaluo_catastral_bien))
               {{ $data->parimonio->avaluo_catastral_bien }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->cedula_catastral_bien))
               {{ $data->parimonio->cedula_catastral_bien }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->matricula_bien))
               {{ $data->parimonio->matricula_bien }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->escritura_bien))
               {{ $data->parimonio->escritura_bien }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->notaria_bien))
               {{ $data->parimonio->notaria_bien }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->fecha_bien))
               {{ $data->parimonio->fecha_bien }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center" colspan="2">
            @if (isset($data->parimonio->ciudad_parimonio_bien))
               {{ $data->parimonio->ciudad_parimonio_bien }}
            @else
               &nbsp;
            @endif 
         </td>
      </tr>

      <tr>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->descripcion_bien_dos))
               {{ $data->parimonio->descripcion_bien_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->ciudad_bien_dos))
               {{ $data->parimonio->ciudad_bien_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if ($data->parimonio->hipoteca_bien_dos == 'Si')
               X
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if ($data->parimonio->hipoteca_bien_dos == 'No')
               X
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->avaluo_comercial_bien_dos))
               {{ $data->parimonio->avaluo_comercial_bien_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->avaluo_catastral_bien_dos))
               {{ $data->parimonio->avaluo_catastral_bien_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->cedula_catastral_bien_dos))
               {{ $data->parimonio->cedula_catastral_bien_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->matricula_bien_dos))
               {{ $data->parimonio->matricula_bien_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->escritura_bien_dos))
               {{ $data->parimonio->escritura_bien_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->notaria_bien_dos))
               {{ $data->parimonio->notaria_bien_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->fecha_bien_dos))
               {{ $data->parimonio->fecha_bien_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center" colspan="2">
            @if (isset($data->parimonio->ciudad_parimonio_bien_dos))
               {{ $data->parimonio->ciudad_parimonio_bien_dos }}
            @else
               &nbsp;
            @endif 
         </td>
      </tr>

      <tr>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->descripcion_bien_tres))
               {{ $data->parimonio->descripcion_bien_tres }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->ciudad_bien_tres))
               {{ $data->parimonio->ciudad_bien_tres }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if ($data->parimonio->hipoteca_bien_tres == 'Si')
               X
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if ($data->parimonio->hipoteca_bien_tres == 'No')
               X
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->avaluo_comercial_bien_tres))
               {{ $data->parimonio->avaluo_comercial_bien_tres }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->avaluo_catastral_bien_tres))
               {{ $data->parimonio->avaluo_catastral_bien_tres }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->cedula_catastral_bien_tres))
               {{ $data->parimonio->cedula_catastral_bien_tres }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->matricula_bien_tres))
               {{ $data->parimonio->matricula_bien_tres }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->escritura_bien_tres))
               {{ $data->parimonio->escritura_bien_tres }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->notaria_bien_tres))
               {{ $data->parimonio->notaria_bien_tres }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->fecha_bien_tres))
               {{ $data->parimonio->fecha_bien_tres }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center" colspan="2">
            @if (isset($data->parimonio->ciudad_parimonio_bien_tres))
               {{ $data->parimonio->ciudad_parimonio_bien_tres }}
            @else
               &nbsp;
            @endif 
         </td>
      </tr>

      <tr>
         <td rowspan="4" style="background-color:rgb(225, 217, 217);">
            <span class="title-ref">VEHICULOS</span>            
         </td>
         <td rowspan="2" colspan="4" class="bg-header text-sm border">
            MARCA
         </td>
         <td rowspan="2" colspan="2" class="bg-header text-sm border">
            CLASE
         </td>
         <td rowspan="2" class="bg-header text-sm border">
            MODELO
         </td>
         <td rowspan="2" colspan="2" class="bg-header text-sm border">
            PLACA
         </td>
         <td rowspan="2" class="bg-header text-sm border">
            VR.COMERCIAL
         </td>
         <td colspan="2" class="bg-header text-sm border">
            VR.PIGNORADO
         </td>
      </tr>
      <tr>
         <td class="bg-header text-xs border">
            SI
         </td>
         <td class="bg-header text-xs border">
            NO
         </td>
      </tr>

      <tr>
         <td class="border text-sm text-center" colspan="4">
            @if (isset($data->parimonio->marca_vehiculo))
               {{ $data->parimonio->marca_vehiculo }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center" colspan="2">
            @if (isset($data->parimonio->clase_vehiculo))
               {{ $data->parimonio->clase_vehiculo }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->modelo_vehiculo))
               {{ $data->parimonio->modelo_vehiculo }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center" colspan="2">
            @if (isset($data->parimonio->placa_vehiculo))
               {{ $data->parimonio->placa_vehiculo }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->valor_vehiculo))
               {{ $data->parimonio->valor_vehiculo }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if ($data->parimonio->hipoteca_vehiculo == 'Si')
               X
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if ($data->parimonio->hipoteca_vehiculo == 'No')
               X
            @else
               &nbsp;
            @endif 
         </td>
      </tr>
      <tr>
         <td class="border text-sm text-center" colspan="4">
            @if (isset($data->parimonio->marca_vehiculo_dos))
               {{ $data->parimonio->marca_vehiculo_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center" colspan="2">
            @if (isset($data->parimonio->clase_vehiculo_dos))
               {{ $data->parimonio->clase_vehiculo_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->modelo_vehiculo_dos))
               {{ $data->parimonio->modelo_vehiculo_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center" colspan="2">
            @if (isset($data->parimonio->placa_vehiculo_dos))
               {{ $data->parimonio->placa_vehiculo_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if (isset($data->parimonio->valor_vehiculo_dos))
               {{ $data->parimonio->valor_vehiculo_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if ($data->parimonio->hipoteca_vehiculo_dos == 'Si')
               X
            @else
               &nbsp;
            @endif 
         </td>
         <td class="border text-sm text-center">
            @if ($data->parimonio->hipoteca_vehiculo_dos == 'No')
               X
            @else
               &nbsp;
            @endif 
         </td>
      </tr>
   </table>

   <span class="text-sm text-bold" style="margin-buttom: -2px;">ANEXOS La información solicitada a continuación debe ser diligenciada para solicitudes de crédito personales (personas naturales)</span>

   {{--------------------------------          ANEXOS       ---------------------------------}}
   @php
      function formatearMoneda($numero) {
         return "$" . number_format($numero, 0, ',', '.');
      }
   @endphp
   <table>
      <tr>
         <td rowspan="4" class="border-right border-bottom" style="background-color:rgb(225, 217, 217); width:20px;">
            <span class="title-ref">ANEXO 1</span>            
         </td>
         <td rowspan="4" class="border-right border-bottom" style="background-color:rgb(225, 217, 217); width:20px;">
            <span class="title-ref">INGRESO</span>            
         </td>
         <td class="text-sm border-right border-bottom">
            SUELDO
         </td>
         <td class="text-sm border-bottom" style="width:150px;">
            @if (isset($data->ingreso->salario))
               {{ $data->ingreso->salario }}
            @else
               $0
            @endif 
         </td>
      </tr>
      <tr>
         <td class="text-sm border-right border-bottom">
            HONORARIOS PROMEDIO
         </td>
         <td class="text-sm border-bottom">
            @if (isset($data->ingreso->honorarios))
               {{ $data->ingreso->honorarios }}
            @else
               $0
            @endif 
         </td>
      </tr>
      <tr>
         <td class="text-sm border-right border-bottom">
            OTROS INGRESOS (INDIQUE FUENTES:                      
            @if (isset($data->ingreso->otros_ingresos_describe))
               {{ $data->ingreso->otros_ingresos_describe }} )
            @else
               )
            @endif             
            
         </td>
         <td class="text-sm border-bottom">
            @if (isset($data->ingreso->otros_ingresos))
               {{ $data->ingreso->otros_ingresos }}
            @else
               $0
            @endif 
         </td>
      </tr>
      <tr>
         <td class="text-sm border-right border-bottom" style="text-align: right">
            TOTAL &nbsp;&nbsp;
         </td>
         <td class="text-sm border-bottom">
            @if (isset($data->ingreso->total_ingresos))
               {{ $data->ingreso->total_ingresos }}
            @else
               $0
            @endif 
         </td>
      </tr>

      <tr>
         <td rowspan="6" class="border-right" style="background-color:rgb(225, 217, 217); width:20px;">
            <span class="title-ref">ANEXO 2</span>            
         </td>
         <td rowspan="6" class="border-right" style="background-color:rgb(225, 217, 217); width:20px;">
            <span class="title-ref">EGRESOS</span>            
         </td>
         <td class="text-sm border-right border-bottom">
            ALQUILER
         </td>
         <td class="text-sm border-bottom" style="width:150px;">
            @if (isset($data->ingreso->alquiler))
               {{ $data->ingreso->alquiler }}
            @else
               $0
            @endif 
         </td>
      </tr>
      <tr>
         <td class="text-sm border-right border-bottom">
            AMORTIZACIÓN CRÉDITOS VIGENTES*
         </td>
         <td class="text-sm border-bottom">
            @if (isset($data->ingreso->amortizacion))
               {{ $data->ingreso->amortizacion }}
            @else
               $0
            @endif 
         </td>
      </tr>
      <tr>
         <td class="text-sm border-right border-bottom">
            AMORTIZACIÓN HIPOTECA
         </td>
         <td class="text-sm border-bottom">
            @if (isset($data->ingreso->amortizacion_hipoteca))
               {{ $data->ingreso->amortizacion_hipoteca }}
            @else
               $0
            @endif 
         </td>
      </tr>
      <tr>
         <td class="text-sm border-right border-bottom">
            PAGO MENSUAL TARJETAS DE CRÉDITO**
         </td>
         <td class="text-sm border-bottom">
            @if (isset($data->ingreso->pago_tarjetas))
               {{ $data->ingreso->pago_tarjetas }}
            @else
               $0
            @endif 
         </td>
      </tr>
      <tr>
         <td class="text-sm border-right border-bottom">
            OTROS GASTOS FAMILIARES (EDUCACIÓN, ALIMENTACIÓN, OTROS)
         </td>
         <td class="text-sm border-bottom">
            @if (isset($data->ingreso->otros_gastos))
               {{ $data->ingreso->otros_gastos }}
            @else
               $0
            @endif 
         </td>
      </tr>
      <tr>
         <td class="text-sm border-right" style="text-align: right">
            TOTAL EGRESOS &nbsp;&nbsp;
         </td>
         <td class="text-sm">
            @if (isset($data->ingreso->total_egresos))
               {{ $data->ingreso->total_egresos }}
            @else
               $0
            @endif 
         </td>
      </tr>

   </table>

   <span class="text-sm text-bold" style="margin-buttom: -2px;">*En caso de tener prestamos vigentes favor llenar ANEXO 3 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; **En caso de tener tarjetas de crédito favor llenar ANEXO 4</span>

   <table>
      <tr>
         <td rowspan="3" class="border-right border-bottom" style="background-color:rgb(225, 217, 217); width:20px;">
            <span class="title-ref">ANEXO 3</span>            
         </td>
         <td rowspan="3" class="border-right border-bottom" style="background-color:rgb(225, 217, 217); width:20px;">
            <span class="title-ref">CRÉDITO <br> VIGENTE</span>            
         </td>
         <td class="text-sm border-right border-bottom bg-header">
            ACREEDOR
         </td>
         <td class="text-sm border-bottom bg-header border-right" style="width:150px;">
            TELEFONO
         </td>
         <td class="text-sm border-bottom bg-header border-right" style="width:150px;">
            VALOR PRESTAMO
         </td>
         <td class="text-sm border-bottom bg-header" style="width:150px;">
            SALDO
         </td>
      </tr>
      <tr>
         <td class="text-sm text-center border-right border-bottom">
            @if (isset($data->creditos->acreedor))
               {{ $data->creditos->acreedor }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="text-sm text-center border-bottom border-right" style="width:150px;">
            @if (isset($data->creditos->acreedor_telefono))
               {{ $data->creditos->acreedor_telefono }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="text-sm text-center border-bottom border-right" style="width:150px;">
            @if (isset($data->creditos->acreedor_valor))
               {{ $data->creditos->acreedor_valor }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="text-sm text-center border-bottom" style="width:150px;">
            @if (isset($data->creditos->acreedor_saldo))
               {{ $data->creditos->acreedor_saldo }}
            @else
               &nbsp;
            @endif 
         </td>
      </tr>
      <tr>
         <td class="text-sm text-center border-right border-bottom">
            @if (isset($data->creditos->acreedor_dos))
               {{ $data->creditos->acreedor_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="text-sm text-center border-bottom border-right" style="width:150px;">
            @if (isset($data->creditos->acreedor_telefono_dos))
               {{ $data->creditos->acreedor_telefono_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="text-sm text-center border-bottom border-right" style="width:150px;">
            @if (isset($data->creditos->acreedor_valor_dos))
               {{ $data->creditos->acreedor_valor_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="text-sm text-center border-bottom" style="width:150px;">
            @if (isset($data->creditos->acreedor_saldo_dos))
               {{ $data->creditos->acreedor_saldo_dos }}
            @else
               &nbsp;
            @endif 
         </td>
      </tr>

      <tr>
         <td rowspan="3" class="border-right" style="background-color:rgb(225, 217, 217); width:20px;">
            <span class="title-ref">ANEXO 4</span>            
         </td>
         <td rowspan="3" class="border-right" style="background-color:rgb(225, 217, 217); width:20px;">
            <span class="title-ref">TARJETA DE <br> CRÉDITO</span>            
         </td>
         <td class="text-sm border-right border-bottom bg-header">
            NOMBRE - BANCO
         </td>
         <td class="text-sm border-bottom bg-header border-right" style="width:150px;">
            ANTIGUEDAD
         </td>
         <td class="text-sm border-bottom bg-header border-right" style="width:150px;">
            NÚMERO
         </td>
         <td class="text-sm border-bottom bg-header" style="width:150px;">
            CUPO MÁXIMO
         </td>
      </tr>
      <tr>
         <td class="text-sm text-center border-right">
            @if (isset($data->creditos->banco_tarjeta))
               {{ $data->creditos->banco_tarjeta }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="text-sm text-center border-right" style="width:150px;">
            @if (isset($data->creditos->banco_antoguedad))
               {{ $data->creditos->banco_antoguedad }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="text-sm text-center border-right" style="width:150px;">
            @if (isset($data->creditos->banco_numero_antoguedad))
               {{ $data->creditos->banco_numero_antoguedad }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="text-sm text-center" style="width:150px;">
            @if (isset($data->creditos->banco_cupo))
               {{ $data->creditos->banco_cupo }}
            @else
               &nbsp;
            @endif 
         </td>
      </tr>
      <tr>
         <td class="text-sm text-center border-right">
            @if (isset($data->creditos->banco_tarjeta_dos))
               {{ $data->creditos->banco_tarjeta_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="text-sm text-center border-right" style="width:150px;">
            @if (isset($data->creditos->banco_antoguedad_dos))
               {{ $data->creditos->banco_antoguedad_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="text-sm text-center border-right" style="width:150px;">
            @if (isset($data->creditos->banco_numero_antoguedad_dos))
               {{ $data->creditos->banco_numero_antoguedad_dos }}
            @else
               &nbsp;
            @endif 
         </td>
         <td class="text-sm text-center" style="width:150px;">
            @if (isset($data->creditos->banco_cupo_dos))
               {{ $data->creditos->banco_cupo_dos }}
            @else
               &nbsp;
            @endif 
         </td>
      </tr>
   </table>

   <div class="row" style="margin-top: 100px;">
      <div class="col-6">
         _______________________________________________ <br>
         NOMBRE DEL SOLICITANTE <br> 
         {{ $data->cliente->nombre }}
      </div>

      <div class="col-6">
         _______________________________________________ <br>
         <span>FIRMA Y SELLO DEL SOLICITANTE</span><br>
         <span>CC. / NIT. No. {{ $data->cliente->documento }}</span>
         
      </div>
   </div>


   {{------------------------------- DOCUMENTACIÓN  REQUERIDA -----------------------------}}

   <table style="margin-top: 100px;">
      <tr>
         <td rowspan="2" class="text-sm border-right border-bottom bg-header">
            DOCUMENTACIÓN REQUERIDA PARA EL ESTUDIO DEL CRÉDITO
         </td>
         <td colspan="2" class="text-sm border-right border-bottom bg-header">
            PERSONA NATURAL
         </td>
         <td rowspan="2" class="text-sm border-bottom bg-header">
            PERSONA JURIDICA
         </td>
      </tr>
      <tr>
         <td class="bg-header text-sm border-bottom border-right">EMPLEADO</td>
         <td class="bg-header text-sm border-bottom border-right">INDEPENDIENTE</td>
      </tr>
      <tr>
         <td class="border-bottom border-right text-xs text-bold">&nbsp;FOTOCOPIA DE LA CÉDULA / PERSONA JURIDICA - REPRESENTANTE LEGAL</td>
         <td class="border-bottom border-right text-center text-sm">X</td>
         <td class="border-bottom border-right text-center text-sm">X</td>
         <td class="border-bottom text-center text-sm">X</td>
      </tr>
      <tr>
         <td class="border-bottom border-right text-xs text-bold">&nbsp;FOTOCOPIA DEL RUT.</td>
         <td class="border-bottom border-right text-center text-sm">X</td>
         <td class="border-bottom border-right text-center text-sm">X</td>
         <td class="border-bottom text-center text-sm">X</td>
      </tr>
      <tr>
         <td class="border-bottom border-right text-xs text-bold">&nbsp;CERTIFICADO LABORAL – CERTIFICACION DE INGRESOS</td>
         <td class="border-bottom border-right text-center text-sm">X</td>
         <td class="border-bottom border-right text-center text-sm">X</td>
         <td class="border-bottom">&nbsp;</td>
      </tr>
      <tr>
         <td class="border-bottom border-right text-xs text-bold">&nbsp;DECLARACIÓN DE RENTA (TRES ÚLTIMOS AÑOS)</td>
         <td class="border-bottom border-right text-center text-sm">X</td>
         <td class="border-bottom border-right text-center text-sm">X</td>
         <td class="border-bottom text-center text-sm">X</td>
      </tr>
      <tr>
         <td class="border-bottom border-right text-xs text-bold">&nbsp;CERTIFICADO DE INGRESOS YRETENCIONES (DOS ÚLTIMOS AÑOS)</td>
         <td class="border-bottom border-right text-center text-sm">X</td>
         <td class="border-bottom border-right text-center text-sm">X</td>
         <td class="border-bottom">&nbsp;</td>
      </tr>
      <tr>
         <td class="border-bottom border-right text-xs text-bold">&nbsp;CERTIFICADO DE CÁMARA Y COMERCIO (VIGENTE) NO MAYOR A 30 DIAS</td>
         <td class="border-bottom border-right text-center text-sm">X</td>
         <td class="border-bottom border-right text-center text-sm">X</td>
         <td class="border-bottom text-center text-sm">X</td>
      </tr>
      <tr>
         <td class="border-bottom border-right text-xs text-bold">&nbsp;BALANCE GENERAL Y ESTADO DE RESULTADOS DE LOS TRES ÚLTIMOS PERIODOS CONTABLES (FIRMADOS POR ELCONTADOR) ANEXO FOTOCOPIA DE LA TARJETA PROFESIONAL Y ANTECEDENTES DISCIPLINARIOS. LOS EFF</td>
         <td class="border-bottom border-right">&nbsp;</td>
         <td class="border-bottom border-right text-center text-sm">X</td>
         <td class="border-bottom text-center text-sm">X</td>
      </tr>
      <tr>
         <td class="border-bottom border-right text-xs text-bold">&nbsp;CERTIFICADO DE TRADICIÓN Y LIBERTAD DE INMUEBLES</td>
         <td class="border-bottom border-right text-center text-sm">X</td>
         <td class="border-bottom border-right text-center text-sm">X</td>
         <td class="border-bottom text-center text-sm">X</td>
      </tr>
      <tr>
         <td class="border-bottom border-right text-xs text-bold">&nbsp;FOTOCOPIA TARJETA DE PROPIEDAD VEHICULOS</td>
         <td class="border-bottom border-right text-center text-sm">X</td>
         <td class="border-bottom border-right text-center text-sm">X</td>
         <td class="border-bottom text-center text-sm">X</td>
      </tr>
      <tr>
         <td class=" border-right text-xs text-bold">&nbsp;EXTRACTOS BANCARIOS ÚLTIMOS 3 MESES</td>
         <td class=" border-right text-center text-sm">X</td>
         <td class=" border-right text-center text-sm">X</td>
         <td class=" text-center text-sm">X</td>&nbsp;</td>
      </tr>
   </table>

   {{------------------------ DECLARACIÓN DE ORIGEN DE FONDOS -----------------------------}}
   <table>
      <tr>
         <td colspan="2" class="text-md border-right border-bottom bg-header">
            DECLARACIÓN DE ORIGEN DE FONDOS
         </td>
      </tr>
      <tr>
         <td colspan="2" class="text-sm">
            En cumplimiento de las normas legales contempladas en el Estatuto Orgánico del Sistema Financiero y demás normas concordantes, declaro a AGRO HELP S.A.S. <br>
            1. Que los fondos con los cuales cubriré mis obligaciones presentes y futuras con AGRO HELP S.A.S, provienen de las siguientes fuentes y corresponden a actividades licitas. <br>
            2. Que no admitiré que terceros efectúen depósitos o pagos a AGRO HELP S.A.S, en mi nombre con fondos provenientes o destinados a realizar actividades licitas.
            <br><br>
         </td>
      </tr>
      <tr>
         <td class="text-center text-sm"  style="margin-top: 20px">
            Declaro que la información suministrada en esta solicitud es válida, al igual <br>
            que las autorizaciones otorgadas en esta solicitud. En constancia de haber <br>
            leído, entendido y aceptado esta Información, firmo el presente documento.
         </td>
         <td class="text-sm" style="background-color: rgb(225, 217, 217);"  style="margin-top: 20px">
            Firma: <br>
            (asegurado)&nbsp;&nbsp;_______________________________________________ <br>
            (Empleado)&nbsp;&nbsp;&nbsp; C.C.

         </td>
      </tr>
   </table>

   <div class="container page-break" style="margin-top: 20px;">
      <span class="text-md">      
         Fecha:_______/_______/_______ <br><br>
      </span>
      <span class="text-md text-bold">
         Señores <br>
         AGRO HELP SAS. <br>
         Nit. 900.406.066-4 <br>
         Ciudad <br><br>
      </span>
      <p style="text-align: justify;" class="text-lg">
         En mi (nuestra) calidad de titular(es) de información. actuando libre y voluntariamente, autorizo(amos) de manera expresa e irrevocable a AGRO HELP SAS, o a quien represente sus derechos, a consultar, solicitar, suministrar, reportar, procesar y divulgar toda la información que se refiera a mi(nuestro) comportamiento crediticio, financiero, comercial, de servicios y de terceros países de la misma naturaleza a la Central de Información -TransUnión® - CIFIN - o Datacrédito, que administra la Asociación Bancaria y de Entidades Financieras de Colombia, o a quien represente sus derechos.
      </p>
      <p style="text-align: justify;" class="text-lg">
         Conozco(conocemos) que el alcance de esta autorización implica que el comportamiento frente a mis(nuestras) obligaciones será(n) registrado(s) con el objeto de suministrar información suficiente y adecuada al mercado sobre el estado de mis(nuestras) obligaciones financieras, comerciales, crediticias, de servicios y la proveniente de terceros países de la misma naturaleza. En consecuencia, quienes se encuentren afiliados y/o tengan acceso a la Central de Información- TransUnión®-CIFIN- o Datacrédito, podrán conocer esta información, de conformidad con la legislación y jurisprudencia aplicable. La información podrá ser igualmente utilizada para efectos estadísticos.
      </p>
      <p style="text-align: justify;" class="text-lg">
         Mis(nuestros) derechos y obligaciones así como la permanencia de mi(nuestra) información en las bases de datos corresponden a lo determinado por el ordenamiento jurídico aplicable del cual, por ser de carácter público, estoy(estamos) enterado(s). Así mismo, manifiesto(manifestamos) que conozco (cemos) el contenido del reglamento de la -TransUnión® -CIFIN- o Datacrédito.
      </p>
      <p style="text-align: justify;" class="text-lg">
         En caso de que, en el futuro, el(los) autorizado(s) en este documento efectúe(n), a favor de un tercero, una venta de cartera o una cesión a cualquier título de las obligaciones a mi(nuestro) cargo, los efectos de la presente autorización se extenderán a éste en los mismos términos y condiciones. Así mismo, autorizo(autorizamos) a la Central de Información -TransUnión® -CIFIN o Datacrédito a que, en su calidad de operador, ponga mi(nuestra) información a disposición de otros operadores nacionales o extranjeros, en los términos que establece la ley, siempre y cuando su objeto sea similar al aquí establecido.
      </p>
      <p style="text-align: justify;" class="text-lg">
         Todo lo anterior de conformidad con lo establecido en la Ley 1266 de 2008 y 1581 de 2012.
      </p>

      <div class="card" style="margin-top: 50px;">
         <div class="row">

            <div class="col-6 border-right">
               <span class="text-md text-bold">&nbsp;&nbsp;
                  FIRMA Y SELLO - P. JURÍDICA
               </span>
               <br><br><br>
               &nbsp;&nbsp;_______________________________________
               <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Nombre Rep. Legal:</span> <br>
               &nbsp;&nbsp;_______________________________________ <br>
               <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;C.C.:<br></span>
               &nbsp;&nbsp;_______________________________________ <br>

               <div class="row">
                  <div style="width: 65%;">
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Empresa:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Nit.:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Teléfono:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Dirección:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Email:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                  </div>
   
                  <div class="text-center" style="width: 30%; margin-top: 20px;">
                     <div style="border: 2px solid black; border-radius: 7px; width: 90px; height: 130px;">
                        &nbsp;
                     </div>
                     <span class="text-bold text-sm">HUELLA</span>
                  </div>
               </div>
            </div>

            <div class="col-6">
               <span class="text-md text-bold">&nbsp;&nbsp;
                  FIRMA - P. NATURAL
               </span>
               <br><br><br>
               &nbsp;&nbsp;_______________________________________
               <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Nombre Rep. Legal:</span> <br>
               &nbsp;&nbsp;_______________________________________ <br>
               <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;C.C.:<br></span>
               &nbsp;&nbsp;_______________________________________ <br>

               <div class="row">
                  <div style="width: 65%;">
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Teléfono:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Dirección:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Email:<br></span>
                     &nbsp;&nbsp;_________________________<br>

                  </div>
   
                  <div class="text-center" style="width: 30%; margin-top: 20px;">
                     <div style="border: 2px solid black; border-radius: 7px; width: 90px; height: 130px;">
                        &nbsp;
                     </div>
                     <span class="text-bold text-sm">HUELLA</span>
                  </div>
               </div>
            </div>
         </div>
      </div>

   </div>

   <div class="container page-break" style="margin-top: 20px;">
      <span class="text-md">      
         Fecha:_______/_______/_______ <br><br>
      </span>
      <span class="text-md text-bold">
         Señores <br>
         AGRO HELP SAS. <br>
         Nit. 900.406.066-4 <br>
         Ciudad <br><br>
      </span>

      <div class="row">
         <span class="text-md text-bold">ASUNTO:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ley Habeas Data - NIC&nbsp;&nbsp;&nbsp;</span>
         <div style="border: 2px solid black; width:170px; height: 20px; margin-top:-5px;"></div>
      </div>

      <div class="row" style="margin-top: 30px;">
         <div class="col-6 text-md text-bold text-center">
            Usuario/suscriptor/propietario
         </div>
         <div class="col-6">
            <span class="text-bold text-md">Representante legal</span> <br>
            <span class="text-sm">(Debe anexar documentos que acrediten la calidad de representante )*</span>
         </div>
      </div>

      <p style="text-align: justify;" class="text-md">
         Yo, _________________________________
         , identificado (a) con la cédula de ciudadanía No. ______________________
         expedida en__________________________ , en cumplimiento a lo dispuesto en la Ley Estatutaria 1581 del 17 de octubre de 2012, "Por la cual se dictan las disposiciones generales para la protección de datos personales", por medio de la presente:
      </p>

      <div class="row"  style="margin-top: 30px; justify-items: center;">
         <div class="col-6 text-bold text-center">
            <div class="row">
               <div style="height: 20px; width: 20px; border: 1px solid black; border-radius: 50%;  margin-top:-3px; margin-right:10px;"></div>
               AUTORIZO
            </div>
         </div>
         <div class="col-6">
            <div class="row text-bold">
               <div style="height: 20px; width: 20px; border: 1px solid black; border-radius: 50%;  margin-top:-3px; margin-right:10px;"></div>
               NO AUTORIZO
            </div>
         </div>
      </div>

      <p class="text-md">
         a <span class="text-bold">AGRO HELP S.A.S.,</span> para que hagan uso de mis datos personales, existentes en su base de datos.
      </p>

      <div class="card" style="margin-top: 50px;">
         <div class="row">

            <div class="col-6 border-right">
               <span class="text-md text-bold">&nbsp;&nbsp;
                  FIRMA Y SELLO - P. JURÍDICA
               </span>
               <br><br><br>
               &nbsp;&nbsp;_______________________________________
               <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Nombre Rep. Legal:</span> <br>
               &nbsp;&nbsp;_______________________________________ <br>
               <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;C.C.:<br></span>
               &nbsp;&nbsp;_______________________________________ <br>

               <div class="row">
                  <div style="width: 65%;">
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Empresa:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Nit.:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Teléfono:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Dirección:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Email:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                  </div>
   
                  <div class="text-center" style="width: 30%; margin-top: 20px;">
                     <div style="border: 2px solid black; border-radius: 7px; width: 90px; height: 130px;">
                        &nbsp;
                     </div>
                     <span class="text-bold text-sm">HUELLA</span>
                  </div>
               </div>
            </div>

            <div class="col-6">
               <span class="text-md text-bold">&nbsp;&nbsp;
                  FIRMA - P. NATURAL
               </span>
               <br><br><br>
               &nbsp;&nbsp;_______________________________________
               <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Nombre Rep. Legal:</span> <br>
               &nbsp;&nbsp;_______________________________________ <br>
               <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;C.C.:<br></span>
               &nbsp;&nbsp;_______________________________________ <br>

               <div class="row">
                  <div style="width: 65%;">
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Teléfono:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Dirección:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Email:<br></span>
                     &nbsp;&nbsp;_________________________<br>

                  </div>
   
                  <div class="text-center" style="width: 30%; margin-top: 20px;">
                     <div style="border: 2px solid black; border-radius: 7px; width: 90px; height: 130px;">
                        &nbsp;
                     </div>
                     <span class="text-bold text-sm">HUELLA</span>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <p class="text-md" style="text-align: justify; margin-top: 20px;">
         <span class="text-bold">*Tercero</span> autorizado: Autorización firmada por parte del Usuario. <span class="text-bold">Apoderado:</span> Poder especial debidamente otorgado ante notario. <span class="text-bold">Representante Legal o Apoderado General de Persona Jurídica:</span> Certificado de Existencia y Representación Legal (Cámara de Comercio) con fecha de expedición no mayor a treinta (30) días.
      </p>

   </div>

   <div class="container page-break" style="margin-top: 20px;">
      <span class="text-md text-bold">      
         Chía,&nbsp;&nbsp; _______/_______/_______ <br><br>
      </span>
      <span class="text-md text-bold">
         Señores <br>
         AGRO HELP SAS. <br>
         Nit. 900.406.066-4 <br>
         Ciudad <br><br>
      </span>
      <span class="text-md text-bold">
         REF: AUTORIZACIÓN PARA LLENAR PAGARÉ FIRMADO EN BLANCO.
      </span>

      <p class="text-lg" style="text-align: justify">
         Yo, (nosotros)____________________________________________________________________________________ <br>____________________________________________________________________________________________, por medio de la presente y en los términos del Artículo 622 del Código de Comercio, los autorizo (amos) irrevocable y permanentemente para llenar el pagaré a la orden que otorgo (amos) a su favor, con los espacios en blanco que AGRO HELP SAS puede completar. El título valor pagaré será llenado por ustedes sin aviso previo, de acuerdo con las siguientes instrucciones; a) la cuantía será igual al monto de cualquier suma que por pagarés , letras, cheques, facturas o cualquier otro título-valor ó título ejecutivo, por cualquier otra obligación presente o futura, que directa o indirectamente, conjunta o separadamente y por cualquier concepto le deba(mos) o llegue (llegáremos) a deber a AGRO HELP SAS el día que sea llenado el título valor pagaré al que accede el presente documento; b) Los intereses corrientes de las obligaciones se liquidarán a las tasas pactadas y en caso contrario, a la máxima corriente bancaria que permitan cobrarlas autoridades monetarias como la Superintendencia Financiera. Los intereses de mora serán pactados y si no hay estipulación al respecto, serán los que correspondan a la tasa máxima legal establecida por la Superintendencia Financiera de Colombia para el día en que se llene el título valor pagaré, los cuales podrán llegar a ser hasta una y media vez el corriente bancario al tenor del Art. 884 de C. de Co.; c) En cuanto al vencimiento del pagaré AGRO HELP SAS deberá colocarle el del día en que lo llene o complete; d) AGRO HELP SAS deberá colocarle como fecha de emisión al pagaré la del día en que decida llenarlo; e) En todos los demás, el texto del título se sujetará al que ordinariamente usa AGRO HELP SAS, f ) Si alguna de las obligaciones es en moneda extranjeraAGRO HELP SAS queda autorizado para liquidarla en pesos colombianos al tipo de cambio vigente para dichas divisas, el día en que decida llenar el pagaré. g) AGRO HELP SAS, además de los eventos de aceleración de los pagos previstos en cada uno de los documentos, contratos o títulos de deuda respectivos, podrá llenar el pagaré cuando el (alguno de los) firmante(s) no pague en todo o en parte, cuando es debido, cualquier cuota de capital, intereses o comisiones de una cualesquiera de las obligaciones que directa, indirecta, conjunta o separadamente, el (cualquiera de los ) firmante(s) tenga o llegue a contraer para con AGRO HELP SAS en los términos del literal a), de estas instrucciones o si EL DEUDOR, cualesquiera de sus fiadores o avalistas aparece vinculado a investigaciones o es sancionado o condenado en desarrollo de investigaciones administrativas, judiciales, penales o de cualquier otra índole por lavado de activos, por delitos o conductas contra la fé pública, por celebración indebida de contratos y en general por delitos o conductas que a juicio de AGRO HELP SAS impliquen duda fundada sobre la moralidad del DEUDOR o deterioro de la capacidad crediticia y de pago de los investigados o que hagan inconveniente para AGRO HELP SAS, de acuerdo con su propio criterio, mantener relaciones con dichas personas.; h) En lo no previsto, AGRO HELP SAS queda plenamente autorizado para actuar a su leal saber y entender en defensa de sus intereses sin que en ningún momento se pueda alegar que carece de facultades o autorizaciones suficientes para completar el título. Se conviene que los intereses pendientes causan intereses en los términos del Artículo 886 del Código de Comercio; i) Si llego(amos) a tener obligaciones de diferente naturaleza, vencimiento, moneda o tasa de mora, AGRO HELP SAS queda autorizada para unificar los vencimientos y la tasa de mora y para convertir las obligaciones en moneda extrajera a la tasa representativa del mercado; j) A partir del día que sea llenado el título, la obligación será reportada a las Centrales de Riesgo ó a su criterio; k) Si las obligaciones fueren de diferente naturaleza y estuvieren sujetas a diversos plazos o tasas, el incumplimiento de una, permite hacer de plazo vencido las demás y se conviene que AGRO HELP SAS queda facultada para unificar el vencimiento y las tasas de interés de las mismas, pudiendo aplicar el promedio de ellas. AUTORIZACIÓN: a) Autorizo (amos) de manera irrevocable a AGRO HELP SAS, para que con fines estadísticos, de control, supervisión y de información comercial, consulte ante la Central de Información de la Asociación Bancaria y cualquier otra entidad que maneje bases de datos con los mismos fines, el nacimiento, modificación, extinción de obligaciones directas o indirectas contraídas con anterioridad o que se llegaren a contraer con el sector financiero o real, fruto de aperturas de crédito, cobranzas, contratos, actos o de cualquier otra relación financiera, y en especial, todo lo relativo a créditos, contratos de cuenta corriente, tarjeta de crédito, hábitos de pago y tarjeta débito ;b) Esta autorización comprende la información presente, pasada y futura referente al manejo, estado, cumplimiento de mis relaciones, contratos y servicios, obligaciones y a las deudas vigentes, vencidas sin cancelar, procesos, o a la utilización indebida de los servicios financieros, etc.
      </p>

   </div>

   <div class="container page-break" style="margin-top: 20px;">
      <div class="text-center text-bold text-lg">REF: AUTORIZACIÓN PARA LLENAR PAGARÉ FIRMADO EN BLANCO.</div>
      <p class="text-lg" style="text-align: justify;">
         Todo lo anterior mientras estén vigentes y adicionalmente por el término máximo de permanencia de los datos en las Centrales de Riesgo, de acuerdo con los pronunciamientos de la Corte Constitucional o de la Ley, contados desde cuando extinga la obligación o relación, este último plazo para los efectos previstos de Riesgo, de acuerdo con los pronunciamientos de la Corte Constitucional o de la Ley, contados desde cuando extinga la obligación o relación, este último plazo para los efectos previstos en los artículos 1527 y ss del C.C. y 882 del C. de Co; c) La autorización faculta a AGRO HELP SAS para reportar, procesar y divulgar a la Central de Información de la Asociación Bancaria o cualquier otra entidad encargada del manejo de datos comerciales, datos personales económicos, sino también para que AGRO HELP SAS pueda solicitar información sobre mis(nuestras) relaciones comerciales con terceros o con el sistema financiero y para que los datos sobre mí reportados sean procesados para el logro del propósito de la Central y puedan ser circularizados o divulgados con fines comerciales; d) Acepto que los registros permanezcan por los términos previstos en los reglamentos de las respectivas Centrales de Información. Me comprometo con AGRO HELP SAS a informar por escrito y oportunamente cualquier cambio en los datos, cifras y demás información, así como a suministrar la totalidad de los soportes documentales exigidos y a actualizar dicha información con una periodicidad como mínimo anual. e) El otorgante se da por enterado que este acto será reportado a las Centrales de Riesgo.
El pagaré así llenado, será exigible inmediatamente y prestará mérito ejecutivo sin más requisitos y renuncio (amos) a formular excepciones contra el mismo.
      </p>
      <p class="text-lg text-bold">
         Atentamente,
      </p>

      <div class="card" style="margin-top: 25px;">
         <div class="row">

            <div class="col-6 border-right">
               <span class="text-md text-bold">&nbsp;&nbsp;
                  FIRMA Y SELLO - P. JURÍDICA
               </span>
               <br><br><br>
               &nbsp;&nbsp;_______________________________________
               <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Nombre Rep. Legal:</span> <br>
               &nbsp;&nbsp;_______________________________________ <br>
               <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;C.C.:<br></span>
               &nbsp;&nbsp;_______________________________________ <br>

               <div class="row">
                  <div style="width: 65%;">
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Empresa:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Nit.:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Teléfono:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Dirección:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Email:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                  </div>
   
                  <div class="text-center" style="width: 30%; margin-top: 20px;">
                     <div style="border: 2px solid black; border-radius: 7px; width: 90px; height: 130px;">
                        &nbsp;
                     </div>
                     <span class="text-bold text-sm">HUELLA</span>
                  </div>
               </div>
            </div>

            <div class="col-6">
               <span class="text-md text-bold">&nbsp;&nbsp;
                  FIRMA - P. NATURAL
               </span>
               <br><br><br>
               &nbsp;&nbsp;_______________________________________
               <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Nombre Rep. Legal:</span> <br>
               &nbsp;&nbsp;_______________________________________ <br>
               <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;C.C.:<br></span>
               &nbsp;&nbsp;_______________________________________ <br>

               <div class="row">
                  <div style="width: 65%;">
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Teléfono:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Dirección:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Email:<br></span>
                     &nbsp;&nbsp;_________________________<br>

                  </div>
   
                  <div class="text-center" style="width: 30%; margin-top: 20px;">
                     <div style="border: 2px solid black; border-radius: 7px; width: 90px; height: 130px;">
                        &nbsp;
                     </div>
                     <span class="text-bold text-sm">HUELLA</span>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="card" style="margin-top: 20px;">
         <div class="row">

            <div class="col-6 border-right">
               <span class="text-md text-bold">&nbsp;&nbsp;
                  FIRMA Y SELLO - P. JURÍDICA
               </span>
               <br><br><br>
               &nbsp;&nbsp;_______________________________________
               <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Nombre Rep. Legal:</span> <br>
               &nbsp;&nbsp;_______________________________________ <br>
               <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;C.C.:<br></span>
               &nbsp;&nbsp;_______________________________________ <br>

               <div class="row">
                  <div style="width: 65%;">
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Empresa:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Nit.:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Teléfono:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Dirección:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Email:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                  </div>
   
                  <div class="text-center" style="width: 30%; margin-top: 20px;">
                     <div style="border: 2px solid black; border-radius: 7px; width: 90px; height: 130px;">
                        &nbsp;
                     </div>
                     <span class="text-bold text-sm">HUELLA</span>
                  </div>
               </div>
            </div>

            <div class="col-6">
               <span class="text-md text-bold">&nbsp;&nbsp;
                  FIRMA - P. NATURAL
               </span>
               <br><br><br>
               &nbsp;&nbsp;_______________________________________
               <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Nombre Rep. Legal:</span> <br>
               &nbsp;&nbsp;_______________________________________ <br>
               <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;C.C.:<br></span>
               &nbsp;&nbsp;_______________________________________ <br>

               <div class="row">
                  <div style="width: 65%;">
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Teléfono:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Dirección:<br></span>
                     &nbsp;&nbsp;_________________________<br>
                     <span class="text-xs text-bold">&nbsp;&nbsp;&nbsp;&nbsp;Email:<br></span>
                     &nbsp;&nbsp;_________________________<br>

                  </div>
   
                  <div class="text-center" style="width: 30%; margin-top: 20px;">
                     <div style="border: 2px solid black; border-radius: 7px; width: 90px; height: 130px;">
                        &nbsp;
                     </div>
                     <span class="text-bold text-sm">HUELLA</span>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <p class="text-sm" style="text-align:justify;">
         Autorizo a <span class="text-bold">AGRO HELP SAS.</span> o a quien represente sus derechos u ostente en el futuro la calidad de acreedor a reportar, procesar, solicitar y divulgar a la Central de Información Financiera <span class="text-bold"> TransUnlón ® • CIFIN • o Datacrédito • Asociación Bancaria</span> y de Entidades Financieras de Colombia, o cualquier otra Entidad que maneje o administre bases de datos con los mismos fines, toda la información referente a mi comportamiento comercial.
      </p>

   </div>

   <script type="text/javascript">
      setTimeout(() => {
          window.print();
      }, 500);
   </script>
</body>
</html>