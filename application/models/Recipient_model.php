<?php
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recipient_model extends Crud
{
    public function __construct()
    {
        parent::__construct();

        $this->idkey = 'id';
        $this->table = 'recipients';
    }

    public function getRecipientData($data)
    {
        $recipientData = $this->getOneByParams(['email' => ArrayHelper::arrayGet($data, 'email')]);

        if (!$recipientData) {
            $data['confirmed']      = ArrayHelper::arrayGet($data, 'confirmed', STATUS_OFF);
            $data['unsubscribed']   = STATUS_OFF;

            if (!$recipientId = $this->add($data)) {
                throw new RuntimeException(
                    'К сожалению, при регистрации произошла ошибка. Пожалуйста, попробуйте еще раз'
                );
            }

            $recipientData = [
                'id' => $recipientId,
                'name' => ArrayHelper::arrayGet($data, 'name'),
                'email' => ArrayHelper::arrayGet($data, 'email'),
                'phone' => ArrayHelper::arrayGet($data, 'phone', ''),
                'confirmed' => ArrayHelper::arrayGet($data, 'confirmed', STATUS_OFF),
                'unsubscribed' => STATUS_OFF,
            ];
        }

        return $recipientData;
    }
}