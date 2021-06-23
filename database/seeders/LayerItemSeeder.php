<?php

namespace Database\Seeders;

use App\Models\LayerItem;
use Database\Factories\LayerItemFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class LayerItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array (
            0 =>
                array (
                    'title' => 'Het oude nest',
                    'body' => 'Een familie bestaat uit ouders en kinderen en in de situatie van bedrijfsovername is meestal minimaal één ouder ook agrarisch ondernemer. Men kent elkaar door en door en de natuurlijke band blijft levenslang bestaan. De familie samenstelling is overal uniek en de posities in het gezin en rollen veranderen ook in loop van de tijd. Kind wordt ouder en kind wordt mogelijk mede ondernemer. Een ouder blijft altijd een ouder, maar als een kind ook mede ondernemer wordt verandert er wel iets in deze relatie en wordt men veel meer gelijkwaardige gesprekspartner. Als er één kind is en die wil en kan het bedrijf overnemen en de ouders willen het ook dan is de situatie relatief eenvoudig. Maar mogelijk willen meerdere kinderen wel het bedrijf in of ze weten het nog niet. Andere kinderen hebben mogelijk heel andere plannen en verwachten misschien ook wel support van hun ouders. Veelal is het wonen en het bedrijf nauw met elkaar verbonden en alle kinderen krijgen automatische het een en ander mee wat agrarische ondernemerschap inhoudt.',
                ),
            1 =>
                array (
                    'title' => 'Liefdes nest',
                    'body' => 'Programma over liefde en relaties in de weekende gepresenteerd door Christine van der Horst en op werkdagen door Carolina Mout. Het programma wordt laat in de nacht uitgezonden voor zij die niet gaan stappen, maar lekker thuis zitten. Liefdesnest wordt uitgezonden als onderdeel van Call TV. Na een aantal maanden verzorgt Inge Ipenburg de presentatie voor de uitzendingen doordeweeks.',
                ),
            2 =>
                array (
                    'title' => 'Rechte pad',
                    'body' => 'Helaas loopt niet altijd alles zoals gepland. En daarom is het goed om na te denken wat er verkeerd kan gaan en hoe men dan vindt hoe hier mee om moet worden gegaan. Zolang alles nog goed is en iedereen nog aanwezig kunnen afspraken altijd worden aangepast. Is het niet het geval dan is het goed dat wensen zijn vertaald in juridische afspraken.',
                ),
            3 =>
                array (
                    'title' => 'Financiële moeras',
                    'body' => '',
                ),
            4 =>
                array (
                    'title' => 'De rustige weide',
                    'body' => '',
                ),
            5 =>
                array (
                    'title' => 'De steile helling',
                    'body' => '',
                ),
            6 =>
                array (
                    'title' => 'De vergezichten',
                    'body' => '',
                ),
            7 =>
                array (
                    'title' => 'Samenwerk samenland',
                    'body' => '',
                ),
            8 =>
                array (
                    'title' => 'Het ambacht',
                    'body' => '',
                ),
            9 =>
                array (
                    'title' => 'Marktplaats',
                    'body' => '',
                ),
            10 =>
                array (
                    'title' => 'Nabije omgeving',
                    'body' => '',
                ),
            11 =>
                array (
                    'title' => 'Politieke oerwoud',
                    'body' => '',
                ),
            12 =>
                array (
                    'title' => 'Sparren bos',
                    'body' => '',
                ),
            13 =>
                array (
                    'title' => 'Speelweide',
                    'body' => '',
                ),
            14 =>
                array (
                    'title' => 'Ondernemingsvorm',
                    'body' => 'De keuze van de ondernemingsvorm/rechtsvorm heeft onder andere invloed op fiscale behandeling, de persoonlijke aansprakelijkheid van de ondernemer(s), wat voor samenwerkings afspraken er gemaakt moeten, hoe gaat het verder als er ongeplande vervelende dingen gebeuren en hoe gaat de overdracht van de bezittingen naar de opvolger. Bij de Eenmanszaak, Maatschap en VOF is er sprake van natuurlijke personen, de ondernemers vallen onder de inkomstenbelasting, zijn hoofdelijk aansprakelijk voor schulden, de samenwerking en inbreng van de activa, winstverdeling is zelf af te spreken. Wel moeten hier goede afspraken worden gemaakt als er wat onverwachts gebeurt en ooit komt er een moment dat naar de notaris zal worden gegaan om de activa over te dragen. Een BV is een rechtspersoon en kan dus eigen activa (bijvoorbeeld grond, gebouwen) in bezit hebben en de BV betaalt Vennootschapsbelasting over de gerealiseerde winst. Deze rechtspersoon kan ook aansprakelijk worden gesteld, waarbij de aandeelhouders buitenschot blijven (uitzonderlingen daargelaten). De ondernemers zijn dan in loondienst bij de eigen BV. Vermogen kan bijvoorbeeld onttrokken worden uit de BV in de vorm van dividend uitkering. Deze is dan wel weer in de inkomstenbelastingsfeer belast. Omdat het een rechtspersoon is, met eigen bezittingen en schulden is de continuïteit niet direct afhankelijk van de een of enkele personen. Ook kunnen er combinaties van rechtsvormen voorkomen, elk met eigen activiteiten en activa. De keuze van de juiste rechtsvorm(en) kan uitdagend zijn en verkeerde beslissingen kunnen grote gevolgen hebben.',
                ),
        );

        $json = File::get("database/data/LayerItem.json");
        $data = json_decode($json);
        foreach($data as $obj){
            $body = $obj->body == '' ? "Nog te omschrijven..." : $obj->body;

            Layeritem::create(array(
                'title' => $obj->title,
                'body' => $body,
                'level' => 1
            ));
        }


    }
}
