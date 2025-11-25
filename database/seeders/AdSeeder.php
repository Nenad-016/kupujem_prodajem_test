<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->pluck('id')->toArray();

        $leafCategories = Category::whereDoesntHave('children')->pluck('id')->toArray();

        if (empty($users) || empty($leafCategories)) {
            $this->command->warn('AdSeeder: Nema usera ili podkategorija – proveri UserSeeder i CategorySeeder.');

            return;
        }

        $titles = [
            'iPhone 12 Pro Max',
            'Gaming PC Ryzen',
            'Polovan bicikl za grad',
            'Drveni sto sa 4 stolice',
            'Laptop Dell Inspiron 15',
            'Samsung S22 Ultra',
            'Auto gume 17 cola',
            'Monitor LG 27 inča',
            'Kompresor 50L',
            'Kućni sobni bicikl',
            'Canon DSLR fotoaparat',
            'Novi patosni tepih',
            'Sony PlayStation 4',
            'Panelna ograda 2m',
            'Mali frižider za garsonjeru',
            'Kolekcija klasika – 20 knjiga',
            'Xiaomi robot usisivač',
            'LED TV 50 inča',
            'Rasklopivi krevet',
            'Set stolica za terasu',
        ];

        foreach ($titles as $title) {
            Ad::create([
                'user_id' => $users[array_rand($users)],
                'category_id' => $leafCategories[array_rand($leafCategories)],
                'title' => $title,
                'description' => Str::limit("Oglas: {$title}. Ovo je demo opis za seed podatke, namenjen testiranju prikaza oglasa u sistemu.", 220),
                'price' => rand(1000, 150000),
                'condition' => rand(0, 1) ? 'new' : 'used',
                'image_path' => 'ads/'.rand(1, 20).'.png',
                'phone' => '06'.rand(1000000, 9999999),
                'location' => collect(['Beograd', 'Novi Sad', 'Niš', 'Kragujevac', 'Subotica'])->random(),
                'status' => 'active',
            ]);
        }
    }
}
