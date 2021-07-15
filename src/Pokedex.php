<?php

/*
 * This file is part of the basic-pokeapi package.
 *
 * (c) Benjamin Georgeault
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hb\BasicPokeapi;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class Pokedex
 *
 * @author Benjamin Georgeault
 */
class Pokedex
{
    private HttpClientInterface $client;

    public function __construct()
    {
        $this->client = HttpClient::createForBaseUri('https://pokeapi.co/api/v2/');
    }

    public function getPikachu(): array
    {
        $response = $this->client->request('GET', 'pokemon/25');

        if (200 !== $response->getStatusCode()) {
            throw new \RuntimeException('Error from Pokeapi.co');
        }

        return $response->toArray();
    }

    public function getCleanPikachu(): array
    {
        $data = $this->getPikachu();

        $clean = array_intersect_key($data, array_flip(['id', 'name', 'weight', 'base_experience']));
        $clean['image'] = $data['sprites']['front_default'];
        return $clean;

//        // same as lines before.
//        return [
//            'id' => $data['id'],
//            'name' => $data['name'],
//            'weight' => $data['weight'],
//            'base_experience' => $data['base_experience'],
//            'image' => $data['sprites']['front_default'],
//        ];
    }
}
