<?php

namespace App\Console\Commands;

use App\Models\Hawkers;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Str;

class UpdateHawkersFromApi extends Command
{
    protected $signature = 'hc:update-hawkers';

    protected $description = 'Update hawkers from data gov api';

    protected $urlMapping = [
        ["key" => "Adam Road Food Centre", "value" => "adam-road-food-centre"],
        ["key" => "Aljunied Ave 2 Blk 117 (Blk 117 Aljunied Market and Food Centre)", "value" => "aljunied-market-and-food-centre"],
        ["key" => "Amoy Street Food Centre (Telok Ayer Food Centre)", "value" => "amoy-street-food-centre"],
        ["key" => "Ang Mo Kio Ave 1 Blk 226D (Kebun Baru Market and Food Centre)", "value" => "kebun-baru-market-and-food-centre"],
        ["key" => "Ang Mo Kio Ave 1 Blk 341 (Teck Ghee Court)", "value" => "teck-ghee-court"],
        ["key" => "Ang Mo Kio Ave 10 Blk 409 (Teck Ghee Square)", "value" => "teck-ghee-square"],
        ["key" => "Ang Mo Kio Ave 10 Blk 453A (Chong Boon Market and Food Centre)", "value" => "chong-boon-market-and-food-centre"],
        ["key" => "Ang Mo Kio Ave 10 Blk 527 (Cheng San Market and Cooked Food Centre)", "value" => "cheng-san-market-and-cooked-food-centre"],
        ["key" => "Ang Mo Kio Ave 4 Blk 160/162 (Mayflower Market)", "value" => "mayflower-market"],
        ["key" => "Ang Mo Kio Ave 4 Blk 628 (Ang Mo Kio 628 Market)", "value" => "ang-mo-kio-628-market"],
        ["key" => "Circuit Road Blk 79/79A", "value" => "circuit-road-blk-79-79a"],
        ["key" => "Ang Mo Kio Ave 6 Blk 724 (Blk 724 Ang Mo Kio Market)", "value" => "blk-724-ang-mo-kio-market"],
        ["key" => "Ang Mo Kio Street 22 Blk 226H (Kebun Baru Food Centre)", "value" => "kebun-baru-food-centre"],
        ["key" => "Bedok Food Centre", "value" => "bedok-food-centre"],
        ["key" => "Bedok North Street 1 Blk 216", "value" => "bedok-north-street-1-blk-216"],
        ["key" => "Havelock Road Blk 22A/B (Havelock Road Cooked Food Centre)", "value" => "havelock-road-cooked-food-centre"],
        ["key" => "Bedok North Street 3 Blk 511 (Kaki Bukit 511 Market and Food Centre)", "value" => "kaki-bukit-511-market-and-food-centre"],
        ["key" => "Bedok North Street 3 Blk 538", "value" => "bedok-north-street-3-blk-538"],
        ["key" => "Bedok North Street 4 Blk 85 (85 Fengshan Centre)", "value" => "85-fengshan-centre"],
        ["key" => "Bedok Reservoir Road Blk 630", "value" => "Bedok Reservoir Road Blk 630"],
        ["key" => "New Upper Changi Road Blk 208B (Bedok Interchange Hawker Centre)", "value" => "bedok-interchange-hawker-centre"],
        ["key" => "Bedok South Road Blk 16", "value" => ""],
        ["key" => "Bendemeer Road Blk 29 (Bendemeer Market and Food Centre)", "value" => ""],
        ["key" => "Beo Crescent Market", "value" => ""],
        ["key" => "Berseh Food Centre", "value" => ""],
        ["key" => "Circuit Road Blk 80 (80 Circuit Road Market and Food Centre)", "value" => ""],
        ["key" => "Boon Lay Place Blk 221A/B (Boon Lay Place Market and Food Village)", "value" => ""],
        ["key" => "Buffalo Road Blk 665 (Tekka Centre/Zhu Jiao Market)", "value" => ""],
        ["key" => "Bukit Merah Central Blk 163 (Bukit Merah Central Food Centre)", "value" => ""],
        ["key" => "Bukit Merah Lane 1 Blk 120 (Alexandra Village Food Centre)", "value" => ""],
        ["key" => "Bukit Merah View Blk 115 (Blk 115 Bukit Merah View Market and Food Centre)", "value" => ""],
        ["key" => "Bukit Panjang Hawker Centre and Market", "value" => ""],
        ["key" => "Bukit Timah Market", "value" => ""],
        ["key" => "Cambridge Road Blk 41A (Pek Kio Market and Food Centre)", "value" => ""],
        ["key" => "Changi Village Blk 2 and 3", "value" => ""],
        ["key" => "Chomp Chomp Food Centre", "value" => ""],
        ["key" => "Ci Yuan Hawker Centre", "value" => ""],
        ["key" => "Circuit Road Blk 89", "value" => ""],
        ["key" => "Clementi Ave 2 Blk 353 (Clementi Ave 2 Market/Cooked Food Centre)", "value" => ""],
        ["key" => "Clementi Ave 3 Blk 448", "value" => ""],
        ["key" => "Clementi West Street 2 Blk 726", "value" => ""],
        ["key" => "Fernvale Hawker Centre and Market", "value" => ""],
        ["key" => "Commonwealth Crescent Market", "value" => ""],
        ["key" => "Dunman Food Centre", "value" => ""],
        ["key" => "East Coast Lagoon Food Village", "value" => ""],
        ["key" => "Empress Road Blk 7 (Empress Road Market and Food Centre)", "value" => ""],
        ["key" => "Eunos Crescent Blk 4A", "value" => ""],
        ["key" => "Geylang Bahru Blk 69 (Blk 69 Geylang Bahru Market and Food Centre)", "value" => ""],
        ["key" => "Geylang Serai Market", "value" => ""],
        ["key" => "Ghim Moh Road Blk 20", "value" => ""],
        ["key" => "Golden Mile Food Centre", "value" => ""],
        ["key" => "Haig Road Blk 13/14 (Haig Road Market and Cooked Food Centre)", "value" => ""],
        ["key" => "Tampines Street 11 Blk 137 (Tampines Round Market and Food Centre)", "value" => ""],
        ["key" => "Holland Drive Blk 44 (Holland Drive Market and Food Centre)", "value" => ""],
        ["key" => "Holland Village Market and Food Centre", "value" => ""],
        ["key" => "Hougang Ave 1 Blk 105 (Hougang 105 Hainanese Village Centre)", "value" => ""],
        ["key" => "Hougang Street 21 Blk 209 (Kovan Hougang Market and Food Centre)", "value" => ""],
        ["key" => "Jalan Batu Blk 4A (Blk 4A Jalan Batu Hawker Centre/Market)", "value" => ""],
        ["key" => "Jalan Bukit Merah Blk 112 (Blk 112 Jalan Bukit Merah Market and Food Centre)", "value" => ""],
        ["key" => "Jalan Bukit Merah Blk 6 (ABC Brickworks Market/Food Centre)", "value" => ""],
        ["key" => "Jalan Kukoh Blk 1 (Kukoh 21 Food Centre)", "value" => ""],
        ["key" => "Jurong East Ave 1 Blk 347 (Yuhua Market and Hawker Centre)", "value" => ""],
        ["key" => "Whampoa Drive Blk 91/92 (Whampoa Drive Makan Place/Whampoa Market)", "value" => ""],
        ["key" => "Jurong East Street 24 Blk 254 (Yuhua Village Market and Food Centre)", "value" => ""],
        ["key" => "Jurong West Hawker Centre", "value" => ""],
        ["key" => "Jurong West Street 52 Blk 505", "value" => ""],
        ["key" => "Kallang Estate Fresh Market and Food Centre", "value" => ""],
        ["key" => "Kampung Admiralty Hawker Centre", "value" => ""],
        ["key" => "Yishun Park Hawker Centre", "value" => ""],
        ["key" => "Margaret Drive Hawker Centre", "value" => ""],
        ["key" => "Marine Parade Central Blk 84 (84 Marine Parade Central Market and Food Centre)", "value" => ""],
        ["key" => "Marine Terrace Blk 50A (50A Marine Terrace)", "value" => ""],
        ["key" => "Market Street Hawker Centre", "value" => ""],
        ["key" => "Yishun Ring Road Blk 104/105 (Chong Pang Market and Food Centre)", "value" => ""],
        ["key" => "Marsiling Lane Blk 20/21", "value" => ""],
        ["key" => "Marsiling Mall Hawker Centre", "value" => ""],
        ["key" => "Maxwell Food Centre (Kim Hua Market)", "value" => ""],
        ["key" => "Mei Chin Road Blk 159 (Mei Chin Road Market)", "value" => ""],
        ["key" => "New Market Road Blk 32 (People's Park Food Centre)", "value" => ""],
        ["key" => "New Upper Changi Road Blk 58", "value" => ""],
        ["key" => "Newton Food Centre", "value" => ""],
        ["key" => "North Bridge Road Market", "value" => ""],
        ["key" => "Old Airport Road Blk 51 (51 Old Airport Road Food Centre and Shopping Mall)", "value" => ""],
        ["key" => "One Punggol Hawker Centre", "value" => ""],
        ["key" => "Our Tampines Hub", "value" => ""],
        ["key" => "Pasir Panjang Food Centre", "value" => ""],
        ["key" => "Pasir Ris Central Hawker Centre", "value" => ""],
        ["key" => "Queen Street Blk 270 (Albert Centre)", "value" => ""],
        ["key" => "Redhill Lane Blk 79 (Redhill Market)", "value" => ""],
        ["key" => "Redhill Lane Blk 85 (Redhill Food Centre)", "value" => ""],
        ["key" => "Taman Jurong Market and Food Centre", "value" => ""],
        ["key" => "Sembawang Hills Food Centre (Jalan Leban Food Centre)", "value" => ""],
        ["key" => "Serangoon Garden Market", "value" => ""],
        ["key" => "Shunfu Road Blk 320 (Shunfu Mart)", "value" => ""],
        ["key" => "Sims Place Blk 49 (Sims Vista Market and Food Centre)", "value" => ""],
        ["key" => "Smith Street Blk 335 (Chinatown Complex Market)", "value" => ""],
        ["key" => "Tanglin Halt Market", "value" => ""],
        ["key" => "Tanjong Pagar Plaza Blk 6 (Blk 6 Tanjong Pagar Plaza Market and Food Centre)", "value" => ""],
        ["key" => "Teban Gardens Road Blk 37A (Teban Gardens Market and Food Centre)", "value" => ""],
        ["key" => "Telok Blangah Crescent Blk 11 (11 Telok Blangah Crescent Market and Food Centre)", "value" => ""],
        ["key" => "Telok Blangah Drive Blk 79 (Telok Blangah Food Centre)", "value" => ""],
        ["key" => "Telok Blangah Drive Blk 82 (Telok Blangah Market)", "value" => ""],
        ["key" => "Telok Blangah Rise Blk 36 (Telok Blangah Rise Market)", "value" => ""],
        ["key" => "Tiong Bahru Market", "value" => ""],
        ["key" => "Toa Payoh Lorong 1 Blk 127 (Toa Payoh West Market and Food Court)", "value" => ""],
        ["key" => "Toa Payoh Lorong 4 Blk 74 (Toa Payoh Vista Market)", "value" => ""],
        ["key" => "Toa Payoh Lorong 4 Blk 93", "value" => ""],
        ["key" => "Toa Payoh Lorong 5 Blk 75", "value" => ""],
        ["key" => "Toa Payoh Lorong 7 Blk 22 (Kim Keat Palm Market and Food Centre)", "value" => ""],
        ["key" => "Toa Payoh Lorong 8 Blk 210", "value" => ""],
        ["key" => "Upper Boon Keng Road Blk 17 (Blk 17 Upper Boon Keng Market and Food Centre)", "value" => ""],
        ["key" => "Upper Cross Street Blk 531A (Hong Lim Food Centre and Market)", "value" => ""],
        ["key" => "West Coast Drive Blk 502 (Ayer Rajah Market)", "value" => ""],
        ["key" => "West Coast Drive Blk 503 (Ayer Rajah Food Centre)", "value" => ""],
        ["key" => "Whampoa Drive Blk 90 (Whampoa Drive Makan Place/Whampoa Food Centre)", "value" => ""],
        ["key" => "Zion Riverside Food Centre", "value" => ""],
    ];

    public function handle()
    {
        $dbUpdatedCount = 0;
        $apiOffsetCount = 0;
        $apiPerPageCount = 100;

        do {
            // call api friendly :)
            sleep(1);

            // data from https://data.gov.sg/dataset/dates-of-hawker-centres-closure
            $response = Http::retry(3, 300)->get('https://data.gov.sg/api/action/datastore_search', [
                'resource_id' => 'b80cb643-a732-480d-86b5-e03957bc82aa',
                'limit' => $apiPerPageCount,
                'offset' => $apiOffsetCount,
            ])->object();

            $stillHasPages = $response->result->total > $response->result->limit + $response->result->offset ? true : false;

            foreach ($response->result->records as $hawker) {
                $dbUpdatedCount++;
                Hawkers::firstOrCreate(['api_id' => $hawker->_id])
                    ->update([
                        'url' => $this->getSeoUrl(collect($hawker)['name']),
                        'api_data' => collect($hawker)
                    ]);
            }

            $apiOffsetCount += $apiPerPageCount;
        } while ($stillHasPages);

        $this->line("Updated ${dbUpdatedCount} hawkers!");

        return Command::SUCCESS;
    }

    protected function getSeoUrl($name)
    {
        $replaced = $name;
        $replaced = Str::replace('(', '', $replaced);
        $replaced = Str::replace(')', '', $replaced);
        $replaced = Str::replace('/', '-', $replaced);
        $replaced = Str::replace('\'', '', $replaced);
        $replaced = Str::of($replaced)->kebab();
        return $replaced->value;
    }
}
