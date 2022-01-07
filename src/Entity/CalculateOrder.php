<?php

namespace App\Entity;

class CalculateOrder
{
  public float $total_order_value;
  public float $average_unit_price;
  public float $distinct_unit_count;
  public float $total_units_count;

  public function calculate($data)
  {
    $sumPrice = 0;
    $totalAmount = 0;
    $countItem = [];

    foreach ($data->items  as $item) {
      $qty = (float) $item->quantity;
      $price = (float) $item->unit_price;
      $sumPrice +=  $price;
      $totalAmount += ($qty * $price);
      $countItem[$item->product->product_id] = 1;
    }

    foreach ($data->discounts  as $discount) {
      $discountValue = (float) $discount->value;
      $discountAmount =  $discount->type == 'PERCENTAGE'
        ? ($discountValue * $totalAmount) / 100
        : $discountValue;
      $totalAmount -= $discountAmount;
    }

    $this->total_order_value = $totalAmount;
    $this->distinct_unit_count = count($countItem);
    $this->total_units_count = count($data->items);
    $this->average_unit_price = $sumPrice / $this->total_units_count;
    return $this;
  }
}