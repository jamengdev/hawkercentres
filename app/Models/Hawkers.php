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

    public function currentCleaningDate()
    {
        $data = json_decode($this->api_data);
        $now = Carbon::now();

        if ($this->isBetween($now, $data->q1_cleaningstartdate, $data->q1_cleaningenddate)) {
            $start = Carbon::createFromFormat('d/m/Y', $data->q1_cleaningstartdate, 'Asia/Singapore')->startOfDay();
            $end = Carbon::createFromFormat('d/m/Y', $data->q1_cleaningenddate, 'Asia/Singapore')->startOfDay();
            return $start->format('d M Y, D') .' to '. $end->format('d M Y, D');
        }

        if ($this->isBetween($now, $data->q2_cleaningstartdate, $data->q2_cleaningenddate)) {
            $start = Carbon::createFromFormat('d/m/Y', $data->q2_cleaningstartdate, 'Asia/Singapore')->startOfDay();
            $end = Carbon::createFromFormat('d/m/Y', $data->q2_cleaningenddate, 'Asia/Singapore')->startOfDay();
            return $start->format('d M Y, D') .' to '. $end->format('d M Y, D');
        }

        if ($this->isBetween($now, $data->q3_cleaningstartdate, $data->q3_cleaningenddate)) {
            $start = Carbon::createFromFormat('d/m/Y', $data->q3_cleaningstartdate, 'Asia/Singapore')->startOfDay();
            $end = Carbon::createFromFormat('d/m/Y', $data->q3_cleaningenddate, 'Asia/Singapore')->startOfDay();
            return $start->format('d M Y, D') .' to '. $end->format('d M Y, D');
        }

        if ($this->isBetween($now, $data->q4_cleaningstartdate, $data->q4_cleaningenddate)) {
            $start = Carbon::createFromFormat('d/m/Y', $data->q4_cleaningstartdate, 'Asia/Singapore')->startOfDay();
            $end = Carbon::createFromFormat('d/m/Y', $data->q4_cleaningenddate, 'Asia/Singapore')->startOfDay();
            return $start->format('d M Y, D') .' to '. $end->format('d M Y, D');
        }

        return '';
    }

    public function nextScheduledCleaningDate()
    {
        $data = json_decode($this->api_data);
        $now = Carbon::now();
        $nextScheduled = Carbon::now()->endOfYear();

        $startCleaningDateQ1 = Carbon::createFromFormat('d/m/Y', $data->q1_cleaningstartdate, 'Asia/Singapore')->startOfDay();
        if ($now->isBefore($startCleaningDateQ1) && $startCleaningDateQ1->isBefore($nextScheduled)) {
            $nextScheduled = $startCleaningDateQ1;
        }

        $startCleaningDateQ2 = Carbon::createFromFormat('d/m/Y', $data->q2_cleaningstartdate, 'Asia/Singapore')->startOfDay();
        if ($now->isBefore($startCleaningDateQ2) && $startCleaningDateQ2->isBefore($nextScheduled)) {
            $nextScheduled = $startCleaningDateQ2;
        }

        $startCleaningDateQ3 = Carbon::createFromFormat('d/m/Y', $data->q3_cleaningstartdate, 'Asia/Singapore')->startOfDay();
        if ($now->isBefore($startCleaningDateQ3) && $startCleaningDateQ3->isBefore($nextScheduled)) {
            $nextScheduled = $startCleaningDateQ3;
        }

        $startCleaningDateQ4 = Carbon::createFromFormat('d/m/Y', $data->q4_cleaningstartdate, 'Asia/Singapore')->startOfDay();
        if ($now->isBefore($startCleaningDateQ4) && $startCleaningDateQ4->isBefore($nextScheduled)) {
            $nextScheduled = $startCleaningDateQ4;
        }

        return $nextScheduled;
    }

    public function isOpenNow()
    {
        $data = json_decode($this->api_data);
        $now = Carbon::now();

        if ($this->isBetween($now, $data->q1_cleaningstartdate, $data->q1_cleaningenddate)) {
            return false;
        }

        if ($this->isBetween($now, $data->q2_cleaningstartdate, $data->q2_cleaningenddate)) {
            return false;
        }

        if ($this->isBetween($now, $data->q3_cleaningstartdate, $data->q3_cleaningenddate)) {
            return false;
        }

        if ($this->isBetween($now, $data->q4_cleaningstartdate, $data->q4_cleaningenddate)) {
            return false;
        }

        return true;
    }

    protected function isBetween($now, $start, $end)
    {
        $startCleaningDate = Carbon::createFromFormat('d/m/Y', $start, 'Asia/Singapore')->startOfDay();
        $endCleaningDate = Carbon::createFromFormat('d/m/Y', $end, 'Asia/Singapore')->endOfDay();

        if ($now->isBetween($startCleaningDate, $endCleaningDate)) {
            return true;
        }

        return false;
    }
}
