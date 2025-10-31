<?php

namespace Database\Seeders;

use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CarBrandWithModelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = resource_path('data/car_models.json');
        $jsonFile = File::get($jsonPath);
        $jsonFile = $this->cleanJsonString($jsonFile);
        $data = json_decode($jsonFile, true);
        foreach ($data as $brandName => $models) {
            $brand = CarBrand::firstOrCreate([
                'name' => $brandName
            ]);
            foreach ($models as $model) {
                CarModel::create([
                    'car_brand_id' => $brand->id,
                    'name' => $model['name']
                ]);
            }
        }
        if ($data === null) {
            $error = json_last_error_msg();
            $this->command->error("JSON decode error: " . $error);
            dd("Stopping due to JSON error");
        }
    }
    private function cleanJsonString($jsonString)
    {
        // Remove BOM (Byte Order Mark) and other invisible characters
        $jsonString = preg_replace('/^\xEF\xBB\xBF/', '', $jsonString); // UTF-8 BOM
        $jsonString = preg_replace('/^\xFE\xFF/', '', $jsonString); // UTF-16 BE BOM
        $jsonString = preg_replace('/^\xFF\xFE/', '', $jsonString); // UTF-16 LE BOM
        // Remove any other non-printable characters at start
        $jsonString = preg_replace('/^[^\x20-\x7E]*/', '', $jsonString);
        // Trim whitespace
        $jsonString = trim($jsonString);
        return $jsonString;
    }

}
