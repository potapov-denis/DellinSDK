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

namespace Yooogi\DellinSDK\Endpoints\Calculations\Responses;

use Yooogi\DellinSDK\Core\ArrayOf;
use Yooogi\DellinSDK\Core\MetaDatable;
use Yooogi\DellinSDK\Core\Traits\FoundAddressesTrait;
use Yooogi\DellinSDK\Core\Traits\MetaData;
use Yooogi\DellinSDK\Endpoints\Calculations\Entities\AccompanyingDocuments;
use Yooogi\DellinSDK\Endpoints\Calculations\Entities\AvailableDeliveryTypes;
use Yooogi\DellinSDK\Endpoints\Calculations\Entities\CostsCalculation;
use Yooogi\DellinSDK\Endpoints\Calculations\Entities\PackagesCostsCalculation;
use Yooogi\DellinSDK\Entities\OrderDates;
use Yooogi\DellinSDK\Enum\AcDoc;
use Yooogi\DellinSDK\Enum\DeliveryType;
use Yooogi\DellinSDK\Enum\PackageType;
use Yooogi\DellinSDK\Instantiator;

final class CalculationResponse extends DerivalArrivalResponse implements MetaDatable
{
	use FoundAddressesTrait, MetaData;


	/**
	 * Итоговая стоимость для выбранного вида перевозки
	 *
	 * @return float|null
	 */
	public function getPrice(): ?float
	{
		return $this->get('price');
	}

	/**
	 * Срок доставки груза от терминала получения до адреса (в днях)
	 *
	 * @return int|null
	 */
	public function getDeliveryTerm(): ?int
	{
		return $this->get('deliveryTerm');
	}

	/**
	 * Общая стоимость страхования груза
	 *
	 * @return float|null
	 */
	public function getInsurance(): ?float
	{
		return $this->get('insurance');
	}

	/**
	 * Информация о доступности услуги 'упрощённая отправка'
	 *
	 * @return bool
	 */
	public function isSimpleShippingAvailable(): bool
	{
		return (bool)$this->get('simpleShippingAvailable');
	}


	/**
	 * Способ перевозки с минимальной стоимостью.
	 *
	 * @return DeliveryType|null
	 */
	public function getPriceMinimal(): ?DeliveryType
	{
		return DeliveryType::tryFrom($this->get('priceMinimal'));
	}

	/**
	 * Информация о стоимости упаковки
	 *
	 * @return CostsCalculation[]|null
	 */
	public function getPackages(): ?array
	{
		if ($this->get('packages') !== null) {
			$packages = $this->get('packages');
			array_walk($packages, function (&$el, $key) {
				$el['type'] = PackageType::tryFrom($key);
			});
			return Instantiator::instantiate(new arrayOf(PackagesCostsCalculation::class), $packages);
		}
		return null;
	}

	/**
	 * Получение информации по сопроводительным документам
	 *
	 * @return AccompanyingDocuments|null
	 */
	public function getAccompanyingDocuments(): ?AccompanyingDocuments
	{
		if ($this->get('accompanyingDocuments') !== null) {
			$accompanyingDocuments = $this->get('accompanyingDocuments');
			array_walk($accompanyingDocuments, function (&$el, $key) {
				$el['type'] = AcDoc::tryFrom($key);
			});
			return Instantiator::instantiate(AccompanyingDocuments::class, $accompanyingDocuments);
		}
		return null;
	}


	/**
	 * @return DeliveryType|null
	 */
	public function getDeliveryType(): ?DeliveryType
	{
		foreach (DeliveryType::DELIVERY_TYPES as $key => $deliveryType) {
			if ($this->get($key) !== null) {
				return DeliveryType::tryFrom($deliveryType);
			}
		}

		return null;
	}

	/**
	 * Информация о стоимости автоперевозки
	 * Информация о стоимости доставки  малогабаритного груза
	 * Информация о стоимости авиаперевозки
	 * Информация о стоимости экспресс-перевозки
	 * Информация о стоимости услуги 'Письмо'
	 *
	 *
	 * @return CostsCalculation|null
	 */
	public function getDeliveryCosts(): ?CostsCalculation
	{
		foreach (DeliveryType::DELIVERY_TYPES as $key => $deliveryType) {
			if ($this->get($key) !== null) {
				return Instantiator::instantiate(CostsCalculation::class, $this->get($key));
			}
		}

		return null;
	}

	/**
	 * Информация о стоимости услуги 'информация о статусе заказа'
	 *
	 * @return CostsCalculation|null
	 */
	public function getNotify(): ?CostsCalculation
	{
		return Instantiator::instantiate(CostsCalculation::class, $this->get('notify'));
	}

	/**
	 * Получение графика движения груза
	 *
	 * @return OrderDates|null
	 */
	public function getOrderDates(): ?OrderDates
	{
		return Instantiator::instantiate(OrderDates::class, $this->get('orderDates'));
	}

	/**
	 * Получение доступных типов доставки
	 *
	 * @return AvailableDeliveryTypes|null
	 */
	public function getAvailableDeliveryTypes(): ?AvailableDeliveryTypes
	{
		return Instantiator::instantiate(AvailableDeliveryTypes::class, $this->get('availableDeliveryTypes'));
	}


}
