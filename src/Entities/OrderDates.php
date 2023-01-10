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

declare(strict_types=1);

namespace Yooogi\DellinSDK\Entities;

use DateTimeImmutable;
use Yooogi\DellinSDK\Core\Traits\DataAware;

final class OrderDates
{
	use DataAware;

	private ?DateTimeImmutable $pickup;
	private ?DateTimeImmutable $senderAddressTime;
	private ?DateTimeImmutable $senderTerminalTime;
	private ?DateTimeImmutable $arrivalToOspSender;
	private ?DateTimeImmutable $derivalFromOspSender;
	private ?DateTimeImmutable $arrivalToOspReceiver;
	private ?DateTimeImmutable $arrivalToAirport;
	private ?DateTimeImmutable $arrivalToAirportMax;
	private ?DateTimeImmutable $giveoutFromOspReceiver;
	private ?DateTimeImmutable $giveoutFromOspReceiverMax;
	private ?DateTimeImmutable $derivalFromOspReceiver;
	private ?DateTimeImmutable $createTo;
	private ?DateTimeImmutable $derivalToAddress;
	private ?DateTimeImmutable $derivalToAddressMax;

	public function __construct($date)
	{
		$this->data = $date;
	}

	/**
	 * Получение даты передачи груза на адресе отправителя
	 * @return DateTimeImmutable|null
	 */
	public function getPickup(): ?DateTimeImmutable
	{
		return ($this->get('pickup')) ? DateTimeImmutable::createFromFormat('Y-m-d', $this->get('pickup')) :
			null;
	}

	/**
	 * Получение времени, до которого необходимо забрать груз на адресе отправителя
	 * @return DateTimeImmutable|null
	 */
	public function getSenderAddressTime(): ?DateTimeImmutable
	{
		return ($this->get('senderAddressTime')) ? DateTimeImmutable::createFromFormat('H:i:s', $this->get('senderAddressTime')) :
			null;
	}

	/**
	 *    Получение времени, до которого необходимо передать груз на терминал отправителя
	 * @return DateTimeImmutable|null
	 */
	public function getSenderTerminalTime(): ?DateTimeImmutable
	{
		return ($this->get('senderTerminalTime')) ? DateTimeImmutable::createFromFormat('H:i:s', $this->get('senderTerminalTime')) :
			null;
	}

	/**
	 * Получение даты прибытия на терминал-отправитель
	 * @return DateTimeImmutable|null
	 */
	public function getArrivalToOspSender(): ?DateTimeImmutable
	{
		return ($this->get('arrivalToOspSender')) ? DateTimeImmutable::createFromFormat('Y-m-d', $this->get('arrivalToOspSender')) :
			null;
	}

	/**
	 * Получение даты отправки из терминала-отправителя
	 * @return DateTimeImmutable|null
	 */
	public function getDerivalFromOspSender(): ?DateTimeImmutable
	{
		return ($this->get('derivalFromOspSender')) ? DateTimeImmutable::createFromFormat('Y-m-d', $this->get('derivalFromOspSender')) :
			null;
	}

	/**
	 * Получение даты прибытия на терминал-получатель
	 * @return DateTimeImmutable|null
	 */
	public function getArrivalToOspReceiver(): ?DateTimeImmutable
	{
		return ($this->get('arrivalToOspReceiver')) ? DateTimeImmutable::createFromFormat('Y-m-d', $this->get('arrivalToOspReceiver')) :
			null;
	}

	/**
	 * Получение даты прибытия на терминал получателя/в аэропорт
	 * @return DateTimeImmutable|null
	 */
	public function getArrivalToAirport(): ?DateTimeImmutable
	{
		return ($this->get('arrivalToAirport')) ? DateTimeImmutable::createFromFormat('Y-m-d', $this->get('arrivalToAirport')) :
			null;
	}

	/**
	 * Получение максимальной даты прибытия на терминал получателя/в аэропорт (в случае, если возможно увеличение срока прибытия)
	 * @return DateTimeImmutable|null
	 */
	public function getArrivalToAirportMax(): ?DateTimeImmutable
	{
		return ($this->get('arrivalToAirportMax')) ? DateTimeImmutable::createFromFormat('Y-m-d', $this->get('arrivalToAirportMax')) :
			null;
	}

	/**
	 * Получение даты и времени, с которого груз готов к выдаче на терминале
	 * @return DateTimeImmutable|null
	 */
	public function getGiveoutFromOspReceiver(): ?DateTimeImmutable
	{
		return ($this->get('giveoutFromOspReceiver')) ? DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->get('giveoutFromOspReceiver')) :
			null;
	}

	/**
	 * Получение даты и времени, с которого груз готов к выдаче на терминале (в случае, если возможно увеличение срока готовности)
	 * @return DateTimeImmutable|null
	 */
	public function getGiveoutFromOspReceiverMax(): ?DateTimeImmutable
	{
		return ($this->get('giveoutFromOspReceiverMax')) ? DateTimeImmutable::createFromFormat('Y-m-d', $this->get('giveoutFromOspReceiverMax')) :
			null;
	}

	/**
	 * Получение даты отправки с терминала-получателя
	 * @return DateTimeImmutable|null
	 */
	public function getDerivalFromOspReceiver(): ?DateTimeImmutable
	{
		return ($this->get('derivalFromOspReceiver')) ? DateTimeImmutable::createFromFormat('Y-m-d', $this->get('derivalFromOspReceiver')) :
			null;
	}

	/**
	 * Получение времени, до которого необходимо подать заявку на доставку от адреса
	 * @return DateTimeImmutable|null
	 */
	public function getCreateTo(): ?DateTimeImmutable
	{
		return ($this->get('createTo')) ? DateTimeImmutable::createFromFormat('H:i:s', $this->get('createTo')) :
			null;
	}

	/**
	 * Получение даты и времени, с которого возможна доставка до клиента
	 * @return DateTimeImmutable|null
	 */
	public function getDerivalToAddress(): ?DateTimeImmutable
	{
		return ($this->get('derivalToAddress')) ? DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->get('derivalToAddress')) :
			null;
	}

	/**
	 * Получение максимальной даты и времени, до которого возможна доставка до клиента
	 * @return DateTimeImmutable|null
	 */
	public function getDerivalToAddressMax(): ?DateTimeImmutable
	{
		return ($this->get('derivalToAddressMax')) ? DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->get('derivalToAddressMax')) :
			null;
	}


}
