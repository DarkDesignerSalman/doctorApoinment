<?php
return [
'disks' => [
// ...
'public' => [
'driver' => 'local',
'root' => public_path('uploads'), // change 'uploads' to your desired folder name
'url' => env('APP_URL').'/uploads',
'visibility' => 'public',
],
// ...
],
];
