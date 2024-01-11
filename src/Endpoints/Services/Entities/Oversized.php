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

namespace Yooogi\DellinSDK\Endpoints\Services\Entities;

use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Enum\DeliveryType;

/**
 *
 * Значения весогабаритных характеристик, при которых груз считается негабаритным в зависимости от вида перевозки, на указанную дату.
 *
 * @see https://dev.dellin.ru/api/catalogs/parametry-negabaritnogo-gruza/
 */
final class Oversized
{
	use DataAware;

	/**
	 * Негабаритная высота
	 *
	 * @return float|null
	 */
	public function getOversizedHeight(): ?float
	{
		return $this->get('oversizedHeight', 'float');
	}

	/**
	 * Негабаритная длина
	 *
	 * @return float|null
	 */
	public function getOversizedLength(): ?float
	{
		return $this->get('oversizedLength', 'float');
	}

	/**
	 * Негабаритная ширина
	 *
	 * @return float|null
	 */
	public function getOversizedWidth(): ?float
	{
		return $this->get('oversizedWidth', 'float');
	}

	/**
	 * Негабаритный объем
	 *
	 * @return float|null
	 */
	public function getOversizedVolume(): ?float
	{
		return $this->get('oversizedVolume', 'float');
	}

	/**
	 * Негабаритный вес
	 *
	 * @return float|null
	 */
	public function getOversizedWeight(): ?float
	{
		return $this->get('oversizedWeight', 'float');
	}

	/**
	 * Вид перевозки.
	 *
	 * Возможные значения:
	 *
	 * 'auto'- автодоставка;
	 * 'express' - экспресс-доставка;
	 * 'avia' - авиадоставка.
	 *
	 * @return DeliveryType|null
	 */
	public function getServiceKind(): ?DeliveryType
	{
		return DeliveryType::TryFrom($this->get('serviceKind'));
	}


	public function toArray(): array
	{
		return $this->data;
	}

}
