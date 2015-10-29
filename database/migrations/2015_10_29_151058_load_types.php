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

        for ($i = 1; $i <= $this->amount; $i++) {
            $response = $client->request('GET', $i);
            if ($response->getStatusCode() == 200) {
                $body = json_decode((string)$response->getBody(), true);
                $type = \App\Type::create([
                    'id' => $body['id'],
                    'name' => strtolower($body['name']),
                ]);
                $output->writeln('created #' . $type->id . ' - ' . $type->name);
            }
        }
        $output->writeln('created ' . \App\Type::count() . ' types');
        foreach (\App\Type::all() as $cause_type) {
            $response = $client->request('GET', $cause_type->id);
            if ($response->getStatusCode() == 200) {
                $body = json_decode((string)$response->getBody(), true);
                foreach ($body['ineffective'] as $aim_type) {
                    $aim_type = \App\Type::name($aim_type['name'])->first();
                    if (!is_null($aim_type)) {
                        $cause_type->types()->attach($aim_type->id, ['value' => -1]);
                    }
                }
                $output->writeln('attached ineffectives ' . $cause_type->ineffectives()->lists('id') . ' to #' . $cause_type->id);
                foreach ($body['super_effective'] as $aim_type) {
                    $aim_type = \App\Type::name($aim_type['name'])->first();
                    if (!is_null($aim_type)) {
                        $cause_type->addEffective($aim_type['name']);
                    }
                }
                $output->writeln('attached effectives ' . $cause_type->effectives()->lists('id') . ' to #' . $cause_type->id);
            }
        }
    }

    public function down()
    {
    }
}
