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

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Entities\WorkingHours;
use Yooogi\DellinSDK\Instantiator;

/**
 * Информация о месте отправки
 * Информация о месте получения
 *
 * @see https://dev.dellin.ru/api/orders/search/#_header12
 */
class DerivalArrival implements Arrayable
{

	use DataAware;

	/**
	 * Город отправки/доставки груза
	 *
	 * @return string|null
	 */
	public function getCity(): ?string
	{
		return $this->get('city');
	}

	/**
	 *    ID города отправления/прибытия
	 *
	 * @return int|null
	 */
	public function getCityId(): ?int
	{
		return $this->get('cityId');
	}

	/**
	 * Код КЛАДР города, см. 'Поиск населённых пунктов'
	 *
	 * @return string|null
	 */
	public function getCityCode(): ?string
	{
		return $this->get('cityCode');
	}

	/**
	 * Адрес отправки/доставки груза
	 *
	 * @return string|null
	 */
	public function getAddress(): ?string
	{
		return $this->get('address');
	}

	/**
	 * Код КЛАДР улицы, см. 'Поиск улиц'
	 *
	 * @return string|null
	 */
	public function getAddressCode(): ?string
	{
		return $this->get('addressCode');
	}

	/**
	 * Наименование терминала хранения
	 *
	 * @return string|null
	 */
	public function getTerminalName(): ?string
	{
		return $this->get('terminalName');
	}

	/**
	 * Адрес терминала хранения
	 *
	 * @return string|null
	 */
	public function getTerminalAddress(): ?string
	{
		return $this->get('terminalAddress');
	}

	/**
	 * ID терминала-отправителя/получателя из 'Справочника терминалов'
	 *
	 * @return int|null
	 */
	public function getTerminalId(): ?int
	{
		return $this->get('terminalId');
	}

	/**
	 * Город терминала хранения
	 *
	 * @return string|null
	 */
	public function getTerminalCity(): ?string
	{
		return $this->get('terminalCity');
	}

	/**
	 * Долгота и широта терминала хранения
	 *
	 * @return array|null
	 */
	public function getTerminalCoordinates(): ?array
	{
		return (is_array($this->get('terminalCoordinates'))) ?
			[$this->get('terminalCoordinates')[0],
				$this->get('terminalCoordinates')[1]] : null;
	}

	/**
	 * Email терминала хранения
	 *
	 * @return string|null
	 */
	public function getTerminalEmail(): ?string
	{
		return $this->get('terminalEmail');
	}

	/**
	 * Телефон терминала хранения
	 *
	 * @return string|null
	 */
	public function getTerminalPhone(): ?string
	{
		return $this->get('terminalPhones');
	}

	/**
	 * Телефон кол-центра
	 *
	 * @return string|null
	 */
	public function getCallCenterPhones(): ?string
	{
		return $this->get('callCenterPhones');
	}

	/**
	 * График работы терминала хранения (график выдачи груза)
	 *
	 * @return WorkingHours|null
	 */
	public function getTerminalWorktables(): ?WorkingHours
	{
		return Instantiator::instantiate(WorkingHours::class, $this->get('terminalWorktables'));
	}

	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return $this->data;
	}
}