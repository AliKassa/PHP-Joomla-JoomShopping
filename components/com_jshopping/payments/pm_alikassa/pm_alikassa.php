<?php

defined('_JEXEC') or die('Restricted access');

class pm_alikassa extends PaymentRoot
{

    function showPaymentForm($params, $pmconfigs)
    {
        include(dirname(__FILE__)."/paymentform.php");
    }

    function showAdminFormParams($params)
    {
        $jmlThisDocument = & JFactory::getDocument();
        $array_params = array('secret_key', 'useSign', 'merchant_uuid', 'hashAlgo', 'transaction_end_status', 'transaction_pending_status', 'transaction_failed_status');
        foreach ($array_params as $key)
            if (!isset($params[$key])) 
                $params[$key] = '';
        $orders = JSFactory::getModel('orders', 'JshoppingModel');
        include(dirname(__FILE__)."/adminparamsform.php");  
    }


    function checkTransaction($pmconfigs, $order, $act)
    {

            $jshopConfig = JSFactory::getConfig();
            saveToLog("paymentdata.log", "start cheking!!!");

            $merchant_id = $pmconfigs['merchant_uuid'];

            $key_sign = $pmconfigs['secret_key'];
       
            $data = array();
            foreach ($_REQUEST as $key => $value) {
                $data[$key] = $value;
            }
            $sign = $data['sign'];
            unset($data['sign']);
            ksort($data, SORT_STRING);
            array_push($data, $key_sign);
            $signString = implode(':', $data);
            $sign = base64_encode(hash($pmconfigs['hashAlgo'], $signString, true));

            if($sign === $sign && $data['merchantUuid'] === $merchant_id){
                $order_id = $data['orderId'];
                if($data['payStatus'] == 'success'){
                    return array(1, 'Заказ #'.$order_id.' успешно оплачен с помощью "Аликассы"');                
                } else {
                    return array(4, 'Платеж по заказу: #'.$order_id.'. был отменен!');
                }
            } else {
                return array(0, 'Error signature.');
            }
        
    }

    function showEndForm($pmconfigs, $order)
    {
    $jshopConfig = &JSFactory::getConfig();        
        
    $action_url = "https://sci.alikassa.com/payment";
    $order_id = $order->order_id;

    //params set
    $params = array(
        'amount' => number_format($order->order_total, 2, ".", ""),
        'currency' => $order->currency_code_iso,
        'merchantUuid' => $pmconfigs['merchant_uuid'],
        'orderId' => $order_id,
        'desc' => "#$order_id",
    );

    ksort($params, SORT_STRING);
    $params['secret'] = $pmconfigs['secret_key'];
    $signString = implode(':', $params);

    $signature = base64_encode(hash($pmconfigs['hashAlgo'], $signString, true));
    unset($params["secret"]);
    $params["sign"] = $signature;
	
    
?>
    <html>
    <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />          
    </head>        
    <body>
    <form id="paymentform" action="<?php print $action_url?>" name = "paymentform" method = "POST">
        <input type=hidden name="amount" value='<?php print $params['amount']; ?>'>
        <input type=hidden name="merchantUuid" value='<?php print $params['merchantUuid']; ?>'>
        <input type=hidden name="orderId" value='<?php print $params['orderId']; ?>'>
        <input type=hidden name="currency" value='<?php print $params['currency']; ?>'>
        <input type=hidden name="desc" value='<?php print $params['desc']; ?>'>
		<?php if($pmconfigs['useSign'] == 'y'){ ?>
        <input type=hidden name="sign" value='<?php print $params['sign']; ?>'>
		<?php } ?>
    </form>        
        <?php print _JSHOP_REDIRECT_TO_PAYMENT_PAGE ?>
        <br>

    <script type="text/javascript">console.log(<?php echo $order->currency_code_iso; ?>);</script>
        <script type="text/javascript">document.getElementById('paymentform').submit();</script>
        </body>
        </html>
        <?php
        die();
    }

    function getUrlParams($pmconfigs){
        $params = array();
        $params['order_id'] = JFactory::getApplication()->input->getInt("orderId");
        $params['hash'] = "";
        $params['checkHash'] = 0;
        $params['checkReturnParams'] = 0;
        return $params;
    }

}
?>