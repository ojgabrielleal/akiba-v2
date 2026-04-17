<?php

namespace App\Services\External;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AudienceService
{
    private array $radios = [
        [
            "nome" => "Rádio Doru",
            "logo" => "https://img.radios.com.br/radio/md/radio141568_1776067616.png",
            "link" => "https://paineldj6.com.br:20038/status-json.xsl",
            "target" => "icestats.source.0.listeners"
        ],
        [
            "nome" => "Rádio Mirai",
            "logo" => "https://img.radios.com.br/radio/lg/radio190637_1741332317.png",
            "link" => "https://stm6.xradios.com.br:6902/stats?json=1",
            "target" => "currentlisteners"
        ],
        [
            "nome" => "Rádio Nikkey",
            "logo" => "https://img.radios.com.br/radio/md/radio72519_1529518559.png",
            "link" => "https://stm8.voxhd.com.br:7996/stats?json=1",
            "target" => "currentlisteners",
        ],
        [
            "nome" => "Rádio J-Hero",
            "logo" => "https://img.radios.com.br/radio/md/radio31206_1743416541.png",
            "link" => "https://api.radiojhero.com/streaming/np",
            "target" => "listeners.current"
        ],
        [
            "nome" => "Rádio Anime Night",
            "logo" => "https://img.radios.com.br/radio/lg/radio47996_1496672705.jpg",
            "link" => "https://stm16.voxhd.com.br:10374/stats?json=1",
            "target" => "currentlisteners"
        ],
        [
            "nome" => "Rádio Toku Hero Club",
            "logo" => "https://img.radios.com.br/radio/lg/radio145648_1756463989.jpeg",
            "link" => "http://sv12.hdradios.net:7664/stats?json=1",
            "target" => "currentlisteners",
        ],
        [
            "nome" => "Rádio Animu",
            "logo" => "https://img.radios.com.br/radio/lg/radio68971_1696516163.png",
            "link" => "https://api.animu.com.br/",
            "target" => "listeners"
        ],
        [
            "nome" => "Rádio Tokyo Groove FM",
            "logo" => "https://img.radios.com.br/radio/lg/radio222299_1768295015.png",
            "link" => "https://stm.sistemayuki.com:1065/status-json.xsl",
            "target" => "icestats.source.listeners"
        ],
        [
            "nome" => "Rede Blast",
            "logo" => "https://img.radios.com.br/radio/lg/radio35904_1505828350.png",
            "link" => "https://centova4.transmissaodigital.com:20143/stats?json=1",
            "target" => "currentlisteners"
        ],
        [
            "nome" => "Rádio Okinawa",
            "logo" => "https://img.radios.com.br/radio/lg/radio204874_1661782384.png",
            "link" => "https://hts05.brascast.com:9080/status-json.xsl",
            "target" => "icestats.source.0.listeners"
        ],
        [
            "nome" => "Rádio P6 PopAsia",
            "logo" => "https://img.radios.com.br/radio/lg/radio236180_1762420981.jpeg",
            "link" => "https://ec5.yesstreaming.net:1430/status-json.xsl",
            "target" => "icestats.source.listeners",
        ],
        [
            "nome" => "Rádio AMC",
            "logo" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQI-MdQhqSuj_6IzGrJ8r_aF0bjZXj-hSJfBg&s",
            "link" => "https://stm16.painelcast.com:6728/stats?json=1",
            "target" => "currentlisteners"
        ],
        [
            "nome" => "Rádio UP!",
            "logo" => "https://img.radios.com.br/radio/lg/radio261613_1760956640.jpg",
            "link" => "https://saber.intra.antbr.com:8443/status-json.xsl",
            "target" => "icestats.source.listeners"
        ]
    ];

    public function getAudience()
    {
        return Cache::remember('audience.radios', 60, function () {
            try {
                $audience = [];
                
                foreach($this->radios as $radio){
                    $response = Http::timeout(5)->withOptions([
                        'verify' => false,
                    ])->get($radio['link']);

                    if($response->failed()){
                        continue;
                    }

                    $data = $response->json();
                    
                    $audience[] = [
                        'nome' => $radio['nome'],
                        'logo' => $radio['logo'],
                        'listeners' => data_get($data, $radio['target'])
                    ];
                }

                return $audience;
            } catch (\Throwable $th) {
                Log::error("AudienceService Error: " . $th->getMessage());
                return [];
            }
        });
    }
}
