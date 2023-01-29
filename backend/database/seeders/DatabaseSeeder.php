<?php

namespace Database\Seeders;

use App\Models\Bogi;
use App\Models\Seat;
use App\Models\Station;
use App\Models\Train;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    foreach (eticket_stations() as $item) {
      $station = new Station();

      $station->name = $item['name'];
      $station->address = $item['address'];
      $station->lat = $item['lat'];
      $station->lon = $item['lon'];

      $station->save();
    }

    foreach (eticket_trains() as $item) {
      $train = new Train();

      $train->name = $item['name'];
      $train->date = date('Y-m-d', strtotime($item['date']));
      $train->home_station_id = $item['home_station_id'];
      $train->start_time = date('h:i:s', strtotime($item['start_time']));

      $train->save();

      foreach (eticket_bogis() as $bogiitem) {
        $bogi = new Bogi();
        $bogi->name = $bogiitem['name'];
        $bogi->train_id = $train->id;

        $bogi->save();

        for ($i = 1; $i <= 60; $i++) {
          $seat = new Seat();
          $seat->name = $bogi->name . '-' . $i;
          $seat->bogi_id = $bogi->id;

          $seat->save();
        }
      }
    }
  }
}
