<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LoadTypes extends Migration
{
    protected $amount = 18;

    public function up()
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $client = new GuzzleHttp\Client(['base_uri' => 'http://pokeapi.co/api/v1/type/']);

        $typeEffectRelations = [];
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
                $output->writeln('created #' . $type->id . ' - ' . $type->name);
            }
        }
        $output->writeln('created ' . \App\Type::count() . ' types');

        foreach ($typeEffectRelations as $id => $data) {
            $type = \App\Type::find($id);
            $typeNames = $data['ineffective'];
            $typeIds = \App\Type::whereIn('name', $typeNames)->lists('id')->toArray();
            $type->types()->attach($typeIds, ['value' => -1]);
            $output->writeln('attached ineffectives ' . $type->ineffectives()->lists('id') . ' to #' . $type->id);

            $typeNames = $data['effective'];
            $typeIds = \App\Type::whereIn('name', $typeNames)->lists('id')->toArray();
            $type->types()->attach($typeIds, ['value' => 1]);
            $output->writeln('attached effectives ' . $type->effectives()->lists('id') . ' to #' . $type->id);
        }
    }

    public function down()
    {
    }
}
