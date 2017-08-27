<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ImportController extends Controller
{
  private function importProvince()
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://api.rajaongkir.com/starter/province",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "key: "."5ecb3bba224692d4978c7f56d744b6fb"
        ),
      ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    }
    else{
      $json = json_decode($response, true);

      foreach($json['rajaongkir']['results'] as $item)
      {
        $province = new Province;
        $province->id = $item['province_id'];
        $province->name = $item['province'];
        $province->save();
      }
    }
  } 

  private function importSubDistrict()
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "key: "."5ecb3bba224692d4978c7f56d744b6fb"
        ),
      ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    }
    else{
      $json = json_decode($response, true);

      echo $json;
      // foreach($json['rajaongkir']['results'] as $item)
      // {
      //   $province = new Province;
      //   $province->id = $item['province_id'];
      //   $province->name = $item['province'];
      //   $province->save();
      // }
    }
  }

  private function importCity()
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://api.rajaongkir.com/starter/city",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "key: "."5ecb3bba224692d4978c7f56d744b6fb"
        ),
      ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    }
    else{
      $json = json_decode($response, true);

      foreach($json['rajaongkir']['results'] as $item)
      {
                // print_r($item);
        $city = new City;
        $city->id = $item['city_id'];
        $city->province_id = $item['province_id'];
        $city->type = $item['type'];
        $city->postal_code = $item['postal_code'];
        $city->name = $item['city_name'];
        $city->save();
      }

            // [city_id] => 1 [province_id] => 21 [province] => Nanggroe Aceh Darussalam (NAD) [type] => Kabupaten [city_name] => Aceh Barat [postal_code] => 23681
    }
  }

    private function importSubDistrict()
    {
  // iterate city
      $cities = City::get();

      $i = 500;
      $count = 50;


      foreach ($cities as $city) {
        if($city->id < $i)
          continue;

        if($city->id < $i+$count)
        {
          $this->storeSubDistrict($city->id);
        }
        else
        {
          echo 'done '.$i.' - '.$count;
          break;
        }
      }
      
      
    }

    private function storeSubDistrict($cityId)
    {
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?city=".$cityId,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "key: "."5ecb3bba224692d4978c7f56d744b6fb"
          ),
        ));

      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
    // insert 
        $json = json_decode($response, true);

        foreach($json['rajaongkir']['results'] as $item)
        {
          $subdistrict = new Subdistrict;
          $subdistrict->id = $item['subdistrict_id'];
          $subdistrict->city_id = $item['city_id'];
          $subdistrict->city = $item['city'];
          $subdistrict->province_id = $item['province_id'];
          $subdistrict->province = $item['province'];
          $subdistrict->type = $item['type'];
          $subdistrict->subdistrict_name = $item['subdistrict_name'];
          $subdistrict->save();
        }
      }
    } 
}
