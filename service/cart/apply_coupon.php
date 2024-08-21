<?php 
    session_start();
    require_once('../../database.php');

    $db = DBConfig::getDB();


    $stmt = $db->prepare("SELECT * FROM codesale WHERE code = ?");
    $code = $_POST['code'];
    $total = $_POST['total'];
    $stmt->bind_param('s', $_POST['code']);
    $stmt->execute();
    
    $codesale = $stmt->get_result()->fetch_assoc();
    $message = '';
    if($codesale){
      $stmt = $db->prepare("SELECT * FROM user_code where code_id =?");
      $stmt->bind_param('i', $codesale['id']);
      $stmt->execute();

      $user_code = $stmt->get_result()->fetch_assoc();
      if($codesale['endAt'] > date('Y-m-d') || $codesale['deactivate'] == 0) {
        $message = 'Mã này đã hết hiệu lực';
      } else if($codesale['min'] > $total){
        $message = 'Đơn hàng của bạn phải tối thiểu '. $codesale['min']. 'đ để nhận mã giảm giá';
      }else if($user_code){
        $message = 'Bạn đã sử dụng mã giảm giá này';
      } else {
        $messaege = ''.$codesale['code'].'
                    '.$codesale['description'].'';
        if($codesale['method'] == 0){
            $value_discount = ($total * (float)$codesale['value'] / 100);
            if($value_discount > $codesale['max'] && $codesale['max'] != null & $codesale['max'] != ''){
              $value_discount = $codesale['max'];
            }
            $total = $total - $value_discount;
        } else {
            $total = $total - (float)$codesale['value'];
        }

      }
    } else {
      $message = 'Mã giảm giá không tồn tại';
    }

    echo json_encode(['success' => true,'message' => $message, 'code_id' => $codesale['id'], 'total' => $total]);
