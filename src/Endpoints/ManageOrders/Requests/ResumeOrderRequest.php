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

use DateTimeImmutable;
use Yooogi\DellinSDK\Entities\OrderId;
use function func_get_args;

/**
 * Запрос на возобновление выдачи
 *
 * @see https://dev.dellin.ru/api/order/suspend/#_header12
 */
final class ResumeOrderRequest extends OrderId
{

	private DateTimeImmutable $resumeDate;

	/**
	 * Запрос на возобновление выдачи
	 *
	 * @param string $orderID
	 * @param DateTimeImmutable $resumeDate
	 *
	 * @see https://dev.dellin.ru/api/order/suspend/#_header12
	 */
	public function __construct(string $orderID, DateTimeImmutable $resumeDate)
	{
		parent::__construct($orderID);
		$this->setResumeDate($resumeDate);
	}

	/**
	 * Запрос на возобновление выдачи
	 *
	 * @see https://dev.dellin.ru/api/order/suspend/#_header12
	 */
	public static function create(string $orderID, DateTimeImmutable $resumeDate): ResumeOrderRequest
	{
		return new ResumeOrderRequest(...func_get_args());
	}

	/**
	 * Дата, с которой должна стать доступной выдача груза
	 *
	 * @return DateTimeImmutable
	 */
	public function getResumeDate(): DateTimeImmutable
	{
		return $this->resumeDate;
	}

	/**
	 * Дата, с которой должна стать доступной выдача груза
	 *
	 * @param DateTimeImmutable $resumeDate
	 */
	public function setResumeDate(DateTimeImmutable $resumeDate): ResumeOrderRequest
	{
		$this->resumeDate = $resumeDate;
		return $this;
	}


	public function toArray(): array
	{
		$this->data = parent::toArray();
		$this->data['resumeDate'] = $this->resumeDate->format('Y-m-d');
		return $this->data;
	}
}