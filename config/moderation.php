<?php
return array(
    /*
    |--------------------------------------------------------------------------
    | Status column
    |--------------------------------------------------------------------------
    */
    'status_column' => 'status',

    /*
    |--------------------------------------------------------------------------
    | Moderated At column
    |--------------------------------------------------------------------------
    */
    'moderated_at_column' => 'moderated_at',

    /*
    |--------------------------------------------------------------------------
    | Moderated By column
    |--------------------------------------------------------------------------
    | Moderated by column is disabled by default.
    | If you want to include the id of the user who moderated a resource set
    | here the name of the column.
    | REMEMBER to migrate the database to add this column.
    */
    'moderated_by_column' => null,

    /*
    |--------------------------------------------------------------------------
    | Strict Moderation
    |--------------------------------------------------------------------------
    | If Strict Moderation is set to true then the default query will return
    | only approved resources. In other case, pending resources will returned
    | as well.
    */
    'strict' => true,
);