<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [ //Ouvinte contendo array com todos os eventos que serão disparados
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \App\Events\NovaSerie::class => [ //Disparando evento NovaSerie
            \App\Listeners\EnviarEmailNovaSerieCadastrada::class, //Executa o ouvinte de envio de e-mail
            \App\Listeners\LogNovaSerieCadastrada::class, //Executa o ouvinte de registro de log
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
