<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LoadMoves extends Migration
{
    protected $amount = 625;

    public function up()
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $client = new GuzzleHttp\Client(['base_uri' => 'http://pokeapi.co/api/v1/move/']);

        for ($i = 1; $i <= $this->amount; $i++) {
            $response = $client->request('GET', $i);
            if ($response->getStatusCode() == 200) {
                $body = json_decode((string)$response->getBody(), true);
                if ($body['power'] >= 10) {
                    $move = \App\Move::create($body);
                    $output->writeln('created #' . $move->id . ' - ' . $move->name);
                }
            }
        }
        $output->writeln('created ' . \App\Move::count() . ' moves');
    }

    public function down()
    {
    }
}
