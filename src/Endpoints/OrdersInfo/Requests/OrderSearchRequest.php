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

namespace Yooogi\DellinSDK\Endpoints\OrdersInfo\Requests;

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\Login;
use Yooogi\DellinSDK\Entities\Member;

/**
 * Сервис позволяет найти заказ, номер которого не известен.
 * Для поиска используются следующие данные: ИНН (для юридических лиц),
 * тип и номер документа (для физических лиц),
 * маршрут перевозки и дата отправки заказа.
 * Использование необязательных параметров позволяет выделить заказ из множества.
 *
 * @see https://dev.dellin.ru/api/orders/partial-search/
 */
final class OrderSearchRequest implements Arrayable
{
	use DataAware, Login;


	private \DateTimeImmutable $dateStart;
	private \DateTimeImmutable $dateEnd;
	private ?Member $sender = null;
	private ?Member $receiver = null;

	/**
	 * Запрос на поиск заказа , номер которого не известен
	 *
	 * @param \DateTimeImmutable $dateStart
	 * @param \DateTimeImmutable $dateEnd
	 */
	public function __construct(\DateTimeImmutable $dateStart, \DateTimeImmutable $dateEnd)
	{

		$this->setDateStart($dateStart);
		$this->setDateEnd($dateEnd);
	}

	/**
	 * Запрос на поиск заказа , номер которого не известен
	 *
	 * @param \DateTimeImmutable $dateStart
	 * @param \DateTimeImmutable $dateEnd
	 */
	public static function create(\DateTimeImmutable $dateStart, \DateTimeImmutable $dateEnd)
	{
		return new self(...\func_get_args());
	}

	/**
	 * Начальная дата периода (для фильтрации результатов поиска по дате отправки заказа).
	 *
	 * Формат: 'ГГГГ-ММ-ДД'
	 * Интервал между начальной и конечной датами периода не должен превышать 7 дней.
	 *
	 * @see https://dev.dellin.ru/api/orders/partial-search/#_header6
	 * @return \DateTimeImmutable
	 */
	public function getDateStart(): \DateTimeImmutable
	{
		return $this->dateStart;
	}

	/**
	 * Конечная дата периода (для фильтрации результатов поиска по дате отправки заказа).
	 *
	 * Формат: 'ГГГГ-ММ-ДД'
	 * Интервал между начальной и конечной датами периода не должен превышать 7 дней.
	 *
	 * @see https://dev.dellin.ru/api/orders/partial-search/#_header6
	 *
	 * @param \DateTimeImmutable $dateStart
	 */
	public function setDateStart(\DateTimeImmutable $dateStart): void
	{
		$this->dateStart = $dateStart;
	}

	/**
	 * @return \DateTimeImmutable
	 */
	public function getDateEnd(): \DateTimeImmutable
	{
		return $this->dateEnd;
	}

	/**
	 * @param \DateTimeImmutable $dateEnd
	 */
	public function setDateEnd(\DateTimeImmutable $dateEnd): void
	{
		$this->dateEnd = $dateEnd;
	}

	/**
	 * Информация об отправителе
	 *
	 * @return Member|null
	 */
	public function getSender(): ?Member
	{
		return $this->sender;
	}

	/**
	 * Информация об отправителе
	 *
	 * @param Member|null $sender
	 */
	public function setSender(?Member $sender): OrderSearchRequest
	{
		$this->sender = $sender;
		return $this;
	}

	/**
	 * Информация о получателе
	 *
	 * @return Member|null
	 */
	public function getReceiver(): ?Member
	{
		return $this->receiver;
	}

	/**
	 * Информация о получателе
	 *
	 * @param Member|null $receiver
	 */
	public function setReceiver(?Member $receiver): OrderSearchRequest
	{
		$this->receiver = $receiver;
		return $this;
	}


	public function toArray(): array
	{
		$this->data['dateStart'] = $this->dateStart->format('Y-m-d');
		$this->data['dateEnd'] = $this->dateEnd->format('Y-m-d');

		if ($this->sender) $this->data['sender'] = $this->sender->toArray();
		if ($this->receiver) $this->data['receiver'] = $this->receiver->toArray();

		return $this->data;
	}

}
