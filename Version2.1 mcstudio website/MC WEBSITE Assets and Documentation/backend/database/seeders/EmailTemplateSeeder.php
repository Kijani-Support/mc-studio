<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customerTemplate = <<<'EOL'
        <p>Hi {{ $name }},</p>
        <p><br></p>
        <p>We have created a new Customer account for you on our system using this {{ $email }} email address.</p>
        <p>You can log into the account using the link below</p>
        <p><br></p>
        <p>{{ $link }}</p>
        <p><br></p>
        <p>Be sure to change your password after you first login.&nbsp;</p>
        <p><br></p>
        <p>Regards</p>
        EOL;

        $supplierTemplate = <<<'EOL'
        <p>Hi {{ $name }},</p>
        <p><br></p>
        <p>We have created a new Supplier account for you on our system using this {{ $email }} address.</p>
        <p>You can log into the account using the link below</p>
        <p><br></p>
        <p>{{ $link }}</p>
        <p><br></p>
        <p>Be sure to change your password after you first login.&nbsp;</p
        ><p><br></p>
        <p>Regards</p>
        EOL;

        $quotationTemplate = <<<'EOL'
        <p>Hi {{ $name }},</p>
        <p><br></p>
        <p>You have received a new quotation number {{ $quotation_number }}</p>
        <p>The items listed in the quotations are:</p>
        <p>{{ $quotation_items }}</p>
        <p><br></p>
        <p>Regards</p>
        EOL;

        $puchaseOrderTemplate = <<<'EOL'
        <p>Hi {{ $name }},</p>
        <p><br></p>
        <p>You have received a new purchase order number {{ $purchase_order_number }}</p>
        <p>The items listed in the quotations are:</p>
        <p>{{ $purchase_order_items }}</p>
        <p><br></p>
        <p>Regards</p>
        EOL;

        $orderTemplate = <<<'EOL'
        <p>Hi {{ $name }},</p>
        <p><br></p>
        <p>You have received a new order number {{ $order_number }}</p>
        <p>The items listed in the quotations are:</p>
        <p>{{ $order_items }}</p>
        <p><br></p>
        <p>Regards</p>
        EOL;

        $stockReturnTemplate = <<<'EOL'
        <p>Hi {{ $name }},</p>
        <p><br></p>
        <p>We are submitting a request for the return of the following item(s):</p>
        <p><br></p>
        <p>{{ $return_items }}</p>
        <p><br></p>
        <p>The reason for the return is</p>
        <p><br></p>
        <p>{{ $reason }}</p>
        <p><br></p>
        <p>The item(s) is/are referenced from the order number {{ $order_number }}</p>
        <p><br></p>
        <p>Regards</p>
        EOL;

        $orderReturnTemplate = <<<'EOL'
        <p>Hi {{ $name }},</p>
        <p><br></p>
        <p>We have received your request for the return of the following item(s):</p>
        <p><br></p>
        <p>{{ $return_items }}</p>
        <p><br></p>
        <p>The reason for the return is</p>
        <p><br></p>
        <p>{{ $reason }}</p>
        <p><br></p>
        <p>The item(s) is/are referenced from the order number {{ $order_number }}</p>
        <p><br></p>
        <p>Regards</p>
        EOL;

        // create customer mail template
        EmailTemplate::create([
            'subject' => 'Welcome - Customer Account Created',
            'record type' => 'create_customer',
            'body' => $customerTemplate
        ]);
        
        // create supplier mail template
        EmailTemplate::create([
            'subject' => 'Welcome - Supplier Account Created',
            'record type' => 'create_supplier',
            'body' => $supplierTemplate
        ]);        
        
        // create quotation mail template
        EmailTemplate::create([
            'subject' => 'Received New Quotation',
            'record type' => 'create_quotation',
            'body' => $quotationTemplate
        ]);
        
        // create Purchase Order mail template
        EmailTemplate::create([
            'subject' => 'Received New Purchase Order',
            'record type' => 'create_purchase_order',
            'body' => $puchaseOrderTemplate
        ]);
        
        // create Order mail template
        EmailTemplate::create([
            'subject' => 'Received New Order',
            'record type' => 'create_order',
            'body' => $orderTemplate
        ]);
        
        // create Stock Return mail template
        EmailTemplate::create([
            'subject' => 'Stock Item Return Request Initiated',
            'record type' => 'create_stock_return',
            'body' => $stockReturnTemplate
        ]);

        // create Order Return mail template
        EmailTemplate::create([
            'subject' => 'Item Return Request Initiated',
            'record type' => 'create_order_return',
            'body' => $orderReturnTemplate
        ]);
    }
}
