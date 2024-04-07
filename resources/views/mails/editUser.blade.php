<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
      <h4><b>Successful user update</b></h4><br>

      <ul>
        <li>Email: {{$user->email}}</li>
        <li>Name: {{$user->nombre}}</li>
        <li>LastName: {{$user->apellido}}</li>
        <li>Identification Type : {{$user->tipo_documento}}</li>
        <li>Document: {{$user->documento}}</li>
        <li>More info, click here {{ url('') }}</li>
      </ul>


  </body>
</html>
