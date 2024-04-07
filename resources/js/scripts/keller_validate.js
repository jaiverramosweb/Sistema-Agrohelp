
export default async function errors_( errors , errors_t  )
{
  let test;
  let v = Object.entries(errors_t).length === 0;
  
  if ( !v ){ 
    test = await clearErrors( errors_t );
  }
  for ( const property in errors )
  {
    $( '#'+property ).addClass( 'is-invalid' );
    let div = $( '#div_'+property );
    div.append( $('<span id="'+property+'_error" class="error invalid-feedback"></span>').html( errors[property] ) );
  }
  return ;
}

function clearErrors( errors_temp )
{
  return new Promise(resolve => {
    let i = 0 ;
    for ( const property in errors_temp )
    {
      $( '#'+property ).removeClass( 'is-invalid' );
      $( '#'+property+'_error' ).remove( );
    }
    resolve( 'resolved' );
  });
}
