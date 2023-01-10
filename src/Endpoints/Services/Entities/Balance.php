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

namespace Yooogi\DellinSDK\Endpoints\Services\Entities;

use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Enum\MailCategory;
use Yooogi\DellinSDK\Enum\MailRank;
use Yooogi\DellinSDK\Enum\MailType;
use Yooogi\DellinSDK\Enum\PaymentMethodType;

/**
 * Информация о движении денежных средств контрагента. Если взаиморасчетов не производилось, значение параметра - null.
 *
 * Параметр присутствует в ответе, только если в запросе метода был передан параметр 'fullInfo' со значением 'true'
 */
final class Balance
{
	use DataAware;

	/**
	 * Дата начала периода.
	 *
	 * Формат: 'ГГГГ-ММ-ДД ЧЧ:ММ:СС'
	 * @return string|null
	 */
	public function getOpeningDate(): ?string
	{
		if (isset($this->data['opening'])) {
			return $this->data['opening']['date'];
		}
		return null;
	}

	/**
	 * Сумма на начало периода, руб
	 * @return int|null
	 */
	public function getOpeningSum(): ?int
	{
		if (isset($this->data['opening'])) {
			return $this->data['opening']['sum'];
		}
		return null;
	}

	/**
	 * Дата конца периода.
	 *
	 * Формат: 'ГГГГ-ММ-ДД ЧЧ:ММ:СС'
	 * @return string|null
	 */
	public function getClosingDate(): ?string
	{
		if (isset($this->data['closing'])) {
			return $this->data['closing']['date'];
		}
		return null;
	}

	/**
	 * Сумма на конец периода, руб
	 * @return int|null
	 */
	public function getClosingSum(): ?int
	{
		if (isset($this->data['closing'])) {
			return $this->data['closing']['sum'];
		}
		return null;
	}

	public function toArray(): array
	{
		return $this->data;
	}
}
