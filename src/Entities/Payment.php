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

namespace Yooogi\DellinSDK\Entities;

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Enum\PayerType;
use Yooogi\DellinSDK\Enum\PaymentType;
use function func_get_args;


final class Payment implements Arrayable
{
	use DataAware;

	private PaymentType $paymentType;
	private PayerType $primaryPayer;
	private ?string $paymentCity;
	private ?string $paymentCitySearch;
	private ?CashOnDelivery $cashOnDelivery;
	/**
	 * @var Product[]
	 */
	private ?array $products;

	/**
	 *
	 * @param PaymentType $paymentType Вид оплаты (1). Доступные значения: CASH, NONCASH
	 * @param PayerType $primaryPayer Плательщик по умолчанию. Указанный плательщик оплачивает основную услугу (межтерминальную перевозку) и все прочие услуги, если по ним
	 * не указаны иные плательщики. Доступные значения: SENDER - отправитель; RECEIVER - получатель; THIRD - третье лицо
	 * @param ?string $paymentCity Код КЛАДР населенного пункта оплаты (1). Может быть получен с помощью сервисов, представленных на странице 'Поиск КЛАДР'.
	 * @param ?string $paymentCitySearch Населённый пункт в виде произвольной строки. Максимум 1024 символа. Помимо наименования населённого пункта, в строке может быть передано наименование страны, региона, района - это позволит уточнить поиск и исключить ошибки, которые могут возникнуть из-за одинаковых названий населённых пунктов
	 * @param ?CashOnDelivery $cashOnDelivery Наложенный платеж.
	 */
	public function __construct(PaymentType     $paymentType,
	                            PayerType       $primaryPayer,
	                            ?string         $paymentCity = null,
	                            ?string         $paymentCitySearch = null,
	                            ?CashOnDelivery $cashOnDelivery = null)
	{
		$this->setPaymentType($paymentType);
		$this->setPrimaryPayer($primaryPayer);
		$this->setPaymentCity($paymentCity);
		$this->setPaymentCitySearch($paymentCitySearch);
		$this->setCashOnDelivery($cashOnDelivery);
	}

	/**
	 *
	 * @param PaymentType $paymentType Вид оплаты (1). Доступные значения: CASH, NONCASH
	 * @param PayerType $primaryPayer Плательщик по умолчанию. Указанный плательщик оплачивает основную услугу (межтерминальную перевозку) и все прочие услуги, если по ним
	 * не указаны иные плательщики. Доступные значения: SENDER - отправитель; RECEIVER - получатель; THIRD - третье лицо
	 * @param ?string $paymentCity Код КЛАДР населенного пункта оплаты (1). Может быть получен с помощью сервисов, представленных на странице 'Поиск КЛАДР'.
	 * @param ?string $paymentCitySearch Населённый пункт в виде произвольной строки. Максимум 1024 символа. Помимо наименования населённого пункта, в строке может быть передано наименование страны, региона, района - это позволит уточнить поиск и исключить ошибки, которые могут возникнуть из-за одинаковых названий населённых пунктов
	 * @param ?CashOnDelivery $cashOnDelivery Наложенный платеж.
	 */
	public static function create(PaymentType     $paymentType,
	                              PayerType       $primaryPayer,
	                              ?string         $paymentCity = null,
	                              ?string         $paymentCitySearch = null,
	                              ?CashOnDelivery $cashOnDelivery = null): self
	{
		return new self(...func_get_args());
	}

	/**
	 * @return PaymentType
	 */
	public function getPaymentType(): ?PaymentType
	{
		return $this->paymentType;
	}

	/**
	 * @param PaymentType $paymentType
	 */
	public function setPaymentType(PaymentType $paymentType): Payment
	{
		$this->paymentType = $paymentType;
		return $this;
	}

	/**
	 * @return PayerType
	 */
	public function getPrimaryPayer(): ?PayerType
	{
		return $this->primaryPayer;
	}

	/**
	 * @param PayerType $primaryPayer
	 */
	public function setPrimaryPayer(PayerType $primaryPayer): Payment
	{
		$this->primaryPayer = $primaryPayer;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPaymentCity(): ?string
	{
		return $this->paymentCity;
	}

	/**
	 * @param string|null $paymentCity
	 */
	public function setPaymentCity(?string $paymentCity): Payment
	{
		$this->paymentCity = $paymentCity;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPaymentCitySearch(): ?string
	{
		return $this->paymentCitySearch;
	}

	/**
	 * @param string|null $paymentCitySearch
	 */
	public function setPaymentCitySearch(?string $paymentCitySearch): Payment
	{
		$this->paymentCitySearch = ($paymentCitySearch)
			? mb_strimwidth($paymentCitySearch, 0, 1024, '', 'UTF8')
			: null;
		return $this;
	}

	/**
	 * @return ?CashOnDelivery
	 */
	public function getCashOnDelivery(): ?CashOnDelivery
	{
		return $this->cashOnDelivery;
	}

	/**
	 * @param ?CashOnDelivery $cashOnDelivery
	 */
	public function setCashOnDelivery(?CashOnDelivery $cashOnDelivery): Payment
	{
		$this->cashOnDelivery = $cashOnDelivery;
		return $this;
	}


	public function toArray(): array
	{
		$this->data['type'] = $this->paymentType->value;
		$this->data['primaryPayer'] = $this->primaryPayer->value;
		if ($this->paymentCity) $this->data['paymentCity'] = $this->paymentCity;
		if ($this->paymentCitySearch) $this->data['paymentCitySearch'] = $this->paymentCitySearch;
		if ($this->cashOnDelivery) $this->data['cashOnDelivery'][] = $this->cashOnDelivery->toArray();
		return $this->data;
	}
}
