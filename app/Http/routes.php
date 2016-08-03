<?php

Route::any('{uri}', ['as' => 'bridge', 'uses' => 'BridgeController@bridge'])->where(['uri' => '([A-Za-z\d-\    /_.]+)?']);