<?php

namespace App\Modules\Clients\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Clients\Application\Actions\CreateClientAction;
use App\Modules\Clients\Infrastructure\Persistence\Models\Client;
use App\Modules\Clients\Presentation\Http\Requests\StoreClientRequest;
use App\Modules\Clients\Presentation\Http\Resources\ClientResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClientController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $clients = Client::query()->latest()->paginate(20);

        return ClientResource::collection($clients);
    }

    public function store(StoreClientRequest $request, CreateClientAction $action): ClientResource
    {
        $client = $action->execute($request->validated(), $request->user());

        return new ClientResource($client);
    }

    public function show(Client $client): ClientResource
    {
        return new ClientResource($client);
    }
}
