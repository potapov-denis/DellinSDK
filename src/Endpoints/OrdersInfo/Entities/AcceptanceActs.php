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

namespace Yooogi\DellinSDK\Endpoints\OrdersInfo\Entities;

use DateTimeImmutable;
use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;

/**
 * Данные счёта-фактуры
 *
 */
class AcceptanceActs implements Arrayable
{
	use DataAware;

	private ?DateTimeImmutable $acceptanceActDate;
	private ?string $acceptanceActNumber;
	private ?string $acceptanceActType;

	/**
	 * Дата счета-фактуры
	 *
	 * @return DateTimeImmutable|null
	 */
	public function getAcceptanceActDate(): ?DateTimeImmutable
	{
		return DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s\Z', $this->get('acceptanceActDate'));
	}

	/**
	 * Номер счета-фактуры
	 *
	 * @return string|null
	 */
	public function getAcceptanceActNumber(): ?string
	{
		return $this->get('acceptanceActNumber');
	}

	/**
	 * Тип. Возможные значения:
	 *
	 * - Корректировочный;
	 * - Исправленный
	 *
	 * В случае обычного счёта-фактуры параметр приходит пустым
	 *
	 * @return string|null
	 */
	public function getAcceptanceActType(): ?string
	{
		return $this->get('acceptanceActType');
	}


	public function toArray(): array
	{
		return $this->data;
	}
}