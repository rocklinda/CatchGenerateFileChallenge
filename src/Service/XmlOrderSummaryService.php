<?php

namespace App\Service;


class XmlOrderSummaryService
{
  static string $format = ".xml";

  static function getOutputFilePath()
  {
    return "storage/order_summary_" . date("Y-m-d-H_i") . static::$format;
  }

  public function createOutputFile($orders)
  {    
    $outputFile = static::getOutputFilePath();
    $xml = new \SimpleXMLElement('<orderSummary></orderSummary>');

    foreach ($orders as $order) {
      $orderNode = $xml->addChild('order');
      $orderNode->addAttribute('id', $order->order_id);
      $orderNode->addChild('orderDateTime', $order->order_datetime);
      $orderNode->addChild('totalOrderValue', $order->calculate->total_order_value);
      $orderNode->addChild('averageUnitPrice', $order->calculate->average_unit_price);
      $orderNode->addChild('distinctUnitCount', $order->calculate->distinct_unit_count);
      $orderNode->addChild('totalUnitsCount', $order->calculate->total_units_count);
      $orderNode->addChild('customerState', $order->customer_state);
    }

    $xml->saveXML($outputFile);

    return $outputFile;

  }
}