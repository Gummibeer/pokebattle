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
                if(count($body['moves']) > 0 && count($body['types']) > 0) {
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
                    foreach ($body['types'] as $type) {
                        $type = \App\Type::name($type['name'])->first();
                        if (!is_null($type)) {
                            $pokemon->types()->attach($type->id);
                        }
                    }
                    $output->writeln('attached types ' . $pokemon->types()->lists('id') . ' to #' . $pokemon->id);
                    foreach ($body['moves'] as $move) {
                        $move = \App\Move::name($move['name'])->first();
                        if (!is_null($move)) {
                            $pokemon->moves()->attach($move->id);
                        }
                    }
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
