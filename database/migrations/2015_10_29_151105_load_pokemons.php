<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LoadPokemons extends Migration
{
    protected $amount = 718;

    public function up()
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $client = new GuzzleHttp\Client(['base_uri' => 'http://pokeapi.co/api/v1/pokemon/']);

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
                    $output->writeln('created #' . $pokemon->id . ' - ' . $pokemon->name);

                    $typeNames = array_column($body['types'], 'name');
                    $typeIds = \App\Type::whereIn('name', $typeNames)->lists('id');
                    $pokemon->types()->sync($typeIds);
                    $output->writeln('attached types ' . $pokemon->types()->lists('id') . ' to #' . $pokemon->id);

                    $moveNames = array_column($body['moves'], 'name');
                    $moveIds = \App\Move::whereIn('name', $moveNames)->lists('id');
                    $pokemon->moves()->sync($moveIds);
                    $output->writeln('attached moves ' . $pokemon->moves()->lists('id') . ' to #' . $pokemon->id);
                }
            }
        }
        $output->writeln('created ' . \App\Pokemon::count() . ' pokemons');
    }

    public function down()
    {
    }
}
