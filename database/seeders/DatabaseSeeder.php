<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@rocgilde.nl',
                'is_admin' => 1,
                'password' => Hash::make('gildeDEVOPS$123'),
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

        DB::table('hoofdthemas')->insert([
            [
                'naam' => 'Differentiatie',
                'beschrijving' => 'Differentiatie',
                'content' => '<h1>Korte beschrijving over differentiatie</h1>',
                'media' => 'https://www.youtube.com/watch?v=ML20TvWphoA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('deelthemas')->insert([
            // Deelthema's voor Hoofdthema 1
            [
                'naam' => 'Onderwijs behoefte bepalen',
                'beschrijving' => 'Beschrijving voor Onderwijs behoefte bepalen',
                'vragen' => json_encode([
                    ['vraag' => 'Ik deel studenten in op basis van onderwijsbehoefte'],
                    ['vraag' => 'Ik ben voordurend op de hoogte van de onderwijsbehoefte van mijn studenten en gebruik deze om (tussentijds) te differentieren '],
                    ['vraag' => 'Ik laat de studenten zelf hun onderwijsbehoefte bepalen']
                ]),
                'content' => 'Onderwijs behoefte bepalen',
                'hoofdthema_id' => 1,
                'media' => 'https://www.youtube.com/watch?v=ML20TvWphoA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Groepsplan',
                'beschrijving' => 'Beschrijving voor Groepsplan',
                'vragen' => json_encode([
                    ['vraag' => 'Ik maak een groepsplan voor de lessen '],
                    ['vraag' => 'Ik cluster de onderwijsbehoefte en deel mijn studenten in groepen '],
                    ['vraag' => 'Ik differenteer ( per subgroep) op basis van concrete leerdoelen']
                ]),
                'content' => 'Groepsplan',
                'hoofdthema_id' => 1,
                'media' => 'https://www.youtube.com/watch?v=ML20TvWphoA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Differentiatie in Instructie',
                'beschrijving' => 'Beschrijving voor Differentiatie in Instructie',
                'vragen' => json_encode([
                    ['vraag' => 'Ik geef sommige studenten een verlengde instructie'],
                    ['vraag' => 'Ik laat sommige studenten de instructie niet volgen'],
                    ['vraag' => 'Ik differentieer op inhoud van de lesstof'],
                    ['vraag' => 'Ik organiseer begeleidingsmomenten specifiek voor studenten die de lesstof op een ander niveau verwerken']
                ]),
                'content' => 'Differentiatie in Instructie',
                'hoofdthema_id' => 1,
                'media' => 'https://www.youtube.com/watch?v=ML20TvWphoA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('uitdagings')->insert([
            // Uitdagingen voor Deelthema
            [
                'deelthema_id' => 1,
                'niveau' => 'experimenteren',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Kies een les waarvan het doel concreet en helder is. Ga voor jezelf na wat je studenten nodig hebben om dit doel te behalen. Gebruik de verschillende manieren die in het filmpje aan bod zijn gekomen en ook eventueel de voorbeelden uit de groslijst ter inspiratie. Wat voor inhoud heeft de student nodig, wat voor docent, wat voor omgeving heeft de student nodig, etc.? Verzamel de onderwijsbehoeften ook door te observeren tijdens de les. '],
                    ['opdracht' => 'Maak een lijst van onderwijsbehoeften.'],
                    ['opdracht' => 'Vraag een collega om feedback.']
                ]),
                'validatie' => 'Validatie Onderwijs behoefte bepalen experimenteren.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'deelthema_id' => 1,
                'niveau' => 'toepassen',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Kies een les waarvan het doel concreet en helder is. Ga voor jezelf na wat je studenten nodig hebben om dit doel te behalen. Maak een lijst van onderwijsbehoeften en ga op zoek naar de overeenkomsten. Welke studenten hebben dezelfde aanpak nodig? Werk eventueel met kleuren en probeer om maximaal 3 kleuren te gebruiken. Zo verdeel je de groep in 3 groepen met hun eigen aanpak om het lesdoel te bereiken. '],
                    ['opdracht' => 'Vraag een collega om feedback.  ']
                ]),
                'validatie' => 'Validatie Onderwijs behoefte bepalen toepassen.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'deelthema_id' => 1,
                'niveau' => 'verdiepen',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Kies een les waarvan het doel concreet en helder is. Ga voor jezelf na wat je studenten nodig hebben om dit doel te behalen. Maak voor jezelf een indeling in onderwijsbehoeften. Vervolgens ga je in gesprek met de studenten over hun behoeften. Experimenteer met als doel om de studenten zelf aan te laten geven wat zij van jou als docent, van de omgeving, de inhoud van de les etc. nodig hebben om het lesdoel te behalen. Werk eens met de gegevens vanuit de studenten en evalueer met de studenten.'],
                    ['opdracht' => 'Vraag een collega of student om feedback.']
                ]),
                'validatie' => 'Validatie Onderwijs behoefte bepalen verdiepen.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'deelthema_id' => 2,
                'niveau' => 'experimenteren',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Vul, op basis van opgehaalde onderwijsbehoeften, een groepsplan in voor je klas. Kies 1 hoofddoel dat je met de les wil bereiken. Verdeel je groep in 3 subgroepen (basis, instructiegevoelig en instructieonafhankelijk). Werk met een groepsplan of Mickey Mouse, afhankelijk van je voorkeur of experimenteer met beide modellen. Beschrijf kort de aanpak per subgroep: hoe gaan ze het hoofddoel bereiken. Zorg er hierbij voor dat het hoofddoel concreet en klein is.'],
                    ['opdracht' => 'Vraag een collega om feedback.']
                ]),
                'validatie' => 'Validatie Groepsplan experimenteren.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'deelthema_id' => 2,
                'niveau' => 'toepassen',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Vul, op basis van opgehaalde onderwijsbehoeften, een groepsplan in voor je klas. Verdeel je groep in 3 subgroepen (basis, instructiegevoelig en instructieonafhankelijk). Werk met een groepsplan of Mickey Mouse, afhankelijk van je voorkeur of experimenteer met beide modellen. Kies voor elke subgroep een doel. Zorg ervoor dat de doelen voor de subgroepen concreet en klein zijn. Beschrijf kort de aanpak per subgroep.'],
                    ['opdracht' => 'Vraag een collega om feedback.']
                ]),
                'validatie' => 'Validatie Groepsplan toepassen.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'deelthema_id' => 2,
                'niveau' => 'verdiepen',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Vul, op basis van opgehaalde onderwijsbehoeften, een groepsplan in voor je klas. Verdeel je groep in 3 subgroepen (basis, instructiegevoelig en instructieonafhankelijk) en kijk ook naar studenten die buiten deze 3 groepen vallen (oorbellen van de MM). Werk met een groepsplan of Mickey Mouse, afhankelijk van je voorkeur of experimenteer met beide modellen. Kies voor elke subgroep een doel. Zorg ervoor dat de doelen voor de subgroepen concreet en klein zijn. Beschrijf kort de aanpak per subgroep en bedenk hoe je de studenten die intensieve begeleiding nodig hebben (bij Mickey Mouse zijn dit de oorbellen) gaat ondersteunen of uitdagen.'],
                    ['opdracht' => 'Vraag een collega om feedback.']
                ]),
                'validatie' => 'Validatie Groepsplan verdiepen.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'deelthema_id' => 3,
                'niveau' => 'experimenteren',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Maak met behulp van een groepsplan een indeling van je studenten en bereid daarop je instructie voor. Je geeft een basisinstructie en een verlengde instructie. Geef de instructie en evalueer met je studenten.'],
                    ['opdracht' => 'Beschrijf ook wat de studenten gaan doen na de basisinstructie en spreek ook af hoe.'],
                    ['opdracht' => 'Vraag je studenten of een collega om feedback.']
                ]),
                'validatie' => 'Validatie Differentiatie in Instructie experimenteren.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'deelthema_id' => 3,
                'niveau' => 'toepassen',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Maak met behulp van een groepsplan een indeling van je studenten en bereid daarop je instructie voor. Je geeft een basisinstructie en een verlengde instructie. Geef bij je voorbereiding extra aandacht aan je looprondes. Hoe ga je deze inzetten? Bespreek een manier waarop je deze uitgestelde aandacht vorm geeft. Wanneer je dit al vaker doet, experimenteer dan ook eens met het instappen en uitstappen tijdens je instructie.'],
                    ['opdracht' => 'Evalueer met je studenten en heb daarbij vooral aandacht voor de eigen keuze van de student. Is het gelukt om in te stappen wanneer je er toch niet uitkwam? Ben je te vroeg uitgestapt? Heb jij als docent de studenten juist ingeschat voor dit lesdoel?'],
                    ['opdracht' => 'Vraag je studenten of een collega om feedback.']
                ]),
                'validatie' => 'Validatie Differentiatie in Instructie toepassen.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'deelthema_id' => 3,
                'niveau' => 'verdiepen',
                'opdrachten' => json_encode([
                    ['opdracht' => 'Laat de studenten, nadat je het lesdoel met ze besproken hebt, zelf aangeven of ze al zelfstandig vooruit kunnen of nog een instructie willen. Zorg ervoor dat de instap en uitstap wel mogelijk blijft. Het doel van deze opdracht is vooral de evaluatie met de studenten. Zijn ze in staat om zichzelf goed in te schatten? Maar voor jezelf vooraf wel een indeling (groepsplan), zodat je ook je eigen indeling kunt evalueren. Ook heb je zo gespreksstof met de studenten, wanneer zij zichzelf anders indelen dan jij had gedacht. '],
                    ['opdracht' => 'Vraag je studenten of een collega om feedback.']
                ]),
                'validatie' => 'Validatie Differentiatie in Instructie verdiepen.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}
/**
 * Seed the application's database.
 */
//    public function run(): void
//    {
//        // Seed users table
//        DB::table('users')->insert([
//            [
//                'name' => 'Admin User',
//                'email' => 'admin@rocgilde.nl',
//                'is_admin' => 1,
//                'password' => Hash::make('password'),
//                'email_verified_at' => now(),
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'name' => 'Regular User',
//                'email' => 'user@rocgilde.nl',
//                'is_admin' => 0,
//                'password' => Hash::make('password'),
//                'email_verified_at' => now(),
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//        ]);
//
//        DB::table('home')->insert([
//            'content' => '<h1>Welkom op onze website</h1><p>Dit is een voorbeeld van inhoud in HTML-formaat.</p>',
//            'media' => 'https://www.youtube.com/watch?v=ML20TvWphoA',
//            'created_at' => now(),
//            'updated_at' => now(),
//        ]);
//
//        // Seed hoofdthemas table
//        DB::table('hoofdthemas')->insert([
//            [
//                'naam' => 'Hoofdthema 1',
//                'beschrijving' => 'Beschrijving voor Hoofdthema 1',
//                'content' => 'Content voor Hoofdthema 1',
//                'media' => 'https://www.youtube.com/watch?v=ML20TvWphoA',
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'naam' => 'Hoofdthema 2',
//                'beschrijving' => 'Beschrijving voor Hoofdthema 2',
//                'content' => 'Content voor Hoofdthema 2',
//                'media' => 'https://www.youtube.com/watch?v=ML20TvWphoA',
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//        ]);
//
//        // Seed deelthemas table
//        DB::table('deelthemas')->insert([
//            // Deelthema's voor Hoofdthema 1
//            [
//                'naam' => 'Deelthema 1A',
//                'beschrijving' => 'Beschrijving voor Deelthema 1A',
//                'vragen' => json_encode([
//                    ['vraag' => 'Wat is het belangrijkste aspect van Deelthema 1A?'],
//                    ['vraag' => 'Hoe zou je dit concept toepassen in de praktijk?'],
//                    ['vraag' => 'Welke uitdagingen verwacht je?']
//                ]),
//                'content' => 'Content voor Deelthema 1A',
//                'hoofdthema_id' => 1,
//                'media' => 'https://www.youtube.com/watch?v=ML20TvWphoA',
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'naam' => 'Deelthema 1B',
//                'beschrijving' => 'Beschrijving voor Deelthema 1B',
//                'vragen' => json_encode([
//                    ['vraag' => 'Wat is de kern van Deelthema 1B?'],
//                    ['vraag' => 'Hoe zou je dit concept toepassen in het dagelijks leven?'],
//                    ['vraag' => 'Welke factoren beïnvloeden de toepassing?']
//                ]),
//                'content' => 'Content voor Deelthema 1B',
//                'hoofdthema_id' => 1,
//                'media' => 'https://www.youtube.com/watch?v=ML20TvWphoA',
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            // Deelthema's voor Hoofdthema 2
//            [
//                'naam' => 'Deelthema 2A',
//                'beschrijving' => 'Beschrijving voor Deelthema 2A',
//                'vragen' => json_encode([
//                    ['vraag' => 'Wat is het belangrijkste aspect van Deelthema 2A?'],
//                    ['vraag' => 'Hoe zou je dit concept toepassen in de praktijk?'],
//                    ['vraag' => 'Welke uitdagingen verwacht je?']
//                ]),
//                'content' => 'Content voor Deelthema 2A',
//                'hoofdthema_id' => 2,
//                'media' => 'https://www.youtube.com/watch?v=ML20TvWphoA',
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'naam' => 'Deelthema 2B',
//                'beschrijving' => 'Beschrijving voor Deelthema 2B',
//                'vragen' => json_encode([
//                    ['vraag' => 'Wat is de kern van Deelthema 2B?'],
//                    ['vraag' => 'Hoe zou je dit concept toepassen in het dagelijks leven?'],
//                    ['vraag' => 'Welke factoren beïnvloeden de toepassing?']
//                ]),
//                'content' => 'Content voor Deelthema 2B',
//                'hoofdthema_id' => 2,
//                'media' => 'https://www.youtube.com/watch?v=ML20TvWphoA',
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//        ]);
//
//        // Seed uitdagings table
//        DB::table('uitdagings')->insert([
//            // Uitdagingen voor Deelthema 1A
//            [
//                'deelthema_id' => 1,
//                'niveau' => 'experimenteren',
//                'opdrachten' => json_encode([
//                    ['opdracht' => 'Voer een experiment uit met Deelthema 1A.'],
//                    ['opdracht' => 'Documenteer de resultaten.']
//                ]),
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'deelthema_id' => 1,
//                'niveau' => 'toepassen',
//                'opdrachten' => json_encode([
//                    ['opdracht' => 'Pas Deelthema 1A toe in een praktijkcase.'],
//                    ['opdracht' => 'Maak een evaluatieverslag.']
//                ]),
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'deelthema_id' => 1,
//                'niveau' => 'verdiepen',
//                'opdrachten' => json_encode([
//                    ['opdracht' => 'Schrijf een verdiepende paper over Deelthema 1A.'],
//                    ['opdracht' => 'Geef een presentatie over je inzichten.']
//                ]),
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            // Uitdagingen voor Deelthema 1B
//            [
//                'deelthema_id' => 2,
//                'niveau' => 'experimenteren',
//                'opdrachten' => json_encode([
//                    ['opdracht' => 'Voer een experiment uit met Deelthema 1B.'],
//                    ['opdracht' => 'Documenteer de resultaten.']
//                ]),
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'deelthema_id' => 2,
//                'niveau' => 'toepassen',
//                'opdrachten' => json_encode([
//                    ['opdracht' => 'Pas Deelthema 1B toe in een praktijkcase.'],
//                    ['opdracht' => 'Maak een evaluatieverslag.']
//                ]),
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'deelthema_id' => 2,
//                'niveau' => 'verdiepen',
//                'opdrachten' => json_encode([
//                    ['opdracht' => 'Schrijf een verdiepende paper over Deelthema 1B.'],
//                    ['opdracht' => 'Geef een presentatie over je inzichten.']
//                ]),
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            // Uitdagingen voor Deelthema 2A
//            [
//                'deelthema_id' => 3,
//                'niveau' => 'experimenteren',
//                'opdrachten' => json_encode([
//                    ['opdracht' => 'Voer een experiment uit met Deelthema 2A.'],
//                    ['opdracht' => 'Documenteer de resultaten.']
//                ]),
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'deelthema_id' => 3,
//                'niveau' => 'toepassen',
//                'opdrachten' => json_encode([
//                    ['opdracht' => 'Pas Deelthema 2A toe in een praktijkcase.'],
//                    ['opdracht' => 'Maak een evaluatieverslag.']
//                ]),
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'deelthema_id' => 3,
//                'niveau' => 'verdiepen',
//                'opdrachten' => json_encode([
//                    ['opdracht' => 'Schrijf een verdiepende paper over Deelthema 2A.'],
//                    ['opdracht' => 'Geef een presentatie over je inzichten.']
//                ]),
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            // Uitdagingen voor Deelthema 2B
//            [
//                'deelthema_id' => 4,
//                'niveau' => 'experimenteren',
//                'opdrachten' => json_encode([
//                    ['opdracht' => 'Voer een experiment uit met Deelthema 2B.'],
//                    ['opdracht' => 'Documenteer de resultaten.']
//                ]),
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'deelthema_id' => 4,
//                'niveau' => 'toepassen',
//                'opdrachten' => json_encode([
//                    ['opdracht' => 'Pas Deelthema 2B toe in een praktijkcase.'],
//                    ['opdracht' => 'Maak een evaluatieverslag.']
//                ]),
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'deelthema_id' => 4,
//                'niveau' => 'verdiepen',
//                'opdrachten' => json_encode([
//                    ['opdracht' => 'Schrijf een verdiepende paper over Deelthema 2B.'],
//                    ['opdracht' => 'Geef een presentatie over je inzichten.']
//                ]),
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//        ]);
//
//        // Seed zelftoets table
//        DB::table('zelftoets')->insert([
//            [
//                'hoofdthema_id' => 1,
//                'deelthema_id' => 1,
//                'user_id' => 1, // Admin User
//                'uitdaging_id' => 1, // Experimenteren uitdaging voor Deelthema 1A
//                'uitslag' => json_encode([
//                    ['vraag' => 'Wat is het belangrijkste aspect van Deelthema 1A?', 'antwoord' => 3],
//                    ['vraag' => 'Hoe zou je dit concept toepassen in de praktijk?', 'antwoord' => 4],
//                    ['vraag' => 'Welke uitdagingen verwacht je?', 'antwoord' => 2],
//                ]),
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'hoofdthema_id' => 2,
//                'deelthema_id' => 3,
//                'user_id' => 2, // Regular User
//                'uitdaging_id' => 4, // Experimenteren uitdaging voor Deelthema 2A
//                'uitslag' => json_encode([
//                    ['vraag' => 'Wat is het belangrijkste aspect van Deelthema 2A?', 'antwoord' => 4],
//                    ['vraag' => 'Hoe zou je dit concept toepassen in het dagelijks leven?', 'antwoord' => 5],
//                    ['vraag' => 'Welke factoren beïnvloeden de toepassing?', 'antwoord' => 3],
//                ]),
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//        ]);
//    }
