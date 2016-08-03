<?php

Route::any('{uri}', ['as' => 'bridge.get', 'uses' => 'BridgeController@bridge'])->where(['uri' => '([A-Za-z\d-\    /_.]+)?']);