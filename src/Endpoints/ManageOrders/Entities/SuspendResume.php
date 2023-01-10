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

namespace Yooogi\DellinSDK\Endpoints\ManageOrders\Entities;

/**
 * Информация о возможности приостановки и возобновления выдачи груза
 *
 * @see https://dev.dellin.ru/api/order/check/#_header13
 *
 */
final class SuspendResume extends AvailableChange
{

	private array $info = [];
	private ?string $terminalInfo;
	private ?\DateTimeImmutable $availableTill;
	private ?string $warning;
	private ?int $terminalId;
	private ?string $stateInfo;

	/**
	 * Информация о терминале, на который прибудет груз
	 *
	 * @return string|null
	 */
	public function getTerminalInfo(): ?string
	{
		return $this->getObject('info')?->get('terminalInfo');
	}

	/**
	 * Дата до которой (включительно) возможна приостановка/возобновление выдачи груза
	 *
	 * @return \DateTimeImmutable|null
	 */
	public function getAvailableTill(): ?\DateTimeImmutable
	{
		return \DateTimeImmutable::createFromFormat('Y-d-m', $this->getObject('info')?->get('availableTill'));
	}

	/**
	 * Дополнительная информация, актуальная в случае, если дата, полученная в параметре 'info.availableTill',
	 * будет передана в запросе метода на приостановку/возобновление выдачи в качестве значения параметра 'suspendDate'/'resumeDate'
	 *
	 * @return string|null
	 */
	public function getWarning(): ?string
	{
		return $this->getObject('info')?->get('warning');
	}

	/**
	 * ID терминала, на который прибудет груз
	 *
	 * @return int|null
	 */
	public function getTerminalId(): ?int
	{
		return (int)$this->getObject('info')?->get('terminalId');
	}

	/**
	 * Дополнительная информация
	 *
	 * @return string|null
	 */
	public function getStateInfo(): ?string
	{
		return $this->getObject('info')?->get('stateInfo');
	}


	/**
	 * Дополнительная информация по возможности изменения
	 *
	 * @return array
	 */
	public function getInfo(): array
	{
		return (array)$this->get('info');
	}


	public function toArray(): array
	{
		return $this->data;
	}
}