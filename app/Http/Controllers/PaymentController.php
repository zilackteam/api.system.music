<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Models\UserVip;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PaymentController extends Controller {


    /**
     * @api {post} /payment/:singerId/charge Create a charge
     * @apiName PaymentCharge
     * @apiGroup Payment
     *
     * @apiParam singerId - ID of singer
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
    public function charge(Request $request, $singerId) {
        try {

            $data = $request->all();

            $singer = User::findOrFail($singerId);
            if ($singer->role != 'singer') {
                return $this->responseError(['Invalid request'], 400);
            }

            $validation = \Validator::make($data, Payment::rules('create'));
            if ($validation->fails()) {

                //Log failed request
                $fileName = 'charge-on-' . date('Y-m-d-H-i-s') . '-' . str_random(5) . '.csv';
                $fp = fopen(upload_path($fileName), 'w');
                fputcsv($fp, $data);
                fclose($fp);

                return $this->responseError($validation->errors()->all(), 422);
            }

            $client = new Client();
            $result = $client->post('payment.vnscapp.com/result.php', [
                'form_params' => [
                    'provider' => $data['provider'],
                    'pin' => $data['pin'],
                    'serial' => $data['serial'],
                    'username' => \Auth::user()->email
                ]
            ]);

            $body = $result->getBody();
            $response = json_decode($body->getContents());

            if ($response->m_Status == 1) {
                //Success

                $myVip = UserVip::firstOrNew([
                    'user_id' => \Auth::user()->id,
                    'singer_id' => $singerId,
                ]);

                if ($myVip->id) {
                    // Vip before
                    if ($myVip->isVip()) {
                        //Current VIP => Only add money
                        $myVip->balance += (int) $response->m_RESPONSEAMOUNT;
                        $myVip->save();
                        return $this->responseSuccess(['Charge successfully']);
                    } else {
                        //Expired VIP => Charge + add
                        $myVip->balance += (int) $response->m_RESPONSEAMOUNT;
                        $result = $myVip->chargeVip();
                        if ($result) {
                            return $this->responseSuccess(['Become VIP successfully!']);
                        } else {
                            return $this->responseError(['Charge success but unable to setup VIP. Please contact us for help'], 500);
                        }
                    }
                } else {
                    // Never vip
                    $myVip->balance =  (int) $response->m_RESPONSEAMOUNT;
                    $result = $myVip->chargeVip();
                    if ($result) {
                        return $this->responseSuccess(['Become VIP successfully!']);
                    } else {
                        return $this->responseError(['Charge success but unable to setup VIP. Please contact us for help'], 500);
                    }
                }


            } else {
                // Not success
                return $this->responseError(['Unable to charge, please check your card and retry']);
            }

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }

    }

    /**
     * @api {get} /payment/:singerId/status Check payment status
     * @apiName PaymentStatus
     * @apiGroup Payment
     *
     * @apiParam singerId - ID of singer
     *
     * * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *              'id' => 1
     *              'singer_id' => 2
     *              'user_id' => 10
     *              'status' => 1 //0 : Not VIP. 1: IS VIP
     *              'active_date' => '2016-01-01'
     *              'balance' => 50000
     *          }
     *      }
     */
    public function status(Request $request, $singerId) {
        try {
            $singer = User::findOrFail($singerId);
            if ($singer->role != 'singer') {
                return $this->responseError(['Invalid request'], 400);
            }

            $myVip = UserVip::where([
                'user_id' => \Auth::user()->id,
                'singer_id' => $singerId
            ])->firstOrFail();

            //Check VIP status
            if (!$myVip->isVip() && !$myVip->chargeVip()) {
                $myVip->status = UserVip::STATUS_NORMAL;
                $myVip->save();
            }

            return $this->responseSuccess($myVip);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {post} /payment/:singerId/subscribe Become VIP
     * @apiName PaymentSubscribe
     * @apiGroup Payment
     *
     * @apiParam singerId - ID of singer
     */
    public function subscribe(Request $request, $singerId) {
        try {
            $singer = User::findOrFail($singerId);
            if ($singer->role != 'singer') {
                return $this->responseError(['Invalid request'], 400);
            }

            $myVip = UserVip::where([
                'user_id' => \Auth::user()->id,
                'singer_id' => $singerId
            ])->firstOrFail();

            if ($myVip->isVip()) {
                // Still VIP
                return $this->responseError(['Already VIP'], 400);
            } else {
                //Expired VIP => Update
                $result = $myVip->chargeVip();
                if ($result) {
                    return $this->responseSuccess(['Become VIP successfully!']);
                } else {
                    return $this->responseError(['Unable to update VIP. Check your balance or contact us'], 500);
                }
            }

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

}