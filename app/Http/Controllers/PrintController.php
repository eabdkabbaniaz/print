<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class PrintController extends Controller
{
  

    


    // public static function printInvoice($order)
    // {
    //     // echo $order;
    //     // اتصال بالطابعة
    //     $connector = new WindowsPrintConnector("smb://MSI/Walaare");
    //     $printer = new Printer($connector);

    //     // طباعة رأس الفاتورة
    //     $printer->setJustification(Printer::JUSTIFY_CENTER);
    //     $printer->text("super star\n");
    //     $printer->text("================================\n");
    //     $printer->text("odrer id : " . $order->id . "\n");
    //     $printer->text("================================\n");
      

    //     // طباعة تفاصيل المنتجات
    //     $printer->text("product           price    amount    total\n");
    //     $printer->text("--------------------------------\n");


    //     foreach ($order->orderdetalis as $detail) {
    //         $productName = $detail->productType->name;
    //         $price = $detail->price_pre_one;
    //         $amount = $detail->amount;
    //         $totalPrice = $detail->total_price;

    //         // تنسيق وتقصير اسم المنتج إذا كان طويلًا
    //         if (strlen($productName) > 15) {
    //             $productName = substr($productName, 0, 15) . '...';
    //         }

    //         $printer->text(sprintf("%-15s %7s %7s %7s\n", $productName, $price, $amount, $totalPrice));
    //     }

      
      

    // //  return $order->offers;
    //  foreach ($order->offers as $offer) {
    //     // ECHO $offer->offerDetails;
    //     foreach ($offer->offerDetails as $offerDetail) {
    //         $offerName = $offerDetail->productType->name;
    //                         $offerPrice = $offerDetail->productType->price;
    //                         $amount = $offerDetail->amount;
    //                         if (strlen($productName) > 15) {
    //                             $productName = substr($offerName, 0, 15) . '...';
    //                         }             
    //                         $printer->text(sprintf("%-19s %7s %7s\n", $offerName, $amount,$offerPrice));
    //     }

    //  }
    //  $printer->setJustification(Printer::JUSTIFY_LEFT);

    //     // // طباعة العروض (إذا كانت موجودة)
    //     // if (!empty($order->offers) ) {
    //     //     foreach ($order->offers as $offer) {
    //     //         if (!empty($offer->offer_details)) {
    //     //             foreach ($offer->offer_details as $offerDetail) {
    //     //                 $offerName = $offerDetail->productType->name;
    //     //                 $offerPrice = $offerDetail->productType->price;
    //     //                 $amount = $offerDetail->amount;
                      
    //     //                 $printer->text(sprintf("%-15s %7s %7s\n", $offerName, $offerPrice, $amount));
    //     //             }
    //     //         }
    //     //     }
    //     // }
    //     $printer->text("total price : " . $order->price . "\n");
    
    //        // طباعة الملاحظات (إذا كانت موجودة)
    //        if (!empty($order->notes->notes)) {
    //         $printer->text("================================\n");
    //         $printer->text("Notes:\n");
    //         $printer->text($order->notes->notes . "\n");
    //     }

    //     // إنهاء الطباعة وقطع الورق
    //     // $printer->cut();
    //     $printer->close();

    //     return response()->json(['message' => 'تمت الطباعة بنجاح']);
    // }
    public static function printInvoice($order)
    {
      // إنشاء النص الذي سيتم طباعته
      $printData = "";
      // طباعة رأس الفاتورة
      $printData .= "               super star                                           \n";
      $printData .= "================================\n";
      $printData .= "order id: " . $order->id . "\n";
      $printData .= "================================\n";
    switch ($order->type_id){
      case 1:
        $type ="internal";
        $printData .="table number: " .$order->table->table_id. "\n";
        break;
      case 2:
        $type ="external";
          break;
        case 3:
        $type ="local";
            break;
        }
  
      $printData .="order type: " .$type. "\n";
      $printData .= "================================\n";
  
      // طباعة تفاصيل المنتجات
      $printData .= "منتج                     سعر         كمية         كلي\n";
      $printData .= "--------------------------------\n";
  
      foreach ($order->orderdetalis as $detail) {
        $productName = $detail->productType->name;
        $price = $detail->price_pre_one;
        $amount = $detail->amount;
        $totalPrice = $detail->total_price;
  
        // تنسيق وتقصير اسم المنتج إذا كان طويلًا
        if (strlen($productName) > 15) {
          $productName = substr($productName, 0, 15) . '...';
        }
  
        $printData .= sprintf("%-15s %7s %7s %7s\n", $productName, $price, $amount, $totalPrice);
      }
  
      // طباعة العروض (إن وجدت)
      if (!empty($order->offers)) {
        $printData .= "Offers:\n";
        $printData .= "اسم العرض         منتج                   سعر         كمية         كلي \n";
        $printData .= "--------------------------------\n";
        foreach ($order->offers as $offer) {
          // echo $offer->offerDetails;
          // echo $offer->offerDetails->product_type;
  
          // echo $offer->orderDetalis;
          foreach ($offer->offerDetails as $offerDetail) {
  
            // echo $offerDetail->productType;
  
            $thename=$offer->name;
            $offerName = $offerDetail->productType->name;
  
            $offerPrice = $offerDetail->productType->price;
            $amount = $offerDetail->amount;
            $totalPrice = $offerPrice * $amount;
  
            // تنسيق وتقصير اسم العرض إذا كان طويلًا
            if (strlen($offerName) > 15) {
              $offerName = substr($offerName, 0, 15) . '...';
            }
  
            $printData .= sprintf("%-22s %-15s %7s %7s %7s\n", $thename,$offerName, $offerPrice, $amount, $totalPrice);
          }
        }
      
      }
      // طباعة السعر الإجمالي
      $printData .= "total price : " . $order->price . "\n";
  
      // طباعة الملاحظات (إن وجدت)
      if (!empty($order->notes->notes)) {
        $printData .= "================================\n";
        $printData .= "   ملاحظات          \n";
              $printData .= $order->notes->notes;
  
      }
  
      // حفظ النص في ملف مؤقت للطباعة
      $filePath = storage_path("app/فاتورة.txt");
      file_put_contents($filePath, $printData);
  
      // استخدام Powershell للطباعة على ويندوز
      $command = "powershell -Command \"Start-Process -FilePath 'notepad.exe' -ArgumentList '/p', '$filePath'\"";
      $output = shell_exec($command);
  
      return response()->json(['message' => 'تمت الطباعة بنجاح', 'output' ]);
    }

}
