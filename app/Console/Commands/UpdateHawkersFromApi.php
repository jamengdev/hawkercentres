<?php

namespace App\Console\Commands;

use App\Models\Hawkers;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateHawkersFromApi extends Command
{
    protected $signature = 'hc:update-hawkers';

    protected $description = 'Update hawkers from data gov api';

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
                    ->update(['api_data' => collect($hawker)]);
            }

            $apiOffsetCount += $apiPerPageCount;
        } while ($stillHasPages);

        $this->line("Updated ${dbUpdatedCount} hawkers!");

        return Command::SUCCESS;
    }
}
