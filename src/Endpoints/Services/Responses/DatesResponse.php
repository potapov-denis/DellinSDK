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

namespace Yooogi\DellinSDK\Endpoints\Services\Responses;

use DateTimeImmutable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\MetaData;
use Yooogi\DellinSDK\Entities\FoundAddresses;

/**
 * Информация о возможных датах передачи груза водителю на адресе отправителя
 * Информация о возможных датах доставки
 * Информация о возможных датах отугрызки на терминал
 *
 * @see https://dev.dellin.ru/api/catalogs/dispatch-dates/
 * @see https://dev.dellin.ru/api/catalogs/delivery-dates/
 */
final class DatesResponse
{
	use DataAware, MetaData;

	private ?array $dates;
	private ?FoundAddresses $foundAddresses;

	/**
	 *  Список возможных дат передачи груза водителю на адресе отправителя.
	 *
	 *  Формат: 'ГГГГ-ММ-ДД'
	 * @return DateTimeImmutable[]|null
	 */
	public function getDates(): ?array
	{
		return array_map(static function ($date) {
			return DateTimeImmutable::createFromFormat('Y-m-d', $date);
		}, $this->get('dates'));
	}


	public function toArray(): array
	{
		return $this->data;
	}

}
