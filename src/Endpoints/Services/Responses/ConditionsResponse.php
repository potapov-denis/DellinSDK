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
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Entities\Loadings;
use Yooogi\DellinSDK\Endpoints\Services\Responses\Traits\PackagesTrait;
use Yooogi\DellinSDK\Enum\InsuranceAvailableType;
use Yooogi\DellinSDK\Instantiator;

/**
 * Ответ получения информации об ограничениях и возможных значениях параметров в зависимости от условий заказа.
 *
 * @see https://dev.dellin.ru/api/catalogs/request-conditions/
 */
final class ConditionsResponse
{
	use DataAware, PackagesTrait, MetaData;

	private ?Loadings $loadings;
	private array $packages;
	private ?string $sameDayPickupEndsAt;
	private ?int $minimalPickupPeriod;
	private bool $sameDayPickupAllowed = false;
	private ?int $terminalId;
	private ?int $minimalSameDayPickupPeriod;


	/**
	 * Доступные виды погрузки/дополнительные опции при погрузке
	 *
	 * @return Loadings|null
	 */
	public function getLoadings(): ?Loadings
	{
		return Instantiator::instantiate(Loadings::class, $this->get('loadings'));
	}


	/**
	 * Информация о доступности услуги страхования срока доставки.
	 *
	 * Возможные значения:
	 *
	 * '1' - Услуга доступна для заказа/Доступен отказ от услуги;
	 * '2' - Услуга недоступна для заказа/Отказ от услуги недоступен;
	 * '3' - Отказ от услуги недоступен
	 *
	 * @return InsuranceAvailableType|null
	 *
	 */
	public function getTermInsurance(): ?InsuranceAvailableType
	{
		$termInsuranceAvailable = (string)$this->getObject('insurance')?->get('term_insurance_available');
		return InsuranceAvailableType::TryFrom($termInsuranceAvailable);
	}

	/**
	 * Время, до которого можно заказать услугу передачи груза водителю-экспедитору в день заказа, ЧЧ:ММ:СС
	 *
	 * @return DateTimeImmutable|null
	 */
	public function getSameDayPickupEndsAt(): ?DateTimeImmutable
	{
		$sameDayPickupEndsAt = (string)$this->getObject('day_to_day')?->get('same_day_pickup_ends_at');

		return DateTimeImmutable::createFromFormat('H:i:s', $sameDayPickupEndsAt);
	}

	/**
	 * Минимальная продолжительность интервала приезда водителя-экспедитора, ч
	 *
	 * (У клиента есть возможность указать, с какого по какое время должен приехать водитель, данный интервал не должен быть меньше значения параметра)
	 * @return int|null
	 */
	public function getMinimalPickupPeriod(): ?int
	{
		return $this->getObject('day_to_day')?->get('minimal_pickup_period');
	}

	/**
	 * Признак возможности передачи груза водителю-экспедитору в день заказа
	 *
	 * @return bool
	 */
	public function isSameDayPickupAllowed(): bool
	{
		return $this->getObject('day_to_day')?->get('same_day_pickup_allowed');
	}

	/**
	 * ID терминала отправки груза (см. 'Справочника терминалов')
	 *
	 * @return int|null
	 */
	public function getTerminalId(): ?int
	{
		return $this->getObject('day_to_day')?->get('terminalId');
	}

	/**
	 * Минимальная продолжительность интервала приезда водителя-экспедитора при передаче груза в день заказа, ч
	 *
	 * (У клиента есть возможность указать, с какого по какое время должен приехать водитель, при передаче груза водителю-экспедитору в день заказа данный интервал не должен быть меньше значения параметра)
	 * @return int|null
	 */
	public function getMinimalSameDayPickupPeriod(): ?int
	{
		return $this->getObject('day_to_day')?->get('minimal_same_day_pickup_period');
	}


	public function toArray(): array
	{
		return $this->data;
	}

}
