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

use DateTimeImmutable;
use Yooogi\DellinSDK\Collections\RequirementsCollection;
use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\MetaDatable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\MetaData;
use Yooogi\DellinSDK\Enum\PayerType;
use Yooogi\DellinSDK\Enum\TransportType;
use function func_get_args;

/**
 * Данные по доставке груза от отправителя
 * Данные по доставке груза до получателя
 *
 * @see https://dev.dellin.ru/api/calculation/calculator/#_header8
 */
final class DerivalArrival implements Arrayable, MetaDatable
{

	use DataAware, MetaData;

	private DateTimeImmutable $produceDate;
	private TransportType $variant;
	private ?int $terminalID = null;
	private ?int $addressID = null;
	private ?Address $address = null;
	private ?string $city = null;
	private ?Time $time = null;
	private ?Handling $handling = null;
	private ?PayerType $payer = null;

	private ?RequirementsCollection $requirements = null;

	/**
	 * Создать данные по доставке груза от отправителя.
	 * Создать данные по доставке груза до получателя.
	 *
	 * @param DateTimeImmutable $produceDate Дата выполнения заказа
	 * @param TransportType $variant Способ доставки груза
	 */
	public function __construct(DateTimeImmutable $produceDate, TransportType $variant)
	{
		$this->setProduceDate($produceDate);
		$this->setVariant($variant);
	}

	/**
	 * Создать данные по доставке груза от отправителя.
	 * Создать данные по доставке груза до получателя.
	 *
	 * @param DateTimeImmutable $produceDate Дата выполнения заказа
	 * @param TransportType $variant Способ доставки груза
	 *
	 * @return DerivalArrival
	 */
	public static function create(DateTimeImmutable $produceDate, TransportType $variant): DerivalArrival
	{
		return new self(...func_get_args());
	}

	/**
	 * Способ доставки груза.
	 *
	 * Возможные значения:
	 *
	 * - 'address' - доставка груза непосредственно от адреса отправителя/до адреса получателя.
	 * Примечание. При заказе перевозки малогабаритного груза (значение параметра запроса 'delivery.deliverуType.type' - 'small') доставка от/до терминала невозможна;
	 *
	 * - 'terminal' - доставка груза от/до терминала;
	 *
	 * - 'airport' - доставка груза до аэропорта, вариант используется, если в городе, в который необходимо доставить груз, нет терминала 'Деловых Линий',
	 * в этом случае груз можно получить в грузовом терминале в аэропорту.
	 * Примечание. Вариант используется только для объекта 'request.delivery.arrival' и только при заказе авиаперевозки (значение параметра запроса 'delivery.deliverуType.type' - 'avia').
	 * При заказе доставки груза до аэропорта следует передать параметр 'city', передача параметров 'terminalID', 'addressID', 'address' невозможна
	 *
	 * @return TransportType
	 */
	public function getVariant(): TransportType
	{
		return $this->variant;
	}

	/**
	 * Способ доставки груза.
	 *
	 * Возможные значения:
	 *
	 * - 'address' - доставка груза непосредственно от адреса отправителя/до адреса получателя.
	 * Примечание. При заказе перевозки малогабаритного груза (значение параметра запроса 'delivery.deliverуType.type' - 'small') доставка от/до терминала невозможна;
	 *
	 * - 'terminal' - доставка груза от/до терминала;
	 *
	 * - 'airport' - доставка груза до аэропорта, вариант используется, если в городе, в который необходимо доставить груз, нет терминала 'Деловых Линий',
	 * в этом случае груз можно получить в грузовом терминале в аэропорту.
	 * Примечание. Вариант используется только для объекта 'request.delivery.arrival' и только при заказе авиаперевозки (значение параметра запроса 'delivery.deliverуType.type' - 'avia').
	 * При заказе доставки груза до аэропорта следует передать параметр 'city', передача параметров 'terminalID', 'addressID', 'address' невозможна
	 *
	 * @param TransportType $variant
	 *
	 * @return DerivalArrival
	 */
	public function setVariant(TransportType $variant): DerivalArrival
	{
		$this->variant = $variant;
		return $this;
	}

	/**
	 * Дата выполнения заказа.
	 *
	 * @return DateTimeImmutable|null
	 */
	public function getProduceDate(): ?DateTimeImmutable
	{
		return $this->produceDate;
	}

	/**
	 * Дата выполнения заказа.
	 *
	 * @param DateTimeImmutable $produceDate
	 *
	 * @return DerivalArrival
	 */
	public function setProduceDate(DateTimeImmutable $produceDate): DerivalArrival
	{
		$this->produceDate = $produceDate;
		return $this;
	}


	/**
	 * ID терминала отправки/доставки груза из 'Справочника терминалов').
	 *
	 * Заполняется при расчете стоимости предзаказа
	 *
	 * Допускается передача только одного из следующих параметров: 'terminalID', 'addressID', 'address', 'city'
	 *
	 * @return int|null
	 */
	public function getTerminalID(): ?int
	{
		return $this->terminalID;
	}


	/**
	 * ID терминала отправки/доставки груза из 'Справочника терминалов').
	 *
	 * Заполняется при расчете стоимости предзаказа
	 *
	 * Допускается передача только одного из следующих параметров: 'terminalID', 'addressID', 'address', 'city'
	 *
	 * @param int $terminalId
	 *
	 * @return DerivalArrival
	 */
	public function setTerminalId(int $terminalId): DerivalArrival
	{
		$this->terminalID = $terminalId;
		return $this;
	}


	/**
	 * ID адреса отправителя/получателя из адресной книги Личного кабинета (подробнее см. сервис 'Адреса').
	 *
	 * Заполняется в случае, если клиенту необходим расчёт для адреса, сохранённого в Личном Кабинете
	 *
	 * Допускается передача только одного из следующих параметров: 'terminalID', 'addressID', 'address', 'city'
	 *
	 * @return int|null
	 */
	public function getAddressID(): ?int
	{
		return $this->terminalID;
	}

	/**
	 * ID адреса отправителя/получателя из адресной книги Личного кабинета (подробнее см. сервис 'Адреса').
	 *
	 * Заполняется в случае, если клиенту необходим расчёт для адреса, сохранённого в Личном Кабинете
	 *
	 * Допускается передача только одного из следующих параметров: 'terminalID', 'addressID', 'address', 'city'
	 *
	 * @param int $addressID
	 *
	 * @return DerivalArrival
	 */
	public function setAddressId(int $addressID): DerivalArrival
	{
		$this->addressID = $addressID;
		return $this;
	}

	/**
	 * Адрес
	 *
	 * Допускается передача только одного из следующих параметров: 'terminalID', 'addressID', 'address', 'city'
	 *
	 * @return Address|null
	 */
	public function getAddress(): ?Address
	{
		return $this->address;
	}

	/**
	 * Адрес
	 *
	 * Допускается передача только одного из следующих параметров: 'terminalID', 'addressID', 'address', 'city'
	 *
	 * @param Address $address
	 *
	 * @return DerivalArrival
	 */
	public function setAddress(Address $address): DerivalArrival
	{
		$this->address = $address;
		return $this;
	}

	/**
	 * Код КЛАДР города. Может быть получен с помощью сервисов, представленных на странице 'Поиск КЛАДР'
	 *
	 * Используется только для параметра 'request.delivery.arrival'.
	 * Передача параметра невозможна, только если заказана доставка до адреса (значение параметра 'variant' - 'address').
	 * Допускается передача только одного из следующих параметров: 'terminalID', 'addressID', 'address', 'city'
	 *
	 * @return string|null
	 */
	public function getCity(): ?string
	{
		return $this->city;
	}

	/**
	 * Код КЛАДР города. Может быть получен с помощью сервисов, представленных на странице 'Поиск КЛАДР'
	 *
	 * Используется только для параметра 'request.delivery.arrival'.
	 * Передача параметра невозможна, только если заказана доставка до адреса (значение параметра 'variant' - 'address').
	 * Допускается передача только одного из следующих параметров: 'terminalID', 'addressID', 'address', 'city'
	 *
	 * @param string $city
	 *
	 * @return DerivalArrival
	 */
	public function setCity(string $city): DerivalArrival
	{
		$this->city = $city;
		return $this;
	}

	/**
	 * Получение времени работы и обеденного перерыва для отправления и доставки
	 *
	 * @return ?Time
	 */
	public function getTime(): ?Time
	{
		return $this->time;
	}

	/**
	 * Установка времени работы и обеденного перерыва для отправления и доставки
	 *
	 * @param Time $time Объект
	 *
	 * @return $this
	 */
	public function setTime(Time $time): DerivalArrival
	{
		$this->time = $time;
		return $this;
	}

	/**
	 * Получение погрузо-разгрузочных работ на адресе
	 *
	 * @return ?Handling
	 */
	public function getHandling(): ?Handling
	{
		return $this->handling;
	}

	/**
	 * Установка погрузо-разгрузочных работ на адресе
	 *
	 * @param Handling $handling Погрузо-разгрузочные работы на адресе
	 *
	 * @return DerivalArrival
	 */
	public function setHandling(Handling $handling): DerivalArrival
	{
		$this->handling = $handling;
		return $this;
	}

	/**
	 * Получить требования к транспорту и видов погрузки
	 *
	 * @return RequirementsCollection|null
	 */
	public function getRequirements(): ?RequirementsCollection
	{
		return $this->requirements;
	}

	/**
	 * Установка требований к транспорту и видов погрузки
	 *
	 * @param RequirementsCollection $requirementsCollection
	 *
	 * @return DerivalArrival
	 */
	public function setRequirements(RequirementsCollection $requirementsCollection): DerivalArrival
	{
		$this->requirements = $requirementsCollection;
		return $this;
	}

	/**
	 * Получить плательщика по забору или доставке
	 *
	 * @return PayerType|null
	 */
	public function getPayer(): ?PayerType
	{
		return $this->payer;
	}

	/**
	 * Установить плательщика по забору или доставке
	 *
	 * @param PayerType|null $payer
	 *
	 * @return DerivalArrival
	 */
	public function setPayer(?PayerType $payer): DerivalArrival
	{
		$this->payer = $payer;
		return $this;
	}


	public function toArray(): array
	{
		unset($this->data['requirements']);
		if ($this->produceDate) $this->data['produceDate'] = $this->produceDate->format('Y-m-d');
		$this->data['variant'] = $this->variant->value;
		if ($this->terminalID) $this->data['terminalID'] = $this->terminalID;
		if ($this->addressID) $this->data['addressID'] = $this->addressID;
		if ($this->city) $this->data['city'] = $this->city;
		if ($this->address) $this->data['address'] = $this->address->toArray();
		if ($this->handling) $this->data['handling'] = $this->handling->toArray();
		if ($this->time) $this->data['time'] = $this->time->toArray();
		if ($this->payer) $this->data['payer'] = $this->payer->value;
		if ($this->requirements) {
			foreach ($this->requirements as $requirement) {
				$this->data['requirements'][] = $requirement->value;
			}
		}
		return $this->data;
	}
}
