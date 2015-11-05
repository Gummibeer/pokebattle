<?php
namespace App\Console\Commands;

use App\Libs\PokemonFight;
use App\User;
use Illuminate\Console\Command;

class LoadMoves extends Command
{
    protected $signature = 'load:moves';
    protected $description = 'Load all moves via curl from the PokeAPI.';
    protected $amount = 625;

    public function handle()
    {
        $client = new GuzzleHttp\Client(['base_uri' => 'http://pokeapi.co/api/v1/move/']);

        $bar = $this->output->createProgressBar($this->amount);
        for ($i = 1; $i <= $this->amount; $i++) {
            $response = $client->request('GET', $i);
            if ($response->getStatusCode() == 200) {
                $body = json_decode((string)$response->getBody(), true);
                if ($body['power'] >= 10) {
                    \App\Move::create($body);
                }
            }
            $bar->advance();
        }
        $bar->finish();
        $this->info('created ' . \App\Move::count() . ' moves');
    }
}
