<?php
// function eticket_stations()
// {
//   return [
//     [
//       'name' => 'Dhaka',
//       'address' => 'Dhaka',
//       'lat' => 90.334,
//       'lon' => 92.154
//     ],
//     [
//       'name' => 'Dhaka Bimanbondor',
//       'address' => 'Dhaka Bimanbondor',
//       'lat' => 90.3134,
//       'lon' => 92.1254
//     ],
//     [
//       'name' => 'Khulna',
//       'address' => 'Khulna',
//       'lat' => 90.23134,
//       'lon' => 92.31254
//     ],
//   ];
// }

// function eticket_trains()
// {
//   return [
//     [
//       'name' => 'Chitra',
//       'date' => '2023-06-02',
//       'home_station_id' => 1,
//       'start_time' => '06:00'
//     ],
//     [
//       'name' => 'Sundarban',
//       'date' => '2023-06-02',
//       'home_station_id' => 1,
//       'start_time' => '12:00'
//     ],

//   ];
// }

function eticket_bogis()
{
  return [
    [
      'name' => 'KA',
      'train_id' => 1,
      'bogi_type_id' => 1
    ],
    [
      'name' => 'KHA',
      'train_id' => 1,
      'bogi_type_id' => 1
    ],
  ];
}

function type_name_by_number()
{
  return [
    0 => 'Shovon',
    1 => 'Shovon Chair',
  ];
}

function table_name_by_number()
{
  return [
    0 => 'shovon_price',
    1 => 's_chair_price',
    2 => 'f_chair_price',
    3 => 'f_seat_price',
    4 => 'f_berth_price',
  ];
}
