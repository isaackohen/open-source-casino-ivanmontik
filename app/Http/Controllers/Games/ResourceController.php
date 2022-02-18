<?php

namespace App\Http\Controllers\Games;

use App\Helpers\Traits\AvailableLanguages;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Laravel\Jetstream\Jetstream;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ResourceController extends ResourceCollection
{
    use AvailableLanguages;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ['games' => $this->collection];
    }


}
