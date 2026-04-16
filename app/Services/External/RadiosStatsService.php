<?php

namespace App\Services\External;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Client\Pool;

class RadiosStatsService
{
    /**
     * Lista fixa de rádios e seus metadados.
     */
    private array $radios = [
        [
            "nome" => "Rádio Doru",
            "logo" => "https://www.radiodoru.com.br/admin/assets/img/logo.png?April162026357pm04",
            "link" => "https://paineldj6.com.br:20038/status-json.xsl",
            "admin" => "ADMIN",
            "color" => "text-yellow-400"
        ],
        [
            "nome" => "Rádio Mirai",
            "logo" => "https://img.radios.com.br/radio/lg/radio190637_1741332317.png",
            "link" => "https://stm6.xradios.com.br:6902/stats?json=1",
            "admin" => "ADMIN",
            "color" => "text-blue-400"
        ],
        [
            "nome" => "Rádio Nikkey",
            "logo" => "https://img.radios.com.br/radio/lg/radio72519_1529518559.png",
            "link" => "https://stm8.voxhd.com.br:7996/stats?json=1",
            "admin" => "TAKA E NEKO",
            "color" => "text-orange-500"
        ],
        [
            "nome" => "Rádio J-Hero",
            "logo" => "https://thumbs.radiojhero.com/KeFhYMjzdxfJiMO5YbzmPGHkcUK3kI5wbnGr05mmBio/f:webp/g:sm/h:48/rt:fill/aHR0cHM6Ly9yYWRpb2poZXJvLmNvbS9hc3NldHMvbG9nby5wbmc.webp",
            "link" => "https://listen.radiojhero.com/status-json.xsl",
            "admin" => "KOTARO",
            "color" => "text-cyan-400"
        ],
        [
            "nome" => "Rádio Anime Night",
            "logo" => "https://www.animenight.com.br/wa_images/logo1000.png?v=1jlid3r",
            "link" => "https://stm16.voxhd.com.br:10374/stats?json=1",
            "admin" => "ADMIN",
            "color" => "text-indigo-400"
        ],
        [
            "nome" => "Rádio Toku Hero Club",
            "logo" => "https://images.cdn-files-a.com/uploads/6678219/400_filter_nobg_6660eaee06135.png",
            "link" => "http://sv12.hdradios.net:7664/stats?json=1",
            "admin" => "ADMIN",
            "color" => "text-red-400"
        ],
        [
            "nome" => "Rádio Animu",
            "logo" => "https://www.animu.moe/wp-content/uploads/2021/10/cropped-cropped-cropped-cropped-Logo-nova-com-slogan-1-189x69.webp",
            "link" => "https://api.animu.com.br/",
            "admin" => "LL",
            "color" => "text-purple-500"
        ],
        [
            "nome" => "Rádio Tokyo Groove FM",
            "logo" => "https://www.tokyogroovefm.com/admin/assets/img/logo.png",
            "link" => "https://stm.sistemayuki.com:1065/status=json.xsl",
            "admin" => "ADMIN",
            "color" => "text-pink-400"
        ],
        [
            "nome" => "Rede Blast",
            "logo" => "https://redeblast.com/assets/blast/img/default.png",
            "link" => "https://centova4.transmissaodigital.com:20143/stats?json=1",
            "admin" => "JOKE",
            "color" => "text-lime-400"
        ],
        [
            "nome" => "Rádio Okinawa",
            "logo" => "https://yt3.googleusercontent.com/SB6vEeJ59pED2E-Tm1-afgQLQY2VAT1wdkDnoNtcWFrFYDbWDpKhjtB-kktN_wPJ1sRrjwQfag=s900-c-k-c0x00ffffff-no-rj",
            "link" => "https://hts05.brascast.com:9080/status-json.xsl",
            "admin" => "ADMIN",
            "color" => "text-teal-400"
        ],
        [
            "nome" => "Rádio P6 PopAsia",
            "logo" => "https://img.radios.com.br/radio/lg/radio236180_1762420981.jpeg",
            "link" => "https://ec5.yesstreaming.net:1430/status-json.xsl",
            "admin" => "ADMIN",
            "color" => "text-fuchsia-400"
        ],
        [
            "nome" => "Rádio AMC",
            "logo" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQI-MdQhqSuj_6IzGrJ8r_aF0bjZXj-hSJfBg&s",
            "link" => "https://stm16.painelcast.com:6728/stats?json=1",
            "admin" => "NOBUNAGA",
            "color" => "text-rose-200"
        ]
    ];

    /**
     * Obtém as estatísticas de audiência de todas as rádios.
     */
    public function getStats(): array
    {
        return Cache::remember('radios_audience_stats', 30, function () {
            $responses = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
            ])
            ->withoutVerifying() // Mantido para compatibilidade com APIs de rádio de terceiros
            ->pool(fn (Pool $pool) => 
                collect($this->radios)->map(fn ($radio) => 
                    $pool->as($radio['nome'])->timeout(3)->get($radio['link'])
                )
            );

            return collect($this->radios)->map(function ($radio) use ($responses) {
                $response = $responses[$radio['nome']];
                $radio['listeners'] = null; // Default to null for NaN display

                if ($response instanceof \Illuminate\Http\Client\Response && $response->successful()) {
                    $radio['listeners'] = $this->parseListeners($response->json() ?? []);
                }

                return $radio;
            })->toArray();
        });
    }

    /**
     * Analisa o JSON de resposta para extrair o número de ouvintes.
     */
    private function parseListeners(array|int|string $data): ?int
    {
        if (empty($data)) return null;

        // Se o dado for apenas um número/texto
        if (!is_numeric($data) && !is_array($data)) {
            return null;
        }

        if (is_numeric($data)) {
            return (int)$data;
        }

        // Icecast (icestats)
        if (isset($data['icestats']['source'])) {
            $source = $data['icestats']['source'];
            $mount = is_array($source) && isset($source[0]) ? $source[0] : $source;
            return isset($mount['listeners']) ? (int)$mount['listeners'] : null;
        }

        // Shoutcast / Animu / Custom
        if (isset($data['uniquelisteners'])) return (int)$data['uniquelisteners'];
        if (isset($data['listeners'])) return (int)$data['listeners'];
        if (isset($data['online'])) return (int)$data['online'];

        return null;
    }
}
