<?php
/*
 * *
 *  * This code is licensed under the MIT License.
 *  *
 *  * Copyright (c) 2022 Denis Potapov (https://yooogi.ru)
 *  *
 *  * Permission is hereby granted, free of charge, to any person obtaining a copy
 *  * of this software and associated documentation files (the "Software"), to deal
 *  * in the Software without restriction, including without limitation the rights
 *  * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  * copies of the Software, and to permit persons to whom the Software is
 *  * furnished to do so, subject to the following conditions:
 *  *
 *  * The above copyright notice and this permission notice shall be included in
 *  * all copies or substantial portions of the Software.
 *  *
 *  * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  * THE SOFTWARE.
 *
 */

declare (strict_types=1);

namespace Yooogi\DellinSDK\Endpoints\ManageOrders\Requests;

use Yooogi\DellinSDK\Entities\Member;
use Yooogi\DellinSDK\Entities\OrderId;
use Yooogi\DellinSDK\Enum\PayerType;
use function func_get_args;

/**
 * Запрос сервиса изменения получателя
 *
 * @see https://dev.dellin.ru/api/order/change-receiver/#_header3
 */
final class ChangeReceiverRequest extends OrderId
{
	private Member $receiver;
	private bool $changeOrderPayer = false;
	private PayerType $storePayer;
	private ?Member $third = null;

	/**
	 * Запрос сервиса изменения получателя
	 *
	 * @param string $orderID ID документа
	 * @param Member $receiver Данные нового получателя
	 * @param bool $changeOrderPayer Флаг, обозначающий необходимость назначить нового получателя плательщиком по заказу
	 * @param PayerType $storePayer Сторона, берущая на себя расходы на платное хранение.
	 * @param Member|null $third Данные третьего лица
	 *
	 */
	public function __construct(string $orderID, Member $receiver, bool $changeOrderPayer, PayerType $storePayer, ?Member $third = null)
	{
		parent::__construct($orderID);
		$this->setReceiver($receiver);
		$this->setChangeOrderPayer($changeOrderPayer);
		$this->setStorePayer($storePayer);
		$this->setThird($third);
	}

	/**
	 * Запрос сервиса изменения получателя
	 *
	 * @param string $orderID ID документа
	 * @param Member $receiver Данные нового получателя
	 * @param bool $changeOrderPayer Флаг, обозначающий необходимость назначить нового получателя плательщиком по заказу
	 * @param PayerType $storePayer Сторона, берущая на себя расходы на платное хранение.
	 * @param Member|null $third Данные третьего лица
	 *
	 * @return ChangeReceiverRequest;
	 */

	public static function create(string $orderID, Member $receiver, bool $changeOrderPayer, PayerType $storePayer, ?Member $third = null): ChangeReceiverRequest
	{
		return new ChangeReceiverRequest(...func_get_args());
	}

	/**
	 * Данные нового получателя
	 *
	 * @return Member
	 */
	public function getReceiver(): Member
	{
		return $this->receiver;
	}

	/**
	 * Данные нового получателя
	 *
	 * @param Member $receiver
	 *
	 * @return ChangeReceiverRequest
	 */
	public function setReceiver(Member $receiver): ChangeReceiverRequest
	{
		$this->receiver = $receiver;
		return $this;
	}

	/**
	 * Флаг, обозначающий необходимость назначить нового получателя плательщиком по заказу.
	 *
	 * Возможные значения:
	 *
	 * 'true' - назначить нового получателя плательщиком;
	 * 'false' - не менять плательщика
	 *
	 * @return bool
	 */
	public function isChangeOrderPayer(): bool
	{
		return $this->changeOrderPayer;
	}

	/**
	 * Флаг, обозначающий необходимость назначить нового получателя плательщиком по заказу.
	 *
	 * Возможные значения:
	 *
	 * 'true' - назначить нового получателя плательщиком;
	 * 'false' - не менять плательщика
	 *
	 *
	 * @param bool $changeOrderPayer
	 *
	 * @return ChangeReceiverRequest
	 */
	public function setChangeOrderPayer(bool $changeOrderPayer): ChangeReceiverRequest
	{
		$this->changeOrderPayer = $changeOrderPayer;
		return $this;
	}

	/**
	 * Сторона, берущая на себя расходы на платное хранение.
	 *
	 * Возможные значения:
	 *
	 * 'sender' - отправитель;
	 * 'receiver' - получатель;
	 * 'third' - третье лицо. В случае передачи данного значения, параметр 'third' является обязательным
	 *
	 * @return PayerType
	 */
	public function getStorePayer(): PayerType
	{
		return $this->storePayer;
	}

	/**
	 * Сторона, берущая на себя расходы на платное хранение.
	 *
	 * Возможные значения:
	 *
	 * 'sender' - отправитель;
	 * 'receiver' - получатель;
	 * 'third' - третье лицо. В случае передачи данного значения, параметр 'third' является обязательным
	 *
	 *
	 * @param PayerType $storePayer
	 *
	 * @return ChangeReceiverRequest
	 */
	public function setStorePayer(PayerType $storePayer): ChangeReceiverRequest
	{
		$this->storePayer = $storePayer;
		return $this;
	}

	/**
	 * Данные третьего лица
	 * Если значение параметра 'storePayer' - 'third', то параметр является обязательным
	 *
	 * @return Member|null
	 */
	public function getThird(): ?Member
	{
		return $this->third;
	}

	/**
	 * Данные третьего лица
	 * Если значение параметра 'storePayer' - 'third', то параметр является обязательным
	 *
	 * @param Member|null $third
	 *
	 * @return ChangeReceiverRequest
	 */
	public function setThird(?Member $third): ChangeReceiverRequest
	{
		$this->third = $third;
		return $this;
	}


	public function toArray(): array
	{
		$this->data['orderID'] = $this->orderID;
		$this->data['receiver'] = $this->receiver->toArray();
		$this->data['changeOrderPayer'] = $this->changeOrderPayer;
		$this->data['storePayer'] = $this->storePayer->value;
		if ($this->third) $this->data['third'] = $this->third->toArray();
		return $this->data;
	}
}