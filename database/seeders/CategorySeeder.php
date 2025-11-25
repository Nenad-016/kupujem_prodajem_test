<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Elektronika' => [
                'Audio',
                'Vinili, CD i kasete',
                'Elektronika i komponente',
                'Mobilni telefoni',
                'Mobilni tel. | Oprema i delovi',
                'TV i Video',
                'Foto-aparati i kamere',
                'Konzole i igrice',
                'Kompjuteri | Desktop',
                'Kompjuteri | Laptop i tablet',
            ],

            'Auto-moto' => [
                'Automobili',
                'Auto oprema',
                'Auto delovi i alati',
                'Motocikli',
                'Motocikli | Oprema i delovi',
            ],

            'Nekretnine' => [
                'Nekretnine | Izdavanje',
                'Nekretnine | Prodaja',
            ],

            'Odeća i obuća' => [
                'Obuća | Muška',
                'Obuća | Ženska',
                'Obuća | Dečja',
                'Odeća | Muška',
                'Odeća | Ženska',
                'Odeća | Dečja',
            ],

            'Kućni ljubimci' => [
                'Kućni ljubimci | Oprema',
            ],

            'Građevinarstvo' => [],
            'Alati i oruđa' => [],
            'Sport i razonoda' => [],
            'Usluge' => [],
            'Poljoprivreda' => [],
            'Poslovi' => [],
        ];

        foreach ($categories as $parentName => $children) {
            $parentSlug = Str::slug($parentName);

            // Kreiraj ili uzmi parent po slug-u
            $parentCategory = Category::firstOrCreate(
                ['slug' => $parentSlug],
                [
                    'name' => $parentName,
                    'parent_id' => null,
                ]
            );

            foreach ($children as $childName) {
                $childSlug = Str::slug($childName);

                Category::firstOrCreate(
                    ['slug' => $childSlug],
                    [
                        'name' => $childName,
                        'parent_id' => $parentCategory->id,
                    ]
                );
            }
        }
    }
}
