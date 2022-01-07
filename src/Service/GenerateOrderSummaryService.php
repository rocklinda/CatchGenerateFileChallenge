<?php

namespace App\Service;

use App\Entity\OrderSummary;

class GenerateOrderSummaryService
{
  
  private const URL = 'https://s3-ap-southeast-2.amazonaws.com/catch-code-challenge/challenge-1-in.jsonl';
  
  public function generate(string $format, string $email = null)
  {
    try {
      $openFile = fopen(self::URL, 'r');
      $i = 0;
      while ((!feof($openFile)) && ($line = fgets($openFile)) !== false) {
        if ($data = $this->isValid($line)) {
          $i++;
          $order = new OrderSummary($data);
          dd($order);
        }
      }
      fclose($stream);
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