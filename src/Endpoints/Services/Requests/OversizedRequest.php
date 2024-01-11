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

namespace Yooogi\DellinSDK\Endpoints\Services\Requests;

use DateTime;
use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\Login;
use Yooogi\DellinSDK\Core\Traits\MetaData;
use Yooogi\DellinSDK\Enum\DeliveryType;
use function func_get_args;


final class OversizedRequest implements Arrayable
{
	use DataAware, Login, MetaData;

	private ?DeliveryType $serviceKind = null;
	private ?DateTime $periodFrom = null;

	/**
	 * Запрос значения весогабаритных характеристик, при которых груз считается негабаритным в зависимости от вида перевозки, на указанную дату.
	 *
	 * @param DeliveryType|null $serviceKind Вид доставки
	 * @param DateTime|null $periodFrom Дата, на которую требуется получить параметры негабаритного груза.
	 *
	 * @see https://dev.dellin.ru/api/catalogs/parametry-negabaritnogo-gruza/
	 */
	public function __construct(?DeliveryType $serviceKind = null, ?DateTime $periodFrom = null)
	{
		$this->setServiceKind($serviceKind);
		$this->setPeriodFrom($periodFrom);

	}

	/**
	 * Запрос значения весогабаритных характеристик, при которых груз считается негабаритным в зависимости от вида перевозки, на указанную дату.
	 *
	 * @param DeliveryType|null $serviceKind Вид доставки
	 * @param DateTime|null $periodFrom Дата, на которую требуется получить параметры негабаритного груза.
	 *
	 * @see https://dev.dellin.ru/api/catalogs/parametry-negabaritnogo-gruza/
	 */
	public static function create(?DeliveryType $serviceKind = null, ?DateTime $periodFrom = null): self
	{
		return new self(...func_get_args());
	}

	/**
	 * Вид перевозки.
	 *
	 * Доступные значения:
	 *
	 * 'auto'- автодоставка;
	 * 'express' - экспресс-доставка;
	 * 'avia' - авиадоставка.
	 *
	 * @return DeliveryType|null
	 */
	public function getServiceKind(): ?DeliveryType
	{
		return $this->serviceKind;
	}

	/**
	 * Вид перевозки.
	 *
	 * Доступные значения:
	 *
	 * 'auto'- автодоставка;
	 * 'express' - экспресс-доставка;
	 * 'avia' - авиадоставка.
	 *
	 *
	 * @param DeliveryType|null $deliveryType
	 */
	public function setServiceKind(?DeliveryType $serviceKind): OversizedRequest
	{
		$this->serviceKind = $serviceKind;
		return $this;
	}

	/**
	 * Дата, на которую требуется получить параметры негабаритного груза.
	 *
	 * @return DateTime|null
	 */
	public function getPeriodFrom(): ?DateTime
	{
		return $this->periodFrom;
	}

	/**
	 * Дата, на которую требуется получить параметры негабаритного груза.
	 *
	 * @param DateTime|null $periodFrom
	 */
	public function setPeriodFrom(?DateTime $periodFrom): OversizedRequest
	{
		$this->periodFrom = $periodFrom;
		return $this;
	}



	public function toArray(): array
	{
		if ($this->serviceKind) $this->data['serviceKind'] = $this->serviceKind->value;
		if ($this->periodFrom) $this->data['periodFrom'] = $this->periodFrom->format('Y-m-d\TH:i:s');

		return $this->data;
	}
}
