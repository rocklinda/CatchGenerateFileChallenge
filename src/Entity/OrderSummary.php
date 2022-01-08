<?php

namespace App\Entity;

use App\Utility\DateFormatter;

class OrderSummary
{
  public string $order_id;
  public string $order_datetime;
  public CalculateOrder $calculateOrder;
  public string $customer_state;

  public function __construct($data)
  {
    $this->order_id = $data->order_id;
    $this->order_datetime = DateFormatter::strToUTCDateTime($data->order_date);
    $this->calculate = (new CalculateOrder())->calculate($data);
    $this->customer_state = $data->customer->shipping_address->state;
  }
}