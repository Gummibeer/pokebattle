<?php

class PokemonListParser
{
    public function getPokelist()
    {
        $pokelist = collect(array_map('str_getcsv', file(('pokemonlist.csv'))))->forget(0)->map(function ($item) {
            $pokemon = \App\Pokemon::find($item[0]);
            if (!is_null($pokemon)) {
                return [
                    'id' => $item[0] * 1,
                    'name' => $pokemon->name,
                    'de' => $item[1],
                    'us' => $item[2],
                    'fr' => $item[3],
                ];
            } else {
                return null;
            }
        })->keyBy('id')->reject(function ($item) {
            return is_null($item);
        });

        $out = '';
        $out .= 'return [' . PHP_EOL;
        foreach ($pokelist as $pokemon) {
            $out .= $this->getLineByItem($pokemon, 'fr');
        }
        $out .= '];' . PHP_EOL;
        echo nl2br($out);
    }

    protected function getLineByItem($item, $locale)
    {
        return "'{$item['name']}' => '{$item[$locale]}', #{$item['id']}" . PHP_EOL;
    }
}