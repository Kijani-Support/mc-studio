<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\StockReturnNotification;
use App\Notifications\UserWelcomeNotification;
use App\Notifications\OrderCreatedNotification;
use App\Notifications\OrderReturnNotification;
use App\Notifications\QuotationCreatedNotification;
use App\Notifications\PurchaseOrderCreatedNotification;
use App\Filament\Resources\QuotationResource\Widgets\QuotationStats;

class SystemEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $model = $event->model;
        $template_name = $event->template;

        switch ($template_name) {
            case 'create_customer':
                Notification::send($model, new UserWelcomeNotification($model, $template_name));
                break;
            case 'create_supplier':
                Notification::send($model, new UserWelcomeNotification($model, $template_name));
                break; 
            case 'create_quotation':
                Notification::send($model->user, new QuotationCreatedNotification($model, $template_name));
                break;
            case 'create_purchase_order':
                Notification::send($model->user, new PurchaseOrderCreatedNotification($model, $template_name));
                break;
            case 'create_order':
                Notification::send($model->user, new OrderCreatedNotification($model, $template_name));
                break;
            case 'create_stock_return':
                Notification::send($model->user, new StockReturnNotification($model, $template_name));
                break;
            case 'create_order_return':
                Notification::send($model->user, new OrderReturnNotification($model, $template_name));
                break;
            
            default:
                # code...
                break;
        }
    }
}
