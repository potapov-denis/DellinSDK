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
use Yooogi\DellinSDK\Core\Traits\MetaData;
use Yooogi\DellinSDK\Enum\LoadType;
use Yooogi\DellinSDK\Enum\TransportRequirements;

/**
 * Доступные виды погрузки/дополнительные опции при погрузке
 *
 * @see https://dev.dellin.ru/api/catalogs/request-conditions/#_header7
 *
 */
class Loadings implements Arrayable
{

	use DataAware, MetaData;

	private array $sender;
	private array $receiver;

	/**
	 * Массив UID видов погрузки/дополнительных опций, доступные получателю.
	 *
	 * @return LoadType[]|TransportRequirements[]|null
	 * @see LoadType, TransportRequirements
	 */
	public function getSender(): ?array
	{
		if (is_array($this->get('sender'))) {
			return self::getEnum($this->get('sender'));
		}

		return null;
	}

	private static function getEnum(array $loadings): array
	{
		return array_map(function ($loading) {
			return LoadType::TryFrom($loading) ?: TransportRequirements::TryFrom($loading);
		}, $loadings);
	}

	/**
	 * Массив UID видов погрузки/дополнительных опций, доступных отправителю
	 *
	 * @return LoadType[]|TransportRequirements[]|null
	 * @see LoadType, TransportRequirements
	 */
	public function getReceiver(): ?array
	{
		if (is_array($this->get('receiver'))) {
			return self::getEnum($this->get('receiver'));
		}

		return null;
	}

	public function toArray(): array
	{
		return $this->data;
	}
}