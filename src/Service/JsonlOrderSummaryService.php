<?php

namespace App\Service;

use stdClass;
use App\Entity\OrderSummary;


class JsonlOrderSummaryService
{
  static string $format = ".jsonl";

  static function getOutputFilePath()
  {
    return "storage/order_summary_" . date("Y-m-d-H_i") . static::$format;
  }

  public function createOutputFile($orders)
  {
    $outputFile = static::getOutputFilePath();
    $fp = fopen($outputFile, 'w');
    fclose($fp);

    foreach ($orders as $order) {
      $line = $this->transform($order);
      $this->append($outputFile, $line);
    }
    return $fp;
  }

  protected function transform(OrderSummary $order)
  {
    $orderSummary = new stdClass();
    $orderSummary->order_id =  $order->order_id;
    $orderSummary->order_date_time =  $order->order_datetime;
    $orderSummary->total_order_value =  $order->calculate->total_order_value;
    $orderSummary->average_unit_price =  $order->calculate->average_unit_price;
    $orderSummary->distinct_unit_count =  $order->calculate->distinct_unit_count;
    $orderSummary->total_units_count =  $order->calculate->total_units_count;
    $orderSummary->customer_state =  $order->customer_state;
    $line = json_encode($orderSummary);
    return $line;
  }

  protected function append($outputFile, $line)
  {
    $fp = fopen($outputFile, 'a');
    fwrite($fp, $line . "\n");
    fclose($fp);
    return true;
  }
}