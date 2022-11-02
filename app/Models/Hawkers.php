<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Hawkers extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function isOpenNow()
    {
        $data = json_decode($this->api_data);

        if ($this->isOpenBetween($data->q1_cleaningstartdate, $data->q1_cleaningenddate)) {
            return true;
        }

        if ($this->isOpenBetween($data->q2_cleaningstartdate, $data->q2_cleaningenddate)) {
            return true;
        }

        if ($this->isOpenBetween($data->q3_cleaningstartdate, $data->q3_cleaningenddate)) {
            return true;
        }

        if ($this->isOpenBetween($data->q4_cleaningstartdate, $data->q4_cleaningenddate)) {
            return true;
        }

        return false;
    }

    protected function isOpenBetween($start, $end)
    {
        $now = Carbon::now();
        $startCleaningDate = Carbon::createFromFormat('d/m/Y', $start, 'Asia/Singapore')->startOfDay();
        $endCleaningDate = Carbon::createFromFormat('d/m/Y', $end, 'Asia/Singapore')->endOfDay();

        if ($now->isBetween($startCleaningDate, $endCleaningDate)) {
            return true;
        }

        return false;
    }
}
