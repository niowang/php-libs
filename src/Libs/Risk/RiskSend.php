<?php

namespace JMD\Libs\Risk;

use JMD\Libs\Risk\Interfaces\Request;

class RiskSend
{
    /** @var  Request */
    public $request;

    // 银行卡
    const TYPE_BANK_CARD = 'BANK_CARD';
    // 催收记录
    const TYPE_COLLECTION_RECORD = 'COLLECTION_RECORD';
    // 订单
    const TYPE_ORDER = 'ORDER';
    // 订单详情
    const TYPE_ORDER_DETAIL = 'ORDER_DETAIL';
    // 还款计划
    const TYPE_REPAYMENT_PLAN = 'REPAYMENT_PLAN';
    // 用户
    const TYPE_USER = 'USER';
    // 用户认证
    const TYPE_USER_AUTH = 'USER_AUTH';
    // 紧急联系人
    const TYPE_USER_CONTACT = 'USER_CONTACT';
    // 用户信息
    const TYPE_USER_INFO = 'USER_INFO';
    // 第三方数据表
    const TYPE_USER_THIRD_DATA = 'USER_THIRD_DATA';
    // 用户工作信息
    const TYPE_USER_WORK = 'USER_WORK';
    // 应用列表
    const TYPE_USER_APPLICATION = 'USER_APPLICATION';
    // 通讯录
    const TYPE_USER_CONTACTS_TELEPHONE = 'USER_CONTACTS_TELEPHONE';
    // 硬件信息
    const TYPE_USER_PHONE_HARDWARE = 'USER_PHONE_HARDWARE';
    // 相册信息
    const TYPE_USER_PHONE_PHOTO = 'USER_PHONE_PHOTO';
    // 位置信息
    const TYPE_USER_POSITION = 'USER_POSITION';
    // 短信记录
    const TYPE_USER_SMS = 'USER_SMS';
    // 人审记录表
    const TYPE_MANUAL_APPROVE_LOG = 'MANUAL_APPROVE_LOG';

    const ALL_TYPE = [
        self::TYPE_BANK_CARD,
        self::TYPE_COLLECTION_RECORD,
        self::TYPE_ORDER,
        self::TYPE_ORDER_DETAIL,
        self::TYPE_REPAYMENT_PLAN,
        self::TYPE_USER,
        self::TYPE_USER_AUTH,
        self::TYPE_USER_CONTACT,
        self::TYPE_USER_INFO,
        self::TYPE_USER_THIRD_DATA,
        self::TYPE_USER_WORK,
        self::TYPE_USER_APPLICATION,
        self::TYPE_USER_CONTACTS_TELEPHONE,
        self::TYPE_USER_PHONE_HARDWARE,
        self::TYPE_USER_PHONE_PHOTO,
        self::TYPE_USER_POSITION,
        self::TYPE_USER_SMS,
        self::TYPE_MANUAL_APPROVE_LOG,
    ];

    // 渠道
    const COMMON_TYPE_CHANNEL = 'CHANNEL';

    const COMMON_ALL_TYPE = [
        self::COMMON_TYPE_CHANNEL,
    ];

    const ROUTER_SEND_DATA_ALL = '/api/risk/send_data/all';

    const ROUTER_SEND_DATA_COMMON = '/api/risk/send_data/common';

    public function __construct($appKey, $secretKey, $domain)
    {
        $this->request = new BaseRequest($appKey, $secretKey);
        $this->request->setDomain($domain);
        $this->isSendUserAll();
    }

    public function isSendUserAll()
    {
        $this->request->setUrl(self::ROUTER_SEND_DATA_ALL);
    }

    public function isSendCommon()
    {
        $this->request->setUrl(self::ROUTER_SEND_DATA_COMMON);
    }

    public function setUserId($userId)
    {
        $this->addBaseRequest('user_id', $userId);
    }

    public function setTaskNo($taskNo)
    {
        $this->addBaseRequest('task_no', $taskNo);
    }

    public function setBankCard($data)
    {
        $this->addBaseRequest(self::TYPE_BANK_CARD, $data);
    }

    public function setCollectionRecord($data)
    {
        $this->addBaseRequest(self::TYPE_COLLECTION_RECORD, $data);
    }

    public function setOrder($data)
    {
        $this->addBaseRequest(self::TYPE_ORDER, $data);
    }

    public function setOrderDetail($data)
    {
        $this->addBaseRequest(self::TYPE_ORDER_DETAIL, $data);
    }

    public function setRepaymentPlan($data)
    {
        $this->addBaseRequest(self::TYPE_REPAYMENT_PLAN, $data);
    }

    public function setUser($data)
    {
        $this->addBaseRequest(self::TYPE_USER, $data);
    }

    public function setUserAuth($data)
    {
        $this->addBaseRequest(self::TYPE_USER_AUTH, $data);
    }

    public function setUserContact($data)
    {
        $this->addBaseRequest(self::TYPE_USER_CONTACT, $data);
    }

    public function setUserInfo($data)
    {
        $this->addBaseRequest(self::TYPE_USER_INFO, $data);
    }

    public function setUserThirdData($data)
    {
        $this->addBaseRequest(self::TYPE_USER_THIRD_DATA, $data);
    }

    public function setUserWork($data)
    {
        $this->addBaseRequest(self::TYPE_USER_WORK, $data);
    }

    public function setUserApplication($data)
    {
        $this->addBaseRequest(self::TYPE_USER_APPLICATION, $data);
    }

    public function setUserContactsTelephone($data)
    {
        $this->addBaseRequest(self::TYPE_USER_CONTACTS_TELEPHONE, $data);
    }

    public function setUserPhoneHardware($data)
    {
        $this->addBaseRequest(self::TYPE_USER_PHONE_HARDWARE, $data);
    }

    public function setUserPhonePhoto($data)
    {
        $this->addBaseRequest(self::TYPE_USER_PHONE_PHOTO, $data);
    }

    public function setUserPosition($data)
    {
        $this->addBaseRequest(self::TYPE_USER_POSITION, $data);
    }

    public function setUserSms($data)
    {
        $this->addBaseRequest(self::TYPE_USER_SMS, $data);
    }

    public function setManualApproveLog($data)
    {
        $this->addBaseRequest(self::TYPE_MANUAL_APPROVE_LOG, $data);
    }

    public function setChannel($data)
    {
        $this->addBaseRequest(self::COMMON_TYPE_CHANNEL, $data);
    }

    private function addBaseRequest($field, $val)
    {
        $data = $this->request->data;
        $data[$field] = $val;
        $this->request->setData($data);
    }

    public function execute()
    {
        return new DataFormat($this->request->execute());
    }
}
