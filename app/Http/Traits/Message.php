<?php

namespace App\Http\Traits;

use App\Models\History;
use http\Exception;

trait Message
{
    public function history($model, $table, $data)
    {
        try {
            foreach ($model->attributesToArray() as $key => $item) {
                $data[0]['id'] = $model->id;
                if (array_key_exists($key, $data[0])) {
                    if ($data[0][$key] != $item) {
                        if (str_contains($key, '_id')) {
                            $newKey = ucfirst(substr($key, 0, -3));
                        }
                        History::create(
                            [
                                'user_id'   => auth('sanctum')->id(),
                                'old_value' => $item == null ? 'null' : $item,
                                'new_value' => $data[0][$key],
                                'column'    => $key,
                                'table'     => $table,
                            ]
                        );
                    }
                }

            };
        } catch (Exception $e) {
            echo 'Something wrong';
        }

    }
}
