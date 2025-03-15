<?php

namespace App\Jobs;

use App\Mail\ImportAccountMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail as FacadesMail;

class SendEmailImportAccount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $datas;
    public function __construct($datas)
    {
        $this->datas = $datas;
    }

    public function handle()
    {
        $chunkSize = 100;
        $chunksUserInsertArr = array_chunk($this->datas, $chunkSize);
        foreach ($chunksUserInsertArr as $chunkUserInsertArr) {
            foreach($chunkUserInsertArr as $item){
                FacadesMail::to($item['email'])->send(new ImportAccountMail($item['email'], $item['password']));
            }
        }
    }
}