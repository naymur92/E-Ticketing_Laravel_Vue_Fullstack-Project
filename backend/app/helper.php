<?php
function eticket_stations()
{
  return [
    [
      'name' => 'Dhaka',
      'address' => 'Dhaka',
      'lat' => 90.334,
      'lon' => 92.154
    ],
    [
      'name' => 'Dhaka Bimanbondor',
      'address' => 'Dhaka Bimanbondor',
      'lat' => 90.3134,
      'lon' => 92.1254
    ],
    [
      'name' => 'Khulna',
      'address' => 'Khulna',
      'lat' => 90.23134,
      'lon' => 92.31254
    ],
  ];
}

function eticket_trains()
{
  return [
    [
      'name' => 'Chitra',
      'date' => '2023-06-02',
      'home_station_id' => 1,
      'start_time' => '06:00'
    ],
    [
      'name' => 'Sundarban',
      'date' => '2023-06-02',
      'home_station_id' => 1,
      'start_time' => '12:00'
    ],

  ];
}
