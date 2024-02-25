<?php

namespace App\Console\Commands;

use App\Models\IbanData;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

class FetchIbanData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'iban:fetch';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and store IBAN data from IBAN.com';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();
        $ibanPageUrl = 'https://www.iban.com/structure';
        $response = $client->request('GET', $ibanPageUrl);
        $html = $response->getBody()->getContents();

        $crawler = new Crawler($html);

        if ($crawler->filter('table.table-bordered')->count() === 0) {
            $this->error('Table not found in HTML!');
            return;
        }

        $ibanData = $crawler->filter('div.register.structure table.table-bordered tbody tr')->each(function (Crawler $node) {

            if ($node->count() === 0) {
                $this->warn('No rows found in table!');
                return null;
            }

            return [
                'country' => trim($node->filter('td')->eq(0)->text()),
                'code' => trim($node->filter('td')->eq(1)->text()),
                'length' => intval(trim($node->filter('td')->eq(3)->text())),
                'format' => trim($node->filter('td')->eq(6)->text()),
            ];
        });

        foreach ($ibanData as $data) {

            IbanData::updateOrCreate(
                ['code' => $data['code']],
                $data
            );

        }


        $this->info('IBAN data fetched and stored successfully!');
    }
}
