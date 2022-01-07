<?php

namespace App\Entity;

use App\Utility\DateFormatter;

class OrderSummary
{
  public string $order_id;
  public string $order_datetime;
  public CalculateOrder $calculateOrder;

  public function __construct($data)
  {
    $this->order_id = $data->order_id;
    $this->order_datetime = static::orderDateTime($data->order_date);
    $this->calculate = (new CalculateOrder())->calculate($data);
    $this->customer_state = static::customerState($data->customer);
  }

  static function orderDateTime($date): string
  {
    return DateFormatter::strToUTCDateTime($date);
  }

  static function customerState($customer): string
  {
    return $customer->shipping_address->state;
  }
}