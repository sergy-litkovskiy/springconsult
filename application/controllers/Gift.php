<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gift extends MY_Controller
{
    /** @var Gift_model */
    public $gift_model;

    public function ajaxGetGiftList()
    {
        $giftList = $this->gift_model->getGiftListWithArticles();

        print json_encode(['data' => $giftList]);
        exit;
    }

    public function ajaxGiftSubscribe()
    {
        $result = ['success' => false];

        try {
            if (!$data = json_decode(file_get_contents('php://input'), true)) {
                throw new HttpRequestException('Subscribe form is not filled');
            }

            if ($this->validateSubscribeData($data)) {
                $result = $this->trySubscribeProcess($data);
            }

        } catch (RuntimeException $e) {
            $result['error'] = $e->getMessage();
        } catch (HttpRequestException $e) {
            $result['error'] = $e->getMessage();
        } catch (Exception $e) {
            $result['error'] = $e->getMessage();
        }

        print json_encode($result);
        exit;
    }

    private function validateSubscribeData($data)
    {
        if (!$giftId = ArrayHelper::arrayGet($data, 'giftId')) {
            throw new HttpRequestException('Форма заполнена неверно');
        }

        if (!$giftName = ArrayHelper::arrayGet($data, 'giftName')) {
            throw new HttpRequestException('Форма заполнена неверно');
        }

        if (!$userName = ArrayHelper::arrayGet($data, 'userName')) {
            throw new HttpRequestException('Форма заполнена неверно');
        }

        if (!$email = ArrayHelper::arrayGet($data, 'email')) {
            throw new HttpRequestException('Форма заполнена неверно');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new HttpRequestException('Форма заполнена неверно');
        }

        return true;
    }

    private function trySubscribeProcess($data)
    {
        $recipientCandidateData = [
            'name' => ArrayHelper::arrayGet($data, 'userName'),
            'email' => ArrayHelper::arrayGet($data, 'email'),
            'confirmed' => STATUS_ON,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $recipientData = $this->recipient_model->getRecipientData($recipientCandidateData);

        if (!$recipientId = ArrayHelper::arrayGet($recipientData, 'id')) {
            throw new RuntimeException(
                'К сожалению, при регистрации произошла ошибка. Пожалуйста, попробуйте еще раз'
            );
        }

        $subscribeName = ArrayHelper::arrayGet($data, 'giftName', '');
        $subscribeId = ArrayHelper::arrayGet($data, 'giftId', 0);

        $recipientData['subscribe']['name'] = trim(strip_tags($subscribeName));
        $recipientData['subscribe']['id']   = $subscribeId;

        if (!$hashData = $this->linkspacker_model->hashProcess($recipientData, $recipientId)) {
            throw new RuntimeException(
                'К сожалению, при регистрации произошла ошибка. Пожалуйста, попробуйте еще раз'
            );
        }

        return ['success' => true, 'data' => ArrayHelper::arrayGet($hashData, 'url')];
    }

    protected function _subscribeMailProcess($data, $recipientDataArr, $hashLink)
    {
        $this->_trySendSubscribeMail($data, $recipientDataArr, $hashLink);
        try {
            $this->_trySendSubscribeAdminMail($data);
            $this->_tryAddMailHistory($data, $recipientDataArr);
        } catch (Exception $e) {
            $this->mailer_model->sendAdminErrorEmailMessage($e->getMessage());
        }
    }


    protected function _trySendSubscribeMail($data, $recipientDataArr, $hashLink)
    {
        $messId = ArrayHelper::arrayGet($data, 'subscribe_id') ?
            $this->mailer_model->sendFreeProductSubscribeEmailMessage($data, $recipientDataArr, $hashLink) :
            $this->mailer_model->sendArticleSubscribeConfirmationEmailMessage($recipientDataArr, $hashLink);

        Common::assertTrue($messId, "<p class='error'>К сожалению, письмо с сылкой на материал не было отправлено.<br/>Пожалуйста, попробуйте еще раз</p>");

        $this->result['success'] = true;
        $this->result["data"]    = "<p class='success'>Спасибо за подписку!<br>На Ваш e-mail отправлено письмо для подтверждения вашей подписки. Проверьте Ваш почтовый ящик - папку Входящие и СПАМ.</p>";
    }


    protected function _trySendSubscribeAdminMail($data)
    {
        $messId = $this->mailer_model->sendAdminSubscribeEmailMessage($data);
        Common::assertTrue($messId, "<p class='error'>Ошибка при попытке отправить AdminSubscribeEmailMessage</p>");
    }

    protected function _tryAddMailHistory($data, $recipientDataArr)
    {
        $dataMailHistory['subscribe_id']  = ArrayHelper::arrayGet($data, 'subscribe_id');
        $dataMailHistory['recipients_id'] = ArrayHelper::arrayGet($recipientDataArr, 'id');
        $dataMailHistory['date']          = date('Y-m-d');
        $dataMailHistory['time']          = date('H:i:s');
        $mailHistoryId                    = $this->index_model->addInTable($dataMailHistory, 'mail_history');
        Common::assertTrue(
            $mailHistoryId,
            sprintf("<p class='error'>Ошибка! Запись в Mail_history для subscribe_id=%s и recipients_id=%s не произошла</p>",
                ArrayHelper::arrayGet($dataMailHistory, 'subscribe_id'),
                ArrayHelper::arrayGet($dataMailHistory, 'recipients_id')
            )
        );
    }

//    public function showFinishSubscribe($finishSubscribeProcessDataArr)
//    {
//        $this->dataMenu          = array('menu' => $this->arrMenu, 'current_url' => $this->urlArr[count($this->urlArr) - 1]);
//        $recipientData           = $this->index_model->getRecipientById($finishSubscribeProcessDataArr['recipient_id']);
//        $subscribeId             = ArrayHelper::arrayGet($finishSubscribeProcessDataArr, 'subscribe_id');
//        $finishSubscribeTemplate = $subscribeId > 0 ? 'index/finish_free_product_subscribe' : 'index/finish_articles_subscribe';
//
//        $this->data = array(
//            'title'              => SITE_TITLE . ' - subscribe'
//            , 'aforizmus'        => $this->aforizmus
//            , 'meta_keywords'    => DEFAULT_META_KEYWORDS
//            , 'meta_description' => DEFAULT_META_DESCRIPTION
//            , 'recipient_data'   => $recipientData
//            , 'url'              => ArrayHelper::arrayGet($finishSubscribeProcessDataArr, 'url')
//        );
//
//        $data = array(
//            'menu'      => $this->load->view(MENU, $this->dataMenu, true),
//            'content'   => $this->load->view($finishSubscribeTemplate, $this->data, true),
//            'cloud_tag' => $this->load->view('blocks/cloud_tag', $this->cloudsTag, true),
//            'subscribe' => $this->load->view('blocks/subscribe', count($this->subscribe) ? $this->subscribe : null, true));
//        $this->load->view('layout', $data);
//    }

//    private function finishSubscribeProcess($recipientData)
//    {
//        $hash = ArrayHelper::arrayGet($recipientData, 'hashData.hash');
//
//        $hash     = Arr;
//
//        $linksPackerData = $this->linkspacker_model->getOneByParams(['hash' => $hash]);
//        Common::assertTrue($linksPackerData, "");
//
//        $url         = ArrayHelper::arrayGet($linksPackerData, 'url');
//        $linkId      = ArrayHelper::arrayGet($linksPackerData, 'id');
//        $count       = ArrayHelper::arrayGet($linksPackerData, 'count');
//        $subscribeId = ArrayHelper::arrayGet($linksPackerData, 'subscribe_id');
//
//        $updateData = ['count' => $count + 1, 'updated_at' => date('Y-m-d H:i:s')];
//        $this->index_model->updateInTable($linkId, $updateData, 'links_packer');
//
//        $urlParts            = explode('/', $url);
//        $recipientId         = $urlParts[count($urlParts) - 1];
//
//        return (['url' => $url, 'subscribe_id' => $subscribeId, 'recipient_id' => $recipientId]);
//    }

    public function outputSubscribe($subscribeId, $recipientId)
    {
        try {
            Common::assertTrue($subscribeId, "");
            $subscribeDataArr = $this->index_model->getGiftDataArrById($subscribeId);
            Common::assertTrue($subscribeDataArr, "");

            $this->_outputFile(ArrayHelper::arrayGet($subscribeDataArr, 'material_path'));
        } catch (Exception $e) {
            redirect('/index');
        }
    }


    private function _outputFile($fileName)
    {
        $filePath = './subscribegift/' . $fileName;
        if (file_exists($filePath)) {
            header("Content-Type: application/octet-stream");
            header("Accept-Ranges: bytes");
            header("Content-Length: " . filesize($filePath));
            header("Content-Disposition: attachment; filename=" . $fileName);
            readfile($filePath);
        } else {
            redirect('/index');
        }
    }
}