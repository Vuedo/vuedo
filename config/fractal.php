<?php

return [

    /*
      |----------------------------------------------------------------------------------------------------------
      | autoload sub level data transformers during an "input_key" variable received from user request
      |----------------------------------------------------------------------------------------------------------
     */
    'autoload'   => env('FRACTAL_AUTOLOAD', true),
    /*
      |----------------------------------------------------------------------------------------------------------
      | input_key user parameter key to include extra transformer specified in transformer class
      |----------------------------------------------------------------------------------------------------------
     */
    'input_key'  => env('FRACTAL_INPUT_KEY', 'include'),
    /*
      |----------------------------------------------------------------------------------------------------------
      | namespace
      |----------------------------------------------------------------------------------------------------------
     */
    'namespace'  => env('FRACTAL_NAMESPACE', 'App\Transformers'),
    /*
      |----------------------------------------------------------------------------------------------------------
      | Transformers store directory
      | path relative to App/
      |----------------------------------------------------------------------------------------------------------
     */

    'directory'  => env('FRACTAL_DIRECTORY', 'Transformers/'),
    /*
      |----------------------------------------------------------------------------------------------------------
      | serializer
      |----------------------------------------------------------------------------------------------------------
     */
    // you are required to provide full namespace for custom serializer
    'serializer' => env('FRACTAL_SERIALIZER', 'ArraySerializer')//DataArraySerializer,JsonApiSerializer, ArraySerializer

];
