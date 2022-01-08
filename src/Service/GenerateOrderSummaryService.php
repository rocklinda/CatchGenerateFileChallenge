<?php

namespace App\Service;

use App\Entity\OrderSummary;
use App\Utility\FormatFileEnum;
use App\Service\CsvOrderSummaryService;
use App\Service\JsonlOrderSummaryService;
use App\Service\XmlOrderSummaryService;

class GenerateOrderSummaryService
{
  
  /**
   * @var CsvOrderSummaryService
   */
  private CsvOrderSummaryService $csvOrderSummaryService;

  /**
   * @var JsonlOrderSummaryService
   */
  private JsonlOrderSummaryService $jsonlOrderSummaryService;

  /**
   * @var XmlOrderSummaryService
   */
  private XmlOrderSummaryService $xmlOrderSummaryService;

  private const URL = 'https://s3-ap-southeast-2.amazonaws.com/catch-code-challenge/challenge-1-in.jsonl';

  public function __construct(
    CsvOrderSummaryService $csvOrderSummaryService,
    JsonlOrderSummaryService $jsonlOrderSummaryService,
    XmlOrderSummaryService $xmlOrderSummaryService
  )
  {
      $this->csvOrderSummaryService = $csvOrderSummaryService;

      $this->jsonlOrderSummaryService = $jsonlOrderSummaryService;

      $this->xmlOrderSummaryService = $xmlOrderSummaryService;
  }
  
  public function generate(string $format, string $email = null)
  {
    try {
      $openFile = fopen(self::URL, 'r');
      $orders = [];
      $i = 0;
      while ((!feof($openFile)) && ($line = fgets($openFile)) !== false) {
        $data = $this->isValid($line);
        if (!empty($data)) {
          $i++;
          $order = new OrderSummary($data);
          $orders [] = $order;
        }
      }
      fclose($openFile);

      switch ($format) {
        case FormatFileEnum::$JSONL:
          $this->jsonlOrderSummaryService->createOutputFile($orders);
          break;

        case FormatFileEnum::$XML:
          $this->xmlOrderSummaryService->createOutputFile($orders);
          break;
        
        default:
          $this->csvOrderSummaryService->createOutputFile($orders);
          break;
      }

    } catch (\Throwable $th) {
      throw $th;
    }
  }

  private function isValid($line)
  {
    $data = json_decode($line);
    return isset($data->order_id) ? $data : null;
  }
}