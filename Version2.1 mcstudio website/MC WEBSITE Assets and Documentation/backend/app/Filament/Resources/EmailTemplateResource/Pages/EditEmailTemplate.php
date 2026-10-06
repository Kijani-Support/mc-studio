<?php

namespace App\Filament\Resources\EmailTemplateResource\Pages;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Quotation;
use Filament\Pages\Actions;
use App\Models\PurchaseOrder;
use App\Models\QuotationItem;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\EmailTemplateResource;
use App\MailPreview;

class EditEmailTemplate extends EditRecord
{
    protected static string $resource = EmailTemplateResource::class;

    public $column_fields = [];

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('preview')
                ->action('')
                ->label('Preview')
                ->color('primary')
                ->slideOver()
                ->modalContent(MailPreview::make($this->record)),
        ];
    }

    public function mount($record): void
    {
        parent::mount($record);
        $this->column_fields = MailPreview::make($this->record)->getFields();
    }

}
