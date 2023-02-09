<?php

namespace App\Service;

class MailAnalysis
{
    /***
     * @param $internal_date
     * @param $message
     * @return array|null[]
     */
    public static function regex($internal_date, $message): array
    {
        $data = [];
        $pattern = "/構成比\r\n-+\r\n|\n=+\r\n|\n\r\n【|】 【|】\r\n\r\n=+\r\n\r\n/";
        $split_message = preg_split($pattern,$message);

        if(str_contains($split_message[1], '売上データはありません。')) {
            return [NULL];
        } else {
            // Get proctor_id and proctor name
            $split_header = preg_split("/\r\n/",$split_message[0]);
            $producer_name = str_replace(" 様\r", '', $split_header[1]);
            // Divide sales-info by store.
            $stores = preg_split("/\n-+\r\n/", $split_message[2]);

            foreach ($stores as $store) {
                preg_match('/\(.+?\)/', $store, $match);
                $date = self::editDate($internal_date, $match);
                $store_name = preg_split('/\s:\s/',$store)[0];
                $products = preg_split("/\n/",preg_split("/現在\)\r\n/",$store)[1]);

                foreach ($products as $product)   {
                    $items = preg_split("/\s+/", $product);
                    $product_name = str_replace('（鳥取県産）','',$items[1]);
                    $price = str_replace('円','',$items[2]);
                    $quantity = str_replace('個','',$items[3]);

                    $data[] = [
                        'date' => $date,
                        'hour' => date('H',strtotime($date)),
                        'producer_name' => $producer_name,
                        'store_name' => $store_name,
                        'product_name' => $product_name,
                        'price' => $price,
                        'quantity' => $quantity,
                    ];
                }
            }
            return $data;
        }
    }

    private static function editDate($internal_date,$text): string
    {
        $text = str_replace('(',date('Y',$internal_date).'-',$text);
        $text = str_replace('月', '-',$text);
        $text = str_replace('日', ' ',$text);
        $text = str_replace('時', ':',$text);
        $text = str_replace('分現在)', ':00',$text);
        return date('Y-m-d H:i',strtotime($text[0]));
    }
}
