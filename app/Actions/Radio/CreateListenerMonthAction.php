<?php

namespace App\Actions\Radio;

use App\Models\ListenerMonth;
use App\Services\Process\ImageProcessService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class CreateListenerMonthAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(?UploadedFile $avatarFile): ?ListenerMonth
    {
        $found = ListenerMonth::mostActiveListenerOfCurrentMonth();

        if (! $found) {
            return null;
        }

        return DB::transaction(fn () => ListenerMonth::updateOrCreate(['id' => 1], [
            'avatar' => $this->image->store('listener-month', $avatarFile, 'public'),
            'name' => $found->name,
            'address' => $found->address,
            'favorite_program' => $found->favorite_program,
            'requests_total' => $found->requests_total,
        ]));
    }
}
