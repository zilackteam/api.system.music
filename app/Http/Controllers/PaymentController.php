<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserVip;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PaymentController extends Controller {


    /**
     * @api {post} /payment/charge Create a charge
     * @apiName PaymentCharge
     * @apiGroup Payment
     *
     * @apiParamExample {json} POST Request-Example:
     *      {
     *          'provider' : 'VNP | VMS | VTT | MGC',
     *          'pin': '123..',
     *          'serial' : '123..',
     *      }
     *`
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *
     *          }
     *      }
     */
    public function charge(Request $request) {
        try {

            $data = $request->all();

            $validation = \Validator::make($data, Payment::rules('create'));
            if ($validation->fails()) {
                //Log failed request
                $fileName = 'charge-on-' . date('Y-m-d-H-i-s') . '-' . str_random(5) . '.csv';
                $fp = fopen(upload_path($fileName), 'w');
                fputcsv($fp, $data);
                fclose($fp);

                return $this->responseError($validation->errors()->all(), 422);
            }

//            $client = new Client();
//            $result = $client->post('payment.vnscapp.com/result.php', [
//                'form_params' => [
//                    'provider' => $data['provider'],
//                    'pin' => $data['pin'],
//                    'serial' => $data['serial'],
//                    'username' => \Auth::user()->email
//                ]
//            ]);
//
//            $body = $result->getBody();
//            $response = json_decode($body->getContents());

//            if ($response->m_Status == 1) {

            if (1) {
                //Success
                $myInfo = UserInfo::firstOrNew([
                    'user_id' => \Auth::user()->id,
                ]);

                $myInfo->balance += 50000;
                $myInfo->save();

                return $this->responseSuccess($myInfo);
            } else {
                // Not success
                return $this->responseError(['Unable to charge, please check your card and retry']);
            }

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }

    }
}