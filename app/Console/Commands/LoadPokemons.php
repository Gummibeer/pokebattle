<?php
namespace App\Console\Commands;

use App\Libs\PokemonFight;
use App\User;
use Illuminate\Console\Command;

class LoadPokemons extends Command
{
    protected $signature = 'load:pokemons';
    protected $description = 'Load all pokemons via curl from the PokeAPI.';
    protected $amount = 720;

    public function handle()
    {
        $client = new GuzzleHttp\Client(['base_uri' => 'http://pokeapi.co/api/v1/pokemon/']);

        $bar = $this->output->createProgressBar($this->amount);
        for ($i = 1; $i <= $this->amount; $i++) {
            $response = $client->request('GET', $i);
            if ($response->getStatusCode() == 200) {
                $body = json_decode((string)$response->getBody(), true);
                if (count($body['moves']) > 0 && count($body['types']) > 0) {
                    $pokemon = \App\Pokemon::create([
                        'id' => $body['national_id'],
                        'name' => $body['name'],
                        'health' => $body['hp'],
                        'attack' => $body['attack'],
                        'defense' => $body['defense'],
                        'speed' => $body['speed'],
                        'experience' => $body['exp'],
                    ]);

                    $typeNames = array_column($body['types'], 'name');
                    $typeIds = \App\Type::whereIn('name', $typeNames)->lists('id')->toArray();
                    $pokemon->types()->sync($typeIds);

                    $moveNames = array_column($body['moves'], 'name');
                    $moveIds = \App\Move::whereIn('name', $moveNames)->lists('id')->toArray();
                    $pokemon->moves()->sync($moveIds);
                }
            }
            $bar->advance();
        }
        $bar->finish();
        $this->info('created ' . \App\Pokemon::count() . ' pokemons');
    }
}
