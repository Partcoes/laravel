<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        //
        $this -> user = $user;
    }

    /**
     * 任务处理方法，发送邮件在这里进行处理
     *
     * @return void
     */
    public function handle()
    {
        Mail::raw('欢迎加入！',function($message){
            $message -> from('2247809345@qq.com','partcoes');
            $message -> to($this -> user -> email);
            $message -> subject('小米商城注册');
        });
        //
    }
}
