<?php
namespace App\Console\Commands;

use App\Libs\PokemonFight;
use App\User;
use Illuminate\Console\Command;

class LoadTypes extends Command
{
    protected $signature = 'load:types';
    protected $description = 'Load all types via curl from the PokeAPI.';
    protected $amount = 20;

    public function handle()
    {
        $client = new GuzzleHttp\Client(['base_uri' => 'http://pokeapi.co/api/v1/type/']);

        $typeEffectRelations = [];

        $bar = $this->output->createProgressBar($this->amount);
        for ($i = 1; $i <= $this->amount; $i++) {
            $response = $client->request('GET', $i);
            if ($response->getStatusCode() == 200) {
                $body = json_decode((string)$response->getBody(), true);
                $type = \App\Type::create([
                    'id' => $body['id'],
                    'name' => strtolower($body['name']),
                ]);
                $typeEffectRelations[$type->id] = [
                    'ineffective' => array_column($body['ineffective'], 'name'),
                    'effective' => array_column($body['super_effective'], 'name'),
                ];
            }
            $bar->advance();
        }
        $bar->finish();
        $this->info('created ' . \App\Type::count() . ' types');

        $bar = $this->output->createProgressBar(count($typeEffectRelations));
        foreach ($typeEffectRelations as $id => $data) {
            $type = \App\Type::find($id);
            $typeNames = $data['ineffective'];
            $typeIds = \App\Type::whereIn('name', $typeNames)->lists('id')->toArray();
            $type->types()->attach($typeIds, ['value' => -1]);

            $typeNames = $data['effective'];
            $typeIds = \App\Type::whereIn('name', $typeNames)->lists('id')->toArray();
            $type->types()->attach($typeIds, ['value' => 1]);
            $bar->advance();
        }
        $bar->finish();
        $this->info('connected all types with theyr ineffectives & effectives.');
    }
}
