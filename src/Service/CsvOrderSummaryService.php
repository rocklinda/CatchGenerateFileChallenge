<?php

namespace App\Service;

use App\Entity\OrderSummary;

class CsvOrderSummaryService
{  
  static string $format = ".csv";
  
  static $HEADERS = array(
    "order_id",
    "order_date_time",
    "total_order_value",
    "average_unit_price",
    "distinct_unit_count",
    "total_units_count",
    "customer_state",
  );

  static function getOutputFilePath()
  {
    return "storage/order_summary_" . date("Y-m-d-H_i") . static::$format;
  }

  public function createOutputFile($orders)
  {
    $outputFile = static::getOutputFilePath();
    $fp = fopen($outputFile, 'w');
    fputcsv($fp, static::$HEADERS);
    fclose($fp);

    foreach ($orders as $order) {
      $line = $this->transform($order);
      $this->append($outputFile, $line);
    }
    return $outputFile;
  }

  public function transform(OrderSummary $order)
  {
    $line = array(
      $order->order_id,
      $order->order_datetime,
      $order->calculate->total_order_value,
      $order->calculate->average_unit_price,
      $order->calculate->distinct_unit_count,
      $order->calculate->total_units_count,
      $order->customer_state,
    );
    return $line;
  }

  protected function append($outputFile, $line)
  {
    $fp = fopen($outputFile, 'a');
    fputcsv($fp, $line);
    fclose($fp);
    return true;
  }
}