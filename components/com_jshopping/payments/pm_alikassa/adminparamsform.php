<?php

defined('_JEXEC') or die('Restricted access');
$protocol;
if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443){
  $protocol = 'https://';
} else {
  $protocol = 'http://';
}
?>

<div class="col100">
<fieldset class="adminform">
<table class="admintable" width = "100%" >

 <tr>
   <td  class="key">
     <?php echo 'Идентификатор мерчанта';?>
   </td>
   <td>
     <input type = "text" class = "inputbox" name = "pm_params[merchant_uuid]" size="45" value = "<?php echo $params['merchant_uuid']?>" />
     <span class="hasTooltip" title="Номер кошелька в системе Аликасса"><img src="/media/system/images/tooltip.png" alt="Tooltip"></span>
   </td>
 </tr>
   <tr>
   <td  class="key">
     <?php echo 'Секретный ключ';?>
   </td>
   <td>
     <input type = "password" class = "inputbox" name = "pm_params[secret_key]" size="45" value = "<?php echo $params['secret_key']?>" />
     <span class="hasTooltip" title="Секретный ключ для подписи платежа"><img src="/media/system/images/tooltip.png" alt="Tooltip"></span>
   </td>
 </tr>`
 <tr>
   <td  class="key">
     <?php echo 'Метод шифрования подписи платежа'?>
   </td>
   <td>
     <input type="checkbox" class = "inputbox" name = "pm_params[hashAlgo]" size="45" value = "md5" <?php if($params['hashAlgo'] == 'md5'){ echo 'checked'; } ?>/> MD5
	 <input type="checkbox" class = "inputbox" name = "pm_params[hashAlgo]" size="45" value = "sha256" <?php if($params['hashAlgo'] == 'sha256'){ echo 'checked'; } ?>/> SHA256
     <span class="hasTooltip" title="Метод широфвания подписи платежа"><img src="/media/system/images/tooltip.png" alt="Tooltip"></span>
   </td>
 </tr>
 <tr>
   <td  class="key">
     <?php echo 'Использовать ли подпись платежа?'?>
   </td>
   <td>
     <input type="checkbox" class = "inputbox" name = "pm_params[useSign]" size="45" value = "y" <?php if($params['useSign'] == 'y'){ echo 'checked'; } ?>/> Да
	 <input type="checkbox" class = "inputbox" name = "pm_params[useSign]" size="45" value = "n" <?php if($params['useSign'] == 'n'){ echo 'checked'; } ?>/> Нет
     <span class="hasTooltip" title="Использовать ли подпись платежа"><img src="/media/system/images/tooltip.png" alt="Tooltip"></span>
   </td>
 </tr>

 
 <tr>
   <td class="key">
     <?php echo 'Статус заказа после успешной транзакции';?>
   </td>
   <td>
     <?php              
         print JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_end_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_end_status'] );
     ?>
   </td>
 </tr>
 <tr>
   <td class="key">
     <?php echo 'Статус заказа в процессе транзакции';?>
   </td>
   <td>
     <?php 
         echo JHTML::_('select.genericlist',$orders->getAllOrderStatus(), 'pm_params[transaction_pending_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_pending_status']);
     ?>
   </td>
 </tr>
 <tr>
   <td class="key">
     <?php echo 'Статус заказа при неуспешной транзакции';?>
   </td>
   <td>
     <?php 
     echo JHTML::_('select.genericlist',$orders->getAllOrderStatus(), 'pm_params[transaction_failed_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_failed_status']);
     ?>
   </td>
 </tr>

 <tr>
   <td  class="key">
     <?php echo 'URL успешной оплаты:'?>
   </td>
   <td>
     <input style="width:725px;" type = "text" readonly class = "inputbox" name = "pm_params[success_url]" size="45" value = "<?php echo $protocol.$_SERVER['SERVER_NAME'];?>/index.php?option=com_jshopping&controller=checkout&task=step7&act=return&js_paymentclass=pm_alikassa" />
     <span class="hasTooltip" title="Вставить в настройках кассы в поле: URL успешной оплаты"><img src="/media/system/images/tooltip.png" alt="Tooltip"></span>
   </td>
 </tr>

  <tr>
   <td  class="key">
     <?php echo 'URL неуспешной оплаты:'?>
   </td>
   <td>
     <input style="width:725px;" type = "text" readonly class = "inputbox" name = "pm_params[fail_url]" size="45" value = "<?php echo $protocol.$_SERVER['SERVER_NAME'];?>/index.php?option=com_jshopping&controller=checkout&task=step7&act=cancel&js_paymentclass=pm_alikassa" />
     <span class="hasTooltip" title="Вставить в настройках кассы в поле: URL неуспешной оплаты"><img src="/media/system/images/tooltip.png" alt="Tooltip"></span>
   </td>
 </tr>

  <tr>
   <td  class="key">
     <?php echo 'URL взаимодействия:'?>
   </td>
   <td>
     <input style="width:725px;" type = "text" readonly class = "inputbox" name = "pm_params[notify_url]" size="45" value = "<?php echo $protocol.$_SERVER['SERVER_NAME'];?>/index.php?option=com_jshopping&controller=checkout&task=step7&act=notify&js_paymentclass=pm_alikassa&no_lang=1" />
     <span class="hasTooltip" title="Вставить в настройках кассы в поле: URL взаимодействия"><img src="/media/system/images/tooltip.png" alt="Tooltip"></span>
   </td>
 </tr>


</table>
</fieldset>   
<div class="clr"></div>

