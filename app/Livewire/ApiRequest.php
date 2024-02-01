<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class ApiRequest extends Component
{
    public array $request;

    public string $route;

    public $response;

    public function mount(array $request): void
    {
        $this->request = $request;

        $this->updateRoute();
    }

    public function updateRoute(): void
    {
        $route = $this->request['route'];

        foreach ($this->request['params'] as $param) {
            if ($param['default']) {
                $route = str_replace('{{ ' . $param['slug'] . ' }}', $param['default'], $route);
            }
        }

        $this->route = $route;
    }

    public function updatedRequest(): void
    {
        $this->updateRoute();
    }

    public function testRequest(): void
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->request($this->request['type'], $this->route, [
            'query' => [
                'api_key' => User::whereIsAdmin(true)->first()->apiKey->key,
            ],
        ]);

        $this->response = json_decode($response->getBody()->getContents());
    }

    public function render()
    {
        return view('livewire.api-request');
    }
}
