require( 'manakin' ).global;
const globby = require( 'globby' );
const verbose = process.argv.indexOf('--debug') !== -1;

const TenUpAssetPathsValidator = {
  hasErrors: false,
  assets:[
    {
      'type': 'css',
      'path': 'assets/css',
      'glob': [ '**/*.css', '!node_modules', '!style.css', '!rtl.css' ]
    },
    {
      'type': 'js',
      'path': 'assets/js',
      'glob': [ '**/*.js', '!node_modules', '!tests', '!Gruntfile.js' ]
    }
  ],
  validate: function(asset){

    /**
     * Check for required keys:
     * 1. type
     * 2. path
     * 3. glob
     */
    if ( !asset.hasOwnProperty( 'type' ) || !asset.hasOwnProperty( 'path' ) || !asset.hasOwnProperty( 'glob' )) {
      return;
    }

    console.info( 'Checking paths for ' + asset.type + ' file types...' );
    console.info( 'Asset should be within: ' + asset.path );

    let assetFiles = globby.sync( asset.glob );

    for( let i in assetFiles ) {
      if ( assetFiles[ i ].indexOf( asset.path ) !== 0 ) {
        if( verbose ) {
          console.error( 'x ' + assetFiles[ i ] );
        }
        TenUpAssetPathsValidator.hasErrors = true;
      }else {
        console.success( '\u2714' + assetFiles[ i ] );
      }
    }

    console.log( '' );

  }
};

TenUpAssetPathsValidator.assets.forEach(TenUpAssetPathsValidator.validate);

if ( TenUpAssetPathsValidator.hasErrors ) {
  throw( 'Some files not in correct paths... See output above...' );
}else{
  console.success( "All Assets in correct paths :)");
}
