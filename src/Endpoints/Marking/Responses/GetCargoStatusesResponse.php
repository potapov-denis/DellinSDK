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

declare (strict_types=1);

namespace Yooogi\DellinSDK\Endpoints\Marking\Responses;

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\MetaData;
use Yooogi\DellinSDK\Enum\CargoStatus;

final class GetCargoStatusesResponse implements Arrayable
{
	use DataAware, MetaData;

	private ?string $cargoPlace;
	private ?string $number;
	private ?CargoStatus $state;

	/**
	 * Артикул грузового места
	 *
	 * @return string|null
	 */
	public function getCargoPlace(): ?string
	{
		return (string)$this->cargoPlace;
	}

	/**
	 * Порядковый номер грузового места
	 *
	 * @return string|null
	 */
	public function getNumber(): ?string
	{
		return (string)$this->number;
	}


	/**
	 * Статус грузового места.
	 *
	 * Возможные значения:
	 *
	 * new - ожидает приемки, грузовое место имеет данный статус с момента отправки информации о грузовых местах до момента их обработки на терминале;
	 * accepted - принято на терминале;
	 * not_accepted - не принято;
	 * unindentified - не опознано; статус устанавливается, если грузовое место не было промаркировано;
	 * no_info - нет информации
	 *
	 * @return CargoStatus|null
	 */
	public function getState(): ?CargoStatus
	{
		return ($this->get('state')) ? CargoStatus::TryFrom($this->get('state')) : null;
	}


	public function toArray(): array
	{
		return $this->data;
	}

}