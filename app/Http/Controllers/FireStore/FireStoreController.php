<?php

namespace App\Http\Controllers\FireStore;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FireStoreController extends Controller
{
    protected $firestoreDB;
    public function __construct()
    {
        $credentialsPath = env('FIREBASE_CREDENTIALS');
        if (!file_exists($credentialsPath)) {
            throw new \Exception("Firebase credentials file not found at path: " . $credentialsPath);
        }
        $serviceAccount = json_decode(file_get_contents($credentialsPath), true);
        $factory = (new Factory)->withServiceAccount($serviceAccount);
        $this->firestoreDB = $factory->createFirestore()->database();
     
    }
    
    public function store(Request $request)
    {
        try {
        
            $result = $this->firestoreDB->collection('users')->add([
                'name' => 'Abdul Moiz',
                'email' => 'abdulmoiz@example.com',
            ]);
    
            dd('Document added successfully. Document ID: ' . $result->id());
            
        } catch (\Exception $e) {
            dd("Error: " . $e->getMessage()); 
        }
   }
    
    // public function store()
    // {
           
    //     // تهيئة Firebase
    //     $factory = (new Factory)->withServiceAccount(config_path('firebase_credentials.json'));
    //     $database = $factory->createDatabase();
        
    //     // تحديد البيانات التي تريد إضافتها
    //     $orderData = [
    //         'order' => 'Order123',
    //         'status' => 'Pending'
    //     ];
        
    //     // إضافة البيانات إلى قاعدة البيانات
    //     $reference = $database->getReference('orders')->push($orderData);
        
    //     echo 'Data added with key: ' . $reference->getKey();
        
    // }
}
