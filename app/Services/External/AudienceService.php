<?php

namespace App\Services\External;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AudienceService
{
    private array $radios = [
        [
            "nome" => "Rádio Doru",
            "logo" => "https://www.radiodoru.com.br/admin/assets/img/logo.png?April162026811pm14",
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
            "logo" => "https://www.radionikkeyweb.com.br/public/89196-2023-12-27.png",
            "link" => "https://stm8.voxhd.com.br:7996/stats?json=1",
            "target" => "currentlisteners",
        ],
        [
            "nome" => "Rádio J-Hero",
            "logo" => "https://thumbs.radiojhero.com/KeFhYMjzdxfJiMO5YbzmPGHkcUK3kI5wbnGr05mmBio/f:webp/g:sm/h:48/rt:fill/aHR0cHM6Ly9yYWRpb2poZXJvLmNvbS9hc3NldHMvbG9nby5wbmc.webp",
            "link" => "https://api.radiojhero.com/streaming/np",
            "target" => "listeners.current"
        ],
        [
            "nome" => "Rádio Anime Night",
            "logo" => "https://www.animenight.com.br/wa_images/logo1000.png?v=1jlid3r",
            "link" => "https://stm16.voxhd.com.br:10374/stats?json=1",
            "target" => "currentlisteners"
        ],
        [
            "nome" => "Rádio Toku Hero Club",
            "logo" => "https://images.cdn-files-a.com/uploads/6678219/400_filter_nobg_6660eaee06135.png",
            "link" => "http://sv12.hdradios.net:7664/stats?json=1",
            "target" => "currentlisteners",
        ],
        [
            "nome" => "Rádio Animu",
            "logo" => "https://www.animu.moe/wp-content/uploads/2021/10/cropped-cropped-cropped-cropped-Logo-nova-com-slogan-1-189x69.webp",
            "link" => "https://api.animu.com.br/",
            "target" => "listeners"
        ],
        [
            "nome" => "Rádio Tokyo Groove FM",
            "logo" => "https://www.tokyogroovefm.com/admin/assets/img/logo.png",
            "link" => "https://stm.sistemayuki.com:1065/status-json.xsl",
            "target" => "icestats.source.listeners"
        ],
        [
            "nome" => "Rede Blast",
            "logo" => "https://redeblast.com/assets/blast/img/default.png",
            "link" => "https://centova4.transmissaodigital.com:20143/stats?json=1",
            "target" => "currentlisteners"
        ],
        [
            "nome" => "Rádio Okinawa",
            "logo" => "https://yt3.googleusercontent.com/SB6vEeJ59pED2E-Tm1-afgQLQY2VAT1wdkDnoNtcWFrFYDbWDpKhjtB-kktN_wPJ1sRrjwQfag=s900-c-k-c0x00ffffff-no-rj",
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
            "logo" => "https://radioup.antbr.com/logo.png",
            "link" => "https://saber.intra.antbr.com:8443/status-json.xsl",
            "target" => "icestats.source.listeners"
        ]
    ];

    public function getAudience()
    {
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
    }
}
