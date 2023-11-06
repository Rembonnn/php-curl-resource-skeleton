<?php

namespace YOUR_NAMESPACE_HERE;

class Curl
{
    /**
     * curl get http request.
     *
     * @param string $url
     * @param array $pagination
     */
    public static function get(string $url, array $pagination = ['page' => 1])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json',
            'User-Agent: ' . $_SERVER['HTTP_USER_AGENT'] ?? null,
        ]);
        $url = $url . '?' . http_build_query([
            'per_page' => config('curl.data.pagination.perpage'),
            'page' => $pagination['page'],
            'order_by' => config('curl.data.order.parameter'),
            'order_type' => config('curl.data.order.type'),
        ]);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // disable if you had install ssl certi in your pc
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // disable if you had install ssl certi in your pc
        $output = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return json_decode($output, true);
    }

    /**
     * curl post http request.
     *
     * @param string $url
     * @param array $data = []
     * @param array $query_params = []
     */
    public static function post(string $url, array $data = [], array $query_params = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json',
            'User-Agent: ' . $_SERVER['HTTP_USER_AGENT'] ?? null,
        ]);

        if (count($query_params) > 0) {
            $url = $url . '?' . http_build_query($query_params);
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // disable if you had install ssl certi in your pc
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // disable if you had install ssl certi in your pc

        $output = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return [
            'result' => json_decode($output),
            'http_code' => json_decode($httpCode)
        ];
    }

    /**
     * curl patch http request.
     *
     * @param string $url
     * @param array $data = []
     * @param array $query_params = []
     */
    public static function patch(string $url, array $data = [], array $query_params = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json',
            'User-Agent: ' . $_SERVER['HTTP_USER_AGENT'] ?? null,
        ]);

        if (count($query_params) > 0) {
            $url = $url . '?' . http_build_query($query_params);
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // disable if you had install ssl certi in your pc
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // disable if you had install ssl certi in your pc

        $output = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return [
            'result' => json_decode($output),
            'http_code' => json_decode($httpCode)
        ];
    }

    /**
     * curl delete http request.
     *
     * @param string $url
     */
    public static function delete(string $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json',
            'User-Agent: ' . $_SERVER['HTTP_USER_AGENT'] ?? null,
        ]);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // disable if you had install ssl certi in your pc
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // disable if you had install ssl certi in your pc

        $output = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return [
            'result' => json_decode($output) ?? [],
            'http_code' => json_decode($httpCode),
        ];
    }
}
