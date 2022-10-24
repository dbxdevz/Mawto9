<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\History;

class HistoryController extends Controller
{
    public function index()
    {
        $limit = request('limit') ? request('limit') : 10;

        $histories = History::with(['user:id,name,role_id', 'user.roles:id,name'])
                            ->orderBy('id', 'desc')
                            ->paginate($limit)
        ;

        return response(['histories' => $histories], 200);
    }
}
