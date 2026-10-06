<?php

namespace App;

use App\Models\SmsTemplate;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

class SmsPreview implements Htmlable
{

  protected $sms;

  protected $template;

  protected $data;

  public function __construct(SmsTemplate $sms)
  {
    $this->sms = $sms;
  }

  public static function make(SmsTemplate $sms): self
  {
    return new self($sms);
  }

    /**
     * @return mixed
     */
    public function getData()
    {
        $this->data = $this->sms->body;
        return $this->data;
    }

  public function getFields(): array
  {
    $fields = [];


    return $fields;
  }

  public function render(): View
  {
      return view('sms.template', ['data' => $this->getData()]);
  }

  public function toHtml(): string
  {
      return $this->render()->render();
  }
}
