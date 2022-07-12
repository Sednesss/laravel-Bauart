<?php

namespace Database\Seeders;

use App\Models\ImageProcessing\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Storage::create([
            'name' => 'file',
            'key' => 'file',
        ]);

        Storage::create([
            'name' => 'yandex cloud',
            'key' => 'yandex_cloud',
        ]);
    }
}
