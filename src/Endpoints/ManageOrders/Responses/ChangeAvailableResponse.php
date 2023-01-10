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

namespace Yooogi\DellinSDK\Endpoints\ManageOrders\Responses;

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Entities\ChangeInfo;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Entities\SuspendResume;
use Yooogi\DellinSDK\Enum\ChangeAvailableType;
use Yooogi\DellinSDK\Instantiator;

class ChangeAvailableResponse implements Arrayable
{
	use DataAware;

	private ChangeInfo $receiver;
	private ChangeInfo $payer;
	private ChangeInfo $pickupInfo;
	private ChangeInfo $deliveryInfo;
	private ChangeInfo $cancelPickup;
	private ChangeInfo $cancelDelivery;
	private ChangeInfo $changeSender;
	private ChangeInfo $changeReceiver;


	private SuspendResume $suspend;
	private SuspendResume $resume;

	/**
	 *    Информация о возможности изменения получателя заказа
	 *
	 * @return ChangeInfo
	 */
	public function getReceiver(): ChangeInfo
	{
		return Instantiator::instantiate(ChangeInfo::class, $this->get('receiver'));
	}

	/**
	 * Информация о возможности изменения плательщика по заказу
	 *
	 * @return ChangeInfo
	 */
	public function getPayer(): ChangeInfo
	{
		return Instantiator::instantiate(ChangeInfo::class, $this->get('payer'));
	}

	/**
	 * Информация о возможности изменения адреса отправки, а также времени передачи груза водителю-экспедитору на адресе отправки
	 *
	 * @return ChangeInfo
	 */
	public function getPickupInfo(): ChangeInfo
	{
		return Instantiator::instantiate(ChangeInfo::class, $this->get('pickupInfo'));
	}

	/**
	 *    Информация о возможности изменения адреса доставки, а также времени получения груза на адресе доставки
	 *
	 * @return ChangeInfo
	 */
	public function getDeliveryInfo(): ChangeInfo
	{
		return Instantiator::instantiate(ChangeInfo::class, $this->get('deliveryInfo'));
	}

	/**
	 * Информация о возможности отмены заявки на доставку от адреса отправителя
	 *
	 * @return ChangeInfo
	 */
	public function getCancelPickup(): ChangeInfo
	{
		return Instantiator::instantiate(ChangeInfo::class, $this->get('cancelPickup'));
	}

	/**
	 * Информация о возможности отмены заявки на доставку до адреса получателя
	 * (для получения груза клиенту необходимо будет приехать на терминал компании 'Деловые Линии')
	 *
	 * @return ChangeInfo
	 */
	public function getCancelDelivery(): ChangeInfo
	{
		return Instantiator::instantiate(ChangeInfo::class, $this->get('cancelDelivery'));
	}

	/**
	 * Информация о возможности приостановки выдачи груза
	 *
	 * @return SuspendResume
	 */
	public function getSuspend(): SuspendResume
	{
		return Instantiator::instantiate(SuspendResume::class, $this->get('suspend'));
	}

	/**
	 * Информация о возможности возобновления выдачи груза
	 *
	 * @return SuspendResume
	 */
	public function getResume(): SuspendResume
	{
		return Instantiator::instantiate(SuspendResume::class, $this->get('resume'));
	}

	/**
	 *    Информация о возможности изменения контактных данных отправителя
	 *
	 * @return ChangeInfo
	 */
	public function getChangeSender(): ChangeInfo
	{
		return Instantiator::instantiate(ChangeInfo::class, $this->getObject('contactInfo')?->get('changeSender'));
	}

	/**
	 *    Информация о возможности изменения контактных данных получателя
	 *
	 * @return ChangeInfo
	 */
	public function getChangeReceiver(): ChangeInfo
	{
		return Instantiator::instantiate(ChangeInfo::class, $this->getObject('contactInfo')?->get('changeReceiver'));
	}

	/**
	 * Получить возможное изменение по Enum типу ChangeAvailableType
	 *
	 * @param ChangeAvailableType $changeAvailableType
	 *
	 * @return ChangeInfo|SuspendResume|null
	 */
	public function getFromChangeAvailableType(ChangeAvailableType $changeAvailableType): ChangeInfo|SuspendResume|null
	{
		$changeAvailableTypeValue = $changeAvailableType->value;
		$method = 'get' . $changeAvailableTypeValue;
		if (is_callable([$this,
			$method])) {
			return $this->$method();
		}
		return null;
	}


	public function toArray(): array
	{
		return $this->data;
	}
}