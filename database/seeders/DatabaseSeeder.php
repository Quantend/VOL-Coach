<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed users table
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@rocgilde.nl',
                'is_admin' => 1,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@rocgilde.nl',
                'is_admin' => 0,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('home')->insert([
            'content' => '<h1>Welkom op onze website</h1><p>Dit is een voorbeeld van inhoud in HTML-formaat.</p>',
            'media' => 'https://www.youtube.com/watch?v=ML20TvWphoA',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed hoofdthemas table
        DB::table('hoofdthemas')->insert([
            [
                'naam' => 'Hoofdthema 1',
                'beschrijving' => 'Beschrijving voor Hoofdthema 1',
                'content' => 'Content voor Hoofdthema 1',
                'media' => 'https://www.youtube.com/watch?v=ML20TvWphoA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Hoofdthema 2',
                'beschrijving' => 'Beschrijving voor Hoofdthema 2',
                'content' => 'Content voor Hoofdthema 2',
                'media' => 'https://www.youtube.com/watch?v=ML20TvWphoA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed deelthemas table
        DB::table('deelthemas')->insert([
            // Deelthema's voor Hoofdthema 1
            [
                'naam' => 'Deelthema 1A',
                'beschrijving' => 'Beschrijving voor Deelthema 1A',
                'vragen' => json_encode([
                    ['vraag' => 'Wat is het belangrijkste aspect van Deelthema 1A?'],
                    ['vraag' => 'Hoe zou je dit concept toepassen in de praktijk?'],
                    ['vraag' => 'Welke uitdagingen verwacht je?']
                ]),
                'content' => 'Content voor Deelthema 1A',
                'hoofdthema_id' => 1,
                'media' => 'https://www.youtube.com/watch?v=ML20TvWphoA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Deelthema 1B',
                'beschrijving' => 'Beschrijving voor Deelthema 1B',
                'vragen' => json_encode([
                    ['vraag' => 'Wat is de kern van Deelthema 1B?'],
                    ['vraag' => 'Hoe zou je dit concept toepassen in het dagelijks leven?'],
                    ['vraag' => 'Welke factoren beïnvloeden de toepassing?']
                ]),
                'content' => 'Content voor Deelthema 1B',
                'hoofdthema_id' => 1,
                'media' => 'https://www.youtube.com/watch?v=ML20TvWphoA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Deelthema's voor Hoofdthema 2
            [
                'naam' => 'Deelthema 2A',
                'beschrijving' => 'Beschrijving voor Deelthema 2A',
                'vragen' => json_encode([
                    ['vraag' => 'Wat is het belangrijkste aspect van Deelthema 2A?'],
                    ['vraag' => 'Hoe zou je dit concept toepassen in de praktijk?'],
                    ['vraag' => 'Welke uitdagingen verwacht je?']
                ]),
                'content' => 'Content voor Deelthema 2A',
                'hoofdthema_id' => 2,
                'media' => 'https://www.youtube.com/watch?v=ML20TvWphoA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Deelthema 2B',
                'beschrijving' => 'Beschrijving voor Deelthema 2B',
                'vragen' => json_encode([
                    ['vraag' => 'Wat is de kern van Deelthema 2B?'],
                    ['vraag' => 'Hoe zou je dit concept toepassen in het dagelijks leven?'],
                    ['vraag' => 'Welke factoren beïnvloeden de toepassing?']
                ]),
                'content' => 'Content voor Deelthema 2B',
                'hoofdthema_id' => 2,
                'media' => 'https://www.youtube.com/watch?v=ML20TvWphoA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed uitdagings table
        DB::table('uitdagings')->insert([
            // Uitdagingen voor Deelthema 1A
            [
                'deelthema_id' => 1,
                'niveau' => 'experimenteren',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Voer een experiment uit met Deelthema 1A.'],
                    ['opdracht' => 'Documenteer de resultaten.']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'deelthema_id' => 1,
                'niveau' => 'toepassen',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Pas Deelthema 1A toe in een praktijkcase.'],
                    ['opdracht' => 'Maak een evaluatieverslag.']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'deelthema_id' => 1,
                'niveau' => 'verdiepen',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Schrijf een verdiepende paper over Deelthema 1A.'],
                    ['opdracht' => 'Geef een presentatie over je inzichten.']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Uitdagingen voor Deelthema 1B
            [
                'deelthema_id' => 2,
                'niveau' => 'experimenteren',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Voer een experiment uit met Deelthema 1B.'],
                    ['opdracht' => 'Documenteer de resultaten.']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'deelthema_id' => 2,
                'niveau' => 'toepassen',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Pas Deelthema 1B toe in een praktijkcase.'],
                    ['opdracht' => 'Maak een evaluatieverslag.']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'deelthema_id' => 2,
                'niveau' => 'verdiepen',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Schrijf een verdiepende paper over Deelthema 1B.'],
                    ['opdracht' => 'Geef een presentatie over je inzichten.']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Uitdagingen voor Deelthema 2A
            [
                'deelthema_id' => 3,
                'niveau' => 'experimenteren',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Voer een experiment uit met Deelthema 2A.'],
                    ['opdracht' => 'Documenteer de resultaten.']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'deelthema_id' => 3,
                'niveau' => 'toepassen',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Pas Deelthema 2A toe in een praktijkcase.'],
                    ['opdracht' => 'Maak een evaluatieverslag.']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'deelthema_id' => 3,
                'niveau' => 'verdiepen',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Schrijf een verdiepende paper over Deelthema 2A.'],
                    ['opdracht' => 'Geef een presentatie over je inzichten.']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Uitdagingen voor Deelthema 2B
            [
                'deelthema_id' => 4,
                'niveau' => 'experimenteren',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Voer een experiment uit met Deelthema 2B.'],
                    ['opdracht' => 'Documenteer de resultaten.']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'deelthema_id' => 4,
                'niveau' => 'toepassen',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Pas Deelthema 2B toe in een praktijkcase.'],
                    ['opdracht' => 'Maak een evaluatieverslag.']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'deelthema_id' => 4,
                'niveau' => 'verdiepen',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Schrijf een verdiepende paper over Deelthema 2B.'],
                    ['opdracht' => 'Geef een presentatie over je inzichten.']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed zelftoets table
        DB::table('zelftoets')->insert([
            [
                'hoofdthema_id' => 1,
                'deelthema_id' => 1,
                'user_id' => 1, // Admin User
                'uitdaging_id' => 1, // Experimenteren uitdaging voor Deelthema 1A
                'uitslag' => json_encode([
                    ['vraag' => 'Wat is het belangrijkste aspect van Deelthema 1A?', 'antwoord' => 3],
                    ['vraag' => 'Hoe zou je dit concept toepassen in de praktijk?', 'antwoord' => 4],
                    ['vraag' => 'Welke uitdagingen verwacht je?', 'antwoord' => 2],
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hoofdthema_id' => 2,
                'deelthema_id' => 3,
                'user_id' => 2, // Regular User
                'uitdaging_id' => 4, // Experimenteren uitdaging voor Deelthema 2A
                'uitslag' => json_encode([
                    ['vraag' => 'Wat is het belangrijkste aspect van Deelthema 2A?', 'antwoord' => 4],
                    ['vraag' => 'Hoe zou je dit concept toepassen in het dagelijks leven?', 'antwoord' => 5],
                    ['vraag' => 'Welke factoren beïnvloeden de toepassing?', 'antwoord' => 3],
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
