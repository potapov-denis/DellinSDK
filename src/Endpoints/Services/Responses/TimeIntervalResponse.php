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
use Yooogi\DellinSDK\Core\Traits\FoundAddressesTrait;
use Yooogi\DellinSDK\Core\Traits\MetaData;

/**
 * Ответ сервиса информации о доступных интервалах приезда водителя-экспедитора при передаче груза
 * на адресе отправителя и доставке груза до адреса получателя
 *
 * @see https://dev.dellin.ru/api/catalogs/time-interva/
 */
final class TimeIntervalResponse
{
	use DataAware, FoundAddressesTrait, MetaData;

	private DateTimeImmutable $intervalFrom;
	private DateTimeImmutable $intervalTo;
	private ?int $defaultMinSameDayPeriod;
	private ?int $minSameDayPeriod;
	private ?int $minPeriod;
	private bool $sameDay;
	private ?array $foundAddresses;

	/**
	 * Допустимое начало интервала
	 *
	 * Формат: 'ЧЧ:ММ:СС'
	 *
	 * @return DateTimeImmutable
	 */
	public function getIntervalFrom(): DateTimeImmutable
	{
		return DateTimeImmutable::createFromFormat('H:i:s', $this->get('interval_from'));

	}

	/**
	 * Допустимый конец интервала
	 *
	 * Формат: 'ЧЧ:ММ:СС'
	 *
	 * @return DateTimeImmutable
	 */
	public function getIntervalTo(): DateTimeImmutable
	{
		return DateTimeImmutable::createFromFormat('H:i:s', $this->get('interval_to'));
	}

	/**
	 * Стандартная продолжительность интервала в случае приезда экспедитора в день оформления заказа, ч
	 *
	 * @return int|null
	 */
	public function getDefaultMinSameDayPeriod(): ?int
	{
		return $this->get('default_min_same_day_period');
	}

	/**
	 * Минимальная продолжительность интервала в случае приезда экспедитора в день оформления заказа, ч
	 *
	 * @return int|null
	 */
	public function getMinSameDayPeriod(): ?int
	{
		return $this->get('min_same_day_period');
	}

	/**
	 * Минимальная продолжительность интервала, ч
	 *
	 * @return int|null
	 */
	public function getMinPeriod(): ?int
	{
		return $this->get('min_period');
	}

	/**
	 *    Флаг, обозначающий, что можно назначить приезд экспедитора на день оформления заказа
	 *
	 * @return bool
	 */
	public function isSameDay(): bool
	{
		return $this->get('same_day');
	}


	public function toArray(): array
	{
		return $this->data;
	}

}
