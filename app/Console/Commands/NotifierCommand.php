<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class NotifierCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifier';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        echo 'start listening for blog creation' . PHP_EOL;
        Redis::subscribe('create:blog', function ($blog) {
            echo 'message received!' . PHP_EOL;
            $blog = json_decode($blog);
            $users = [
                [
                    "name" => "John Doe",
                    "email" => "jon@gmail.com",
                    "topics" => ['sports', 'food']
                ],
                [
                    "name" => "Jane Doe",
                    "email" => "jane@gmail.com",
                    "topics" => ['sports', 'fashion']
                ]
            ];
            foreach ($users as $user) {
                foreach ($user['topics'] as $topic) {
                    if ($blog->topic === $topic) {
                        echo 'New blog on "' . $topic . '" for "' . $user['name'] . '" with title => "' . $blog->title . PHP_EOL;
                    }
                }
            }
        });
    }
}
