<?php

use Illuminate\Database\Seeder;
use SoapBox\Formatter\Formatter;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');
        }

        $filePath = database_path() . '/seeds/CSVs/Countries.csv';
        $string = file_get_contents($filePath);
        $string = str_replace("\n", "\r", $string);
        $formatter = Formatter::make($string, Formatter::CSV);
        $array = $formatter->toArray();

        $countries = [];
        for ($i = 0; $i < sizeof($array); $i++)
        {
            $countries[]        = [
                'id'            => $array[$i]['id'],
                'name'          => $array[$i]['name'],
                'code'          => $array[$i]['iso2'],
            ];
        }

        DB::table('countries')->insert(
            $countries
        );
    }
}
