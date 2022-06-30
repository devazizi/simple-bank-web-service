<?php

namespace App\Service;

class Responser
{
    public static function success($data = null)
    {
        return [
            'message' => trans('messages.success_action_message'),
            'data' => $data
        ];
    }
}
