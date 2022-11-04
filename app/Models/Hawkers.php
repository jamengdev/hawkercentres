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

    protected function isTheNextNearestCleaningDate($startCleaningDate, $currentScheduledDate, $now)
    {
        try {
            $startCleaningDate = Carbon::createFromFormat('d/m/Y', $startCleaningDate, 'Asia/Singapore')->startOfDay();
            if ($now->isBefore($startCleaningDate) && $startCleaningDate->isBefore($currentScheduledDate)) {
                return true;
            }
            return false;
        } catch (\Throwable $exception) {
            return false;
        }
    }

    public function nextScheduledCleaningDate()
    {
        $data = json_decode($this->api_data);
        $now = Carbon::now();
        $nextScheduled = Carbon::now()->endOfYear();

        if ($this->isTheNextNearestCleaningDate($data->q1_cleaningstartdate, $nextScheduled, $now)) {
            $nextScheduled = Carbon::createFromFormat('d/m/Y', $data->q1_cleaningstartdate, 'Asia/Singapore')->startOfDay();
        }

        if ($this->isTheNextNearestCleaningDate($data->q2_cleaningstartdate, $nextScheduled, $now)) {
            $nextScheduled = Carbon::createFromFormat('d/m/Y', $data->q2_cleaningstartdate, 'Asia/Singapore')->startOfDay();
        }

        if ($this->isTheNextNearestCleaningDate($data->q3_cleaningstartdate, $nextScheduled, $now)) {
            $nextScheduled = Carbon::createFromFormat('d/m/Y', $data->q3_cleaningstartdate, 'Asia/Singapore')->startOfDay();
        }

        if ($this->isTheNextNearestCleaningDate($data->q4_cleaningstartdate, $nextScheduled, $now)) {
            $nextScheduled = Carbon::createFromFormat('d/m/Y', $data->q4_cleaningstartdate, 'Asia/Singapore')->startOfDay();
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
        try {
            $startCleaningDate = Carbon::createFromFormat('d/m/Y', $start, 'Asia/Singapore')->startOfDay();
            $endCleaningDate = Carbon::createFromFormat('d/m/Y', $end, 'Asia/Singapore')->endOfDay();
            if ($now->isBetween($startCleaningDate, $endCleaningDate)) {
                return true;
            }
            return false;
        } catch (\Throwable $exception) {
            return false;
        }
    }
}
