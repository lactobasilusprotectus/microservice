<?php

function getUser($userId)
{
    $url = env('SERVICE_USER_URL') . 'users/'. $userId;

    try {
        $response = \Illuminate\Support\Facades\Http::timeout(10)->get($url);

        $data = $response->json();

        $data['http_code'] = $response->getStatusCode();

        return $data;
    }catch (Throwable $throwable)
    {
        return [
          'status' => 'error',
          'http_code' => 500,
          'message' => 'service tidak ada '
        ];
    }
}

function getUserById($userId = [])
{
    $url = env('SERVICE_USER_URL') . 'users/';

    try {
        if (count($userId === 0))
        {
            return [
                'status' => 'success',
                'http_code' => 200,
                'data' => []
            ];
        }

        $response = \Illuminate\Support\Facades\Http::timeout(10)->get($url, ['userId[]' => $userId]);

        $data = $response->json();

        $data['http_code'] = $response->getStatusCode();

        return $data;
    }catch (Throwable $throwable)
    {
        return [
            'status' => 'error',
            'http_code' => 500,
            'message' => 'service tidak ada '
        ];
    }
}
