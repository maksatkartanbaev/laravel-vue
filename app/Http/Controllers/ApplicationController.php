<?php

namespace App\Http\Controllers;

use dacoto\DomainValidator\Validator\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Iodev\Whois\Whois;


class ApplicationController extends Controller
{
    public function __invoke()
{
    return view('app');
}

    public function check(Request $request)
    {

        $domains = $request->input('domains');
        $results = [];

        foreach ($domains as $domain) {
            $result = [
                'name' => $domain,
                'status' => '',
            ];
            $validator = Validator::make(['domain' => $domain], [
                'domain' => ['required', new Domain],
            ]);

            if ($validator->fails()) {
                $result['status'] = "Невалидный домен";
            }

            else if (!in_array($domain, $results) && filter_var($domain, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
                try {
                    $whois = Whois::create();

                    if ($whois->isDomainAvailable($domain)) {
                        $result['status'] = "Свободен";
                    }else{
                        $info = $whois->loadDomainInfo($domain);
                        $result['status'] = date("Y-m-d", $info->expirationDate);
                    }
                } catch (\Exception $e) {
                    $result['status'] = 'Ошибка: ' . $e->getMessage();
                }
            } else {
                $result['status'] = 'Невалидный домен';
            }

            $results[] = $result;
        }

        return response()->json($results);
    }
}
